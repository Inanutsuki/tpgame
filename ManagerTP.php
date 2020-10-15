<?php 
class ManagerTP
{

    protected function dbConnect()
    {
        global $db;
        if (empty($db)) {
            try {
                $db = new PDO('mysql:host=localhost;dbname=tp_game;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }

        return $db;
    }

}
?>