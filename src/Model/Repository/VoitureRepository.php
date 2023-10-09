<?php

    namespace App\Covoiturage\Model\Repository;

    use App\Covoiturage\Model\DataObject\Voiture;

    class VoitureRepository extends AbstractRepository
    {
        public function getNomsColonnes(): array
        {
            return array('immatriculationBDD', 'marqueBDD', 'couleurBDD', 'nbSiegesBDD');
        }

        public function getNomTable(): string
        {
            return "voiture";
        }

        public function getPrimaryKeyColumn(): string
        {
            return "immatriculationBDD";
        }

        public function Construire($arrayData): Voiture
        {
            return new Voiture(
                $arrayData['immatriculationBDD'],
                $arrayData['marqueBDD'],
                $arrayData['couleurBDD'],
                $arrayData['nbSiegesBDD'],
            );
        }
    }