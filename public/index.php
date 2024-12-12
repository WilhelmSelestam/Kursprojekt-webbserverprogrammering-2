<?php
// Leta upp och definiera rotmappen för projektet
define('ROOT', dirname(__DIR__));

require_once ROOT . "/vendor/autoload.php";
require_once ROOT . "/vendor/pecee/simple-router/helpers.php";
session_start();

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::setDefaultNamespace('\App\Controllers');

require_once ROOT . "/App/routes.php";

SimpleRouter::error(function(Request $request, \Exception $exception) {
    switch($exception->getCode()) {
        case 404:
             response()->redirect('/');
            break;
        default:
         response()->redirect('/');
    }
});

SimpleRouter::start();