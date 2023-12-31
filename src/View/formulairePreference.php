<?php
    use App\Covoiturage\Lib\PreferenceController;

    if (isset($_GET['controleur_defaut']))
    {
        echo "<p>Préférence enregistré : " . $_GET['controleur_defaut'] . "</p>";
    }
    else if (PreferenceController::existe())
    {
        echo "<p>Votre préférence actuelle : " . PreferenceController::lire() . "</p>";
    }
?>
<form method="GET" action="index.php">
    <input type="hidden" name="controller" value="generic"/>
    <input type="hidden" name="action" value="enregistrerPreference"/>
    <fieldset>
        <legend>Choisissez votre contrôleur préféré :</legend>
        <input type="radio" id="voitureId" name="controleur_defaut" value="voiture" <?php PreferenceController::checkRadio('voiture'); ?>>
        <label for="voitureId">Voiture</label>
        <input type="radio" id="utilisateurId" name="controleur_defaut" value="utilisateur" <?php PreferenceController::checkRadio('utilisateur'); ?>>
        <label for="utilisateurId">Utilisateur</label>
        <input type="radio" id="trajetId" name="controleur_defaut" value="trajet" <?php PreferenceController::checkRadio('trajet'); ?>>
        <label for="trajetId">Trajet</label>
        <p><br><input type="submit" value="Envoyer"/></p>
    </fieldset>
</form>
<a href="index.php">Retour</a>