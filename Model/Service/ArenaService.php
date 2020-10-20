<?php

namespace App\Model\Service;

use App\Model\Entity\Character;
use App\Model\Manager\CharacterManager;
use App\Model\Traits\EntityHelperTrait;

class ArenaService
{
    use EntityHelperTrait;

    public function prepareNewBadGuy()
    {
        if (isset($_POST['newBadGuy'])) {
            $characterAdd = $this->getRandomCharacterClassInstance(['nameChar' => 'bad guy']);
        }
    }

    public function prepareToFight(Character $character, string &$outMessage)
    {
        $CharacterManager = $this->getManager(Character::class);
        if ($CharacterManager instanceof CharacterManager) {
            if (isset($_GET['fight'])) {
                if (!isset($character)) {
                    $outMessage = 'Merci de créer un personnage ou de vous identifier.';
                } else {
                    if (!$CharacterManager->exists((int) $_GET['fight'])) {
                        $outMessage = 'Le personnage que vous voulez frapper n\'existe pas !';
                    } else {
                        $characterToFight = $CharacterManager->get((int) $_GET['fight']);
                        $characterInfos = $CharacterManager->get($character->nameChar());
                        $retour = $character->fight($character, $characterToFight);
                        switch ($retour) {
                            case Character::ITS_ME:
                                $outMessage = 'Mais pourquoi vous vous frappez !';
                                break;
                            case Character::CHARACTER_HIT:
                                $outMessage = 'Le personnage a bien été frappé !';

                                $CharacterManager->update($character);
                                $CharacterManager->update($characterToFight);
                                break;
                            case Character::CHARACTER_DIE:
                                $outMessage = 'Vous avez tué ce personnage.';

                                $CharacterManager->update($character);
                                $CharacterManager->delete($characterToFight);
                                break;

                            case Character::HERO_WIN:
                                $outMessage = 'Votre héro a gagné !';

                                $CharacterManager->update($character);
                                $CharacterManager->delete($characterToFight);
                                break;

                            case Character::HERO_LOOSE:
                                $outMessage = 'Votre héro a perdu !';

                                $CharacterManager->update($character);
                                $CharacterManager->delete($characterToFight);
                                break;
                        }
                    }
                }
            }
        }
    }
}
