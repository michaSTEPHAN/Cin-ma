<?php
    ob_start();
?>

<form action="index.php?action=addGenre" method="POST" enctype="multipart/form-data">
    <p>
        <label>
            Nom du genre :
            <input type="text" name="nomGenre">
        </label>
    </p>
    <p>
        <input type="submit" name="submit" value="Ajouter le genre">
    </p>
</form>

<?php
    $titre = "Ajout d'un genre";
    $titre_secondaire = "Ajout d'un genre";
    $contenu = ob_get_clean();
    require "view/template.php";
?>