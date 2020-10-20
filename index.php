<?php 
/**
 * Controller frontal (Routing)
 */

session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: arenaTP.php');
    exit();
}

use App\Controller\AppController;

require_once 'autoload.php';

$action = "home";
if(isset($_GET["action"])){
    $action = $_GET["action"];
}

$ctrl = new AppController();

if (isset($_SESSION['character'])) {
    $ctrl->setCharacter($_SESSION['character']);
}

switch($action){
    case "home":
        $ctrl->home();
    break;
    case "lobby":
        $ctrl->lobby();
    break;
    case "arena":
        $ctrl->arena();
    break;
    default:
        $ctrl->error404();
    break;
}