<?php
    if (isset($voitures)) {
        echo "<ul>";
        foreach ($voitures as $voiture) {

            $immat = $voiture->getPrimaryKeyValue();
            $stringImmat = htmlspecialchars($immat);
            $urlImmat = rawurlencode($immat);

            echo '<li><p> Voiture d\'immatriculation ' . $stringImmat .
                ' <a href=\'frontController.php?controller=voiture&action=readOne&immat=' . $urlImmat . ' \'>Détails</a> ' .
                ' <a href=\'frontController.php?controller=voiture&action=update&immat=' . $urlImmat . ' \'>Update</a> ' .
                '<a href=\'frontController.php?controller=voiture&action=delete&immat=' . $urlImmat . ' \'>Effacer</a></p></li>';
        }
        echo "</ul>";
        echo '<br><a href=\'frontController.php?controller=voiture&action=create \'>Créer une voiture</a> ';
    }
