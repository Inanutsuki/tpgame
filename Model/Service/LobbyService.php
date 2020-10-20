<?php

namespace App\Model\Service;

use App\Model\Entity\Character;
use App\Model\Manager\CharacterManager;
use App\Model\Traits\EntityHelperTrait;

class LobbyService
{
    use EntityHelperTrait;

    public function createNewHero(string &$outMessage): ?Character
    {
        $CharacterManager = $this->getManager(Character::class);

        if ($CharacterManager instanceof CharacterManager) {
            $character = $this->getRandomCharacterClassInstance(['nameChar' => $_POST['nameChar']]);           if (!$character->nomValide()) {
                $outMessage = 'Le nom choisi est invalide.';
                unset($character);
            } elseif ($CharacterManager->exists($character->nameChar())) {
                $outMessage = 'Le nom du personnage est déjà pris.';
            } else {
                $CharacterManager->add($character);
                return $character;
            }
        }
        return null;
    }

    public function useHero(string &$outMessage): ?Character
    {
        $CharacterManager = $this->getManager(Character::class);

        if ($CharacterManager instanceof CharacterManager) {
            if ($CharacterManager->exists($_POST['nameChar'])) {
                $character = $CharacterManager->get($_POST['nameChar']);
                $outMessage = 'Vous avez sélectionné ' . $character->nameChar();
                return $character;
            } else {
                $outMessage = 'Ce personnage n\'existe pas !';
                return null;
            }
        }
        return null;
    }
}