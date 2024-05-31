<?php
    ob_start();
?>

<p class="uk-label uk-label-warning"> Il y a <?= $requete->rowCount() ?> films</p>

<table class="uk-table uk-table-striped">
    <thead>
        <th>TITRE</th>
        <th>ANNEE DE SORTIE</th>
    </thead>  
    <body>
        <?php foreach ($requete->fetchAll() as $film) { ?>
            <tr>
                <td><?= $film["titre_film"] ?></td>
                <td><?= $film["annee_sortie_film"] ?></td>
            </tr>
        <?php } ?>    
    </body>
</table>

<?php
  
    $titre = "Liste des films";
    $titre_secondaire = "Liste des films";
    $contenu = ob_get_clean();
    require "view/template.php";
?>