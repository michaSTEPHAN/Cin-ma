<?php
    ob_start();
?>

<div class="gestion_bouton">    
    <a href="index.php?action=ajoutGenre">
        <img class="img_ajouter" src="public\img\icones\ajouter.webp"></img>
    </a>
    <a href="index.php?action=modifGenre">
        <img class="img_modifier" src="public\img\icones\modifier.webp"></img>
    </a>
    <a href="index.php?action=suppressionGenre">
        <img class="img_supprimer" src="public\img\icones\supprimer.webp"></img>
    </a>
</div>

<div class="liste_genres">
    <?php foreach ($requete->fetchAll() as $genre) { ?>
        <p class="nom_genre">            
            <?= $genre["libelle_genre"] ?>
        </p> 
    <?php } ?>    
</div>

<?php  
    $titre = "Liste des genres de film";
    $titre_secondaire = "Liste des genre de film";
    $contenu = ob_get_clean();
    require "view/template.php";
?>