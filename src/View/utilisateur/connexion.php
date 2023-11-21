<form method="GET" action="index.php">
    <input type="hidden" name="controller" value="utilisateur"/>
    <input type="hidden" name="action" value="connected"/>
    <fieldset>
        <legend>Connexion utilisateur :</legend>
        <p>
            <label for="login_id">Login</label> :
            <input type="text" placeholder="johndoe" name="login" id="login_id" required/>
        </p>
        <p>
            <label for="mdp_id">Mot de passe&#42; : </label>
            <input type="password" placeholder="**********" name="mdpClair" id="mdp_id" required>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>
<a href="index.php?controller=utilisateur&action=create ">Créer un utilisateur</a>
<a href="index.php?controller=utilisateur&action=readAll">Retour</a>
