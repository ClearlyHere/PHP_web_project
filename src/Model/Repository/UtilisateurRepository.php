<?php

    namespace App\Covoiturage\Model\Repository;

    use App\Covoiturage\Lib\MotDePasse;
    use App\Covoiturage\Model\DataObject\Utilisateur;
    use PDO;

    class UtilisateurRepository extends AbstractRepository
    {
        /*
         * Méthode statique permettant de créer un utilisateur avec uniquement le login
         * On insère les données dans une variable $row grâce à la méthode loadLogin
         * On utilise les données dans $row pour créer un instance d'utilisateur
         */

        protected function getNomTable(): string
        {
            return "utilisateur";
        }

        protected function getPrimaryKeyColumn(): string
        {
            return "login";
        }

        public function getNomsColonnes(): array
        {
            return array('login', 'mdpHache', 'nom', 'prenom', );
        }

        public function Construire(array $arrayData): Utilisateur|bool
        {
                return new Utilisateur(
                    $arrayData['login'],
                    $arrayData['mdpHache'],
                    $arrayData['nom'],
                    $arrayData['prenom'],
                );
        }

        public static function construireDepuisFormulaire(array $tableauFormulaire) : Utilisateur
        {
            $tableauFormulaire['mdpHache'] = MotDePasse::hacher($tableauFormulaire['mdpHache']);
            $tableauConstruire = [$tableauFormulaire['login'],
                $tableauFormulaire['mdpHache'],
                $tableauFormulaire['nom'],
                $tableauFormulaire['prenom']];
            return new Utilisateur(...$tableauConstruire);
        }

        public static function withLogin($login, bool $return_user = false): array|Utilisateur
        {
            $sql = "SELECT * FROM utilisateur WHERE login = :conducteurLoginTag";
            $values = array('conducteurLoginTag' => $login);
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $pdoStatement->execute($values);
            $array = $pdoStatement->fetch(PDO::FETCH_ASSOC);
            if ($return_user) {
                return new Utilisateur(...$array);
            }
            else {
                return $array;
            }
        }

        public static function GetTrajetsLogin(string $login): array|null
        {
            $sql = "SELECT trajetID FROM passager INNER JOIN utilisateur
                ON utilisateur.login = passager.passagerLogin WHERE utilisateur.login = :loginTag";
            $values = array('loginTag' => $login);
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $pdoStatement->execute($values);
            $fetchData = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
            $results = [];
            if ($fetchData) {
                foreach ($fetchData as $data) {
                    $results[] = (new TrajetRepository())->select($data['trajetID']);
                }
                return $results;
            } else return null;
        }

        public static function GetConduitesLogin(string $login): array|null
        {
            $sql = "SELECT id FROM trajet WHERE conducteurLogin = :loginTag";
            $values = array(":loginTag" => $login);
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $pdoStatement->execute($values);
            $fetchData = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
            $results = [];
            if ($fetchData) {
                // echo "<h2>Trajets de " . static::withlogin($login)->GetNom() . " " . static::withlogin($login)->GetPrenom() . "</h2>\n<ul>\n";
                foreach ($fetchData as $data) {
                    $results[] = (new TrajetRepository())->select($data['id']);
                }
                return $results;
            } else return null;
        }

        public static function lireTrajetsConduitesLogin($login): void
        {
            $trajets = static::GetTrajetsLogin($login);
            if (is_array($trajets)) {
                $user = (new UtilisateurRepository())->select($login);
                echo "<h2>Trajets de " . $user->GetNom() . " " . $user->GetPrenom() . "</h2>\n<ul>\n";
                foreach ($trajets as $trajet) {
                    echo "<li>" . $trajet . "</li>";
                }
                echo "</ul>";
            } else echo $trajets;
            $conduites = static::GetConduitesLogin($login);
            if (is_array($conduites)) {
                $user = (new UtilisateurRepository())->select($login);
                echo "<h2>Conduites de " . $user->GetNom() . " " . $user->GetPrenom() . "</h2>\n<ul>\n";
                foreach ($conduites as $conduite) {
                    echo "<li>" . $conduite . "</li>";
                }
                echo "</ul>";
            } else echo $conduites;
        }
    }