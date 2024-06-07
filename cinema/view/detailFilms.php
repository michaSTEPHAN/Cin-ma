<?php
    ob_start();
    $film    = $detailFilms->fetch();
    $genres  = $genreFilm->fetchAll();
    $acteurs = $acteursFilms->fetchAll()    
?>

<!-- ----------------------------------------------------- -->
<!-- Affichage du détail d'un film                         -->
<!-- ----------------------------------------------------- -->
<div class="detail_film">
    <div class="img_detail">
        <img class="img_film_clic" src="<?= $film['affiche_film'] ?>">
    </div>
    <div class="lib_detail">
        <p class = "titre_info_film">INFORMATION SUR LE FILM</p>
        <div class="info1_film">
            <p class = "info_film">Réalisateur</p>
            <p class = "film_data"><?= $film['personne'] ?></p>
        </div>
        <div class="info2_film">
            <p class = "info_film">Année de sortie</p>
            <p class = "film_data"><?= $film['annee_sortie_film'] ?></p>
        </div>
        <div class="info2bis_film">
            <p class = "info_film">Durée</p>
            <p class = "film_data"><?= $film['dureeFormat'] ?></p>
        </div>
        <div class="info3_film">
            <p class = "info_film">Genre</p>            
            <?php $listGenre = "" ?>
            <?php foreach ($genres as $genre) {
                $listGenre .= $genre['libelle_genre']."-";
            } ?> 
            <?php $listGenre = substr($listGenre,0,strlen($listGenre)-1) ?>
            <p class = "film_data"><?= $listGenre ?></p>
        </div>
        <div class="info4_film">
            <p class = "info_film">Note</p>
            <p class = "film_data"><?= $film['note_film'] ?> / 5</p>
        </div>
        <p class = "titre_synopsis_film">SYNOPSIS</p>
        <p class = "synopsis_film"><?= $film['synopsis_film'] ?></p>
        
    </div>
</div>

<!-- ----------------------------------------------------- -->
<!-- Affichage du réalisateur du film                      -->
<!-- ----------------------------------------------------- -->
<div class="realisateur_film">
    <figure>
        <h2 class="titre_det_realisateur">Le réalisateur</h2>
        <a href="index.php?action=detailRealisateur&id=<?= $film['id_realisateur'] ?>">
            <img class="img_realisateur" src="<?= $film['photo_individu'] ?>">
        </a>
        <p class="nom_realisateur"><?= $film['personne'] ?></p>
        <p class="dnaiss_realisateur"><?= $film['dateNaissRea'] ?></p>
    </figure> 
</div>    

<!-- ----------------------------------------------------- -->
<!-- Affichage des acteurs du film                         -->
<!-- ----------------------------------------------------- -->
<div class="acteurs_film">    
    <h2 class="titre_det_acteur">Les acteurs</h2>
    <div class="acteurs_du_film">
        <?php foreach ($acteurs as $acteur) { ?>    
            <figure> 
                <a href="index.php?action=detailActeur&id=<?= $acteur['id_acteur'] ?>">               
                    <img class="img_realisateur" src="<?= $acteur['photo_individu'] ?>">       
                </a>         
                <p class="nom_acteur"><?= $acteur['individu'] ?></p>
                <p class="dnaiss_acteur"><?= $acteur['dateNaissAct'] ?></p>
                <p class="role_acteur">"<?= $acteur['nom_role'] ?>"</p>
            </figure>
        <?php } ?>   
    </div>      
</div>    

<!-- ----------------------------------------------------- -->
<!-- Affichage des titres et contenu des requêtes          -->
<!-- ----------------------------------------------------- -->
<?php
    $titre = "Détail d'un film";
    $titre_secondaire = "Détail d'un film";
    $contenu = ob_get_clean();
    require "view/template.php";
?>