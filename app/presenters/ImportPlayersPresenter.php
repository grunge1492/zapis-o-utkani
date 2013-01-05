<?php

class ImportPlayersPresenter extends BasePresenter
{
    public function renderDefault($table, $searched_phrase = null)
    {
//         $id_team = 61; // Kralice
//         $id_team = 44; // Blatnice
//         $id_team = 53; // Nove Syrovice
        $id_team = 35; // Vycapy

        if ($report = $this->importPlayers($id_team)) {
            $this->template->done = "Done.";
            $this->template->report = $report;
        } else {
            $this->template->done = "Error.";
        }
    }

    private function importPlayers($id_team)
    {
        $away_team_facr_id = $this->getTeamFACRID($id_team);

        if (empty($away_team_facr_id)) return false;

        if (!($import = $this->parseCsv($away_team_facr_id[$id_team]))) return false;

        foreach ($import as $player) {
            $this->model->setImportPlayer($player, $away_team_facr_id[$id_team]);
        }

        return $import;
    }
    
    // vrati pole s importem
    private function parseCsv($id_team)
    {
        require_once LIBS_DIR . '/csv/DataSource.php';

        $import_dir = WWW_DIR . "/import/teams/" . BasePresenter::SEASON;
        $file = $import_dir . "/" . $id_team . ".csv";

        if (file_exists($file)) {
            $csv = new File_CSV_DataSource;
            $csv->settings = array(
                'delimiter' => ';',
                'eol' => ";",
                'length' => 999999,
                'escape' => '"',
            );

            $csv->load($file);
            return $csv->connect();
        } else {
            return false;
        }
    }
}
