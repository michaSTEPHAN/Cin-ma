<?php
    ob_start();
?>

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