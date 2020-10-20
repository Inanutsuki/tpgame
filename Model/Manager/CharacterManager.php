<?php
namespace App\Model\Manager;

use \PDO;
use App\Model\Entity\Character;

class CharacterManager extends Manager
{
    public function add(Character $character)
    {
        $req = $this->_db->prepare('INSERT INTO gamecharacter(nameChar) VALUE(:nameChar)');
        $req->bindValue(':nameChar', $character->nameChar());

        $req->execute();
        $character->hydrate([
            'id' => $this->_db->lastInsertId(),
            'classChar' => $character->getClassName(),
            'ability' => 100,
            'damage' => 0,
            'experience' => 0,
            'levelChar' => 3,
            'strength' => 45,
            'DPS' => 0,
        ]);

        $this->update($character);
    }
    
    public function addNewBadGuy(Character $character, $heroInfos)
    {
        $req = $this->_db->prepare('INSERT INTO gamecharacter(nameChar) VALUE(:nameChar)');
        $req->bindValue(':nameChar', $character->nameChar());
        $req->execute();

        $character->hydrate([
            'id' => $this->_db->lastInsertId(),
            'classChar' => $character->getClassName(),
            'ability' => 100,
            'damage' => 0,
            'experience' => 0,
            'levelChar' => ceil(random_int($heroInfos->levelChar()-1, $heroInfos->levelChar()+1)),
            'strength' => 0,
            'DPS' => 0,
        ]);
        
        $strength = (int) ($character->levelChar() * 15);

        $character->hydrate([
            'strength' => $strength
        ]);

        $this->update($character);
    }

    public function delete(Character $character)
    {
        $this->_db->exec('DELETE FROM gamecharacter WHERE id=' . $character->id());
    }

    public function get($info)
    {
        if (is_int($info)) {
            $req = $this->_db->query('SELECT * FROM gamecharacter WHERE id = ' . $info);
            $data = $req->fetch(PDO::FETCH_ASSOC);

            return new Character($data);
        } else {
            $req = $this->_db->prepare('SELECT * FROM gamecharacter WHERE nameChar = :nameChar');
            $req->execute([':nameChar' => $info]);

            return new Character($req->fetch(PDO::FETCH_ASSOC));
        }
    }

    public function getList($nameChar)
    {
        $characters = [];

        $req = $this->_db->prepare('SELECT * FROM gamecharacter WHERE nameChar <> :nameChar ORDER BY nameChar');
        $req->execute([':nameChar' => $nameChar]);

        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $characters[] = new Character($data);
        }

        return $characters;
    }

    public function update(Character $character)
    {
        $req = $this->_db->prepare('UPDATE gamecharacter SET classChar = :classChar, ability = :ability, damage = :damage, experience = :experience, levelChar = :levelChar, strength = :strength, DPS = :DPS WHERE id = :id');
        $req->bindValue(':classChar', $character->classChar(), PDO::PARAM_STR);
        $req->bindValue(':ability', $character->ability(), PDO::PARAM_INT);
        $req->bindValue(':damage', $character->damage(), PDO::PARAM_INT);
        $req->bindValue(':experience', $character->experience(), PDO::PARAM_INT);
        $req->bindValue(':levelChar', $character->levelChar(), PDO::PARAM_INT);
        $req->bindValue(':strength', $character->strength(), PDO::PARAM_INT);
        $req->bindValue(':DPS', $character->DPS(), PDO::PARAM_INT);
        $req->bindValue(':id', $character->id(), PDO::PARAM_INT);

        $req->execute();
    }

    public function count()
    {
        return $this->_db->query('SELECT COUNT(*) FROM gamecharacter')->fetchColumn();
    }

    public function exists($info)
    {
        if (is_int($info)) {
            return (bool) $this->_db->query('SELECT COUNT(*) FROM gamecharacter WHERE id =' . $info)->fetchColumn();
        }

        $req = $this->_db->prepare('SELECT COUNT(*) FROM gamecharacter WHERE nameChar = :nameChar');
        $req->execute([':nameChar' => $info]);

        return (bool) $req->fetchColumn();
    }
}
