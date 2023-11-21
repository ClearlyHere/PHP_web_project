<?php if (isset($utilisateur)) ?>
<form method="GET" action="index.php">
    <input type="hidden" name="controller" value="utilisateur"/>
    <input type="hidden" name="action" value="updated"/>
    <input type="hidden" name="oldLogin"
           value="<?php if (isset($utilisateur)) echo $utilisateur->getPrimaryKeyValue(); ?>">
    <fieldset>
        <legend><?php if (isset($utilisateur)) echo "Mise à jour utilisateur " . $utilisateur->getPrimaryKeyValue(); ?></legend>
        <p>
            <label for="login_id">Login <?php if (isset($utilisateur)) echo $utilisateur->getPrimaryKeyValue() ?></label>
            :
            <input type="text" placeholder="johndoe" name="login" id="login_id" required/>
        </p>
        <p>
            <label for="mdp_id">Mot de passe&#42; :</label>
            <input type="password" placeholder="**********" name="ancienMdpClair" id="mdp_id" required>
        </p>
        <p>
            <label for="mdp_id">Nouveau mot de passe&#42; :</label>
            <input type="password" placeholder="**********" name="mdpHache" id="mdp_id" required>
        </p>
        <p>
            <label for="mdp2_id">Vérification du nouveau mot de passe&#42; :</label>
            <input type="password" placeholder="**********" name="mdpHacheVerif" id="mdp2_id" required>
        </p>
        <p>
            <label for="nom_id">Nom <?php if (isset($utilisateur)) echo $utilisateur->GetNom() ?></label> :
            <input type="text" placeholder="John" name="nom" id="nom_id" required/>
        </p>
        <p>
            <label for="prenom">Nom <?php if (isset($utilisateur)) echo $utilisateur->GetPrenom() ?></label> :
            <input type="text" placeholder="Doe" name="prenom" id="prenom" required/>
        </p>
        <?php

            use App\Covoiturage\Lib\ConnexionUtilisateur;

            if ($utilisateur->isEstAdmin()) $check = 'checked';
            else $check = null;

            if (ConnexionUtilisateur::estAdministrateur()) {
                echo '<p><label for="estAdmin_id">Administrateur</label>
            <input type="checkbox" name="estAdmin" id="estAdmin_id"' . $check . '></p>';
            }
        ?>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>
<a href="index.php?controller=utilisateur&action=readAll">Retour</a>