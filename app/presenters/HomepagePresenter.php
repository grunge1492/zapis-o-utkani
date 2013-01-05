<?php

/**
 * Homepage presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class HomepagePresenter extends BasePresenter
{
    public function renderDefault()
    {
        $section = $this->session->getSection(BasePresenter::U_MAIN_SESSION_KEY);

        if (!empty($section)) {
            $section->remove();
        }

        $this->template->squads = $this->squads;
    }

    // ajaxove volani po stisknuti tlacitka TISK
    public function actionAjax()
    {
        $id_squad = $_POST['id_squad'];

        $this->setUserSession('id_squad', $id_squad);

        return true;
    }
}
