<?php
    ob_start();
?>

<div class="liste_roles">
    <?php foreach ($requete->fetchAll() as $roles) { ?>
        <div class="listRole">
            <a href="index.php?action=detailRole&id=<?= $roles['id_role'] ?>">             
                <p class="libRole"><?= $roles['nom_role'] ?></p>
            </a>
        </div>               
    <?php } ?>    
</div>

<?php  
    $titre = "Liste des rôles";
    $titre_secondaire = "Liste des rôles";
    $contenu = ob_get_clean();
    require "view/template.php";
?>