<?php
    ob_start();
    $nomGenres      = $detailNomGenre->fetch();   
    $filmsGenres    = $detailFilmsGenre->fetchAll();     
?>

<div class="gestion_bouton">    
    <a href="index.php?action=updGenre&id=<?= $nomGenres['id_genre'] ?>">         
        <img class="img_modifier" src="public\img\icones\modifier.webp"></img>
    </a>
    <a href="index.php?action=delGenre&id=<?= $nomGenres['id_genre'] ?>">         
        <img class="img_supprimer" src="public\img\icones\supprimer.webp"></img>
    </a>
</div>

<!-- ----------------------------------------------------- -->
<!-- Affichage des films du genre                          -->
<!-- ----------------------------------------------------- -->
<div class="det_genre">
        <h2 class="titre_det_genre">Liste des films</h2>
        <?php foreach ($filmsGenres as $filmsGenre) { ?>    
            <div class="info1_genre">                
                <p class="genre_film"><?= $filmsGenre['titre_film'] ?></p>
            </div>            
        <?php } ?>  
</div>    

<!-- ----------------------------------------------------- -->
<!-- Affichage des titres et contenu des requêtes          -->
<!-- ----------------------------------------------------- -->
<?php
    $titre              = $nomGenres['libelle_genre'];
    $titre_secondaire   = $nomGenres['libelle_genre'];
    $contenu            = ob_get_clean();
    require "view/template.php";
?>