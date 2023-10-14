<?php
    if (isset($trajets)) {
        echo "<ul>";
        foreach ($trajets as $trajet) {

            $id = $trajet->getPrimaryKeyValue();
            $stringId = htmlspecialchars($id);
            $stringTrajet = htmlspecialchars($trajet->getDepart() . ', ' . $trajet->getArrivee());
            $urlid = rawurlencode($id);

            echo '<li><p> Trajet ' . $stringId . ' : ' . $stringTrajet .
                ' <a href=\'frontController.php?controller=trajet&action=readOne&id=' . $urlid . ' \'>Détails</a> ' .
                ' <a href=\'frontController.php?controller=trajet&action=update&id=' . $urlid . ' \'>Update</a> ' .
                '<a href=\'frontController.php?controller=trajet&action=delete&id=' . $urlid . ' \'>Effacer</a></p></li>';
        }
        echo "</ul>";
        echo '<br><a href=\'frontController.php?controller=trajet&action=create \'>Créer un trajet</a> ';
    }
