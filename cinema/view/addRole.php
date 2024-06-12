<?php
    ob_start();
?>

<form class="formAddRole" action="index.php?action=addRole" method="POST" enctype="multipart/form-data">
    <p class="labnomRole">
        <p class="lab1">
            <label>
                Nom du rôle :
                <input type="text" name="nomRole">
            </label>
        </p>
    </p>
    <p class= "AddRole">
        <input class= "submitAddRole" type="submit" name="submit" value="Ajouter le rôlee">
    </p>
</form>

<?php
    $titre = "Ajout d'un rôle";
    $titre_secondaire = "Ajout d'un rôle";
    $contenu = ob_get_clean();
    require "view/template.php";
?>