<?php
    ob_start();
?>

<form class="formAddGenre" action="index.php?action=addGenre" method="POST" enctype="multipart/form-data">
    <p class="labnomGenre">
        <p class="lab1">
            <label>
                Nom du genre :
                <input type="text" name="nomGenre">
            </label>
        </p>    
    </p>
    <p class= "AddGenre">
        <input class= "submitAddGenre" type="submit" name="submit" value="Ajouter le genre">
    </p>
</form>

<?php
    $titre = "Ajout d'un genrezzz";
    $titre_secondaire = "Ajout d'un genre";
    $contenu = ob_get_clean();
    require "view/template.php";
?>