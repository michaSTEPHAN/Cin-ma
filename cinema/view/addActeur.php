<?php
    ob_start();
?>

<form class="formAddAct" action="index.php?action=addActeur" method="POST" enctype="multipart/form-data">
    <p class="labnomAct">
        <label>
            Prénom :
            <input type="text" maxlength="50" name="prenomAct">
        </label>
        <label>
            Nom :
            <input type="text" maxlength="50" name="nomAct">
        </label>
        <label>
            Sexe :
            <input type="text" maxlength="1" name="sexeAct">
        </label>
        <label>
            Date de naissance :
            <input type="date" name="dateNaissAct">
        </label>  
        <label for="file">
            Photo de l'acteur : 
            <input type="file" name="file">
            <!-- <button type="submit">Enregistrer</button>   
            <input type="text" name="photoRea">             -->
        </label>  
    </p>
    <p class= "AddAct">
        <input class= "submitAddAct" type="submit" name="submit" value="Ajouter l'acteur">
    </p>
</form>

<?php
    $titre = "Ajout d'un acteur";
    $titre_secondaire = "Ajout d'un acteur";
    $contenu = ob_get_clean();
    require "view/template.php";
?>