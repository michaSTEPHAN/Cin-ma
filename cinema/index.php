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
            case "detailFilms"          : $ctrlCinema->detailFilms($id); break;
            case "acteursFilms"         : $ctrlCinema->acteursFilms($id); break;
            
            case "listRealisateurs"     : $ctrlCinema->listRealisateurs(); break;
            case "detailRealisateur"    : $ctrlCinema->detailRealisateur($id); break;

            case "listActeurs"          : $ctrlCinema->listActeurs(); break;            
            case "detailActeur"         : $ctrlCinema->detailActeur($id); break;

            case "listRoles"            : $ctrlCinema->listRoles(); break;         
            case "detailRole"           : $ctrlCinema->detailRole($id); break;                                                                   

            case "listGenres"           : $ctrlCinema->listGenres(); break;
            case "detailGenre"           : $ctrlCinema->detailGenre($id); break;            
            case "addGenre"             : $ctrlCinema->addGenre(); break;
            case "updGenre"             : $ctrlCinema->updGenre($id); break;     
            case "delGenre"             : $ctrlCinema->delGenre($id); break;          
        }
    }
?> 