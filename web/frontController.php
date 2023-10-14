<?php

    use App\Covoiturage\Config\ExceptionHandling;
    use App\Covoiturage\Controller\ControllerVoiture;
    use App\Covoiturage\Model\Repository\UtilisateurRepository;
    use App\Covoiturage\Lib\PreferenceController;

    require_once(__DIR__ . '/../src/Lib/Psr4AutoloaderClass.php');

    $loader = new App\Covoiturage\Lib\Psr4AutoloaderClass();
    $loader->addNamespace('App\Covoiturage', __DIR__ . '/../src');
    $loader->register();

    if (isset($_GET['controller'])) {
        $controller = $_GET['controller'];
        $controllerClassName = 'App\Covoiturage\Controller\Controller' . ucwords($controller);

        if (class_exists($controllerClassName)) {
            if (isset($_GET['action'])) {
                $action = $_GET['action'];
                $URLidentifier = (new $controllerClassName())->GetURLIdentifier();
                $identifier = $_GET[$URLidentifier] ?? null;

                if (method_exists($controllerClassName, $action)) {
                    (new $controllerClassName())->$action($identifier);
                } else {
                    // Dans le cas où l'action n'existe pas
                    (new $controllerClassName())->error(ExceptionHandling::triggerException(110));
                }
            } else {
                $action = "readAll";
                if (method_exists($controllerClassName, $action)) {
                    $controllerClassName::$action();
                }
            }
        } else {
            // Dans le cas où le controller n'existe pas, on affiche une erreur
            (new ControllerVoiture())->error(ExceptionHandling::triggerException(109));
        }
    } else {
        if (PreferenceController::existe()) {
            $controller = PreferenceController::lire();
        } else $controller = 'voiture';
        $action = "readAll";
        $controllerClassName = 'App\Covoiturage\Controller\Controller' . ucwords($controller);
        if (method_exists($controllerClassName, $action)) {
            $controllerClassName::$action();
        }
    }