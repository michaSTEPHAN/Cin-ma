<?php
    ob_start();
?>

<div class="gestion_bouton">    
    <a href="index.php?action=addGenre">
        <img class="img_ajouter" src="public\img\icones\ajouter.webp"></img>
    </a>
</div>

<div class="liste_genres">
    <?php foreach ($requete->fetchAll() as $genre) { ?>
        <p class="nom_genre">  
        <a href="index.php?action=detailGenre&id=<?= $genre['id_genre'] ?>">     
            <?= $genre["libelle_genre"] ?>
        </a>
        </p> 
    <?php } ?>    
</div>

<?php  
    $titre = "Liste des genres de film";
    $titre_secondaire = "Liste des genres de film";
    $contenu = ob_get_clean();
    require "view/template.php";
?>