<?php
/**
 * Základní třída modelu.
 */
class Model extends NObject
{
    public $database;
    public $player_columns = ", u.id id, concat_ws(' ', prijmeni, jmeno, suffix) as whole_name, concat_ws(' ', prijmeni, jmeno) as arrangement_name";
    public $import_player_columns = ", u.id_facr id_facr, concat_ws(' ', prijmeni, jmeno) as whole_name, concat_ws(' ', prijmeni, jmeno) as arrangement_name";

    public function __construct($database)
    {
        $this->database = $database;
    }

    // vytahne vsechny hrace dane sezony a muzstva
    public function getPlayers($id_season, $id_squad)
    {
        return dibi::query(
            "
                SELECT
                    DISTINCT *{$this->player_columns}
                FROM
                    uzivatel u
                JOIN
                    aktivni_hraci a
                ON
                    u.id = a.id_hrac
                WHERE
                    a.id_sezona = $id_season
                AND
                    a.stav = 'a'
                AND
                    u.id_facr IS NOT NULL
            UNION
                SELECT
                    DISTINCT *{$this->player_columns}
                FROM
                    uzivatel u
                JOIN
                    funkcionari f
                ON
                    u.id = f.id_uzivatel
                WHERE
                    f.id_sezona= $id_season
                AND
                    u.id_facr IS NOT NULL
            ORDER BY
                prijmeni ASC,
                jmeno ASC,
                suffix DESC
            "
        )->setRowClass('Player');
    }

    // ulozi sestavu do DB
    public function setArrangement($id_season, $id_squad, $players)
    {
        $table = "zapisy";

        $ai = dibi::query(
            "SHOW TABLE STATUS LIKE '$table'"
        )->fetch();

        $id = $ai["Auto_increment"];

        $saved = dibi::query(
            "
                INSERT INTO
                    $table
                    (id, id_season, id_squad, datetime)
                VALUES
                    ($id, $id_season, $id_squad, '" . Date("Y-m-d H:i:s") . "')
            "
        );
        
        if ($saved) {
            return $id;
        } else {
            return false;
        }
    }

    // ulozi hráce do sestavy
    public function setPlayerToArrangement($id_arrangement, $position, $player)
    {
        $player_id     = empty($player['id'])     ? 'NULL' : str_replace('_', '', mb_strstr($player['id'], '_'));
        $player_number = empty($player['number']) ? 'NULL' : $player['number'];
        $position     += 1;

        return dibi::query(
            "
                INSERT INTO
                    zapisy_players
                    (id_arrangement, id_player, position, number)
                VALUES
                    ($id_arrangement, $player_id, $position, $player_number)
            "
        );
    }

    // vytahne posledni ulozenou sestavu muzstva v dane sezone
    public function getLastArrangement($id_season, $id_squad)
    {
        if ($id_arrangement = dibi::query(
            "
                SELECT
                    id
                FROM
                    zapisy
                WHERE
                    id_season = $id_season
                AND
                    id_squad = $id_squad
                ORDER BY
                    datetime DESC
            "
        )->fetchSingle()) {
            if ($players = dibi::query(
            "
                SELECT
                    u.id_facr, u.datum_narozeni, z.position, z.id_player, z.number{$this->player_columns}
                FROM
                    zapisy_players z
                LEFT JOIN
                    uzivatel u
                ON
                    z.id_player = u.id_facr
                WHERE
                    z.id_arrangement = $id_arrangement
                ORDER BY
                    position ASC
            "
            )) {
                return $players->setRowClass('Player')->fetchAssoc('position');
            }
        }

        return false;
    }

    // vytahne vsechny tymy dane sezony a muzstva
    public function getTeams($id_season, $id_squad, $searched_phrase = null)
    {
        $search = (empty($searched_phrase)) ? null : " AND t.nazev LIKE '%$searched_phrase%'";

        return dibi::query(
            "
                SELECT DISTINCT
                    t.id, t.zkratka, t.nazev
                FROM
                    tymy t
                JOIN
                    zapisy_import_players zip
                ON
                    zip.id_club = t.id_facr
                JOIN
                    tymy_sezony_$id_squad ts
                ON
                    (
                        t.id = ts.tym_1
                    OR
                        t.id = ts.tym_2
                    OR
                        t.id = ts.tym_3
                    OR
                        t.id = ts.tym_4
                    OR
                        t.id = ts.tym_5
                    OR
                        t.id = ts.tym_6
                    OR
                        t.id = ts.tym_7
                    OR
                        t.id = ts.tym_8
                    OR
                        t.id = ts.tym_9
                    OR
                        t.id = ts.tym_10
                    OR
                        t.id = ts.tym_11
                    OR
                        t.id = ts.tym_12
                    OR
                        t.id = ts.tym_13
                    OR
                        t.id = ts.tym_14
                    OR
                        t.id = ts.tym_15
                    OR
                        t.id = ts.tym_16
                    )
                WHERE
                    ts.id_sezona = $id_season
                AND
                    t.zkratka <> 'BRZ'
                $search
                ORDER BY
                    t.zkratka ASC
            "
        )->setRowClass('Team');
    }

    // vytahne tym podle ID
    public function getTeam($id_team)
    {
        return dibi::query(
            "
                SELECT
                    t.id, t.zkratka, t.nazev, t.id_facr
                FROM
                    tymy t
                WHERE
                    t.id = $id_team
            "
        )->setRowClass('Team');
    }
    
    public function setImportPlayer($player, $id_club)
    {
        if (dibi::query(
            "
                SELECT
                    *
                FROM
                    zapisy_import_players zip
                WHERE
                    zip.id_facr = '{$player['id']}'
                AND
                    zip.id_club = '$id_club'
            "
        )->fetchSingle()) {
//             NDebugger::dump($id_club);
            return dibi::query(
                "
                    UPDATE
                        zapisy_import_players zip
                    SET
                        zip.jmeno = '{$player['jmeno']}', zip.prijmeni = '{$player['prijmeni']}'
                    WHERE
                        zip.id_facr = '{$player['id']}'
                    AND
                        zip.id_club = '$id_club'
                "
            );
        } else {
            return dibi::query(
                "
                    INSERT INTO
                        zapisy_import_players
                        (id_club, id_facr, jmeno, prijmeni)
                    VALUES
                        ('$id_club', '{$player['id']}', '{$player['jmeno']}', '{$player['prijmeni']}')
                "
            );
        }
    }

    // vytahne vsechny hrace dane sezony a muzstva
    public function getImportPlayers($id_team)
    {
        return dibi::query(
            "
                SELECT
                    *{$this->import_player_columns}, id_club
                FROM
                    zapisy_import_players u
                WHERE
                    u.id_club = $id_team
                AND
                    u.id_facr IS NOT NULL
                ORDER BY
                    prijmeni ASC,
                    jmeno ASC,
                    id_facr ASC
            "
        )->setRowClass('PlayerImport');
    }


    // vytahne oznaceni sezony na zaklade id sezony
    public function getSeasonName($id_season)
    {
        return dibi::query(
            "
                SELECT
                    oznaceni
                FROM
                    sezony
                WHERE
                    id = $id_season
            "
        )->fetchSingle();
    }
}
