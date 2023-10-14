<?php

    namespace App\Covoiturage\Model\DataObject;

    // Classe User
    use App\Covoiturage\Lib\MotDePasse;

    class Utilisateur extends AbstractDataObject
    {
        // Méthode constructeur avec attributs définis directement
        public function __construct(
            private string $login,
            private string $mdpHache,
            private string $nom,
            private string $prenom,
            private bool   $estAdmin,
        )
        {
        }

        public function formatTableau(): array
        {
            if ($this->isEstAdmin()) $isAdmin = 1;
            else $isAdmin = 0;
            return array(
                "loginTag" => $this->getPrimaryKeyValue(),
                "mdpHacheTag" => $this->getMdpHache(),
                "nomTag" => $this->GetNom(),
                "prenomTag" => $this->GetPrenom(),
                "estAdminTag" => strval($isAdmin),
            );
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

        public function isEstAdmin(): bool
        {
            return $this->estAdmin;
        }

        public function setEstAdmin(bool $estAdmin): void
        {
            $this->estAdmin = $estAdmin;
        }


//      Méthode __toString() pour afficher les informations d'un User en un string
//      Tout en utilisant les méthodes getters
        public function __toString(): string
        {
            if ($this->isEstAdmin()) $admin = ', Admin : Oui';
            else $admin = ', Admin : Non';
            return "Utilisateur : " . $this->getPrimaryKeyValue() .
                ", Nom : " . $this->GetNom() . ", Prénom : " . $this->GetPrenom()
                . $admin;
        }
    }
