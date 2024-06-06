<?php
    ob_start();
    $roles = $detailRole->fetchAll()    
?>

<!-- ----------------------------------------------------- -->
<!-- Affichage des infos sur le rôle                       -->
<!-- ----------------------------------------------------- -->
<div class="det_role">
        <h2 class="titre_det_role">Information sur le rôle</h2>
        <?php foreach ($roles as $role) { ?>    
            <div class="info1_role">
                <p class="role_nom">Film</p>
                <p class="role_film"><?= $role['titre_film'] ?></p>
            </div>
            <div class="info2_role">
                <p class="role_nom">Acteur</p>
                <p class="role_act"><?= $role['individu'] ?></p>
            </div>
        <?php } ?>  
</div>    

<!-- ----------------------------------------------------- -->
<!-- Affichage des titres et contenu des requêtes          -->
<!-- ----------------------------------------------------- -->
<?php
    $titre = $role['nom_role'];
    $titre_secondaire = $role['nom_role'];
    $contenu = ob_get_clean();
    require "view/template.php";
?>