<?php
    if (isset($utilisateur)) $stringUtilisateur = htmlspecialchars($utilisateur);
    echo '<h1> Détails </h1><p>' . $stringUtilisateur . '</p><a href="frontController.php?controller=utilisateur&action=readAll">Retour</a>';
?>