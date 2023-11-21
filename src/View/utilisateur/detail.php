<?php

    use App\Covoiturage\Lib\ConnexionUtilisateur;

    if (isset($utilisateur)) {
        $stringUtilisateur = htmlspecialchars($utilisateur);
        $urlLogin = rawurlencode($utilisateur->getPrimaryKeyValue());
        $userLogin = $utilisateur->getPrimaryKeyValue();
        echo '<h1> Détails </h1><p>' . $stringUtilisateur . '</p>';

        $sessionLogin = ConnexionUtilisateur::getLoginUtilisateurConnecte() == $utilisateur->getPrimaryKeyValue();
        if ($sessionLogin == $userLogin) {
            echo '<p><a href=\'index.php?controller=utilisateur&action=update&login=' . $urlLogin . ' \'>Update</a></p>';
            echo '<p><a href=\'index.php?controller=utilisateur&action=delete&login=' . $urlLogin . ' \'>Effacer</a></p>';
        }
        else if (ConnexionUtilisateur::estAdministrateur()) {
            echo '<p><a href=\'index.php?controller=utilisateur&action=updateAdmin&login=' . $urlLogin . ' \'>Update</a></p>';
            echo '<p><a href=\'index.php?controller=utilisateur&action=delete&login=' . $urlLogin . ' \'>Effacer</a></p>';
        }
        if ($sessionLogin == $userLogin) {
            echo '<p><a href=\'index.php?controller=utilisateur&action=logout\'>Déconnexion</a></p>';
        }

        echo '<p><br><a href="index.php?controller=utilisateur&action=readAll">Retour</a></p>';
    }