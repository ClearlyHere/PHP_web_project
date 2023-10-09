<?php
    namespace App\Covoiturage\Model\DataObject;

    class Voiture extends AbstractDataObject
    {
        private string $immatriculation;
        private string $marque;
        private string $couleur;
        private int $nbSieges;

        public function formatTableau(): array
        {
            return array(
                'immatriculationBDDTag' => $this->getPrimaryKeyValue(),
                'marqueBDDTag' => $this->getMarque(),
                'couleurBDDTag' => $this->getCouleur(),
                'nbSiegesBDDTag' => $this->getNbSieges()
            );
        }

        public function __construct(
            string $immatriculation,
            string $marque,
            string $couleur,
            int    $nbSieges
        )
        {
            $this->immatriculation = $immatriculation;
            $this->marque = $marque;
            $this->couleur = $couleur;
            $this->nbSieges = $nbSieges;
        }

        public function getMarque(): string
        {
            return $this->marque;
        }

        public function getPrimaryKeyValue(): string
        {
            return $this->immatriculation;
        }

        public function getCouleur(): string
        {
            return $this->couleur;
        }

        public function getNbSieges(): int
        {
            return $this->nbSieges;
        }

        public function setMarque(string $marque): void
        {
            $this->marque = $marque;
        }

        public function setImmatriculation(string $immatriculation): void
        {
            $immatriculation = substr($immatriculation, 0, 8);
            $this->immatriculation = $immatriculation;
        }

        public function setCouleur(string $couleur): void
        {
            $this->couleur = $couleur;
        }

        public function SetNbSieges(int $nbSieges): void
        {
            $this->nbSieges = $nbSieges;
        }


        public function __toString(): string
        {
            return "Voiture " . $this->getPrimaryKeyValue() . " de marque " . $this->getMarque() .
                " (couleur " . $this->getCouleur() . ", " . $this->getNbSieges() . " sièges)";
        }
    }
