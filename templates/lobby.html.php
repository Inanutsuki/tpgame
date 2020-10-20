<div class="container mt-5 d-flex justify-content-center">
    <div class="col-6">
        <p>Nombre de personnage créés : <?= $countHero ?></p>
        <?php
        if (isset($message) || isset($messageUP) || (isset($message) && isset($messageUP))) {
            echo '<p>' . $message . ' ' . isset($messageUP) . '</p>';
        }
        ?>

        <form action="index.php?action=arena" method="post">
            <div class="form-row align-items-center">
                <div class="col-6">
                    <label class="sr-only" for="inlineFormInput">Nom</label>
                    <input class="form-control mb-2" type="text" name="nameChar" maxlength="50">
                    <input class="mb-2" type="submit" value="Créer ce personnnage" name="createHero">
                    <input class="mb-2" type="submit" value="Utiliser ce personnage" name="useHero">
                </div>
            </div>
        </form>
    </div>
</div>