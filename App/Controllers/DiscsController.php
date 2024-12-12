<?php

namespace App\Controllers;

use App\Functions;
use App\Models\Discs;
use App\Models\Settings;
use App\Models\Users;

class DiscsController
{
    public function showAllDiscs()
    {
        $function = new Functions();
        $disc = new Discs();
        $settings = new Settings();

        $discType = $_GET["discType"] ?? null;
        $plastic = $_GET["plastic"] ?? null;
        $manufacrurer = $_GET["manufacturer"] ?? null;

        $sortorderlower = $_GET['sortorderlower'] ?? null;
        $sortorderhigher = $_GET['sortorderhigher'] ?? null;

//        var_dump($discType);
//        var_dump($plastic);
//        var_dump($manufacrurer);
//        var_dump($sortorderlower);
//        var_dump($sortorderhigher);

        $data = [
            'discs' => $disc->showSomeDiscs($manufacrurer, $plastic, $discType, $sortorderhigher, $sortorderlower),
            'types' => $disc->ShowDiscTypes(),
            'manufacturers' => $disc->ShowManufacturers(),
            'plastics' => $disc->ShowPlastics(),
            'ColorMode' => $function->colorMode()
        ];

        $function->renderView("/Discs/Discs.twig", $data);
    }

    public function ValidateDiscs()
    {
        $function = new Functions();
        $user = new Users();
        $disc = new Discs();

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            $loggedin = true;
        } else {
            $loggedin = false;
        }

        $username = null;

        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        }

        if (isset($_SESSION['loggedin']) && $user->checkAdmin($username) == 1) {
            $data = [
                'discs' => $disc->showNotValidatedDiscs(),
                'types' => $disc->ShowDiscTypes(),
                'manufacturers' => $disc->ShowManufacturers(),
                'plastics' => $disc->ShowPlastics(),
                'colorMode' => $function->colorMode(),
            ];

            $function->renderView("/Discs/ValidateDiscs.twig", $data);
        } else {
            response()->redirect("/");
        }
    }

    public function StoreValidatedDiscs()
    {
        $function = new Functions();
        $disc = new Discs();

        $discId = $_POST["discId"];

        $disc->ValidateDisc($discId);

        response()->redirect("/validatediscs");
    }

    public function showOneDisc(string $fromUrl)
    {
        $function = new Functions();
        $disc = new Discs();

        $cssColorMode = $function->colorMode();

        $data = [
            'disc' => $disc->showOneDisc($fromUrl),
            'ColorMode' => $cssColorMode
        ];

//        var_dump($data);

        $function->renderView("/Discs/OneDisc.twig", $data);
    }

    public function AdDisc()
    {
        $function = new Functions();
        $disc = new Discs();

        $function->checkIfLoggedin();

        $fields2 = [
            'discName' => '',
            'discDescription' => '',
            'speed' => '',
            'glide' => '',
            'turn' => '',
            'fade' => '',
            'price' => '',
            'discType' => 1,
            'manufacturer' => 1,
            'plastic' => 1,
        ];

//        if (isset($_SESSION["fields"])){
//            unset($_SESSION["fields"]);
//        }
//
//        if (isset($_SESSION["errors"])){
//            unset($_SESSION["errors"]);
//        }
//
//        if (isset($_SESSION["ERROR"])){
//            unset($_SESSION["ERROR"]);
//        }

        $data = [
            'types' => $disc->ShowDiscTypes(),
            'manufacturers' => $disc->ShowManufacturers(),
            'plastics' => $disc->ShowPlastics(),
            'ColorMode' => $function->colorMode(),
            'errors' => $_SESSION["errors"] ?? false,
            'ERROR' => $_SESSION["ERROR"] ?? false,
            'fields' => $_SESSION["fields"] ?? $fields2,
        ];

//        var_dump($_SESSION["errors"]);

        $function->renderView("/Discs/AddDisc.twig", $data);
    }

    public function StoreDiscs()
    {
        $disc = new Discs();

//        var_dump($_POST);
//        var_dump($_FILES);
//        var_dump($_SESSION);

        $rules = [
            'discName' => [
                'filter' => FILTER_SANITIZE_STRING,
            ],
            'discDescription' => [
                'filter' => FILTER_SANITIZE_STRING,
            ],
            'speed' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1, 'max_range' => 15]
            ],
            'glide' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1, 'max_range' => 8]
            ],
            'turn' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => -5, 'max_range' => 5]
            ],
            'fade' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => -5, 'max_range' => 5]
            ],
            'price' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1, 'max_range' => 10000]
            ],
            'discType' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1, 'max_range' => count($disc->ShowDiscTypes())]
            ],
            'manufacturer' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1, 'max_range' => count($disc->ShowManufacturers())]
            ],
            'plastic' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1, 'max_range' => count($disc->ShowPlastics())]
            ],
            'beginnerfriendly' => [
                'filter' => FILTER_VALIDATE_BOOL
            ],
        ];

        $validatedInput = filter_input_array(INPUT_POST, $rules);
