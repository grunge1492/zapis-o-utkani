<?php

class PDFPresenter extends Added2Presenter
{
    public function renderDefault($id_squad)
    {
        if ($id_squad = $this->getUserSession('id_squad')) {
            $this->setSetupVariables($id_squad);
        } else {
            throw new ForbiddenRequestException;
        }

        $session = array(
            'arrangement_home' => $this->getUserSession('arrangement_home'),
            'arrangement_away' => $this->getUserSession('arrangement_away'),
            'added_home'       => $this->getUserSession('added_home'),
            'added_away'       => $this->getUserSession('added_away'),
            'variables'        => $this->setVariablesFromSession($this->getUserSession('variables')),
        );

        $session['variables']['squad_title']  = $this->squads[$id_squad]['sheet_title'];
        $session['variables']['season_title'] = $this->model->getSeasonName(BasePresenter::SEASON);

        $session['variables']['contest_level'] = $this->setContest('level', $session['variables']['contest_level']);
        $session['variables']['contest_type']  = $this->setContest('type',  $session['variables']['contest_type']);

        $session['variables']['home_team_title'] = BasePresenter::HOME_TEAM_TITLE;
        $session['variables']['stadion_title']   = BasePresenter::STADION_TITLE;

        $this->createPDF($session);
    }

    private function setContest($type, $value)
    {
        return (int) str_replace("contest_{$type}_", null, $value);
    }

    // vytvori PDF
    private function createPDF($session)
    {
        require_once LIBS_DIR . '/tcpdf/config/lang/ces.php';
        require_once LIBS_DIR . '/tcpdf/tcpdf.php';

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(BasePresenter::AUTHOR . " " . BasePresenter::YEARS);
        $pdf->SetTitle(BasePresenter::TITLE . " " . BasePresenter::VERSION);
        $pdf->SetSubject($session['variables']['home_team_title'] . " — " . $session['variables']['away_team_title'] . " [" . $session['variables']['den'] . "]");
        $pdf->SetKeywords(BasePresenter::KEYWORDS);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(0, 0, 0, true);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        $pdf->setLanguageArray($l);

        // ---------------------------------------------------------

// $fontname = $pdf->addTTFfont(K_PATH_IMAGES . 'courbd.ttf', 'TrueTypeUnicode', '', 32);
// NDebugger::dump($fontname);
// exit;

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        $pdf->SetFont('courbd', '', 12, '', true);

        /** PAGE 1 **/
        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // OBRAZEK NA POZADI
        // get the current page break margin
        $bMargin = $pdf->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $pdf->getAutoPageBreak();
        // disable auto-page-break
        $pdf->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = K_PATH_IMAGES . 'zapis-1.png';
        $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $pdf->setPageMark();

        $this->PDFSouper1($pdf, $session['variables']['home_team_title']);
        $this->PDFSouper2($pdf, $session['variables']['away_team_title']);
        $this->PDFStadion($pdf, $session['variables']['stadion_title']);

        call_user_func(array($this, 'PDFContestLevel' . $session['variables']['contest_level']), $pdf);
        call_user_func(array($this, 'PDFContestType' . $session['variables']['contest_type']), $pdf);

        $this->PDFSoutez($pdf, $session['variables']['squad_title']);
        $this->PDFKolo($pdf, ltrim(str_replace(".", null, $session['variables']['kolo']) . ".", "0"));
        $this->PDFRocnik($pdf, $session['variables']['season_title']);
        $this->PDFDen($pdf, $session['variables']['den']);
// cas se neuvadi, utkani muze zacit pozdeji
//         $this->PDFCas1($pdf, $session['variables']['cas1']);
//         $this->PDFCas2($pdf, $session['variables']['cas2']);

        $this->PDFPlayers1($pdf, $session['arrangement_home']);
        $this->PDFPlayers2($pdf, $session['arrangement_away']);

        $this->PDFCaptain1($pdf, $session['arrangement_home']);
        $this->PDFCaptain2($pdf, $session['arrangement_away']);

        /** PAGE 2 **/
        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // OBRAZEK NA POZADI
        // get the current page break margin
        $bMargin = $pdf->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $pdf->getAutoPageBreak();
        // disable auto-page-break
        $pdf->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = K_PATH_IMAGES . 'zapis-2.png';
        $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $pdf->setPageMark();

        $this->PDFFunctionars1($pdf, $session['added_home']);
        $this->PDFFunctionars2($pdf, $session['added_away']);

        $this->PDFHlPoradatel($pdf, $session['added_home']);
        $this->PDFPocetPoradatelu($pdf, $session['variables']['pocet_poradatelu']);

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('zapis-' . Date("Ymd-His") . '.pdf', 'I');
        exit; // bez tohohle exitu to nefrci
    }
    
