<?php
    use controller\CinemaController;
    use controller\IndividuController;
    use controller\FilmController;

    spl_autoload_register(function ($class_name) {
        include $class_name . '.php';
    });

    $ctrlCinema         = new CinemaController();     
    $ctrlIndividu       = new IndividuController();    
    $ctrlFilm           = new FilmController();    
    $titre_secondaire   = "";
    $contenu            = "";
    $action = $_GET['action'] ?? 'listFilms';
    $id     = (isset ($_GET["id"])) ? $_GET["id"] : "";
    $idFilm = (isset ($_GET["idFilm"])) ? $_GET["idFilm"] : "";
    $idRole = (isset ($_GET["idRole"])) ? $_GET["idRole"] : "";

    if(isset($action)) {        
        switch ($action) {           
            case "listFilms"            : $ctrlFilm->listFilms(); break;
            case "detailFilms"          : $ctrlFilm->detailFilms($id); break;
            case "acteursFilms"         : $ctrlFilm->acteursFilms($id); break;
            case "addFilm"              : $ctrlFilm->addFilm($id); break;
            case "delFilm"              : $ctrlFilm->delFilm($id); break; 
            case "updFilm"              : $ctrlFilm->updFilm($id); break; 
            case "addFilmActeur"        : $ctrlFilm->addFilmActeur($id); break; 
            
            case "listRealisateurs"     : $ctrlIndividu->listRealisateurs(); break;
            case "detailRealisateur"    : $ctrlIndividu->detailRealisateur($id); break;
            case "addRealisateur"       : $ctrlIndividu->addRealisateur($id); break;
            case "delRealisateur"       : $ctrlIndividu->delRealisateur($id); break; 
            case "updRealisateur"       : $ctrlIndividu->updRealisateur($id); break; 

            case "listActeurs"          : $ctrlIndividu->listActeurs(); break;            
            case "detailActeur"         : $ctrlIndividu->detailActeur($id); break;
            case "addActeur"            : $ctrlIndividu->addActeur($id); break;
            case "delActeur"            : $ctrlIndividu->delActeur($id); break;
            case "delRoleActeur"        : $ctrlIndividu->delRoleActeur($id,$idFilm,$idRole); break;
            case "updActeur"            : $ctrlIndividu->updActeur($id); break; 

            case "listRoles"            : $ctrlFilm->listRoles(); break;         
            case "detailRole"           : $ctrlFilm->detailRole($id); break;  
            case "addRole"              : $ctrlFilm->addRole($id); break;
            case "delRole"              : $ctrlFilm->delRole($id); break; 
            case "updRole"              : $ctrlFilm->updRole($id); break;                                                                  

            case "listGenres"           : $ctrlCinema->listGenres(); break;
            case "detailGenre"          : $ctrlCinema->detailGenre($id); break;            
            case "addGenre"             : $ctrlCinema->addGenre(); break;
            case "updGenre"             : $ctrlCinema->updGenre($id); break;     
            case "delGenre"             : $ctrlCinema->delGenre($id); break;          
        }
    }
?> 