<?php
    ob_start();
    $nomActeur = $acteurAModifier->fetch();    
?>

<form action="index.php?action=updActeur&id=<?= $_GET["id"] ?>" method="POST" enctype="multipart/form-data">
    <p class="labnomGenre">
        <label>
            Prénom :
            <input type="text" name="prenomAct" value="<?php echo $nomActeur['prenom_individu'] ?>">
        </label>
        <label>
            Nom :
            <input type="text" name="nomAct" value="<?php echo $nomActeur['nom_individu'] ?>">
        </label>
        <label>
            Sexe :
            <input type="text" name="sexeAct" value="<?php echo $nomActeur['sexe_individu'] ?>">
        </label>
        <label>
            Date de naissance :
            <input type="date" name="dateNaissAct" value="<?php echo $nomActeur['date_naissance_individu'] ?>">
        </label>    
        <label for="file">
            Photo de l'acteur : 
            <input type="file" name="file">           
        </label>      
    </p>
    <p class= "UpdActeur">
        <input class= "submitUpdActeur" type="submit" name="submit" value="Modifier l'acteur">
    </p>
</form>

<?php
    $titre = "Modifier l'acteur ".$nomActeur['prenom_individu']." ".$nomActeur['nom_individu'];
    $titre_secondaire = "Modifier l'acteur ".$nomActeur['prenom_individu']." ".$nomActeur['nom_individu'];
    $contenu = ob_get_clean();
    require "view/template.php";
?>