//        var_dump($validatedInput);
        $errors = [];

        if ($validatedInput["discName"]) {
            $uncleandiscname = $validatedInput['discName'];
        } else  {
            $errors[] = "Problem with discname";
        }

        if ($validatedInput["discDescription"]) {
            $discDescription = $validatedInput['discDescription'];
        } else {
            $errors[] = "Problem with discdescription";
        }

        if ($validatedInput["speed"]) {
            $speed = $validatedInput['speed'];
        } else {
            $errors[] = "Speed needs to be between 1 and 15";
        }

        if ($validatedInput["glide"]) {
            $glide = $validatedInput['glide'];
        } else {
            $errors[] = "Glide needs to be between 1 and 8";
        }

        if ($validatedInput["turn"]) {
            $turn = $validatedInput['turn'];
        } else {
            $errors[] = "Turn needs to be between -5 and 5";
        }

        if ($validatedInput["fade"]) {
            $fade = $validatedInput['fade'];
        } else {
            $errors[] = "Fade needs to be between -5 and 5";
        }

        if ($validatedInput["price"]) {
            $price = $validatedInput['price'];
        } else {
            $errors[] = "Price needs to be between 1 and 10000";
        }

        if ($validatedInput["discType"]) {
            $discType = $validatedInput['discType'];
        } else {
            $errors[] = "Invalid disctype";
        }

        if ($validatedInput["manufacturer"]) {
            $manufacturer = $validatedInput['manufacturer'];
        } else {
            $errors[] = "Invalid maufacturer";
        }

        if ( $validatedInput["plastic"]) {
            $plastic = $validatedInput['plastic'];
        } else {
            $errors[] = "Invalid plastictype";
        }

        if ($validatedInput["beginnerfriendly"]) {
            $beginnerfriendly = $validatedInput['beginnerfriendly'];
        } else {
            $errors[] = "Problem with beginnerthing";
        }

        if (count($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["fields"] = $validatedInput;
            response()->redirect($_SERVER["HTTP_REFERER"]);
        }

        $discnameful1 = str_replace(" ", "-", $uncleandiscname);
        $discnameful2 = str_replace("#", "-", $discnameful1);
        $discname = str_replace('"', " ", $discnameful2);

        $target_dir = "Images/";
        $target_file = $target_dir . basename($_FILES['img']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $uploadOk = 1;

        if (file_exists($target_file)) {

            $uploadOk = 0;
            $_SESSION["ERROR"] = "Sorry, file already exists";
            response()->redirect("/addisc");
        }

        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["img"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $_SESSION["ERROR"] = "File is not an image";

                response()->redirect("/addisc");

                $uploadOk = 0;
            }
        }

        if ($_FILES["img"]["size"] > 10000000) {
            $_SESSION["ERROR"] = "Sorry, your file is too large";
            response()->redirect("/addisc");
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $_SESSION["ERROR"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
            response()->redirect("/addisc");
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $_SESSION["ERROR"] = "Sorry, your file was not uploaded";
            response()->redirect("/addisc");
        } else {
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["img"]["name"])) . " has been uploaded.";
            } else {
                $_SESSION["ERROR"] = "Sorry, there was an error uploading your file";
                response()->redirect("/addisc");
            }
        }

        $realfilename = '/' . $target_file;

        $disc = new Discs();
        $success = $disc->StoreDisc($discname, $discDescription, $speed, $glide, $turn, $fade, $price, $discType, $manufacturer, $plastic, $beginnerfriendly, $realfilename);


        response()->redirect("/discs");
    }

    public function EditDisc($fromUrl)
    {
        $function = new Functions();
        $disc = new Discs();

        $function->checkIfLoggedin();
        $cssColorMode = $function->colorMode();

//        var_dump($fromUrl);
        $data = [
            'disc' => $disc->showOneDisc($fromUrl),
            'types' => $disc->ShowDiscTypes(),
            'manufacturers' => $disc->ShowManufacturers(),
            'plastics' => $disc->ShowPlastics(),
            'thedisc' => $fromUrl,
            'ColorMode' => $cssColorMode
        ];

        $function->renderView("/Discs/EditDisc.twig", $data);
    }

    public function UpdateDisc()
    {
//        var_dump($_POST);

        $discId = $_POST["thediscId"];
        $discname = $_POST['discName'];
        $discDescription = $_POST['discDescription'];
        $speed = $_POST['speed'];
        $glide = $_POST['glide'];
        $turn = $_POST['turn'];
        $fade = $_POST['fade'];
        $price = $_POST['price'];
        $discType = $_POST['discType'];
        $manufacturer = $_POST['manufacturer'];
        $plastic = $_POST['plastic'];
        $beginnerfriendly = $_POST['beginnerfriendly'];

        $disc = new Discs();
        $disc->UpdateDisc($discId, $discname, $discDescription, $speed, $glide, $turn, $fade, $price, $discType, $manufacturer, $plastic, $beginnerfriendly);

        var_dump($disc->UpdateDisc($discId, $discname, $discDescription, $speed, $glide, $turn, $fade, $price, $discType, $manufacturer, $plastic, $beginnerfriendly));

        response()->redirect("/discs/$discname");
    }

    public function DeleteDisc()
    {
        $disc = new Discs();

        $discId = $_POST['discId'] ?? null;

        $disc->DeleteDisc($discId);
//        var_dump($disc->DeleteDisc($discId));

        response()->redirect("/discs");
    }

    public function PreDeleteDisc()
    {
        $disc = new Discs();

        $discId = $_POST['discId'] ?? null;

        $disc->DeleteDisc($discId);
//        var_dump($disc->DeleteDisc($discId));

        response()->redirect("/validatediscs");
    }

    public function AddManufacturer()
    {
        $function = new Functions();

        $function->checkIfLoggedin();
        $cssColorMode = $function->colorMode();

        $data = [
            'ColorMode' => $cssColorMode
        ];

        $function->renderView("/Discs/AddManufacturer.twig", $data);
    }

    public function StoreManufacturer()
    {
        $manufacturerName = $_POST['ManufacturerName'];
        $manufacturerDescription = $_POST['ManufacturerDescription'];
        $manufacturerCountry = $_POST['ManufacturerCountry'];

        $disc = new Discs();
        $success = $disc->StoreManufacturer($manufacturerName, $manufacturerDescription, $manufacturerCountry);

//        var_dump($success);
        response()->redirect("/discs");
    }

    public function AddPlastic()
    {
        $function = new Functions();
        $disc = new Discs();

        $function->checkIfLoggedin();

        $data = [
            'manufacturers' => $disc->ShowManufacturers(),
            'ColorMode' => $function->colorMode()
        ];
        $function->renderView("/Discs/AddPlastic.twig", $data);
    }

    public function StorePlastic()
    {
        $plasticName = $_POST['PlasticName'];
        $plasticDescription = $_POST['PlasticDescription'];
        $manufacturerId = $_POST['ManufacturerId'];
//        var_dump($_POST);
//        var_dump($plasticDescription);
//        var_dump($plasticName);
//        var_dump($manufacturerId);

        $disc = new Discs();
        $success = $disc->StorePlastic($plasticName, $plasticDescription, $manufacturerId);

        response()->redirect("/");
    }
}