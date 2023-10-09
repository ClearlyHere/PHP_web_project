<?php

    namespace App\Covoiturage\Model\Repository;

    use App\Covoiturage\Model\DataObject\AbstractDataObject;
    use InvalidArgumentException;
    use LogicException;
    use PDOException;
    use PDO;

    abstract class AbstractRepository
    {


        /**
         * @return AbstractDataObject[]
         */
        public function selectAll(): array
        {
            $sql = 'SELECT * FROM ' . $this->getNomTable() . ';';
            $pdoStatement = DatabaseConnection::getPdo()->query($sql);
            $fetchData = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
            $result = [];
            foreach ($fetchData as $data) {
                $result[] = $this->Construire($data);
            }
            return $result;
        }

        public function select(string $identifier): AbstractDataObject|string
        {
            try {
                $sql = 'SELECT ' . $this->getSQLColumns() . ' FROM ' . $this->getNomTable() .
                    ' WHERE ' . $this->getPrimaryKeyColumn() . ' = :' . $this->getPrimaryKeyColumn() . 'Tag;';
                $values = array(':' . $this->getPrimaryKeyColumn() . 'Tag' => $identifier);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new InvalidArgumentException("$identifier inexistant");
                }
                $data = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                return $this->Construire($data);
            } catch (InvalidArgumentException $e) {
                return $e->getMessage();
            }
        }

        public function effacer(string $identifier): bool|string
        {
            try {
                $sql = 'DELETE FROM ' . $this->getNomTable() .
                    ' WHERE ' . $this->getPrimaryKeyColumn() . ' = :' . $this->getPrimaryKeyColumn() . 'Tag;';
                $values = array(':' . $this->getPrimaryKeyColumn() . 'Tag' => $identifier);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);
                if ($pdoStatement->rowCount() == 0) {
                    throw new InvalidArgumentException("$identifier inexistant");
                }
                return true;
            } catch (InvalidArgumentException $e) {
                return $e->getMessage();
            }
        }

        public function mettreAJour(AbstractDataObject $objet, string $oldIdentifier): bool|string
        {
            try {
                $setColonnes = $this->getSQLColumns(true);

                $sql = 'UPDATE ' . $this->getNomTable() . ' SET ' . $setColonnes .
                    ' WHERE ' . $this->getPrimaryKeyColumn() . ' = :old' . $this->getPrimaryKeyColumn() . 'Tag;';

                $values = $objet->formatTableau();
                $values += ['old' . $this->getPrimaryKeyColumn() . 'Tag' => $oldIdentifier];

                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new LogicException($oldIdentifier . ' inexistant');
                }
                return true;

            } catch (LogicException|PDOException $e) {
                return $e->getMessage();
            }
        }

        public function Sauvegarder(AbstractDataObject $object) : bool|string {
            try {
                $sql = 'INSERT INTO ' . $this->getNomTable() . ' (' . $this->getSQLColumns() .
                    ') VALUES ' . '(' . $this->getSQLTags() . ');';

                $values = $object->formatTableau();
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);
                if ($pdoStatement->rowCount() < 1){
                    throw new LogicException($object->getPrimaryKeyValue() . 'inexistant');
                }
                return true;
            } catch (LogicException|PDOException $e) {
                return $e->getMessage();
            }
        }

        /*
        I love jésus he is for real the love of my life my cutie potatootie pookie bear kawaii desu
        I HAVE A VIDEO THAT I WATCH IN MY BED IT REPLAYS IN MY AYI AYI HEAD YOU SAID YOU LOVE ME WE LAUGH TOGETHER EVERY NIGHT*/

        // Get SQL Columns of corresponding repository, set tagmode to true if you want the tag version for inputs
        public function getSQLColumns(bool $tagMode = false) : string
        {
            $arrayColonnes = $this->getNomsColonnes();
            if ($tagMode) {
                $setColonnes = '';
                foreach ($arrayColonnes as $colonne) {
                    $setColonnes .=  $colonne . ' = :' . $colonne . 'Tag, ';
                }
                return rtrim($setColonnes, ', ');
            }

            else {
                $return_colonnes = implode(', ', $arrayColonnes);
                return rtrim($return_colonnes, ', ');
            }
        }

        private function getSQLTags() : string
        {
            $arrayColonnes = $this->getNomsColonnes();
            $setColonnes = '';
            foreach ($arrayColonnes as $colonne) {
                $setColonnes .= ':' . $colonne . 'Tag, ';
            }
            return rtrim($setColonnes, ', ');
        }

        protected abstract function getPrimaryKeyColumn(): string;

        protected abstract function getNomTable(): string;

        protected abstract function Construire(array $arrayData): AbstractDataObject|bool;

        protected abstract function getNomsColonnes(): array;
    }