<?php
    if(isset($trajet)) {
        echo "<p>Le trajet " . htmlspecialchars($trajet->getPrimaryKeyValue())  . " : "
            . htmlspecialchars($trajet->getDepart()) . " - " . htmlspecialchars($trajet->getArrivee()) .
            " a bien été créé !</p>";
    }
    echo '<br>';
    require_once("list.php");
?>
