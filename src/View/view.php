<?php
    use App\Covoiturage\Model\HTTP\Session;
    use App\Covoiturage\Lib\MessageFlash;
    use App\Covoiturage\Lib\ConnexionUtilisateur;

    $session = Session::getInstance();
?>
<html lang="fr">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <base href="http://localhost/R301/TD8/web/">
    <link rel="stylesheet" type="text/css" href="/R301/TD8/assets/css/style.css">
    <meta charset="UTF-8">
    <title><?php if (isset($pagetitle)) echo $pagetitle; ?></title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php?controller=voiture&action=readAll">Accueil voitures</a></li>
            <li><a href="index.php?controller=utilisateur&action=readAll">Accueil utilisateurs</a></li>
            <li><a href="index.php?controller=trajet&action=readAll">Accueil trajets</a></li>
            <li class="heart"><a href="index.php?&controller=generic&action=formulairePreference"><img
                            src="/R301/TD8/assets/images/heart.png" alt="Heart Icon"></a></li>
            <?php
                if (ConnexionUtilisateur::estConnecte()) {
                    $userLogin = ConnexionUtilisateur::getLoginUtilisateurConnecte();
                    if (ConnexionUtilisateur::estAdministrateur()) {
                        echo '<li class="heart"><a href="index.php?controller=utilisateur&action=readOne&login=' . $userLogin .
                            '"><img src="/R301/TD8/assets/images/admin_logo.png" alt="admin user icon"></a></li>';
                    } else {
                        echo '<li class="heart"><a href="index.php?controller=utilisateur&action=readOne&login=' . $userLogin .
                            '"><img src="/R301/TD8/assets/images/user_logo.png" alt="Happy user icon"></a></li>';
                    }
                } else {
                    echo '<li class="heart"><a href="index.php?controller=utilisateur&action=connexion">
                <img src="/R301/TD8/assets/images/login.png" alt="Sad user icon"></a></li>';
                }
            ?>
        </ul>
    </nav>
</header>
<main>
    <?php
        if (MessageFlash::contientMessage()) {
            echo MessageFlash::lireMessage();
        }
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
