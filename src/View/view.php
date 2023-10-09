<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="./../assets/css/view.css">
    <meta charset="UTF-8">
    <title><?php if (isset($pagetitle)) echo $pagetitle; ?></title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="frontController.php?controller=voiture&action=readAll">Accueil voitures</a></li>
            <li><a href="frontController.php?controller=utilisateur&action=readAll">Accueil utilisateurs</a></li>
            <li><a href="frontController.php?controller=trajet&action=readAll">Accueil trajets</a></li>
            <li class="heart"><a href="frontController.php?&controller=generic&action=formulairePreference"><img src="./../assets/images/heart.png" alt="Heart Icon"></a></li>
        </ul>
    </nav>
</header>
<main>
    <?php
        if (isset($cheminVueBody)) require __DIR__ . $cheminVueBody;
    ?>
</main>
<footer>
    <p>
        Site de covoiturage de Syndra Corporations
    </p>
</footer>
</body>
</html>
