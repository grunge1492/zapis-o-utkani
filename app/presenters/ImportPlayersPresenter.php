<?php

class ImportPlayersPresenter extends BasePresenter
{
    public function renderDefault($table, $searched_phrase = null)
    {
        $squad_ids = array(
            // MUZSTVO A
            35 => 'Vycapy',
            36 => 'Jaromerice B',
            44 => 'Blatnice',
            46 => 'Chlístov',
            47 => 'Dukovany',
            48 => 'Namest B',
            49 => 'Vladislav',
            50 => 'Trebelovice',
            51 => 'M. Budejovice B',
            53 => 'Nove Syrovice',
            54 => 'Rudikov-Trnava',
            68 => 'Mohelno',
            69 => 'Okrisky B',

            // MUZSTVO B
            57 => 'Pysel',
            58 => 'Rouchovany B',
            59 => 'Trebenice B',
            60 => 'Konesin B',
            61 => 'Kralice',
            63 => 'Hodov',
            70 => 'Smrk',
            71 => 'Rudikov-Trnava B',
            72 => 'Dukovany B',
            73 => 'Namest C',
        );
    
        $this->template->report = array();

        foreach ($squad_ids as $id_team => $name)
        {
            if ($report = $this->importPlayers($id_team)) {
                $this->template->done = "Done.";
                $this->template->report = array_merge($this->template->report, $report);
            } else {
                $this->template->done = "Error.";
            }
        }
    }

    private function importPlayers($id_team)
    {
        $away_team_facr_id = $this->getTeamFACRID($id_team);

        if (empty($away_team_facr_id)) return false;

        // vymazu vsechny stavajici hrace
        if (!($this->model->deleteImportPlayers($away_team_facr_id[$id_team]))) return false;

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
