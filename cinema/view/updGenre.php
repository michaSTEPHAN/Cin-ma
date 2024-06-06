<?php
    ob_start();
    // $genre = $prevGenreInfos->fetch();
?>


<form action="index.php?action=updGenre&id=<?= $_GET["id"] ?>" method="POST" enctype="multipart/form-data">
    <p>
        <label>
            Nom du genre :
            <input type="text" name="libelleGenre">
        </label>
    </p>
    <p>
        <input type="submit" name="submit" value="Modifier le genre">
    </p>
</form>

<?php
    $titre = "Modifier un genre";
    $titre_secondaire = "Modifier un genre";
    $contenu = ob_get_clean();
    require "view/template.php";
?>