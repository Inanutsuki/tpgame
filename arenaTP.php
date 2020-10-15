<?php
require 'worldTP.php'
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gladiators</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5 d-flex justify-content-center"">
        <div class=" col-6">
        <p>Nombre de personnage créés : <?= $CharacterManager->count() ?></p>
        <?php
        if (isset($message) || isset($messageUP) || (isset($message) && isset($messageUP))) {
            echo '<p>' . $message . ' ' . isset($messageUP) . '</p>';
        }
        if (isset($character)) {
        ?>
            <p><a href="?logout=1">Déconnexion</a></p>
            <form action="" method="post">
                <div class="form-row">
                    <input type="submit" value="Créer de nouveaux méchant" name="newBadGuy">
                </div>
            </form>
            <fieldset>
                <legend>Mes informations</legend>
                <p>
                    Nom : <?= htmlspecialchars($character->nameChar()) ?><br>
                    Dégats : <?= $character->damage() ?><br>
                    Force : <?= $character->strength() ?><br>
                    Level : <?= $character->levelChar() ?><br>
                    Experience : <?= $character->experience() ?><br>
                    DGT : <?= (int) (($character->levelChar() * 0.2) + 10) ?> - <?= (int) (($character->strength() * 0.2) + 10) ?>
                </p>
            </fieldset>
            <fieldset>
                <legend>Qui frapper ?</legend>
                <p>
                    <?php
                    $characters = $CharacterManager->getList($character->nameChar());
                    if (empty($character)) {
                        echo 'Personne à frapper !';
                    } else {
                        foreach ($characters as $oneCharacter) {
                            echo '<button type="button" class="btn btn-dark"><a style="color:white;" href="?hit=' . $oneCharacter->id() . '">' . htmlspecialchars($oneCharacter->nameChar()) . '</a></button> (dégâts : ' . $oneCharacter->damage() . ', force : ' . $oneCharacter->strength() . ', level : ' . $oneCharacter->levelChar() . ')<br />';
                        }
                    }
                    ?>
                </p>
            </fieldset>
        <?php
        } else {
        ?>
            <form action="" method="post">
                <div class="form-row align-items-center">
                    <div class="col-2">
                        <label class="sr-only" for="inlineFormInput">Nom</label>
                        <input class="form-control mb-2" type="text" name="nameChar" maxlength="50">
                        <input class="mb-2" type="submit" value="Créer ce personnnage" name="creer">
                        <input class="mb-2" type="submit" value="Utiliser ce personnage" name="utiliser">
                    </div>
                </div>
            </form>
        <?php
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>

</html>
<?php
if (isset($character)) {
    $_SESSION['character'] = $character;
}
?>