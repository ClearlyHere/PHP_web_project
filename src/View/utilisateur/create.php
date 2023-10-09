<form method="GET" action="frontController.php">
    <input type="hidden" name="controller" value="utilisateur"/>
    <input type="hidden" name="action" value="created"/>
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p>
            <label for="login_id">Login</label> :
            <input type="text" placeholder="johndoe" name="login" id="login_id" required/>
        </p>
        <p>
            <label for="nom_id">Nom</label> :
            <input type="text" placeholder="John" name="nom" id="nom_id" required/>
        </p>
        <p>
            <label for="prenom_id">Prenom</label> :
            <input type="text" placeholder="Doe" name="prenom" id="prenom_id" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>
<a href="frontController.php?controller=utilisateur&action=readAll">Retour</a>