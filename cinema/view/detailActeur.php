<?php
    ob_start();
    $acteurs       = $detailActeur->fetch();  
    $filmsActeurs  = $detailFilmsActeur->fetchAll();  
?>

<!-- ----------------------------------------------------- -->
<!-- Affichage du détail d'un acteur                       -->
<!-- ----------------------------------------------------- -->
<div class="detail_acteur">
    <div class="photo_act">
        <img class="img_acteur" src="<?= $acteurs['photo_individu'] ?>">
    </div>
    <div class="lib_detail">
        <h2 class = "titre_info_act">Information sur l'acteur</h2>
        <div class="info2_act">
            <p class = "info_act">Date de naissance</p>
            <p class = "act_data"><?= $acteurs['date_naissance_individu'] ?></p>
        </div>
    </div>
</div>

<!-- ----------------------------------------------------- -->
<!-- Affichage de la liste des films + rôles de l'acteur   -->
<!-- ----------------------------------------------------- -->
<div class="acteur_film">    
    <h2 class="titre_act_film">Les films de l'acteur</h2>
    <div class="act_films">
        <?php foreach ($filmsActeurs as $toto) { ?>               
            <p class="films_act"><?= $toto['titre_film'] ?></p>
            <p class="films_act"><?= $toto['nom_role'] ?></p>                                        
        <?php } ?>   
    </div>      
</div>    

<!-- ----------------------------------------------------- -->
<!-- Affichage des titres et contenu des requêtes          -->
<!-- ----------------------------------------------------- -->
<?php
    $titre = $acteurs['personne'];
    $titre_secondaire = $acteurs['personne'];
    $contenu = ob_get_clean();
    require "view/template.php";
?>