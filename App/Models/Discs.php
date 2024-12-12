<?php

namespace App\Models;

use PDO;

class Discs extends Database
{
    public function showAllDiscs()
    {
        $sql = <<<EOD
            select * from Discs
            join Manufacturers M on M.ManufacturerId = Discs.ManufacturerId
            join Types T on T.TypeId = Discs.TypeId
            join Plastics P on P.PlasticId = Discs.PlasticId;
        EOD;
        return $this->fetchAll($sql, PDO::FETCH_OBJ);
    }

    public function showSomeDiscs($manufacturer, $plastic, $discType, $sortorderhigher, $sortorderlower)
    {
        $sql = <<<EOD
        select * from Discs
        join Manufacturers M on M . ManufacturerId = Discs . ManufacturerId
        join Types T on T . TypeId = Discs . TypeId
        join Plastics P on P . PlasticId = Discs . PlasticId
        where 1=1
        and Validated = true

        EOD;
        if (isset($plastic)) {
            $sql .= <<<EOD
            and P.PlasticId = $plastic
            
            EOD;
        }
        if (isset($manufacturer)) {
            $sql .= <<<EOD
            and M.ManufacturerId = $manufacturer
            
            EOD;
        }
        if (isset($discType)) {
            $sql .= <<<EOD
            and T.TypeId = $discType
            
            EOD;
        }
        if (isset($sortorderhigher)) {
            $sql .= <<<EOD
            order by Price desc
            
            EOD;
        }
        if (isset($sortorderlower)) {
            $sql .= <<<EOD
            order by Price asc
            ,
            EOD;
        }
        return $this->fetchAll($sql, PDO::FETCH_OBJ);
     }


    public function showNotValidatedDiscs()
    {
        $sql = <<<EOD
        select * from Discs
        join Manufacturers M on M . ManufacturerId = Discs . ManufacturerId
        join Types T on T . TypeId = Discs . TypeId
        join Plastics P on P . PlasticId = Discs . PlasticId
        where Validated = false
        EOD;
        return $this->fetchAll($sql, PDO::FETCH_OBJ);
    }

    public function ValidateDisc($discId)
    {
        $validateDisc = <<<EOD
        update Discs
        set Validated = true
        where DiscId = $discId;
        EOD;
        return $this->query($validateDisc);
    }

    public function showOneDisc($name)
    {
        $sql = <<<EOD
         select DiscId, DiscName, DiscDescription, Speed, Glide, Turn, Fade, PlasticName, ManufacturerName, DiscTypes,Price, BeginnerFriendly, ImageLink
         from Discs
         join Manufacturers M on M.ManufacturerId = Discs.ManufacturerId
         join Types T on T.TypeId = Discs.TypeId
         join Plastics P on P.PlasticId = Discs.PlasticId
            where DiscName = '%$name%';
        EOD;
        return $this->fetch($sql, PDO::FETCH_OBJ);
    }

    public function ShowDiscTypes()
    {
        $sql = <<<EOD
         select DiscTypes, TypeId from Types;
        EOD;
        return $this->fetchAll($sql, PDO::FETCH_OBJ);
    }

    public function ShowManufacturers()
    {
        $sql = <<<EOD
         select ManufacturerName, ManufacturerId from Manufacturers;
        EOD;
        return $this->fetchAll($sql, PDO::FETCH_OBJ);
    }

    public function ShowPlastics()
    {
        $sql = <<<EOD
         select PlasticName, PlasticId from Plastics;
        EOD;
        return $this->fetchAll($sql, PDO::FETCH_OBJ);
    }

    public function StoreDisc($discname, $discDescription, $speed, $glide, $turn, $fade, $price, $discType, $manufacturer, $plastic, $beginnerfriendly, $imagelink )
    {
        $createDisc = <<<EOD
        insert into Discs(DiscName, DiscDescription, Speed, Glide, Turn, Fade, TypeId, ManufacturerId, PlasticId, Price, BeginnerFriendly, ImageLink, Validated)
        values ('$discname', '$discDescription', $speed, $glide, $turn, $fade, $discType, $manufacturer, $plastic, $price, $beginnerfriendly, '$imagelink', false);
        EOD;
        return $this->query($createDisc);
    }

    public function StoreManufacturer($manufacturerName, $manufacturerDescription, $manufacturerCountry)
    {
        $createManufacturer = <<<EOD
        insert into manufacturers(ManufacturerName, ManufacturerCountry, ManufacturerDescription)
        values ('$manufacturerName', '$manufacturerCountry', '$manufacturerDescription');
        EOD;
        return $this->query($createManufacturer);
    }

    public function StorePlastic($plasticName, $plasticDescription, $manufacturerId)
    {
        $createPlastic = <<<EOD
        insert into plastics (PlasticName, ManufacturerId, PlasticDescription)
        values ('$plasticName', '$manufacturerId', '$plasticDescription');
        EOD;
        return $this->query($createPlastic);
    }

    public function UpdateDisc($discId, $discname, $discDescription, $speed, $glide, $turn, $fade, $price, $discType, $manufacturer, $plastic, $beginnerfriendly)
    {
        $updateDisc = <<<EOD
        update Discs
        set DiscName = '$discname', DiscDescription = '$discDescription', Speed = $speed, Glide = $glide, Turn = $turn, Fade = $fade, TypeId = $discType, 
            ManufacturerId = $manufacturer, PlasticId = $plastic, Price = $price, BeginnerFriendly = $beginnerfriendly
        where DiscId = $discId;
        EOD;
        return $this->query($updateDisc);
    }

    public function DeleteDisc($discId)
    {
        $deleteDisc = <<<EQD
        delete from Discs where DiscId = $discId;
        EQD;
        return $this->query($deleteDisc);
    }
}