<?php
class ArrangementPresenter extends BasePresenter
{
    public function renderDefault($id_squad)
    {
        if ($id_squad = $this->getUserSession('id_squad')) {
            $this->template->players = $this->model->getPlayers(BasePresenter::SEASON, $id_squad)->fetchAssoc('id');
        } else {
            throw new ForbiddenRequestException;
        }

        if ($players = $this->getUserSession('arrangement_home')) {
            $this->template->sess_arrangement = json_encode($players);
        }
    }

    protected function getImportPlayers()
    {
        if ($id_away_team = $this->getUserSession('id_away_team')) {
            $away_team_facr_id = $this->getTeamFACRID($id_away_team);

            if (array_key_exists($id_away_team, $away_team_facr_id)) {
                return $this->model->getImportPlayers($away_team_facr_id[$id_away_team])->fetchAssoc('id_facr');
            }
        } else {
            throw new ForbiddenRequestException;
        }
    }

    /***************************/
    /**    AJAX               **/
    /***************************/

    // ajaxove volani po stisknuti tlacitka Soupiska - hosté
    public function actionClickAway()
    {
        $this->setView('ajax');

        $players = $_POST['players'];

        // do SESSIONy ulozime hrace na soupisce
        $this->setPlayersToSession($players);

        return true;
    }
    
    // do SESSIONy ulozime domaci hrace na soupisce
    protected function setPlayersToSession($players)
    {
        $this->setUserSession('arrangement_home', $players);
    }

    private function array_change_key_case_unicode($arr, $c = CASE_LOWER)
    {
        $c = ($c == CASE_LOWER) ? MB_CASE_LOWER : MB_CASE_UPPER;

        foreach ($arr as $k => $v) {
            $ret[mb_convert_case($k, $c, "UTF-8")] = $v;
        }

        return $ret;
    }

    // restrikce pro ulozeni sestavy
    protected function playersRestrictions($players, $suffix = null, $no_count_players = false)
    {
        $ignore_warnings = $this->getUserSession('ignore_warnings');

        if (!empty($ignore_warnings) && $ignore_warnings === 'true') {
            return false;
        }

        $counter = 0;
        $unique_ids = $unique_numbers = array();

        foreach ($players as $player) {
            $counter++;

            // u prvnich 7 hracu musi byt vyplneno ID i cislo
            if (!$no_count_players && $counter <= 7) {
                if (empty($player['number']) || empty($player['id'])) {
                    return "Musí být zadáno 7 hráčů s čísly.$suffix";
                }
            }

            // u kazdeho zadaneho hrace musi byt vyplneno cislo
            if (!empty($player['id']) && empty($player['number'])) {
                return "Některá z čísel hráčů nejsou vyplněna.$suffix";
            }

            // ID hrace musi byt unikatni
            if (in_array($player['id'], $unique_ids)) {
                return "V sestavě nemůžou figurovat duplicitní hráči.$suffix";
            } else {
                if (!empty($player['id'])) $unique_ids[] = $player['id'];
            }

            // cislo hrace musi byt unikatni
            if (!empty($player['number']) && in_array($player['number'], $unique_numbers)) {
                return "Čísla hráčů jsou duplicitní.$suffix";
            } else {
                if (!empty($player['id'])) $unique_numbers[] = $player['number'];
            }
        }

        // spolecne restrikce
        if ($hlaska = $this->unifiedRestrictions($players, $suffix)) return $hlaska;

        return false;
    }

    // restrikce pro ulozeni funkcionaru
    protected function functionarsRestrictions($players, $suffix = null, $hl_poradatel = false)
    {
        $ignore_warnings = $this->getUserSession('ignore_warnings');

        if (!empty($ignore_warnings) && $ignore_warnings === 'true') {
            return false;
        }

        $counter = 0;

        foreach ($players as $player) {
            $counter++;

            // musi byt zadan minimalne vedouci muzstva
            if ($counter == 1) {
                if (empty($player['id'])) {
                    return "Nebyl zadán vedoucí mužstva.$suffix";
                }
            }

            // musi byt zadan hlavni poradatel
            if ($hl_poradatel && $counter == 7) {
                if (empty($player['id'])) {
                    return "Nebyl zadán Hlavní pořadatel.$suffix";
                }
            }
        }
        
        // spolecne restrikce
        if ($hlaska = $this->unifiedRestrictions($players, $suffix)) return $hlaska;

        return false;
    }

