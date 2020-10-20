<?php
// function classLoader($className)
// {
//     require $className . '.php';
// }

// spl_autoload_register('classLoader');

session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: arenaTP.php');
    exit();
}

// $db = new PDO('mysql:host=localhost;dbname=tp_game', 'root', '');
// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$db = DatabasePDO::dbConnect();

$CharacterManager = new CharacterManager($db);

if (isset($_SESSION['character'])) {
    $character = $_SESSION['character'];
}

if (isset($_POST['creer']) && isset($_POST['nameChar'])) {
    $character = getRandomCharacterClassInstance(['nameChar' => $_POST['nameChar']]);
    if (!$character->nomValide()) {
        $message = 'Le nom choisi est invalide.';
        unset($character);
    } elseif ($CharacterManager->exists($character->nameChar())) {
        $message = 'Le nom du personnage est déjà pris.';
    } else {
        $CharacterManager->add($character);
    }
} elseif (isset($_POST['utiliser']) && isset($_POST['nameChar'])) {
    if ($CharacterManager->exists($_POST['nameChar'])) {
        $character = $CharacterManager->get($_POST['nameChar']);
        $message = 'Vous avez sélectionné ' . $character->nameChar();
    } else {
        $message = 'Ce personnage n\'existe pas !';
    }
} elseif (isset($_POST['newBadGuy'])) {
    $characterAdd = getRandomCharacterClassInstance(['nameChar' => 'bad guy']);

    $CharacterManager->addNewBadGuy($characterAdd, $character);
} elseif (isset($_GET['fight'])) {
    if (!isset($character)) {
        $message = 'Merci de créer un personnage ou de vous identifier.';
    } else {
        if (!$CharacterManager->exists((int) $_GET['fight'])) {
            $message = 'Le personnage que vous voulez frapper n\'existe pas !';
        } else {
            $characterToFight = $CharacterManager->get((int) $_GET['fight']);
            $characterInfos = $CharacterManager->get($character->nameChar());
            $retour = $character->fight($character, $characterToFight);
            switch ($retour) {
                case Character::ITS_ME:
                    $message = 'Mais pourquoi vous vous frappez !';
                    break;
                case Character::CHARACTER_HIT:
                    $message = 'Le personnage a bien été frappé !';

                    $CharacterManager->update($character);
                    $CharacterManager->update($characterToFight);
                    break;
                case Character::CHARACTER_DIE:
                    $message = 'Vous avez tué ce personnage.';

                    $CharacterManager->update($character);
                    $CharacterManager->delete($characterToFight);
                    break;

                case Character::HERO_WIN:
                    $message = 'Votre héro a gagné !';

                    $CharacterManager->update($character);
                    $CharacterManager->delete($characterToFight);
                    break;

                case Character::HERO_LOOSE:
                    $message = 'Votre héro a perdu !';

                    $CharacterManager->update($character);
                    $CharacterManager->delete($characterToFight);
                    break;
            }
        }
    }
}



// Utility
function getRandomCharacterClassInstance(array $data): Character {
    $className = getRandomCharacterClass();

    return new $className($data);
}

function getRandomCharacterClass() {
    $availableClasses = [
        "Warrior", "Wizard"
    ];
    $namespace = "";

    $randomIndex = random_int(0, count($availableClasses) - 1);
    $className = $availableClasses[$randomIndex];

    return $namespace . "\\" . $className;
}