<?php
    if (isset($trajet)) {
        $stringTrajet = htmlspecialchars($trajet);
        echo '<h1> Détails </h1><br><p>' .
            "Identifiant trajet : " . htmlspecialchars($trajet->getPrimaryKeyValue()) . '<br>' .
            "Depart : " . htmlspecialchars($trajet->getDepart()) . '<br>' .
            "Arrivée : " . htmlspecialchars($trajet->getArrivee()) . '<br>' .
            "Date : " . htmlspecialchars($trajet->getDateString()) . '<br>' .
            "Nombre de places : " . htmlspecialchars($trajet->getNbPlaces()) . '<br>' .
            "Prix : " . htmlspecialchars($trajet->getPrix()) . '€<br>' .
            "Conducteur : " . htmlspecialchars($trajet->getLoginConducteur()) . '</p><br>';
    }
    ?>
<a href="index.php?controller=trajet&action=readAll">Retour</a>
