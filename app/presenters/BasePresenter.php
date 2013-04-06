<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    const U_MAIN_SESSION_KEY = 'u-main-session-key';

    const SEASON   = 55;

    const TITLE    = 'Zápis o utkání';
    const AUTHOR   = 'Grunge';
    const VERSION  = 'v1.3';
    const YEARS    = '© 2012-2013';
    const KEYWORDS = 'zapis o utkani, zapis';

    const HOME_TEAM_TITLE  = "Sokol Březník";
    const STADION_TITLE    = "Březník";
    const POCET_PORADATELU = 5;

    const STEP_1_TITLE = 'Start';
    const STEP_2_TITLE = 'Výběr soupeře';
    const STEP_3_TITLE = 'Soupiska — domácí';
    const STEP_4_TITLE = 'Soupiska — hosté';
    const STEP_5_TITLE = 'Zadní strana — domácí';
    const STEP_6_TITLE = 'Zadní strana — hosté';
    const STEP_7_TITLE = 'TISK do PDF';

    const MAXIMALNI_POCET_KOL = 26;

    protected $squads = array(
        1 => array(
            "button_title" => "Muži A — OP II. třída", // muzi a
            "sheet_title"  => "II. třída",
        ),
        4 => array(
            "button_title" => "Muži B — IV. třída skupina A", // muzi b
            "sheet_title"  => "IV. třída A",
        ),
    );

    protected $home_teams = array(
        1 => "Sokol Březník A", // muzi a
        4 => "Sokol Březník B", // muzi b
    );

    protected $model;

    public function startup()
    {
        parent::startup();
        $this->model = $this->getService('model');
    }

    protected function getUserSession($key)
    {
        $section = $this->session->getSection(self::U_MAIN_SESSION_KEY);

        if (empty($key)) {
            return $section;
        }

        if (empty($section[$key])) {
            return false;
        } else {
            return $section[$key];
        }
    }

    protected function setUserSession($key, $value)
    {
        $section = $this->session->getSection(self::U_MAIN_SESSION_KEY);

        if (empty($key)) {
            return false;
        } else {
            $section[$key] = $value;
        }
    }

    protected function unsetUserSession($key)
    {
        $section = $this->session->getSection(self::U_MAIN_SESSION_KEY);

        if (isset($section[$key])) {
            unset($section[$key]);
        }
    }

    protected function getTeamFACRID($id_team)
    {
        return $this->model->getTeam($id_team)->fetchPairs('id', 'id_facr');
    }
}
