<?php
class Player extends DibiRow // DibiRow obstará korektní načtení dat
{
    public function __construct($arr = array())
    {
        parent::__construct($arr);
        $this->setAttributes();
    }

    private function setAttributes()
    {
        $this->setSeoUrlName();
        $this->setRC();
        $this->getPlayerPhoto();

        $this->id = $this->id_facr;

        if (empty($this->cislo_dresu)) {
            $this->cislo_dresu = null;
        }
    }

    private function setSeoUrlName()
    {
        $id = empty($this->id) ? $this->id_facr : $this->id;
        $this->seo_url_name = $id . "-" . Format::makeSeoUrl($this->whole_name);
    }

    protected function getPlayerPhoto()
    {
        $photo_dir = "/images/players";
        $file = $photo_dir . "/" . $this->seo_url_name . ".jpg";

        if (file_exists(WWW_DIR . $file)) {
            $this->photo = $file;
        } else {
            $this->photo = $photo_dir . "/nophoto.png";
        }
    }

    private function setRC()
    {
        if (empty($this->id_facr)) {
            $this->rc = null;
        } else {
            $this->rc = $this->id_facr;
        }
    }
}
