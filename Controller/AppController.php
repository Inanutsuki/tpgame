<?php

namespace App\Controller;

use App\Model\Entity\Character;
use App\Model\Manager\CharacterManager;
use App\Model\Service\LobbyService;
use App\Model\Service\ArenaService;


class AppController extends BaseController
{

    protected $_character;

    public function home()
    {
        $this->render("home.html.php");
    }

    public function lobby()
    {
        $CharacterManager = $this->getManager(Character::class);
        $countHero = $CharacterManager->count();
        $data = [
            'countHero' => $countHero,
        ];
        $this->render("lobby.html.php", $data);
    }

    public function arena()
    {
        if (isset($_POST['createHero']) && isset($_POST['nameChar'])) {
            $CharacterManager = $this->getManager(Character::class);
            $LobbyService = new LobbyService;
            if ($CharacterManager instanceof CharacterManager) {
                $message = "";
                $character = $LobbyService->createNewHero($message);
                if ($character == null) {
                    $countHero = $CharacterManager->count();
                    $data = [
                        'message' => $message,
                        'countHero' => $countHero,
                    ];
                    $this->render("lobby.html.php", $data);
                } else {
                    $_SESSION['character'] = $character;
                    $characters = $CharacterManager->getList($_POST['nameChar']);
                    $data = [
                        'character' => $character,
                        'characters' => $characters,
                    ];
                    $this->render("arena.html.php", $data);
                }
            }
        } elseif (isset($_POST['useHero']) && isset($_POST['nameChar'])) {
            $CharacterManager = $this->getManager(Character::class);
            $LobbyService = new LobbyService;
            $message = "";
            $character = $LobbyService->useHero($message);
            if ($character == null) {
                if ($CharacterManager instanceof CharacterManager) {
                    $countHero = $CharacterManager->count();
                    $data = [
                        'message' => $message,
                        'countHero' => $countHero,
                    ];
                    $_SESSION['character'] = $character;
                    $this->render("lobby.html.php", $data);
                }
            } else {
                if ($CharacterManager instanceof CharacterManager) {
                    $characters = $CharacterManager->getList($_POST['nameChar']);
                    $data = [
                        'character' => $character,
                        'characters' => $characters,
                    ];
                    $_SESSION['character'] = $character;
                    $this->render('arena.html.php', $data);
                }
            }
        }
    }

    public function addNewBadGuy()
    {
        $ArenaService = new ArenaService;
        $CharacterManager = $this->getManager(Character::class);

        $character = $_SESSION['character'];
        $nameChar = $character->nameChar();
        $ArenaService->prepareNewBadGuy($character);
        $characters = $CharacterManager->getList($nameChar);
        $data = [
            'character' => $character,
            'characters' => $characters,
        ];
        $_SESSION['character'] = $character;
        $this->render('arena.html.php', $data);
    }

    public function startFight()
    {
        $ArenaService = new ArenaService;
        $CharacterManager = $this->getManager(Character::class);
        $character = $_SESSION['character'];
        $nameChar = $character->nameChar();
        $logFight = [];
        $ArenaService->prepareToFight($character, $logFight);
        $characters = $CharacterManager->getList($nameChar);
        $data = [
            'character' => $character,
            'characters' => $characters,
            'logFight' => $logFight,
        ];
        $_SESSION['character'] = $character;
        $this->render('arena.html.php', $data);
    }

    public function error404()
    {
    }



    public function getCharacter(): Character
    {
        return $this->_character;
    }
}
