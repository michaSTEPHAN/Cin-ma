<?php
    ob_start();
    $acteurs       = $detailActeur->fetch();  
    $filmsActeurs  = $detailFilmsActeur->fetchAll();  
?>

<!-- ----------------------------------------------------- -->
<!-- Affichage des boutons modifier & supprimer            -->
<!-- ----------------------------------------------------- -->
<div class="gestion_bouton">    
    <a href="index.php?action=updActeur&id=<?= $acteurs['id_individu'] ?>">         
        <img class="img_modifier" src="public\img\icones\modifier.webp"></img>
    </a>
    <a href="index.php?action=delActeur&id=<?= $acteurs['id_individu'] ?>">         
        <img class="img_supprimer" src="public\img\icones\supprimer.webp"></img>
    </a>
</div>

<!-- ----------------------------------------------------- -->
<!-- On récupère le sexe pour afficher acteur/actrice      -->
<!-- ----------------------------------------------------- -->
<?php
    $sexe = $acteurs['sexe_individu'];
    if ($sexe == "F") {
        $libSexe = "Actrice";
    } else {
        $libSexe = "Acteur";
    }
?>

<!-- ----------------------------------------------------- -->
<!-- Affichage du détail d'un acteur                       -->
<!-- ----------------------------------------------------- -->
<div class="detail_acteur">
    <div class="photo_act">
        <img class="img_acteur" src="<?= $acteurs['photo_individu'] ?>">
    </div>
    <div class="lib_detail">
        <h2 class = "titre_info_act">Information sur l'<?= $libSexe ?></h2>
        <div class="info2_act">
            <p class = "info_act">Date de naissance</p>
            <p class = "act_data"><?= $acteurs['dateNaissAct'] ?></p>
        </div>
    </div>
</div>

<!-- ----------------------------------------------------- -->
<!-- Affichage de la liste des films + rôles de l'acteur   -->
<!-- ----------------------------------------------------- -->
<div class="acteur_film">    
    <h2 class="titre_act_film">Les rôles de l'<?= $libSexe ?></h2>
    <div class="act_films">
        <?php foreach ($filmsActeurs as $film) { ?>               
            <div class="aaa">
                <p class="films_act"><?= $film['titre_film'] ?> [ <?= $film['nom_role'] ?> ]</p>                  
                <a href="index.php?action=delRoleActeur&id=<?= $acteurs['id_individu'] ?> &idFilm=<?= $film['id_film'] ?> &idRole=<?= $film['id_role'] ?>">          
                    <img class="img_supprimer_pt" src="public\img\icones\supprimer.webp"></img>
                </a>             
            </div>                             
        <?php } ?>   
    </div>      
</div>    

<!-- ----------------------------------------------------- -->
<!-- Affichage des titres et contenu des requêtes          -->
<!-- ----------------------------------------------------- -->
<?php
    $titre = $libSexe.' "'.$acteurs['personne'].'"';
    $titre_secondaire = $libSexe.' "'.$acteurs['personne'].'"';
    $contenu = ob_get_clean();
    require "view/template.php";
?>