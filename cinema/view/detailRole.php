<?php
    ob_start();
    $nomRoles       = $detailNomRole->fetch();   
    $acteursRoles   = $detailRoleActeur->fetchAll();          
?>

<!-- ----------------------------------------------------- -->
<!-- Affichage des boutons modifier & supprimer            -->
<!-- ----------------------------------------------------- -->
<div class="gestion_bouton">    
    <a href="index.php?action=updRole&id=<?= $nomRoles['id_role'] ?>">         
        <img class="img_modifier" src="public\img\icones\modifier.webp"></img>
    </a>
    <a href="index.php?action=delRole&id=<?= $nomRoles['id_role'] ?>">         
        <img class="img_supprimer" src="public\img\icones\supprimer.webp"></img>
    </a>
</div>


<!-- ----------------------------------------------------- -->
<!-- Affichage des infos sur le rôle                       -->
<!-- ----------------------------------------------------- -->
<div class="det_role">
        <h2 class="titre_det_role">Information sur le rôle</h2>
        <?php foreach ($acteursRoles as $role) { ?>    
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
    $titre = $nomRoles['nom_role'];
    $titre_secondaire = $nomRoles['nom_role'];
    $contenu = ob_get_clean();
    require "view/template.php";
?>