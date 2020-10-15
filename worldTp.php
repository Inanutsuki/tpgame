<?php
function classLoader($className)
{
    require $className . '.php';
}

spl_autoload_register('classLoader');

session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: arenaTP.php');
    exit();
}

$db = new PDO('mysql:host=localhost;dbname=tp_game', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$CharacterManager = new CharacterManagerTP($db);

if (isset($_SESSION['character'])) {
    $character = $_SESSION['character'];
}

if (isset($_POST['creer']) && isset($_POST['nameChar'])) {
    $character = new CharacterTP(['nameChar' => $_POST['nameChar']]);
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
    $characterAdd = new CharacterTP(['nameChar' => 'bad guy']);
    $CharacterManager->addNewBadGuy($characterAdd);
} elseif (isset($_GET['hit'])) {
    if (!isset($character)) {
        $message = 'Merci de créer un personnage ou de vous identifier.';
    } else {
        if (!$CharacterManager->exists((int) $_GET['hit'])) {
            $message = 'Le personnage que vous voulez frapper n\'existe pas !';
        } else {
            $characterToHit = $CharacterManager->get((int) $_GET['hit']);
            $characterInfos = $CharacterManager->get($character->nameChar());
            $retour = $character->hit($characterToHit);
            switch ($retour) {
                case CharacterTP::ITS_ME:
                    $message = 'Mais pourquoi vous vous frappez !';
                    break;
                case CharacterTP::CHARACTER_HIT:
                    $message = 'Le personnage a bien été frappé !';

                    $CharacterManager->update($character);
                    $CharacterManager->update($characterToHit);
                    break;
                case CharacterTP::CHARACTER_DIE:
                    $message = 'Vous avez tué ce personnage.';

                    $CharacterManager->update($character);
                    $CharacterManager->delete($characterToHit);
                    break;
            }
        }
    }
}
