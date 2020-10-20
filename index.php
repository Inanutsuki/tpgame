<?php 
/**
 * Controller frontal (Routing)
 */

use App\Controller\AppController;

require_once 'autoload.php';

$action = "home";
if(isset($_GET["action"])){
    $action = $_GET["action"];
}

$ctrl = new AppController();

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