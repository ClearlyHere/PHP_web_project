<form method="GET" action="index.php">
    <input type="hidden" name="controller" value="voiture"/>
    <input type="hidden" name="action" value="created"/>
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p>
            <label for="immat_id">Immatriculation</label> :
            <input type="text" placeholder="256AB34" name="immatriculationBDD" id="immat_id" required/>
        </p>
        <p>
            <label for="marque_id">Marque</label> :
            <input type="text" placeholder="Renault" name="marqueBDD" id="marque_id" required/>
        </p>
        <p>
            <label for="couleur_id">Couleur</label> :
            <input type="text" placeholder="Bleu" name="couleurBDD" id="couleur_id" required/>
        </p>
        <p>
            <label for="nbSiege_id">Nombre de sièges</label> :
            <input type="number" placeholder="4" name="nbSiegesBDD" id="nbSiege_id" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>
<a href="index.php?controller=voiture&action=readAll">Retour</a>