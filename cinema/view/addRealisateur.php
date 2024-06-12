<?php
    ob_start();
?>

<form class="formAddRea" action="index.php?action=addRealisateur" method="POST" enctype="multipart/form-data">
    <p class="labnomRea">
        <p class="lab1">
            <label>
                Prénom :
                <input type="text" name="prenomRea">
            </label>
        </p>
        <p class="lab1">
            <label>
                Nom :
                <input type="text" name="nomRea">
            </label>
        </p>
        <p class="lab1">
            <label>
                Sexe :
                <input type="text" name="sexeRea">
            </label>
        </p>
        <p class="lab1">
            <label>
                Date de naissance :
                <input type="date" name="dateNaissRea">
            </label>  
        </p>
        <p class="lab1">
            <label for="file">
                Photo du réalisateur : 
                <input type="file" name="file">
            </label>
        </p>      
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