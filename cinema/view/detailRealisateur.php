<?php
    ob_start();
    $realisateurs       = $detailRealisateur->fetch();  
    $filmsRealisateurs  = $detailFilmsRealisateur->fetchAll();  
?>

<!-- ----------------------------------------------------- -->
<!-- Affichage du détail d'un réalisateur                  -->
<!-- ----------------------------------------------------- -->
<div class="detail_realisateur">
    <div class="photo_rea">
        <img class="img_realisateur" src="<?= $realisateurs['photo_individu'] ?>">
    </div>
    <div class="lib_detail">
        <h2 class = "titre_info_rea">Information sur le réalisateur</h2>        
        <div class="info2_rea">
            <p class = "info_rea">Date de naissance</p>
            <p class = "rea_data"><?= $realisateurs['date_naissance_individu'] ?></p>
        </div>
    </div>
</div>

<!-- ----------------------------------------------------- -->
<!-- Affichage de la liste des films du réalisateur        -->
<!-- ----------------------------------------------------- -->
<div class="rea_film">    
    <h2 class="titre_rea_film">Les films du réalisateur</h2>
    <div class="rea_films">
        <?php foreach ($filmsRealisateurs as $toto) { ?>   
            <p class="films_rea"><?= $toto['titre_film'] ?></p>                                        
        <?php } ?>   
    </div>      
</div>    

<!-- ----------------------------------------------------- -->
<!-- Affichage des titres et contenu des requêtes          -->
<!-- ----------------------------------------------------- -->
<?php
    $titre = $realisateurs['personne'];
    $titre_secondaire = $realisateurs['personne'];
    $contenu = ob_get_clean();
    require "view/template.php";
?>