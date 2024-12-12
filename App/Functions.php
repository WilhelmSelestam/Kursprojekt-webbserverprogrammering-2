<?php

namespace App;

use App\Models\Users;

class Functions
{
    public function renderView($fileToLoad, $data = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader('../App/Views');
        $twig = new \Twig\Environment($loader, []);
        $template = $twig->load($fileToLoad);
        echo $template->render($data);
    }

    public function checkIfLoggedin()
    {
        if (!isset($_SESSION['loggedin'])) {
            $_SESSION['loggedin'] = false;
        }

        if (!$_SESSION["loggedin"]) {
            $_SESSION["referer"] = request()->getUrl()->getPath();
            response()->redirect("/login");
        }
    }

    public function colorMode()
    {
        $user = new Users();

        $username = null;

        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        }

        $colorMode = $user->checkColorMode($username);
        $cssColorMode = "";

        if ($colorMode == 1){
            $cssColorMode = '/css/whitemode.css';
        } elseif ($colorMode == 2){
            $cssColorMode = '/css/darkmode.css';
        } elseif ($colorMode == 3){
            $cssColorMode = '/css/redmode.css';
        }

        return $cssColorMode;
    }
}