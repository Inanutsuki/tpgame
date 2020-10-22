<?php

namespace App\Model\Entity;

class Warrior extends Character
{

    public function hit(Character $character)
    {
        // parent::hit($character);

        if ($character->id() == $this->id()) {
            return self::ITS_ME;
        }
        $ability = $this->damage() * 20;

        $characterState = $character->receiveDamage($this, $ability);

        if ($characterState == self::CHARACTER_DIE) {
            $this->increaseExperience();
        }

        return $characterState;
    }

    // public function receiveDamage($attacker, int &$ability)
    // {
    //     // parent::receiveDamage($attacker, $ability);

    //     $DPS = ceil((random_int((int) (($attacker->levelChar() * 0.2) + 10), (int) (($attacker->strength() * 0.2) + 10)) + $ability));
    //     $attacker->_DPS = $DPS;
    //     $this->_damage += $DPS;
    //     echo "j'ai la rage";
    //     if ($this->_damage >= 100) {
    //         return self::CHARACTER_DIE;
    //     }
    //     return self::CHARACTER_HIT;
    // }

    public function receiveDamage($attacker, int &$ability)
    {
        echo "j'ai la rage";

        return parent::receiveDamage($attacker, $ability);
    }

    protected function computeHitDamage($attacker, $ability){
        return ceil((random_int((int) (($attacker->levelChar() * 0.2) + 10), (int) (($attacker->strength() * 0.2) + 10)) + $ability));
    }

}
