<?php
    ob_start();
    $nomRoles = $roleAModifier->fetch();    
?>

<form action="index.php?action=updRole&id=<?= $_GET["id"] ?>" method="POST" enctype="multipart/form-data">
    <p class="labnomRole">
        <p class="lab1">
            <label>
                Nom du rôle :
                <input type="text" name="nomRole" value="<?php echo $nomRoles['nom_role'] ?>">
            </label>
        </p>
    </p>
    <p class= "UpdRole">
        <input class= "submitUpdRole" type="submit" name="submit" value="Modifier le rôle">
    </p>
</form>

<?php
    $titre = "Modifier le rôle ".$nomRoles['nom_role'];
    $titre_secondaire = "Modifier le rôle ".$nomRoles['nom_role'];
    $contenu = ob_get_clean();
    require "view/template.php";
?>