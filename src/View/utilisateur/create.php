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
            <label for="mdp_id">Mot de passe&#42;</label>
            <input type="password" placeholder="**********" name="mdpHache" id="mdp_id" required>
        </p>
        <p>
            <label for="mdp2_id">Vérification du mot de passe&#42;</label>
            <input type="password" placeholder="**********" name="mdpHacheVerif" id="mdp2_id" required>
        </p>
        <p>
            <label for="nom_id">Nom</label> :
            <input type="text" placeholder="John" name="nom" id="nom_id" required/>
        </p>
        <p>
            <label for="prenom_id">Prenom</label> :
            <input type="text" placeholder="Doe" name="prenom" id="prenom_id" required/>
        </p>
        <?php

            use App\Covoiturage\Lib\ConnexionUtilisateur;

            if (ConnexionUtilisateur::estAdministrateur())
                echo '<p>
            <label for="estAdmin_id">Administrateur?</label>
            <input type="checkbox" name="estAdmin" id="estAdmin_id">
            </p>'
        ?>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>
<a href="frontController.php?controller=utilisateur&action=readAll">Retour</a>