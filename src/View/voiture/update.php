<form method="GET" action="index.php">
    <input type="hidden" name="controller" value="voiture"/>
    <input type="hidden" name="action" value="updated"/>
    <input type="hidden" name="oldImmat" value="<?php if (isset($voiture)) echo $voiture->getPrimaryKeyValue(); ?>">
    <fieldset>
        <legend><?php if (isset($voiture)) echo "Mise à jour voiture " . $voiture->getPrimaryKeyValue(); ?></legend>
        <p>
            <label for="immat_id">Immatriculation <?php if (isset($voiture)) echo $voiture->getPrimaryKeyValue()?></label> :
            <input type="text" placeholder="256AB34" name="immatriculationBDD" id="immat_id" required/>
        </p>
        <p>
            <label for="marque_id">Marque <?php if (isset($voiture)) echo $voiture->getMarque()?></label> :
            <input type="text" placeholder="Renault" name="marqueBDD" id="marque_id" required/>
        </p>
        <p>
            <label for="couleur_id">Couleur <?php if (isset($voiture)) echo $voiture->getCouleur()?></label> :
            <input type="text" placeholder="Bleu" name="couleurBDD" id="couleur_id" required/>
        </p>
        <p>
            <label for="nbSiege_id">Nombre de sièges <?php if (isset($voiture)) echo $voiture->getNbSieges()?></label> :
            <input type="number" placeholder="4" name="nbSiegesBDD" id="nbSiege_id" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>
<a href="index.php?controller=voiture&action=readAll">Retour</a>