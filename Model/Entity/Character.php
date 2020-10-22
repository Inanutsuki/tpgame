<?php

namespace App\Model\Entity;

abstract class Character
{

    protected $_id;
    protected $_nameChar;
    protected $_damage;
    protected $_experience;
    protected $_levelChar;
    protected $_strength;
    protected $_DPS;
    protected $_ability;
    protected $_classChar;

    // protected $_initiative;

    const ITS_ME = 1;
    const CHARACTER_DIE = 2;
    const CHARACTER_HIT = 3;
    const HERO_WIN = 4;
    const HERO_LOOSE = 5;

    // CONSTRUCT

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    // HYDRATATION

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }


    // GETTER

    public function id()
    {
        return $this->_id;
    }

    public function nameChar()
    {
        return $this->_nameChar;
    }

    public function damage()
    {
        return $this->_damage;
    }

    public function experience()
    {
        return $this->_experience;
    }

    public function levelChar()
    {
        return $this->_levelChar;
    }

    public function strength()
    {
        return $this->_strength;
    }

    public function DPS()
    {
        return $this->_DPS;
    }

    public function ability()
    {
        return $this->_ability;
    }
    public function classChar()
    {
        return $this->_classChar;
    }

    // public function initiative()
    // {
    //     return $this->_initiative;
    // }


    // SETTER

    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setNameChar($nameChar)
    {
        if (is_string($nameChar)) {
            $this->_nameChar = $nameChar;
        }
    }

    public function setDamage($damage)
    {
        $damage = (int) $damage;
        if ($damage >= 0 && $damage <= 100) {
            $this->_damage = $damage;
        }
    }

    public function setExperience($experience)
    {
        $experience = (int) $experience;
        if ($experience >= 0 && $experience <= 100) {
            $this->_experience = $experience;
        }
    }

    public function setLevelChar($levelChar)
    {
        $levelChar = (int) $levelChar;
        if ($levelChar >= 0 && $levelChar <= 100) {
            $this->_levelChar = $levelChar;
        }
    }


    public function setStrength($strength)
    {
        $strength = (int) $strength;
        if ($strength >= 0) {
            $this->_strength = $strength;
        }
    }

    public function setDPS($DPS)
    {
        $DPS = (int) $DPS;
        if ($DPS >= 0) {
            $this->_DPS = $DPS;
        }
    }

    public function setAbility($ability)
    {
        $ability = (int) $ability;
        if ($ability >= 0 && $ability <= 100) {
            $this->_ability = $ability;
        }
    }

    public function setClassChar($classChar)
    {
        $classChar = (string) $classChar;
        $this->_classChar = $classChar;
    }

    // public function setInitiative($initiative)
    // {
    //     $initiative = (int) $initiative;
    //     if ($initiative >= 0) {
    //         $this->_initiative = $initiative;
    //     }
    // }

    // FUNCTION


    public function nomValide()
    {
        return !empty($this->_nameChar);
    }

    public function hit(Character $character)
    {
        if ($character->id() == $this->id()) {
            return self::ITS_ME;
        }
        $ability = 0;
        $characterState = $character->receiveDamage($this, $ability);

        if ($characterState == self::CHARACTER_DIE) {
            $this->increaseExperience();
        }

        return $characterState;
    }

    public function receiveDamage($attacker, int &$ability)
    {
        $DPS = $this->computeHitDamage($attacker, $ability);
        $attacker->_DPS = $DPS;
        $this->_damage += $DPS;
        if ($this->_damage >= 100) {
            return self::CHARACTER_DIE;
        }
        return self::CHARACTER_HIT;
    }

    protected function computeHitDamage($attacker, $ability){
        return ceil((random_int((int) (($attacker->levelChar() * 0.2) + 10), (int) (($attacker->strength() * 0.2) + 10)) + $ability));
    }


    public function increaseExperience()
    {
        $this->_experience += 15;
        if ($this->_experience >= 80) {
            $this->increaseLevelChar();
            $this->increaseStrength();
            $this->_experience = 0;

            return $this->_experience;
        }
        return $this->_experience;
    }

    public function increaseStrength()
    {
        $this->_strength += 15;
    }

    public function increaseLevelChar()
    {
        ++$this->_levelChar;
    }

    // public function increaseAbility()
    // {

    // }

    public function fight(Character $attacker, Character $badguy, array &$logFight)
    {
        $logFight = [];
        $attackerCount = 0;
        $badguyCount = 0;
        $attacker->_damage = 0;
        while ($attacker->_damage < 100 || $badguy->_damage < 100) {
            if ($attacker->_damage >= 100 || $badguy->_damage >= 100) {
                if ($badguy->_damage >= 100) {
                    return self::HERO_WIN;
                } else {
                    return self::HERO_LOOSE;
                }
            } else {
                if ($attackerCount == $badguyCount) {
                    $attacker->hit($badguy);
                    ++$attackerCount;
                    $logMessage = $attacker->nameChar() . ' a attaqué pour ' . $attacker->DPS();
                    $logFight[] = $logMessage;
                } elseif ($attackerCount > $badguyCount) {
                    $badguy->hit($attacker);
                    ++$badguyCount;
                    $logMessage = $badguy->nameChar() . ' a attaqué pour ' . $badguy->DPS();
                    $logFight[] = $logMessage;
                }
            }
        }
    }

    public function getClassName()
    {
        $name = str_replace("App\\Model\\Entity\\", "", static::class);
        return $name;
    }


    public static function factoryCreateFromData(array $data)
    {
        $className = $data['classChar'];
        $fullClassName = "App\\Model\\Entity\\" . $className;

        return new $fullClassName($data);
    }
}
