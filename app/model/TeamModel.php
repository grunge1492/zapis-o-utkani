<?php
class Team extends DibiRow // DibiRow obstará korektní načtení dat
{
    public function __construct($arr = array())
    {
        parent::__construct($arr);
        $this->setAttributes();
    }

    private function setAttributes()
    {
        $this->title = $this->nazev;

        $this->getTeamBadges();
        $this->setGraphicLabel();
    }

    private function getTeamBadges()
    {
        $zkratka = mb_strtolower($this->zkratka);
        $photo_dir = "/images/teams";
        $file  = $photo_dir . "/big_badges/" . $zkratka . ".png";

        if (file_exists(WWW_DIR . $file)) {
            $this->badge = $file;
            $this->badge_html = $this->getImgPattern($file, $this->title);
        }
    }
    
    private function getImgPattern($url, $title)
    {
        return "<img src='$url' alt='$title' />";
    }

    private function setGraphicLabel()
    {
        $this->label = "<span style='background-image: url(\"{$this->badge}\");'>{$this->title}</span>";
    }
}
