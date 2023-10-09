<?php
    if (isset($utilisateurs)) {
        echo "<ul>";
        foreach ($utilisateurs as $utilisateur) {

            $login = $utilisateur->getPrimaryKeyValue();
            $stringlogin = htmlspecialchars($login);
            $urlLogin = rawurlencode($login);
            echo '<li><p> Utilisateur avec login : ' . $stringlogin .
                ' <a href=\'frontController.php?controller=utilisateur&action=readOne&login=' . $urlLogin . ' \'>Détails</a> ' .
                ' <a href=\'frontController.php?controller=utilisateur&action=update&login=' . $urlLogin . ' \'>Update</a> ' .
                '<a href=\'frontController.php?controller=utilisateur&action=delete&login=' . $urlLogin . ' \'>Effacer</a></p></li>';
        }
        echo "</ul>";
        echo '<br><a href=\'frontController.php?controller=utilisateur&action=create \'>Créer un utilisateur</a><br>';

        if (isset($cookies) && is_array($cookies)) {
            echo "<br>";
            foreach ($cookies as $cookie){
                echo $cookie . "<br>";
            }
        }
    }
?>
