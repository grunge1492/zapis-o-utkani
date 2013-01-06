<?php

class ImportPlayersPresenter extends BasePresenter
{
    public function renderDefault($table, $searched_phrase = null)
    {
        // MUZSTVO A
//         $id_team = 35; // Vycapy
//         $id_team = 36; // Jaromerice B
//         $id_team = 44; // Blatnice
//         $id_team = 46; // Chlístov
//         $id_team = 47; // Dukovany
//         $id_team = 48; // Namest B
//         $id_team = 49; // Vladislav
//         $id_team = 50; // Trebelovice
//         $id_team = 51; // M. Budejovice B
//         $id_team = 53; // Nove Syrovice
//         $id_team = 54; // Rudikov-Trnava
//         $id_team = 68; // Mohelno
//         $id_team = 69; // Okrisky B

        // MUZSTVO B
//         $id_team = 57; // Pysel
//         $id_team = 58; // Rouchovany B
//         $id_team = 59; // Trebenice B
//         $id_team = 60; // Konesin B
//         $id_team = 61; // Kralice
//         $id_team = 63; // Hodov
//         $id_team = 70; // Smrk
//         $id_team = 71; // Rudikov-Trnava B
//         $id_team = 72; // Dukovany B
//         $id_team = 73; // Namest C

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
