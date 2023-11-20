<?php

    use App\Covoiturage\Config\ExceptionHandling;

    if (isset($exception)) {
        echo "<h1>Erreur " . $exception->getCode() . "</h1>";
        echo "<p>" . ExceptionHandling::getErrorMessage($exception->getCode()) . "</p>";
    } else echo "<p>Nous avons trouvé une erreur inconnue durant votre requête</p>";
?>
<br>
<a href="frontController.php?controller=utilisateur&action=readAll">Retour</a>