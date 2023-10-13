<?php

    namespace App\Covoiturage\Model\DataObject;

    // Classe User
    use App\Covoiturage\Lib\MotDePasse;

    class Utilisateur extends AbstractDataObject
    {
        // Un user contient ses 3 attributs en string
        private string $login;
        private string $mdpHache;
        private string $nom;
        private string $prenom;

        public function formatTableau(): array
        {
            return array(
                "loginTag" => $this->getPrimaryKeyValue(),
                "mdpHacheTag" => $this->getMdpHache(),
                "nomTag" => $this->GetNom(),
                "prenomTag" => $this->GetPrenom(),
            );
        }

        // Méthode constructeur habituel
        public function __construct(
            string $login,
            string $mdpHache,
            string $nom,
            string $prenom,
        )
        {
            $this->login = $login;
            $this->mdpHache = $mdpHache;
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

        public function getMdpHache(): string
        {
            return $this->mdpHache;
        }

        public function setMdpHache(string $mdpClair): void
        {
            $mdpHache = MotDePasse::hacher($mdpClair);
            $this->mdpHache = $mdpHache;
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
