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
        <p class = "titre_info_rea">INFORMATION SUR LE REALISATEUR</p>
        <div class="info1_rea">
            <p class = "info_rea">Nom</p>
            <p class = "rea_data"><?= $realisateurs['personne'] ?></p>
        </div>
        <div class="info2_rea">
            <p class = "info_rea">Date de naissance</p>
            <p class = "rea_data"><?= $realisateurs['date_naissance_individu'] ?></p>
        </div>
    </div>
</div>

<!-- ----------------------------------------------------- -->
<!-- Affichage de la liste des films du réalisateur        -->
<!-- ----------------------------------------------------- -->
<div class="realisateur_film">    
    <h2 class="titre_det_film_rea">Les films du réalisateur</h2>
    <div class="films_du_rea">
        <?php foreach ($filmsRealisateurs as $toto) { ?>   
            <p class="films_rea"><?= $toto['titre_film'] ?></p>                                        
        <?php } ?>   
    </div>      
</div>    

<!-- ----------------------------------------------------- -->
<!-- Affichage des titres et contenu des requêtes          -->
<!-- ----------------------------------------------------- -->
<?php
    $titre = "Détail d'un réalisateur";
    $titre_secondaire = "Détail d'un réalisateur";
    $contenu = ob_get_clean();
    require "view/template.php";
?>