<?php
    ob_start();
?>

<div class="liste_roles">
    <?php foreach ($requete->fetchAll() as $roles) { ?>
        <div class="listRole">
            <!-- <p class="libRole"><?= $roles['personne'] ?></p> -->
            <p class="libRole"><?= $roles['nom_role'] ?></p>
            <!-- <p class="libRole">Dans <?= $roles['titre_film'] ?></p> -->
        </div>               
    <?php } ?>    
</div>

<?php  
    $titre = "Liste des rôles";
    $titre_secondaire = "Liste des rôles";
    $contenu = ob_get_clean();
    require "view/template.php";
?>