<?php
class ArrangementPresenter extends BasePresenter
{
    public function renderDefault($id_squad)
    {
        if ($id_squad = $this->getUserSession('id_squad')) {
            $this->template->players = $this->model->getPlayers(BasePresenter::SEASON, $id_squad)->fetchAssoc('id');
        } else {
            throw new NForbiddenRequestException;
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
            throw new NForbiddenRequestException;
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

    // restrikce pro ulozeni sestavy
    protected function playersRestrictions($players, $suffix = null, $no_count_players = false)
    {
        if (!$this->getUserSession('ignore_warnings')) {
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
                return "V sestavě nemůžou figorovat duplicitní hráči.$suffix";
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

        return false;
    }

    // restrikce pro ulozeni funkcionaru
    protected function functionarsRestrictions($players, $suffix = null, $hl_poradatel = false)
    {
        if (!$this->getUserSession('ignore_warnings')) {
            return false;
        }

        $counter = 0;
        $unique_ids = $unique_numbers = array();

        foreach ($players as $player) {
            $counter++;

            // musi byt zadan minimalne vedouci muzstva
            if ($counter == 1) {
                if (empty($player['id'])) {
                    return "Nebyl zadán vedoucí mužstva.$suffix";
                }
            }

            if ($hl_poradatel && $counter == 7) {
                if (empty($player['id'])) {
                    return "Nebyl zadán Hlavní pořadatel.$suffix";
                }
            }
        }

        return false;
    }

    // restrikce pro ulozeni obecneho nastaveni
    protected function variablesRestrictions($variables)
    {
        if (!$this->getUserSession('ignore_warnings')) {
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
