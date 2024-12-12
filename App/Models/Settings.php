<?php

namespace App\Models;

use PDO;

class Settings extends Database
{
    public function StoreSettings($username, $colorMode)
    {
        $sql = <<<EOD
        update Users
        set ColorMode = $colorMode
        where Username = '$username'
        EOD;
        return $this->query($sql);
    }
}