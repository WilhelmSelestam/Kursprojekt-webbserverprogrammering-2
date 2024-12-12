<?php

namespace App\Controllers;

use App\Functions;
use App\Models\Discs;
use App\Models\Users;
use App\Models\Settings;

class SettingsController
{
    public function Settings()
    {
        $function = new Functions();
        $disc = new Discs();

        $function->checkIfLoggedin();
        $cssColorMode = $function->colorMode();

        $data = [
            'ColorMode' => $cssColorMode
        ];

        $function->renderView("/Settings/Settings.twig", $data);
    }

    public function StoreSettings()
    {
        $settings = new Settings();

        $colorMode = $_POST['colorMode'];

        $username = null;
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        }

        $settings->StoreSettings($username, $colorMode);

        response()->redirect("/settings");
    }
}