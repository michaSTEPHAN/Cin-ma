<?php
    ob_start();
    $film           = $filmAModifier->fetch();  
    $filmGenre      = $genreAModifier->fetch(); 
    $genres         = $listGenres->fetchAll();    
?>

<form action="index.php?action=updFilm&id=<?= $_GET["id"] ?>" method="POST" enctype="multipart/form-data">
    <div class="pageUpdFilm">
        <p class="labnomFilm">
            <p class="lab1">
                <label>
                    Titre :
                    <input type="text" maxlength="50" name="titreFilm" value="<?php echo $film['titre_film'] ?>">
                </label>
            </p>
            <p class="lab2">
                <label>
                    Durée :
                    <input type="int" name="dureeFilm" value="<?php echo $film['duree_film'] ?>">
                </label>
            </p>
            <p class="lab3">
                <label>
                    Synopsis :
                    <input type="text" maxlength="50" name="synopsisFilm" value="<?php echo $film['synopsis_film'] ?>">
                </label>
            </p>
            <p class="lab4">
                <label>
                    Note :
                    <input type="int" name="noteFilm" value="<?php echo $film['note_film'] ?>">
                </label>
            </p>
            <p class="lab6">
                <label>
                    Année de sortie :
                    <input type="int" name="anneeSortieFilm" value="<?php echo $film['annee_sortie_film'] ?>">
                </label>  
            </p>            
            <p class="lab7">
                <label>
                    Genre :
                    <checkbox name="id_genre">       
                        <?php foreach ($genres as $genre) { ?>
                            <?php $checked = ''; ?>
                            <!-- // On teste si le genre affiché est dans les genres du film -->
                            <?php if (in_array($genre["id_genre"],$tabGenres)) {
                                $checked='checked';
                            } ?>

                            <input type="checkbox" name="genreFilm[]" <?= $checked ?> value="<?= $genre["id_genre"] ?>"> 
                            <!-- <?php 
                                // if (isset( $_POST['value'])) echo 'checked="checked"'; 
                                
                            ?> -->
                            <?= $genre["libelle_genre"]?><br />                       
                        <?php } ?>
                    </checkbox>
                </label>
            </p>       
            <p class="lab8">
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