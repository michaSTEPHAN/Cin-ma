<?php
    ob_start();
    $film       = $filmAModifier->fetch();  
    $filmGenre  = $genreAModifier->fetch();  
?>

<form action="index.php?action=updFilm&id=<?= $_GET["id"] ?>" method="POST" enctype="multipart/form-data">
    <div class="pageUpdFilm">
        <p class="labnomFilm">
            <label>
                Titre :
                <input type="text" maxlength="50" name="titreFilm" value="<?php echo $film['titre_film'] ?>">
            </label>
            <label>
                Durée :
                <input type="int" name="dureeFilm" value="<?php echo $film['duree_film'] ?>">
            </label>
            <label>
                Synopsis :
                <input type="text" maxlength="50" name="synopsisFilm" value="<?php echo $film['synopsis_film'] ?>">
            </label>
            <label>
                Note :
                <input type="int" name="noteFilm" value="<?php echo $film['note_film'] ?>">
            </label>
            <label>
                Année de sortie :
                <input type="int" name="anneeSortieFilm" value="<?php echo $film['annee_sortie_film'] ?>">
            </label>                        
            <label>
                Genre :
                <select name="genreFilm" value="<?= $filmGenre["id_genre"] ?>">
                    <?php if ($listGenres) {
                        foreach ($listGenres->fetchAll() as $genre) {
                            $selected = ($genre["id_genre"] == $filmGenre["id_genre"]) ? 'selected' : ''; ?>
                            <option value="<?= $genre["id_genre"] ?>" <?= $selected ?>>
                                <?= $genre["libelle_genre"] ?>
                            </option>
                        <?php }
                    } ?>
                </select>
            </label>

            <label>
                Réalisateur :
                <select name="realisateurFilm" value="<?php $filmGenre['id_realisateur'] ?>">
                    <?php if ($listRealisateurs) {
                        foreach ($listRealisateurs->fetchAll() as $realisateur) {
                            $selected = ($realisateur["id_realisateur"] == $film["id_realisateur"]) ? 'selected' : ''; ?>
                            <option value="<?= $realisateur["id_realisateur"] ?>" <?= $selected ?>>
                                <?= $realisateur["personne"] ?>
                            </option>
                        <?php }
                    } ?>
                </select>
            </label>
        </p>    
    </div>
    <p class= "UpdFilm">
        <input class= "submitUpdActeur" type="submit" name="submit" value="Modifier le film">
    </p>

</form>

<?php
    $titre = "Modifier le film ".$film['titre_film'];
    $titre_secondaire = "Modifier le film ".$film['titre_film'];
    $contenu = ob_get_clean();
    require "view/template.php";
?>