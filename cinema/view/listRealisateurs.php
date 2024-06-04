<?php
    ob_start();
?>

<div class="liste_realisateurs">
    <?php foreach ($requete->fetchAll() as $realisateur) { ?>
        <figure>
            <img class="img_realisateur" src="<?= $realisateur['photo_individu'] ?>">
            <figcaption class="nom_realisateur"><?= $realisateur["prenom_individu"] ?> <?= $realisateur["nom_individu"] ?></figcaption>
        </figure> 
    <?php } ?>    
</div>

<?php
  
    $titre = "Liste des realisateurs";
    $titre_secondaire = "Liste des realisateurs";
    $contenu = ob_get_clean();
    require "view/template.php";
?>