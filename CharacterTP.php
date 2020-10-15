<?php

class CharacterTP
{

    private $_id;
    private $_nameChar;
    private $_damage;
    private $_experience;
    private $_levelChar;
    private $_strength;
    private $_DPS;

    const ITS_ME = 1;
    const CHARACTER_DIE = 2;
    const CHARACTER_HIT = 3;
    const CHARACTER_LEVEL_UP = 4;
    const CHARACTER_STRENGTH_UP = 5;

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

    public function nomValide()
    {
        return !empty($this->_nameChar);
    }

    // FUNCTION

    public function hit(CharacterTP $character)
    {
        if ($character->id() == $this->id()) {
            return self::ITS_ME;
        }

        $characterState = $character->receiveDamage($this);

        if ($characterState == self::CHARACTER_DIE) {
            $this->increaseExperience();
        }

        return $characterState;
    }

    public function receiveDamage($attacker)
    {
        $DPS = ceil(random_int ( (int) (($attacker->levelChar()*0.2)+10) , (int) (($attacker->strength() *0.2 )+10)));
        // $attacker->_DPS = $DPS;
        $this->_damage += $DPS;
        if ($this->_damage >= 100) {
            return self::CHARACTER_DIE;
        }
        return self::CHARACTER_HIT;
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
        return self::CHARACTER_LEVEL_UP;
    }
}
