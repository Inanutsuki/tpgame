<p><a href="index.php?action=logout">Quitter le combat !</a></p>


<form action="index.php?action=createBadGuy" method="post">
    <div class="form-row">
        <input type="submit" value="Créer un méchant" name="newBadGuy">
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
    if (empty($characters)) {
        echo 'Personne à frapper !';
    } else {
        foreach ($characters as $opponent) {
            echo '<button type="button" class="btn btn-dark"><a style="color:white;" href="index.php?action=fight&fight=' . $opponent->id() . '">' . htmlspecialchars($opponent->nameChar()) . '</a></button> (classe : ' . $opponent->classChar() . ' dégâts : ' . $opponent->damage() . ', force : ' . $opponent->strength() . ', level : ' . $opponent->levelChar() . ', DGT : ' . (int) (($opponent->levelChar() * 0.2) + 10) . ' - ' . (int) (($opponent->strength() * 0.2) + 10) . ' )<br />';
        }
    }
    ?>
    <p>Log du combat :</p>
    <?php 
    if (isset($logFight)) {
        foreach ($logFight as $logMessage) {
            echo '<p>' . $logMessage . '</p>';
        }
    }
    ?>
</p>