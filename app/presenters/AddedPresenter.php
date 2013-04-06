<?php
class AddedPresenter extends ArrangementPresenter
{
    public function renderDefault($id_squad)
    {
        if ($id_squad = $this->getUserSession('id_squad')) {
            $this->setSetupVariables($id_squad);
        } else {
            throw new ForbiddenRequestException;
        }

        if ($players = $this->getUserSession('added_home')) {
            $this->template->sess_arrangement = json_encode($players);
        }

        $this->template->sess_variables = $this->setVariablesFromSession($this->getUserSession('variables'));

//         NDebugger::dump($this->getUserSession('variables'));
//         exit;
    }
    
    protected function setVariablesFromSession($variables)
    {
        $fields = array(
            'contest_level',
            'contest_type',
            'kolo',
            'den',
// cas se neuvadi, utkani muze zacit pozdeji
//             'cas1',
//             'cas2',
            'pocet_poradatelu',
        );

        $ret_variables = array();
        
        foreach ($fields as $field) {
            $ret_variables[$field] = null;

            if (!empty($variables[$field])) {
                // vyplnim hodnotou ze sessiony
                $ret_variables[$field] = $variables[$field];
            } else {
                if (!empty($this->template->variables[$field])) {
                    // popr. vyplnim vychozi hodnotou
                    $ret_variables[$field] = $this->template->variables[$field];
                }
            }
        }

        $ret_variables['away_team_title'] = $this->template->away_team;

        return $ret_variables;
    }
    
    protected function setSetupVariables($id_squad)
    {
        $this->template->players = $this->model->getPlayers(BasePresenter::SEASON, $id_squad)->fetchAssoc('id');
        $this->template->add_squad_title = $this->squads[$id_squad]['sheet_title'];
        $this->template->add_season_title = $this->model->getSeasonName(BasePresenter::SEASON);

        $this->template->variables = array(
            'den'  => Date("d.m.Y"),
//             'cas1' => '15',
//             'cas2' => '30',
            'pocet_poradatelu' => BasePresenter::POCET_PORADATELU,
        );

        if ($id_away_team = $this->getUserSession('id_away_team')) {
            $this->template->away_team = $this->model->getTeam($id_away_team)->fetch()->title;
        }
        
        $this->template->contests = $this->setContests();
    }

    protected function setContests()
    {
        return array(
            'level' => array(
                'Mistrovské',
                'Pohárové',
                'Přátelské',
            ),
            'type' => array(
                'Muži',
                'Dorostenci',
                'Žáci',
                'Ženy',
            ),
        );
    }


    /***************************/
    /**    AJAX               **/
    /***************************/

    // ajaxove volani po stisknuti tlacitka Soupiska - hosté
    public function actionClickAway()
    {
        $this->setView('ajax');

        // do SESSIONy ulozime domaci funkcionare na soupisce
        $this->setPlayersToSession($_POST['players']);

        // do SESSIONy ulozime promenne
        $this->setVariablesToSession($_POST['variables']);

        return true;
    }

    // do SESSIONy ulozime domaci funkcionare na soupisce
    protected function setPlayersToSession($players)
    {
        $this->setUserSession('added_home', $players);
    }

    // do SESSIONy ulozime promenne
    protected function setVariablesToSession($variables)
    {
        $this->setUserSession('variables', $variables);
    }
}
