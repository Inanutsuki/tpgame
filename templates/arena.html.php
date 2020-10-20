<p><a href="index.php?action=lobby">Quitter le combat !</a></p>
<?php
if (isset($message) || isset($messageUP) || (isset($message) && isset($messageUP))) {
    echo '<p>' . $message . ' ' . isset($messageUP) . '</p>';
}
?>

<form action="" method="post">
    <div class="form-row">
        <input type="submit" value="Entrer dans l'arène" name="newBadGuy">
    </div>
</form>
<legend>Mes informations</legend>
<p>
    Nom : <?= htmlspecialchars($character->nameChar()) ?><br>
    Classe : <?= $character->classChar() ?><br>
    Dégats : <?= $character->damage() ?><br>
    Force : <?= $character->strength() ?><br>
    Level : <?= $character->levelChar() ?><br>
    Experience : <?= $character->experience() ?><br>
    DGT : <?= (int) (($character->levelChar() * 0.2) + 10) ?> - <?= (int) (($character->strength() * 0.2) + 10) ?>
</p>
<legend>Qui frapper ?</legend>
<p>
    <?php
    if (empty($character)) {
        echo 'Personne à frapper !';
    } else {
        foreach ($characters as $opponent) {
            echo '<button type="button" class="btn btn-dark"><a style="color:white;" href="?fight=' . $opponent->id() . '">' . htmlspecialchars($opponent->nameChar()) . '</a></button> (classe : ' . $opponent->classChar() . ' dégâts : ' . $opponent->damage() . ', force : ' . $opponent->strength() . ', level : ' . $opponent->levelChar() . ', DGT : ' . (int) (($opponent->levelChar() * 0.2) + 10) . ' - ' . (int) (($opponent->strength() * 0.2) + 10) . ' )<br />';
        }
    }
    ?>
</p>