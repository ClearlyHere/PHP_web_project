<?php

    namespace App\Covoiturage\Model\DataObject;

    // Classe User
    class Utilisateur extends AbstractDataObject
    {
        // Un user contient ses 3 attributs en string
        private string $login;
        private string $nom;
        private string $prenom;

        public function formatTableau(): array
        {
            return array(
                "loginTag" => $this->getPrimaryKeyValue(),
                "nomTag" => $this->GetNom(),
                "prenomTag" => $this->GetPrenom()
            );
        }

        // Méthode constructeur habituel
        public function __construct(
            string $login,
            string $nom,
            string $prenom
        )
        {
            $this->login = $login;
            $this->nom = $nom;
            $this->prenom = $prenom;
        }

        // Méthodes Getters et Setters
        public function getPrimaryKeyValue(): string
        {
            return $this->login;
        }

        public function GetNom(): string
        {
            return $this->nom;
        }

        public function GetPrenom(): string
        {
            return $this->prenom;
        }

        public function SetLogin(string $login): void
        {
            $this->login = $login;
        }

        public function SetNom(string $nom): void
        {
            $this->nom = $nom;
        }

        public function SetPrenom(string $prenom): void
        {
            $this->prenom = $prenom;
        }

        /*
        Méthode __toString() pour afficher les informations d'un User en un string
        Tout en utilisant les méthodes getters
        */
        public function __toString(): string
        {
            return "Utilisateur : " . $this->getPrimaryKeyValue() .
                ", Nom : " . $this->GetNom() . ", Prénom : " . $this->GetPrenom();
        }
    }
