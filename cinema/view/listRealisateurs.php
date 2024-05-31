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
        <?php foreach ($requete->fetchAll() as $realisateur) { ?>
            <tr>
                <td><?= $realisateur["prenom_individu"] ?></td>
                <td><?= $realisateur["nom_individu"] ?></td>
            </tr>
        <?php } ?>    
    </body>
</table>

<?php
  
    $titre = "Liste des realisateurs";
    $titre_secondaire = "Liste des realisateurs";
    $contenu = ob_get_clean();
    require "view/template.php";
?>