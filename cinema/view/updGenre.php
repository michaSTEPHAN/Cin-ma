<?php
    ob_start();
    $nomGenres = $genreAModifier->fetch();    
?>

<form action="index.php?action=updGenre&id=<?= $_GET["id"] ?>" method="POST" enctype="multipart/form-data">
    <p class="labnomGenre">
        <p class="lab1">
            <label>
                Nom du genre :
                <input type="text" name="libelleGenre" value="<?php echo $nomGenres['libelle_genre'] ?>">
            </label>
        </p>
    </p>
    <p class= "UpdGenre">
        <input class= "submitUpdGenre" type="submit" name="submit" value="Modifier le genre">
    </p>
</form>

<?php
    $titre = "Modifier le genre ".$nomGenres['libelle_genre'];
    $titre_secondaire = "Modifier le genre ".$nomGenres['libelle_genre'];
    $contenu = ob_get_clean();
    require "view/template.php";
?>