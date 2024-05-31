<?php
    ob_start();
?>

<p class="uk-label uk-label-warning"> Il y a <?= $requete->rowCount() ?> films</p>

<table class="uk-table uk-table-striped">
    <thead>
        <th>PRENOM</th>
        <th>NOM</th>
    </thead>  
    <body>
        <?php foreach ($requete->fetchAll() as $acteur) { ?>
            <tr>
                <td><?= $acteur["prenom_individu"] ?></td>
                <td><?= $acteur["nom_individu"] ?></td>
            </tr>
        <?php } ?>    
    </body>
</table>

<?php
  
    $titre = "Liste des acteurs";
    $titre_secondaire = "Liste des acteurs";
    $contenu = ob_get_clean();
    require "view/template.php";
?>