<?php
    require_once "./../../../web/autoloaderInclude.php";
    $exception = new Exception("Nous avons retrouvé une erreur avec le serveur,
     veuillez réessayer ultérieurement.", 500);
    $pageTitle = "Error 500";
    $cheminVueBody = "/error.php";
    require_once "../view.php";
