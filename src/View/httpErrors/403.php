<?php
    require_once "./../../../web/autoloaderInclude.php";
    $exception = new Exception("Vous n'avez pas les permissions pour accéder à ce fichier", 403);
    $pageTitle = "Error 403";
    $cheminVueBody = "/error.php";
    require_once "../view.php";
