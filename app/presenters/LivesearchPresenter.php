<?php

class LivesearchPresenter extends BasePresenter
{
    private $tables = array(
        'tymy' => 'Teams',
    );

    public function renderDefault($table, $searched_phrase = null)
    {
        if (array_key_exists($table, $this->tables)) {
            $method_name = 'get' . $this->tables[$table];
            $matches = call_user_func(array($this, $method_name), $searched_phrase);
            $this->sendResponse(new NJsonResponse($matches));
        }
    }

    private function getTeams($searched_phrase)
    {
        return $this->model->getTeams(BasePresenter::SEASON, $this->getUserSession('id_squad'), $searched_phrase)->fetchAll();
    }
}
