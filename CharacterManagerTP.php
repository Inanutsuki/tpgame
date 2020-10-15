<?php
class CharacterManagerTP
{
    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

    public function add(CharacterTP $character)
    {
        $req = $this->_db->prepare('INSERT INTO gamecharacter(nameChar) VALUE(:nameChar)');
        $req->bindValue(':nameChar', $character->nameChar());

        $req->execute();
        $character->hydrate([
            'id' => $this->_db->lastInsertId(),
            'damage' => 0,
            'experience' => 0,
            'levelChar' => 3,
            'strength' => 10,
            'DPS' => 2,
        ]);
        $this->update($character);
    }

    // public function addNewHero(CharacterTP $character)
    // {
    //     $req = $this->_db->prepare('INSERT INTO gamecharacter(nameChar) VALUE(:nameChar)');
    //     $req->bindValue(':nameChar', $character->nameChar());
    //     $req->execute();

    //     $character->hydrate([
    //         'id' => $this->_db->lastInsertId(),
    //         'damage' => 0,
    //         'experience' => 0,
    //         'levelChar' => 0,
    //         'strength' => 0,
    //     ]);
    // }
    public function addNewBadGuy(CharacterTP $character)
    {
        $req = $this->_db->prepare('INSERT INTO gamecharacter(nameChar) VALUE(:nameChar)');
        $req->bindValue(':nameChar', $character->nameChar());
        $req->execute();

        $character->hydrate([
            'id' => $this->_db->lastInsertId(),
            'damage' => 0,
            'experience' => 0,
            'levelChar' => 0,
            'strength' => 0,
            'DPS' => 0,
        ]);
    }

    public function delete(CharacterTP $character)
    {
        $this->_db->exec('DELETE FROM gamecharacter WHERE id=' . $character->id());
    }

    public function get($info)
    {
        if (is_int($info)) {
            $req = $this->_db->query('SELECT * FROM gamecharacter WHERE id = ' . $info);
            $data = $req->fetch(PDO::FETCH_ASSOC);

            return new CharacterTP($data);
        } else {
            $req = $this->_db->prepare('SELECT * FROM gamecharacter WHERE nameChar = :nameChar');
            $req->execute([':nameChar' => $info]);

            return new CharacterTP($req->fetch(PDO::FETCH_ASSOC));
        }
    }

    public function getList($nameChar)
    {
        $characters = [];

        $req = $this->_db->prepare('SELECT * FROM gamecharacter WHERE nameChar <> :nameChar ORDER BY nameChar');
        $req->execute([':nameChar' => $nameChar]);

        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $characters[] = new CharacterTP($data);
        }

        return $characters;
    }

    public function update(CharacterTP $character)
    {
        $req = $this->_db->prepare('UPDATE gamecharacter SET damage = :damage, experience = :experience, levelChar = :levelChar, strength = :strength, DPS = :DPS WHERE id = :id');
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
