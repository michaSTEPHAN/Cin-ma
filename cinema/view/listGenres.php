<?php
    ob_start();
?>

<p class="uk-label uk-label-warning"> Il y a <?= $requete->rowCount() ?> genre</p>

<table class="uk-table uk-table-striped">
    <thead>
        <th>GENRE</th>        
    </thead>  
    <body>
        <?php foreach ($requete->fetchAll() as $genre) { ?>
            <tr>
                <td><?= $genre["libelle_genre"] ?></td>
            </tr>
        <?php } ?>    
    </body>
</table>

<?php
  
    $titre = "Liste des genres de film";
    $titre_secondaire = "Liste des genre de film";
    $contenu = ob_get_clean();
    require "view/template.php";
?>