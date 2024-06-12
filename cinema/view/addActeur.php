<?php
    ob_start();
?>

<form class="formAddAct" action="index.php?action=addActeur" method="POST" enctype="multipart/form-data">
    <p class="labnomAct">
        <p class="lab1">
            <label>
                Prénom :
                <input type="text" maxlength="50" name="prenomAct">
            </label>
        </p>
        <p class="lab2">
            <label>
                Nom :
                <input type="text" maxlength="50" name="nomAct">
            </label>
        </p>
        <p class="lab3">
            <label>
                Sexe :
                <input type="text" maxlength="1" name="sexeAct">
            </label>
        </p>
        <p class="lab4">
            <label>
                Date de naissance :
                <input type="date" name="dateNaissAct">
            </label>  
        </p>
        <p class="lab5">
            <label for="file">
                Photo de l'acteur : 
                <input type="file" name="file">
                <!-- <button type="submit">Enregistrer</button>   
                <input type="text" name="photoRea">             -->
            </label>  
        </p>
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