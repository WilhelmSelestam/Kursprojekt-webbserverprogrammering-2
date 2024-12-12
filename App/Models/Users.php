<?php

namespace App\Models;

use PDO;

class Users extends Database
{
    public function checkPassword($username)
    {
        $sql = <<<EOD
            select Password
            from Users
            where Username like '$username';
        EOD;
        return $this->fetch($sql, PDO::FETCH_OBJ);
    }

    public function createUser($username, $password, $colorMode)
    {
        $createUser = <<<EOD
        insert into Users(username, password, ColorMode)
        values ('$username', '$password', $colorMode);
        EOD;
        return $this->query($createUser);
    }

    public function checkAdmin($username)
    {
        $sql = <<<EOD
            select Admin
            from Users
            where Username like '$username';
        EOD;
        return $this->fetch($sql, PDO::FETCH_COLUMN);
    }

    public function checkColorMode($username)
    {
        $sql = <<<EOD
            select ColorMode
            from Users
            where Username like '$username';
        EOD;
        return $this->fetch($sql, PDO::FETCH_COLUMN);
    }
}