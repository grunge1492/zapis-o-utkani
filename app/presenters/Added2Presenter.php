<?php
class Added2Presenter extends AddedPresenter
{
    public function renderDefault($id_squad)
    {
        if ($id_squad = $this->getUserSession('id_squad')) {
            $this->setSetupVariables($id_squad);
        } else {
            throw new NForbiddenRequestException;
        }

        // natazeni funkcionaru hostu
        $this->template->players = $this->getImportPlayers();

        // natazeni funkcionaru hostu ze sessiony
        if ($players = $this->getUserSession('added_away')) {
            $this->template->sess_arrangement = json_encode($players);
        }

        $this->template->sess_variables = $this->setVariablesFromSession($this->getUserSession('variables'));
    }

    /***************************/
    /**    AJAX               **/
    /***************************/

    // ajaxove volani po stisknuti tlacitka TISK
    public function actionPrint()
    {
        $this->setView('ajax');

        // do SESSIONy ulozime domaci funkcionare na soupisce
        $this->setPlayersToSession($_POST['players']);

        // do SESSIONy ulozime promenne
        $this->setVariablesToSession($_POST['variables']);

        // validace sestavy domaci
        if ($error_message = $this->playersRestrictions($this->getUserSession('arrangement_home'), " (" . BasePresenter::STEP_3_TITLE . ")")) {
            echo $error_message;
            return false;
        }

        // validace sestavy hostu
        if ($error_message = $this->playersRestrictions($this->getUserSession('arrangement_away'), " (" . BasePresenter::STEP_4_TITLE . ")", true)) {
            echo $error_message;
            return false;
        }

        // validace funkcionaru domaci
        if ($error_message = $this->functionarsRestrictions($this->getUserSession('added_home'), " (" . BasePresenter::STEP_5_TITLE . ")", true)) { // + hl. poradatel
            echo $error_message;
            return false;
        }

        // validace funkcionaru hostu
        if ($error_message = $this->functionarsRestrictions($this->getUserSession('added_away'), " (" . BasePresenter::STEP_6_TITLE . ")")) {
            echo $error_message;
            return false;
        }

        // validace obecneho nastaveni
        if ($error_message = $this->variablesRestrictions($this->getUserSession('variables'))) {
            echo $error_message;
            return false;
        }

        // ulozeni sestavy do DB
        if ($error_message = $this->setArrangement(BasePresenter::SEASON, $this->getUserSession('id_squad'), $this->getUserSession('arrangement_home'))) {
        } else {
            echo $error_message;
            return false;
        }

        return true;
    }

    // do SESSIONy ulozime hostujici funkcionare na soupisce
    protected function setPlayersToSession($players)
    {
        $this->setUserSession('added_away', $players);
    }
}
