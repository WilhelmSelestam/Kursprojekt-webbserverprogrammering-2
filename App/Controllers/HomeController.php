<?php

namespace App\Controllers;

use App\Functions;
use App\Models\Users;

class HomeController
{
    /**
     * Enklast möjliga demometod. Gör ytterligare klasser efter behov.
     * Exempelvis en klass UsersController ifall du ska ha användare och där hanterar du allt med användaren.
     * @return void
     */
    public function index()
    {
        $function = new Functions();
        $user = new Users();

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            $loggedin = true;
        } else {
            $loggedin = false;
        }

        $username = null;

        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        }

        $cssColorMode = $function->colorMode();

        $data = [
            'loggedinStatus' => $loggedin,
            'username' => $username,
            'Admin' => $user->checkAdmin($username),
            'ColorMode' => $cssColorMode
        ];

        if (isset($_SESSION['loggedin']) && $user->checkAdmin($username) == 1) {
            $function->renderView("/Home/HomeAdmin.twig", $data);
        } else {
            $function->renderView("/Home/Home.twig", $data);
        }

    }

}