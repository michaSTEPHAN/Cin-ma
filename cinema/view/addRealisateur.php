<?php
    ob_start();
?>

<form class="formAddRea" action="index.php?action=addRealisateur" method="POST" enctype="multipart/form-data">
    <p class="labnomRea">
        <label>
            Prénom :
            <input type="text" name="prenomRea">
        </label>
        <label>
            Nom :
            <input type="text" name="nomRea">
        </label>
        <label>
            Sexe :
            <input type="text" name="sexeRea">
        </label>
        <label>
            Date de naissance :
            <input type="date" name="dateNaissRea">
        </label>  
        <label for="file">
            Photo du réalisateur : 
            <input type="file" name="file">
            <!-- <button type="submit">Enregistrer</button>   
            <input type="text" name="photoRea">             -->
        </label>  
    </p>
    <p class= "AddRea">
        <input class= "submitAddRea" type="submit" name="submit" value="Ajouter le réalisateur">
    </p>
</form>

<?php
    $titre = "Ajout d'un réalisateur";
    $titre_secondaire = "Ajout d'un réalisateur";
    $contenu = ob_get_clean();
    require "view/template.php";
?>