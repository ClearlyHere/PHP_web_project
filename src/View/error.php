<?php
    echo "<p>Erreur durant votre requête</p>";
    if (isset($errorMessage)) echo "<br><p>$errorMessage</p>";
?>
<br>
<a href="frontController.php?controller=utilisateur&action=readAll">Retour</a>