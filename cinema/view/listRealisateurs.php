<?php
    ob_start();
?>

<div class="gestion_bouton">    
    <a href="index.php?action=addRealisateur">
        <img class="img_ajouter" src="public\img\icones\ajouter.webp"></img>
    </a>
</div>

<div class="liste_realisateurs">
    <?php foreach ($requete->fetchAll() as $realisateur) { ?>
        <figure>
            <a href="index.php?action=detailRealisateur&id=<?= $realisateur['id_individu'] ?>">
                <img class="img_realisateur" src="<?= $realisateur['photo_individu'] ?>">
            </a>    
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