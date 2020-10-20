<?php
namespace App\Model\Manager;

use \PDO;

class Manager {
    protected $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}