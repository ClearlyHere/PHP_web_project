<?php
    if (isset($utilisateurs)) {
        echo "<ul>";
        foreach ($utilisateurs as $utilisateur) {

            $login = $utilisateur->getPrimaryKeyValue();
            $stringlogin = htmlspecialchars($login);
            $urlLogin = rawurlencode($login);
            echo '<li><p> Utilisateur avec login : ' . $stringlogin .
                ' <a href=\'frontController.php?controller=utilisateur&action=readOne&login=' . $urlLogin . ' \'>Détails</a> ';
        }
        echo "</ul>";

        if (isset($cookies) && is_array($cookies)) {
            echo "<br>";
            foreach ($cookies as $cookie){
                echo $cookie . "<br>";
            }
        }
    }
