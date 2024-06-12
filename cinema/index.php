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
            case "addFilm"              : $ctrlCinema->addFilm($id); break;
            case "delFilm"              : $ctrlCinema->delFilm($id); break; 
            case "updFilm"              : $ctrlCinema->updFilm($id); break; 
            case "addFilmActeur"        : $ctrlCinema->addFilmActeur($id); break; 
            
            case "listRealisateurs"     : $ctrlCinema->listRealisateurs(); break;
            case "detailRealisateur"    : $ctrlCinema->detailRealisateur($id); break;
            case "addRealisateur"       : $ctrlCinema->addRealisateur($id); break;
            case "delRealisateur"       : $ctrlCinema->delRealisateur($id); break; 
            case "updRealisateur"       : $ctrlCinema->updRealisateur($id); break; 

            case "listActeurs"          : $ctrlCinema->listActeurs(); break;            
            case "detailActeur"         : $ctrlCinema->detailActeur($id); break;
            case "addActeur"            : $ctrlCinema->addActeur($id); break;
            case "delActeur"            : $ctrlCinema->delActeur($id); break; 
            case "updActeur"            : $ctrlCinema->updActeur($id); break; 

            case "listRoles"            : $ctrlCinema->listRoles(); break;         
            case "detailRole"           : $ctrlCinema->detailRole($id); break;  
            case "addRole"              : $ctrlCinema->addRole($id); break;
            case "delRole"              : $ctrlCinema->delRole($id); break; 
            case "updRole"              : $ctrlCinema->updRole($id); break;                                                                  

            case "listGenres"           : $ctrlCinema->listGenres(); break;
            case "detailGenre"          : $ctrlCinema->detailGenre($id); break;            
            case "addGenre"             : $ctrlCinema->addGenre(); break;
            case "updGenre"             : $ctrlCinema->updGenre($id); break;     
            case "delGenre"             : $ctrlCinema->delGenre($id); break;          
        }
    }
?> 