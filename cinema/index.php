<?php
    use controller\CinemaController;

    spl_autoload_register(function ($class_name) {
        include $class_name . '.php';
    });

    $ctrlCinema = new CinemaController();     
    $titre_secondaire   = "";
    $contenu            = "";
    $action = $_GET['action'] ?? 'listFilms';
    $id = (isset ($_GET["id"])) ? $_GET["id"] : "";

    if(isset($action)) {        
        switch ($action) {           
            case "listFilms"            : $ctrlCinema->listFilms(); break;
            case "listGenres"           : $ctrlCinema->listGenres(); break;
            case "listRealisateurs"     : $ctrlCinema->listRealisateurs(); break;
            case "listActeurs"          : $ctrlCinema->listActeurs(); break;            
            case "listRoles"            : $ctrlCinema->listRoles(); break;            
            case "detailFilms"          : $ctrlCinema->detailFilms($id); break;
            case "detailRealisateur"    : $ctrlCinema->detailRealisateur($id); break;
            case "detailActeur"         : $ctrlCinema->detailActeur($id); break;
            case "acteursFilms"         : $ctrlCinema->acteursFilms($id); break;
        }
    }
?> 