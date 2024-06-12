<?php
    ob_start();
    $realisateurs       = $detailRealisateur->fetch();  
    $filmsRealisateurs  = $detailFilmsRealisateur->fetchAll();  
?>

<!-- ----------------------------------------------------- -->
<!-- Affichage des boutons modifier & supprimer            -->
<!-- ----------------------------------------------------- -->
<div class="gestion_bouton">    
    <a href="index.php?action=updRealisateur&id=<?= $realisateurs['id_individu'] ?>">         
        <img class="img_modifier" src="public\img\icones\modifier.webp"></img>
    </a>
    <a href="index.php?action=delRealisateur&id=<?= $realisateurs['id_individu'] ?>">         
        <img class="img_supprimer" src="public\img\icones\supprimer.webp"></img>
    </a>
</div>

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
            <p class = "rea_data"><?= $realisateurs['dateNaissRea'] ?></p>
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
    $titre = "Réalisateur : ".'"'.$realisateurs['personne'].'"';
    $titre_secondaire = "Réalisateur : ".'"'.$realisateurs['personne'].'"';
    $contenu = ob_get_clean();
    require "view/template.php";
?>