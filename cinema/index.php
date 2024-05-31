<?php
    use controller\CinemaController;

    spl_autoload_register(function ($class_name) {
        include $class_name . '.php';
    });

    $ctrlCinema = new CinemaController();       

    if(isset($_GET["action"])) {        
        switch ($_GET["action"]) {           
            case "listFilms"        : $ctrlCinema->listFilms(); break;
            case "listGenres"       : $ctrlCinema->listGenres(); break;
            case "listRealisateurs" : $ctrlCinema->listRealisateurs(); break;
            case "listActeurs"      : $ctrlCinema->listActeurs(); break;
        }
    }

?>