<?php

    namespace App\Covoiturage\Model\Repository;

    use App\Covoiturage\Model\DataObject\Trajet;
    use LogicException;
    use PDO;

    class TrajetRepository extends AbstractRepository
    {

        protected function getNomTable(): string
        {
            return "trajet";
        }

        protected function getPrimaryKeyColumn(): string
        {
            return "id";
        }

        public function getNomsColonnes(): array
        {
            return array('id', 'depart', 'arrivee', 'date', 'nbPlaces', 'prix', 'conducteurLogin');
        }

        public function Construire(array $arrayData): Trajet
        {
            if (isset($arrayData['id'])){
                return new Trajet(
                    $arrayData['id'],
                    $arrayData['depart'],
                    $arrayData['arrivee'],
                    $arrayData['date'],
                    $arrayData['nbPlaces'],
                    $arrayData['prix'],
                    $arrayData['conducteurLogin']
                );
            }
            else {
                $pdoStatement = DatabaseConnection::getPdo()->query("SHOW TABLE STATUS LIKE 'trajet'");
                $idAI = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                return new Trajet(
                    $idAI['Auto_increment'],
                    $arrayData['depart'],
                    $arrayData['arrivee'],
                    date($arrayData['date']),
                    $arrayData['nbPlaces'],
                    $arrayData['prix'],
                    $arrayData['conducteurLogin']
                );
            }
        }

        public static function getPassagers(int $id): array
        {
            $sql = "SELECT passagerLogin FROM trajet INNER JOIN passager ON trajet.id = passager.trajetID
            WHERE passager.trajetID = :trajetIDTag";
            $values = array("trajetIDTag" => $id);
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $pdoStatement->execute($values);
            $fetchData = $pdoStatement->fetchAll();
            $results = [];
            foreach ($fetchData as $data) {
                $results[] = (new UtilisateurRepository())->select($data['identifiant']);
            }
            foreach ($results as $user) {
                echo $user . "<br>";
            }
            return $results;
        }

        public static function SupprimerPassager(int $trajetID, string $passagerLogin): void
        {
            try {
                $sql = "DELETE FROM passager WHERE trajetID = :trajetIDTag AND passagerLogin = :identifiantTag";
                $values = array(
                    "trajetIDTag" => $trajetID,
                    "identifiantTag" => $passagerLogin
                );
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);
                if ($pdoStatement->rowCount() <= 0) {
                    throw new LogicException("Erreur : Aucun passager n'a été effacé");
                }
            } catch (LogicException $e) {
                echo $e->getMessage();
            }
        }
    }