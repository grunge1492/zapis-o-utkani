<?php
class PlayerImport extends Player // DibiRow obstará korektní načtení dat
{
    protected function getPlayerPhoto()
    {
        $photo_dir = "/images/players/" . $this->id_club;
        $file = $photo_dir . "/" . $this->seo_url_name . ".jpg";

        if (file_exists(WWW_DIR . $file)) {
            $this->photo = $file;
        } else {
            $this->photo = "/images/players/nophoto.png";
        }
    }
}
