<?php

class ClubSelectPresenter extends BasePresenter
{
    public function renderDefault()
    {
        $id_squad = $this->getUserSession('id_squad');

        if (!empty($id_squad) && array_key_exists($id_squad, $this->home_teams)) {
            $this->template->squad_title = $this->home_teams[$id_squad];
        } else {
            throw new ForbiddenRequestException;
        }

        if ($id_away_team = $this->getUserSession('id_away_team')) {
            $this->template->away_team = $this->model->getTeam($id_away_team)->fetch();
        }
    }

    // ajaxove volani po stisknuti tlacitka Soupiska - domaci
    public function actionAjax()
    {
        $id_away_team = $_POST['id_away_team'];

        $this->setUserSession('id_away_team', $id_away_team);

        return true;
    }
}
