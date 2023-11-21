<?php

    use App\Covoiturage\Lib\ConnexionUtilisateur;

    if (isset($utilisateurs)) {
        echo "<ul>";
        foreach ($utilisateurs as $utilisateur) {

            $login = $utilisateur->getPrimaryKeyValue();
            $stringlogin = htmlspecialchars($login);
            $urlLogin = rawurlencode($login);
            echo '<li><p> Utilisateur avec login : ' . $stringlogin .
                ' <a href=\'index.php?controller=utilisateur&action=readOne&login=' . $urlLogin . ' \'>Détails</a> ';
        }
        echo "</ul>";

        if (ConnexionUtilisateur::estAdministrateur()) {
            echo '<br><a href="index.php?controller=utilisateur&action=create">Créer un utilisateur</a>';
        }
    }
