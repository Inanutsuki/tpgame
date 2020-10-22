<?php

namespace App\Model\Service;

use App\Model\Entity\Character;
use App\Model\Manager\CharacterManager;
use App\Model\Traits\EntityHelperTrait;

class ArenaService
{
    use EntityHelperTrait;

    public function prepareNewBadGuy(Character $character)
    {
        $CharacterManager = $this->getManager(Character::class);
        if ($CharacterManager instanceof CharacterManager) {
            if (isset($_POST['newBadGuy'])) {
                $characterAdd = $this->getRandomCharacterClassInstance(['nameChar' => 'bad guy']);
                $CharacterManager->addNewBadGuy($characterAdd, $character);

                return $characterAdd;
            }
        }
    }
    // string &$outMessage
    public function prepareToFight(Character $character, array &$logFight)
    {
        $CharacterManager = $this->getManager(Character::class);
        if ($CharacterManager instanceof CharacterManager) {
            if (!isset($character)) {
                $outMessage = 'Merci de créer un personnage ou de vous identifier.';
            } else {
                if (!$CharacterManager->exists((int) $_GET['fight'])) {
                    $outMessage = 'Le personnage que vous voulez frapper n\'existe pas !';
                } else {
                    $characterToFight = $CharacterManager->get((int) $_GET['fight']);
                    $characterInfos = $CharacterManager->get($character->nameChar());
                    $retour = $character->fight($character, $characterToFight, $logFight);
                    switch ($retour) {
                        case Character::ITS_ME:
                            $outMessage = 'Mais pourquoi vous vous frappez !';
                            $logFight[] = $outMessage;
                            break;
                        case Character::CHARACTER_HIT:
                            $CharacterManager->update($character);
                            $CharacterManager->update($characterToFight);
                            break;
                        case Character::CHARACTER_DIE:
                            $CharacterManager->update($character);
                            $CharacterManager->delete($characterToFight);
                            break;

                        case Character::HERO_WIN:
                            $outMessage = 'Votre héro a gagné !';
                            $logFight[] = $outMessage;

                            $CharacterManager->update($character);
                            $CharacterManager->delete($characterToFight);
                            break;

                        case Character::HERO_LOOSE:
                            $outMessage = 'Votre héro a perdu !';
                            $logFight[] = $outMessage;

                            $CharacterManager->update($character);
                            $CharacterManager->delete($characterToFight);
                            break;
                    }
                }
            }
            return $logFight;
        }
    }
}
