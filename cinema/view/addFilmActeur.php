<?php
    ob_start();
    $acteurs    = $listeActeur->fetchall();   
    $roles      = $listeRole->fetchall();
    $film       = $filmAModifier->fetch();
?>

<form class="formAddFilmActeur" action="index.php?action=addFilmActeur&id=<?= $_GET["id"] ?>" method="POST" enctype="multipart/form-data">

    <p class="labnomFilmActeur">   
        <p class="lab1">          
            <label>
                Acteur :
                <select name="id_individu">
                    <option value="">-- Acteur --</option>
                    <?php foreach ($acteurs as $acteur) { ?>
                        <option value="<?= $acteur["id_individu"] ?>">
                            <?= $acteur["personne"] ?>
                        </option>
                    <?php } ?>
                </select>
            </label>
        </p>
        <p class="lab2">    
            <label>
                Rôle :
                <select name="id_role">
                    <option value="">-- Rôle --</option>
                    <?php foreach ($roles as $role) { ?>
                        <option value="<?= $role["id_role"] ?>">
                            <?= $role["nom_role"] ?>
                        </option>
                    <?php } ?>
                </select>
            </label>
        </p>
    </p>
    <p class= "addFilmActeur">
        <input class= "submitAddFilmActeur" type="submit" name="submit" value="Ajouter l'acteur au film'">
    </p>
</form>

<?php
    $titre = "Ajout d'un acteur au film ".'"'.$film['titre_film'].'"';
    $titre_secondaire = "Ajout d'un acteur au film ".'"'.$film['titre_film'].'"';
    $contenu = ob_get_clean();
    require "view/template.php";
?>