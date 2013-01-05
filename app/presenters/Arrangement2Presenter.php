<?php
class Arrangement2Presenter extends ArrangementPresenter
{
    public function renderDefault($id_squad)
    {
        // natazeni hracu hostu
        $this->template->players = $this->getImportPlayers();

        // natazeni hracu hostu ze sessiony
        if ($players = $this->getUserSession('arrangement_away')) {
            $this->template->sess_arrangement = json_encode($players);
        }
    }

    // do SESSIONy ulozime hostujici hrace na soupisce
    protected function setPlayersToSession($players)
    {
        $this->setUserSession('arrangement_away', $players);
    }

    // ajaxove volani po stisknuti tlacitka Vymazat
    public function actionEraseArrangement()
    {
        $this->setView('ajax');

        $this->unsetUserSession('arrangement_away');

        return true;
    }

    // ulozeny aktualni sestavy - U HOSTU SE SESTAVA NEUKLADA
    protected function setArrangement($id_season, $id_squad, $players)
    {
        return true;
    }
}
