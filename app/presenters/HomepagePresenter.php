<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
    public function renderDefault()
    {
// Debugger::dump("pepa");

        $section = $this->session->getSection(BasePresenter::U_MAIN_SESSION_KEY);

        if (!empty($section)) {
            $section->remove();
        }

        $this->template->squads = $this->squads;
    }

    // ajaxove volani po stisknuti tlacitka TISK
    public function actionAjax()
    {
        $this->setUserSession('id_squad',        $_POST['id_squad']);
        $this->setUserSession('ignore_warnings', $_POST['ignore_warnings']);

        return true;
    }
}
