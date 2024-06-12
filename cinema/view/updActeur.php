<?php
    ob_start();
    $nomActeur = $acteurAModifier->fetch();    
?>

<!-- ----------------------------------------------------- -->
<!-- On récupère le sexe pour afficher acteur/actrice      -->
<!-- ----------------------------------------------------- -->
<?php
    $sexe = $nomActeur['sexe_individu'];
    if ($sexe == "F") {
        $libSexe = "Actrice";
    } else {
        $libSexe = "Acteur";
    }
?>

<form action="index.php?action=updActeur&id=<?= $_GET["id"] ?>" method="POST" enctype="multipart/form-data">
    <p class="labnomAct">
        <p class="lab1">
            <label>
                Prénom :
                <input type="text" name="prenomAct" value="<?php echo $nomActeur['prenom_individu'] ?>">
            </label>
        </p>
        <p class="lab2">
            <label>
                Nom :
                <input type="text" name="nomAct" value="<?php echo $nomActeur['nom_individu'] ?>">
            </label>
        </p>
        <p class="lab3">
            <label>
                Sexe :
                <input type="text" name="sexeAct" value="<?php echo $nomActeur['sexe_individu'] ?>">
            </label>
        </p>
        <p class="lab4">
            <label>
                Date de naissance :
                <input type="date" name="dateNaissAct" value="<?php echo $nomActeur['date_naissance_individu'] ?>">
            </label>     
        </p>
    </p>
    <p class= "UpdActeur">
        <input class= "submitUpdActeur" type="submit" name="submit" value="Modifier l'<?= $libSexe ?>">
    </p>
</form>

<?php
    $titre = "Modifier l'".$libSexe." ".$nomActeur['prenom_individu']." ".$nomActeur['nom_individu'];
    $titre_secondaire = "Modifier l'".$libSexe." ".$nomActeur['prenom_individu']." ".$nomActeur['nom_individu'];
    $contenu = ob_get_clean();
    require "view/template.php";
?>