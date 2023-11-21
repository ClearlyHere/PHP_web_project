<?php
    require_once "./../../../web/autoloaderInclude.php";
    $exception = new Exception("Le fichier ou l'URL que vous avez saisi semble être indisponible", 404);
    $pageTitle = "Error 404";
    $cheminVueBody = "/error.php";
    require_once "../view.php";
