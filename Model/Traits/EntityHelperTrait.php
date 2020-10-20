<?php
namespace App\Model\Traits;

use App\Model\Database\DatabasePDO;
use App\Model\Entity\Character;
use App\Model\Manager\Manager;

trait EntityHelperTrait {
    protected function getManager(string $entityFullName): Manager {
        try {
            $managerClassName = $entityFullName . "Manager";
            $managerClassName = str_replace("\\Entity\\", "\\Manager\\", $managerClassName);
            $db = DatabasePDO::dbConnect();
            $manager = new $managerClassName($db);

            return $manager;
        }catch(\Exception $err){
            throw new \Exception("No manager exists for this entity.");
        }
    }

    protected function getEntity(string $entity) {
        try {
            $entityClassPath = "App\\Model\\Entity\\" . $entity;
            return $entityClassPath;
        }catch(\Exception $err){

        }
    }

    protected function getRandomCharacterClass()
    {
        $availableClasses = [
            "Warrior", "Wizard"
        ];
        $namespace = "App\\Model\\Entity";

        $randomIndex = random_int(0, count($availableClasses) - 1);
        $className = $availableClasses[$randomIndex];

        return $namespace . "\\" . $className;
    }

    protected function getRandomCharacterClassInstance(array $data): Character
    {
        $className = $this->getRandomCharacterClass();

        return new $className($data);
    }
}