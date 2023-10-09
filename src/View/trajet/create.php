<form method="GET" action="frontController.php">
    <input type="hidden" name="controller" value="trajet"/>
    <input type="hidden" name="action" value="created"/>
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p>
            <label for="id_id">ID</label> :
            <input type="number" placeholder="123" name="id" id="id_id" required/>
        </p>
        <p>
            <label for="depart_id">Depart</label> :
            <input type="text" placeholder="Paris" name="depart" id="depart_id" required/>
        </p>
        <p>
            <label for="arrivee_id">Arrivee</label> :
            <input type="text" placeholder="Lyon" name="arrivee" id="arrivee_id" required/>
        </p>
        <p>
            <label for="date_id">Date</label> :
            <input type="date" placeholder="20-02-2021" name="date" id="date_id" required/>
        </p>
        <p>
            <label for="nbPlaces_id">Nombre de places</label> :
            <input type="number" placeholder="20" name="nbPlaces" id="nbPlaces_id" required/>
        </p>
        <p>
            <label for="prix_id">Prix</label> :
            <input type="number" placeholder="25€" name="prix" id="prix_id" required/>
        </p>
        <p>
            <label for="conducteur_id">Conducteur</label> :
            <input type="text" placeholder="Nom Conducteur" name="conducteur" id="conducteur_id" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>
<a href="frontController.php?controller=trajet&action=readAll">Retour</a>