<?php
function classLoader($className)
{
    // $className = "App\Model\Entity\Warrior";
    $path = str_replace("App\\", "", $className); // $path = "Model\Entity\Warrior";
    $path = str_replace("\\", "/", $path); // $path = "Model/Entity/Warrior";
    require $path . '.php'; // return "Model/Entity/Warrior.php";
}

spl_autoload_register('classLoader');