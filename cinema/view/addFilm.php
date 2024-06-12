<?php
    ob_start();
?>

<form class="formAddFilm" action="index.php?action=addFilm" method="POST" enctype="multipart/form-data">
    <p class="labnomFilm">
        <label>
            Titre :
            <input type="text" maxlength="50" name="titreFilm">
        </label>
        <label>
            Durée :
            <input type="int" name="dureeFilm">
        </label>
        <label>
            Synopsis :
            <input type="text" maxlength="50" name="synopsisFilm">
        </label>
        <label>
            Note :
            <input type="int" name="noteFilm">
        </label>
        <label>
            Année de sortie :
            <input type="int" name="anneeSortieFilm">
        </label>  
        <label>
            Genre :
            <input type="int" name="genreFilm">
        </label>  
        <label>
            Réalisateur :
            <input type="int" name="realisateurFilm">
        </label>  
        <label for="file">
            Affiche du film
            <input type="file" name="file">
        </label>  
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