    // spolecne restrikce
    private function unifiedRestrictions($players, $suffix = null)
    {
        $unique_players = array();

        foreach ($players as $player) {

            // u kazde zadane osoby musi byt vyplneno jmeno
            if (!empty($player['id']) && empty($player['arrangement_name'])) {
                return "Některá jména nejsou vyplněna.$suffix";
            }

            // u kazde zadane osoby musi byt vyplneno ID
            if (!empty($player['id']) && empty($player['rc'])) {
                return "Některá ID nejsou vyplněna.$suffix";
            }

            // ID musi mit spravny tvar
            if (!empty($player['rc']) && strlen($player['rc']) != 8) {
                return "ID nemá správný tvar. [{$player['rc']}]{$suffix}";
            }

            // jmeno musi mit spravny tvar
            if (!empty($player['arrangement_name']) && !strpos($player['arrangement_name'], " ")) {
                return "Jméno nemá správný tvar. [{$player['arrangement_name']}]{$suffix}";
            }

            // Osoba musi byt unikatni
            if (!empty($player['rc'])) {
                if (in_array($player['rc'], $unique_players)) {
                    $player_whole_name = empty($player['arrangement_name']) ? null : $player['arrangement_name'] . " ";
                    return "ID nemohou být duplicitní. {$player_whole_name}[{$player['rc']}]{$suffix}";
                } else {
                    $unique_players[] = $player['rc'];
                }
            }

//             if (!empty($player['arrangement_name']) && !empty($player['rc'])) {
//                 $unique_players = empty($unique_players) ? $unique_players : $this->array_change_key_case_unicode($unique_players, CASE_UPPER);
//                 $player_whole_name = mb_strtoupper($player['arrangement_name'], 'UTF-8');
//
//                 if (array_key_exists($player_whole_name, $unique_players) && ($player['rc'] == $unique_players[$player_whole_name])) {
//                     return "Funkcionáři nemohou být duplicitní.$suffix $player_whole_name [{$player['rc']}]";
//                 } else {
//                     if (!empty($player['arrangement_name']) && !empty($player['rc'])) $unique_players[$player['arrangement_name']] = $player['rc'];
//                 }
//
//                 // jmeno musi mit spravny tvar
//                 if (!strpos($player_whole_name, " ")) {
//                     return "Jméno nemá správný tvar.$suffix [{$player_whole_name}]";
//                 }
//             }
        }
        
        return false;
    }

    // restrikce pro ulozeni obecneho nastaveni
    protected function variablesRestrictions($variables)
    {
        $ignore_warnings = $this->getUserSession('ignore_warnings');
    
        if (!empty($ignore_warnings) && $ignore_warnings === 'true') {
            return false;
        }

        foreach ($variables as $key => $value) {
            // validace kola
            if ($key == 'kolo') {
                if (empty($value) || !is_numeric($value) || $value > BasePresenter::MAXIMALNI_POCET_KOL) {
                    return "Chybně zadáno kolo.";
                }
            }
            // validace dne
            if ($key == 'den') {
                if (empty($value) || !$this->checkDateFormat($value)) {
                    return "Chybně zadáno datum.";
                }
            }
            // validace casu
            if (in_array($key, array('cas1', 'cas2'))) {
                $message = "Chybně zadán čas.";

                if (empty($value) || !is_numeric($value)) {
                    return $message;
                }
                
                if ($key == 'cas1' && $value > 23) {
                    return $message;
                }

                if ($key == 'cas2' && $value > 59) {
                    return $message;
                }
            }
            // validace poctu poradatelu
            if ($key == 'pocet_poradatelu') {
                if (empty($value) || !is_numeric($value)) {
                    return "Chybně zadán počet pořadatelů.";
                }
            }
        }

        return false;
    }

    public function checkDateFormat($date)
    {
        if (preg_match ("/^([0-9]{2})\.([0-9]{2})\.([0-9]{4})$/", $date, $parts)) {
            if (checkdate($parts[2], $parts[1], $parts[3])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // ulozeny aktualni sestavy
    protected function setArrangement($id_season, $id_squad, $players)
    {
        $return_message = null;

        if ($id_arrangement = $this->model->setArrangement($id_season, $id_squad, $players)) {
            $return_message .= "Sestava úspěšně uložena.\nID: $id_arrangement";
        } else {
            $return_message .= "Sestavu se nepodařilo uložit.";
            return $return_message;
        }

        if (!empty($players)) {
            foreach ($players as $position => $player) {
                if (!$this->model->setPlayerToArrangement($id_arrangement, $position, $player)) {
                    $return_message .= "\nNěkteré hráče se nepodařilo uložit do sestavy.";
                }
            }
        }
        
        return $return_message;
    }

    // vyvolani posledni sestavy
    public function actionLastArrangement()
    {
        $this->setView('ajax');

        if ($players = $this->model->getLastArrangement(BasePresenter::SEASON, $this->getUserSession('id_squad'))) {
            echo json_encode($players);
            return true;
        } else {
            return false;
        }
    }

    // ajaxove volani po stisknuti tlacitka Vymazat
    public function actionEraseArrangement()
    {
        $this->setView('ajax');
        
        $assoc = array(
            'erase_arrangement'  => 'arrangement_home',
            'erase_arrangement2' => 'arrangement_away',
            'erase_added'        => 'added_home',
            'erase_added2'       => 'added_away',
        );

        $this->unsetUserSession($assoc[$_POST['erase_id']]);

        return true;
    }
}
