<?php

    namespace App\Covoiturage\Model\DataObject;

    use App\Covoiturage\Model\Repository\UtilisateurRepository;
    use DateTime;

    // Classe road
    class Trajet extends AbstractDataObject
    {
        // Contient les attributs avec typage
        private int $id;
        private string $depart;
        private string $arrivee;
        private DateTime $date; // La date est de type DateTime
        private int $nbPlaces;
        private int $prix;
        private Utilisateur $loginConducteur; // Le loginConducteur est de type User


        // Méthode constructeur habituel
        public function __construct(
            int         $id,
            string      $depart,
            string      $arrivee,
            string      $date,
            int         $nbPlaces,
            int         $prix,
            string $loginConducteur
        )
        {
            $this->id = $id;
            $this->depart = $depart;
            $this->arrivee = $arrivee;
            $this->date = new DateTime($date); // Création d'objet DateTime à partir du string obtenu
            $this->nbPlaces = $nbPlaces;
            $this->prix = $prix;
            $this->loginConducteur = (new UtilisateurRepository())->Construire(UtilisateurRepository::withLogin($loginConducteur));
        }

        public function formatTableau(): array
        {
            return array(
                "idTag" => $this->getPrimaryKeyValue(),
                "departTag" => $this->getDepart(),
                "arriveeTag" => $this->getArrivee(),
                "dateTag" => $this->getDateString(),
                "nbPlacesTag" => $this->getNbPlaces(),
                "prixTag" => $this->getPrix(),
                "conducteurLoginTag" => $this->getLoginConducteur()->getPrimaryKeyValue()
            );
        }

        // Méthodes getters et setters
        public function getPrimaryKeyValue(): int
        {
            return $this->id;
        }

        public function setId(int $id): void
        {
            $this->id = $id;
        }

        public function getDepart(): string
        {
            return $this->depart;
        }

        public function setDepart(string $depart): void
        {
            $this->depart = $depart;
        }

        public function getArrivee(): string
        {
            return $this->arrivee;
        }

        public function setArrivee(string $arrivee): void
        {
            $this->arrivee = $arrivee;
        }

        // Obtenir la date comme objet DateTime
        public function getDate(): DateTime
        {
            return $this->date;
        }

        // Obtenir la date comme objet string en format d-m-Y
        public function getDateString(): string
        {
            return $this->date->format("Y-m-d");
        }

        public function setDate(DateTime $date): void
        {
            $this->date = $date;
        }

        public function getNbPlaces(): int
        {
            return $this->nbPlaces;
        }

        public function setNbPlaces(int $nbPlaces): void
        {
            $this->nbPlaces = $nbPlaces;
        }

        public function getPrix(): int
        {
            return $this->prix;
        }

        public function setPrix(int $prix): void
        {
            $this->prix = $prix;
        }

        public function getLoginConducteur(): Utilisateur
        {
            return $this->loginConducteur;
        }

        public function setLoginConducteur(Utilisateur $loginConducteur): void
        {
            $this->loginConducteur = $loginConducteur;
        }

        /*
        Méthode __toString() pour afficher les informations d'un Road en un string
        Tout en utilisant les méthodes getters
        */
        public function __toString(): string
        {
            return
                "Trajet : " . $this->getPrimaryKeyValue() .
                "Depart : " . $this->getDepart() .
                "Arrivée : " . $this->getArrivee()  .
                "Date : " . $this->getDateString()  .
                "Nombre de places : " . $this->getNbPlaces()  .
                "Prix : " . $this->getPrix() . '€' .
                "Conducteur : " . $this->getLoginConducteur() ;
        }
    }
