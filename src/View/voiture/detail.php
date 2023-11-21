<?php
    if (isset($voiture)) $stringVoiture = htmlspecialchars($voiture);
    echo '<h1> Détails </h1><p>' . $stringVoiture . '</p><a href="index.php?controller=voiture&action=readAll">Retour</a>';