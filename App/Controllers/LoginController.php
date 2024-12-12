<?php

namespace App\Controllers;

use App\Functions;
use App\Models\Users;

class LoginController
{
    public function loginForm()
    {
        if (!isset($_SESSION['loggedin'])) {
            $_SESSION['loggedin'] = false;
        }

        $function = new Functions();

        $cssColorMode = $function->colorMode();

        $data = [
            'previuspage' => $_SESSION["referer"],
            'ColorMode' => $cssColorMode
        ];

        $function->renderView("/Login/Login.twig", $data);
    }

    public function loginForm2()
    {
        if (!isset($_SESSION['loggedin'])) {
            $_SESSION['loggedin'] = false;
        }

        $function = new Functions();
        $cssColorMode = $function->colorMode();

        $data = [
            'ColorMode' => $cssColorMode
        ];

        $function->renderView("/Login/Login2.twig", $data);
    }

    public function loginCheck()
    {
//        var_dump($_SESSION);
        $user = new Users();

        if (!isset($_SESSION['loggedin'])) {
            $_SESSION['loggedin'] = false;
        }

        if (!$_SESSION["loggedin"] || !isset($_SESSION['username'])) {
            $username = $_POST["username"] ?? null;
            $password = $_POST["password"] ?? null;
            $whereto = $_SESSION["referer"] ?? null;

//            var_dump($username);
//            var_dump($password);
//            var_dump($whereto);
//            var_dump($_SESSION);
//
//            var_dump($user->checkPassword($username)->Password == $password);
//            var_dump($user->checkPassword($username));
//            var_dump($password);

            if ($user->checkPassword($username) == $password) {
                $_SESSION["username"] = $username;
                $_SESSION["loggedin"] = true;
//                var_dump($_SESSION["loggedin"]);
                if ($user->checkAdmin($username)) {
                    $_SESSION["Admin"] = true;
//                    var_dump($_SESSION["Admin"]);
                }
                echo "successs";
                response()->redirect("$whereto");
            } else {
                echo "wrong password";
                $_SESSION["loggedin"] = false;

//                var_dump($user->checkPassword($username));

                response()->redirect("/login");
            }
        } else {
            echo "already loggedin";
            response()->redirect("/");
        }
    }

    public function loginCheck2()
    {
//        var_dump($_SESSION);
        $user = new Users();

        if (!isset($_SESSION['loggedin'])) {
            $_SESSION['loggedin'] = false;
        }

        if (!$_SESSION["loggedin"] || !isset($_SESSION['username'])) {
            $username = $_POST["username"] ?? null;
            $password = $_POST["password"] ?? null;

//            var_dump($username);
//            var_dump($password);
//            var_dump($_SESSION);

            if ($password == $user->checkPassword($username)->Password) {
                $_SESSION["username"] = $username;
                $_SESSION["loggedin"] = true;
//                var_dump($_SESSION["loggedin"]);
                echo "successs";
                if ($user->checkAdmin($username)) {
                    $_SESSION["Admin"] = true;
//                    var_dump($_SESSION["Admin"]);
                }
                response()->redirect("/");
            } else {
                echo "wrong password";
                $_SESSION["loggedin"] = false;

//                var_dump($user->checkPassword($username));

                response()->redirect("/login2");
            }
        } else {
            echo "already loggedin";
            response()->redirect("/");
        }
    }

    public function logout()
    {
        $_SESSION["loggedin"] = false;

        if (isset($_SESSION["username"])) {
            unset($_SESSION["username"]);
        }
        if (isset($_SESSION["Admin"])) {
            unset($_SESSION["Admin"]);
        }
        response()->redirect("/");
    }

    public function createUser()
    {
        $function = new Functions();
        $cssColorMode = $function->colorMode();

        $data = [
            'ColorMode' => $cssColorMode
        ];

        $function->renderView("/Login/CreateUser.twig", $data);
    }

    public function storeUser()
    {
//        var_dump($_POST);

        $username = $_POST['username'];
        $password = $_POST['password'];
        $colorMode = $_POST['colorMode'];

        $user = new Users();
        $success = $user->createUser($username, $password, $colorMode);

        if ($success) {
            response()->redirect("/");
        } else {
            response()->redirect("/createuser");
        }
    }
}