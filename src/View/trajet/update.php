<form method="GET" action="index.php">
    <input type="hidden" name="controller" value="trajet"/>
    <input type="hidden" name="action" value="updated"/>
    <input type="hidden" name="oldId" value="<?php if (isset($trajet)) echo $trajet->getPrimaryKeyValue();?>">
    <fieldset>
        <legend><?php if (isset($trajet)) echo "Mise à jour Trajet " . $trajet->getPrimaryKeyValue(); ?></legend>
        <p>
            <label for="id_id">ID : <?php if (isset($trajet)) echo $trajet->getPrimaryKeyValue()?></label> :
            <input type="number" placeholder="12" name="id" id="id_id" required/>
        </p>
        <p>
            <label for="depart_id">Depart : <?php if (isset($trajet)) echo $trajet->getDepart()?></label> :
            <input type="text" placeholder="Paris" name="depart" id="depart_id" required/>
        </p>
        <p>
            <label for="arrivee_id">Arrivee :  <?php if (isset($trajet)) echo $trajet->getArrivee()?></label> :
            <input type="text" placeholder="Lyon" name="arrivee" id="arrivee_id" required/>
        </p>
        <p>
            <label for="date_id">Date :  <?php if (isset($trajet)) echo $trajet->getDateString()?></label> :
            <input type="date" placeholder="2004-02-12" name="date" id="date_id" required/>
        </p>
        <p>
            <label for="nbPlaces_id">Places :  <?php if (isset($trajet)) echo $trajet->getNbPlaces()?></label> :
            <input type="number" placeholder="25" name="nbPlaces" id="nbPlaces_id" required/>
        </p>
        <p>
            <label for="prix_id">Prix :  <?php if (isset($trajet)) echo $trajet->getPrix()?>€</label> :
            <input type="number" placeholder="30€" name="prix" id="prix_id" required/>
        </p>
        <p>
            <label for="conducteur_id">Conducteur <?php if (isset($trajet)) echo $trajet->getLoginConducteur()->getPrimaryKeyValue()?></label> :
            <input type="text" placeholder="johndoe" name="conducteur" id="conducteur_id" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>
<a href="index.php?controller=trajet&action=readAll">Retour</a>