    private function w(&$pdf, $html = null, $x = 0, $y = 0)
    {
        $pdf->writeHTMLCell($w=0, $h=0, $x, $y, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=false);
    }

    private function wFont(&$pdf, $big = false, $bold = false, $small = false)
    {
        $font_size   = $big   ? 12       : 10;
        $font_size   = $small ? 9        : $font_size;
        $font_weight = $bold  ? 'courbd' : 'cour';

        $pdf->SetFont($font_weight, '', $font_size, '', true);
    }

    private function wCapitals($ret)
    {
        if (!empty($ret)) {
            return str_replace("Š", "&Scaron;", mb_strtoupper($ret, 'UTF-8'));
        }
    }

    private function PDFSouper1(&$pdf, $text = null)
    {
        // Set font
        $this->wFont($pdf, true, true);

        $html = "
            <div id='souper1'>$text</div>
        ";

        $this->w($pdf, $html, 28, 22.3);
    }

    private function PDFSouper2(&$pdf, $text = null)
    {
        // Set font
        $this->wFont($pdf, true, true);

        $html = "
            <div id='souper2'>$text</div>
        ";

        $this->w($pdf, $html, 123, 22.3);
    }

    private function PDFStadion(&$pdf, $text = null)
    {
        // Set font
        $this->wFont($pdf, true);

        $html = "
            <div id='stadion'>$text</div>
        ";

        $this->w($pdf, $html, 123, 29.5);
    }

    private function PDFCircled(&$pdf, $x = 0, $y = 0)
    {
        $pdf->Image(K_PATH_IMAGES . 'circled.png', $x, 7.3, '', '', '', '', '', false, 300);
    }

    private function PDFContestLevel1($pdf)
    {
        $this->PDFCircled($pdf, 109);
    }

    private function PDFContestLevel2($pdf)
    {
        $this->PDFCircled($pdf, 126);
    }

    private function PDFContestLevel3($pdf)
    {
        $this->PDFCircled($pdf, 141);
    }

    private function PDFContestType1($pdf)
    {
        $this->PDFCircled($pdf, 154);
    }

    private function PDFContestType2($pdf)
    {
        $this->PDFCircled($pdf, 168);
    }

    private function PDFContestType3($pdf)
    {
        $this->PDFCircled($pdf, 181);
    }

    private function PDFContestType4($pdf)
    {
        $this->PDFCircled($pdf, 191);
    }

    private function PDFSoutez(&$pdf, $text = null)
    {
        // Set font
        $this->wFont($pdf);

        $html = "
            <div id='soutez'>$text</div>
        ";

        $this->w($pdf, $html, 111, 12.4);
    }

    private function PDFKolo(&$pdf, $text = null)
    {
        // Set font
        $this->wFont($pdf);

        $html = "
            <div id='kolo'>$text</div>
        ";

        $this->w($pdf, $html, 169, 12.5);
    }

    private function PDFCaptain(&$pdf, $players, $away = false)
    {
        if (empty($players)) return false;

        $position = null;

        foreach ($players as $player) {
            if ($player['captain'] == 'true' && !empty($player['id'])) {
                $position = $player['position'];
                break;
            }
        }
        
        if (empty($position)) return false;

        $top = 65.7 + ($position * 5.86);

        // Set font
        $this->wFont($pdf);

        if ($away) {
            $captain_suffix = "_2";
            $left = 205;
        } else {
            $captain_suffix = "_1";
            $left = 4;
        }

        $html = "
            <div id='captain$captain_suffix'>K</div>
        ";

        $this->w($pdf, $html, $left, $top);
    }

    private function PDFCaptain1(&$pdf, $players)
    {
        $this->PDFCaptain($pdf, $players);
    }

    private function PDFCaptain2(&$pdf, $players)
    {
        $this->PDFCaptain($pdf, $players, true);
    }

    private function PDFRocnik(&$pdf, $text = null)
    {
        // Set font
        $this->wFont($pdf);

        $html = "
            <div id='rocnik'>$text</div>
        ";

        $this->w($pdf, $html, 111, 16.3);
    }

    private function PDFDen(&$pdf, $text = null)
    {
        // Set font
        $this->wFont($pdf);

        $html = "
            <div id='den'>$text</div>
        ";

        $this->w($pdf, $html, 151, 16.3);
    }

