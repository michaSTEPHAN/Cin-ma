<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description"
            content="Mov/ies, le site référence qui vous donne les meilleures informations de vos films préférés !">
        <meta name="theme-color" content="#101C28" />
        <title><?= $titre ?></title>
        <link rel="stylesheet" href="public/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet">
    </head>

    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="index.php" class="nav_links nav_link1">Accueil</a></li>
                    <li><a href="index.php?action=listFilms" class="nav_links nav_link2">Films</a></li>
                    <li><a href="index.php?action=listGenres" class="nav_links nav_link3">Genres</a></li>
                    <li><a href="index.php?action=listActeurs" class="nav_links nav_link4">Acteurs</a></li>
                    <li><a href="index.php?action=listRealisateurs" class="nav_links nav_link5">Réalisateurs</a></li>
                    <li><a href="index.php?action=listRoles" class="nav_links nav_link5">Rôles</a></li>                                    
                </ul>
            </nav>
        </header>

        <main>
            <div id="contenu">
                <h1 class="titre-principal">MY FAVORITE MOVIES</h1>
                <h2 class="titre-secondaire"><?= $titre_secondaire ?></h2>
                <?= $contenu ?>
            </div>
        </main>

        <footer>
        </footer>
            
        </div>        
    </body>
</html>