<?php
    ob_start();
?>

<!-- ----------------------------------------------------- -->
<!-- Bouton ajouter un film                                -->
<!-- ----------------------------------------------------- -->
<div class="gestion_bouton">    
    <a href="index.php?action=addFilm">
        <img class="img_ajouter" src="public\img\icones\ajouter.webp"></img>
    </a>
</div>

<!-- ----------------------------------------------------- -->
<!-- Affichage de la liste des films sous forme d'affiches -->
<!-- ----------------------------------------------------- -->
<div class="liste_films">    
    <?php foreach ($requete->fetchAll() as $film) { ?>
        <figure>
            <a href="index.php?action=detailFilms&id=<?= $film['id_film'] ?>">
                <img class="img_film" src="<?= $film['affiche_film'] ?>">
            </a>
            <figcaption class="titre_film"><?= $film['titre_film'] ?></figcaption>
        </figure> 
    <?php } ?>    
</div>

<?php
    $titre = "Liste des films";
    $titre_secondaire = "Liste des films";
    $contenu = ob_get_clean();
    require "view/template.php";
?>