    private function PDFCas1(&$pdf, $text = null)
    {
        // Set font
        $this->wFont($pdf);

        $html = "
            <div id='cas1'>$text</div>
        ";

        $this->w($pdf, $html, 184, 16.3);
    }

    private function PDFCas2(&$pdf, $text = null)
    {
        // Set font
        $this->wFont($pdf);

        $html = "
            <div id='cas2'>$text</div>
        ";

        $this->w($pdf, $html, 190, 16.3);
    }

    private function PDFPlayersPattern(&$pdf, $text = null)
    {
        if (empty($text[0]['id'])) return;

        $names = $numbers = $dress_numbers = null;

        foreach ($text as $key => $player) {
            if ($key >= 18) break;

            $name         = empty($player['arrangement_name']) ? null : $this->wCapitals($player['arrangement_name']);
            $number       = empty($player['rc'])               ? null : $player['rc'];
            $dress_number = empty($player['number'])           ? null : $player['number'];

            $names         .= "<div id='player1_$key'>$name</div>";
            $numbers       .= "<div id='number1_$key'>$number</div>";
            $dress_numbers .= "<div id='dress_number1_$key'>$dress_number</div>";
        }

        // Set font
        $this->wFont($pdf);
        $pdf->setCellHeightRatio(0.84);

        $html1 = "
            <div id='dress_numbers1'>
                $dress_numbers
            </div>
        ";
        $html2 = "
            <div id='players1'>
                $names
            </div>
        ";
        $html3 = "
            <div id='numbers1'>
                $numbers
            </div>
        ";

        return array($html1, $html2, $html3);
    }

    private function PDFPlayers1(&$pdf, $text = null)
    {
        list($html1, $html2, $html3) = $this->PDFPlayersPattern($pdf, $text);

        $this->w($pdf, $html1, 10, 68.3);
        $this->w($pdf, $html2, 17, 68.3);
        $this->w($pdf, $html3, 62, 68.3);
    }

    private function PDFPlayers2(&$pdf, $text = null)
    {
        list($html1, $html2, $html3) = $this->PDFPlayersPattern($pdf, $text);

        $this->w($pdf, $html1, 107.4, 68.3);
        $this->w($pdf, $html2, 114.4, 68.3);
        $this->w($pdf, $html3, 159.4, 68.3);
    }

    private function PDFFunctionarsPattern(&$pdf, $text = null)
    {
        if (empty($text[0]['id'])) return;

        $names = $numbers = null;

        foreach ($text as $key => $player) {
            if ($key >= 6) break;

            $name   = empty($player['arrangement_name']) ? null : $this->wCapitals($player['arrangement_name']);
            $number = empty($player['rc'])               ? null : $player['rc'];

            $names   .= "<div id='player1_$key'>$name</div>";
            $numbers .= "<div id='number1_$key'>$number</div>";
        }

        // Set font
        $this->wFont($pdf);
        $pdf->setCellHeightRatio(0.75);

        $html1 = "
            <div id='players1'>
                $names
            </div>
        ";
        $html2 = "
            <div id='numbers1'>
                $numbers
            </div>
        ";

        return array($html1, $html2);
    }
    
    private function PDFFunctionars1(&$pdf, $text = null)
    {
        list($html1, $html2) = $this->PDFFunctionarsPattern($pdf, $text);

        $this->w($pdf, $html1, 7, 22.7);
        $this->w($pdf, $html2, 67, 22.7);
    }

    private function PDFFunctionars2(&$pdf, $text = null)
    {
        list($html1, $html2) = $this->PDFFunctionarsPattern($pdf, $text);

        $this->w($pdf, $html1, 117, 22.7);
        $this->w($pdf, $html2, 177, 22.7);
    }

    private function PDFHlPoradatel(&$pdf, $text = null)
    {
        if (empty($text[6]) || empty($text[6]['id']) || $text[6]['position'] != 7) return;
    
        // Set font
        $this->wFont($pdf, false, false, true);
        $pdf->setCellHeightRatio(0.5);

        $html = "
            <div id='hlavni_poradatel'>{$this->wCapitals($text[6]['arrangement_name'])}</div>
            <div id='hlavni_poradatel_cislo'>{$text[6]['rc']}</div>
         ";

        $this->w($pdf, $html, 78, 64);
    }

    private function PDFPocetPoradatelu(&$pdf, $text = null)
    {
        // Set font
        $this->wFont($pdf, true, true);

        $html = "
            <div id='pocet_poradatelu'>$text</div>
         ";

        $this->w($pdf, $html, 102, 59);
    }
}
