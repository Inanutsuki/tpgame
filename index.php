<?php

/**
 * Controller frontal (Routing)
 */
require_once 'autoload.php';

session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php?action=lobby');
    exit();
}

use App\Controller\AppController;



$action = "home";
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

$ctrl = new AppController();

switch ($action) {
    case "home":
        $ctrl->home();
        break;
    case "lobby":
        $ctrl->lobby();
        break;
    case "arena":
        $ctrl->arena();
        break;
    case "createBadGuy":
        $ctrl->addNewBadGuy();
        break;
        case "fight":
            $ctrl->startFight();
            break;
    case "logout":
        header('Location: logout.php');
        break;
    default:
        $ctrl->error404();
        break;
}
