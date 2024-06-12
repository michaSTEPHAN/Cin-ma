<?php
    ob_start();
?>

<form class="formAddFilmActeur" action="index.php?action=addFilmActeur" method="POST" enctype="multipart/form-data">
    <p class="labnomFilmActeur">

        <label>
            Acteur :
            <select name="listeActeur">                
                <?php foreach ($listeActeur->fetchAll() as $acteur) { ?>                        
                    <option value="<?= $acteur["id_individu"] ?>">
                        <?= $acteur["personne"] ?>
                    </option>
                <?php } ?>                
            </select>
        </label>

        <label>
            Rôle :
            <select name="listeRole">                
                <?php foreach ($listeRole->fetchAll() as $role) { ?>                        
                    <option value="<?= $role["id_role"] ?>">
                        <?= $role["nom_role"] ?>
                    </option>
                <?php } ?>                
            </select>
        </label>

        
    </p>
    <p class= "AddFilmActeur">
        <input class= "submitAddFilmActeur" type="submit" name="submit" value="Ajouter l'acteur au film'">
    </p>
</form>

<?php
    $titre = "Ajout d'un acteur à un film";
    $titre_secondaire = "Ajout d'un acteur à un film";
    $contenu = ob_get_clean();
    require "view/template.php";
?>