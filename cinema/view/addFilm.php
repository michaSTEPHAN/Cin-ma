<?php
    ob_start();
    $realisateurs   = $listeRealisateur->fetchall();   
    $genres         = $listeGenre->fetchall();
?>

<form class="formAddFilm" action="index.php?action=addFilm" method="POST" enctype="multipart/form-data">
    <p class="labnomFilm">
        <p class="lab1">
            <label>
                Titre :
                <input type="text" maxlength="50" name="titreFilm">
            </label>
        </p>
        <p class="lab2">
            <label>
                Durée :
                <input type="int" name="dureeFilm">
            </label>
        </p>
        <p class="lab3">
            <label>
                Synopsis :
                <input type="text" maxlength="50" name="synopsisFilm">
            </label>
        </p>
        <p class="lab4">
            <label>
                Note :
                <input type="int" name="noteFilm">
            </label>
        </p>
        <p class="lab5">
            <label>
                Année de sortie :
                <input type="int" name="anneeSortieFilm">
            </label>
        </p>  
        
        <p class="lab7">
            <label>
                Réalisateur :
                <select name="id_realisateur">
                    <option value="">-- Réalisateur --</option>
                    <?php foreach ($realisateurs as $realisateur) { ?>
                        <option value="<?= $realisateur["id_realisateur"] ?>">
                            <?= $realisateur["personne"] ?>
                        </option>
                    <?php } ?>
                </select>
            </label>
        </p>

        <p class="lab6">
            <label>
                Genre :
                <checkbox name="id_genre">       
                    <?php foreach ($genres as $genre) { ?>
                        <input type="checkbox" name="genreFilm[]" value="<?= $genre["id_genre"] ?>"> 
                        <?php 
                            if ( isset( $_POST['value'])) echo 'checked="checked"'; 
                        ?>
                        <?= $genre["libelle_genre"]?><br />                       
                    <?php } ?>
                </checkbox>
            </label>
        </p>
        
        <p class="lab8">
            <label for="file">
                Affiche du film
                <input type="file" name="file">
            </label>  
        </p>
    </p>
    <p class= "AddFilm">
        <input class= "submitAddFilm" type="submit" name="submit" value="Ajouter le film">
    </p>
</form>

<?php
    $titre = "Ajout d'un film";
    $titre_secondaire = "Ajout d'un film";
    $contenu = ob_get_clean();
    require "view/template.php";
?>