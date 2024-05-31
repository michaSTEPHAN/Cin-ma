<?php

namespace Controller;
use Model\Connect;

class CinemaController {

    //------------------------------------
    // Liste des films
    //------------------------------------
    public function listFilms() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("SELECT titre_film, annee_sortie_film FROM film");
        require "view/listFilms.php";
    }

   //------------------------------------
   //Lister des genres
   //------------------------------------
   public function listGenres() {
       $pdo = Connect::seConnecter();
       $requete = $pdo->query("SELECT * FROM genre");
       require "view/listGenres.php";
   }

   //------------------------------------
   //Lister des réalisateurs
   //------------------------------------
   public function listRealisateurs() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT i.prenom_individu, i.nom_individu
            FROM individu i
            INNER JOIN realisateur r ON i.id_individu = r.id_individu
    ");
        require "view/listRealisateurs.php";
    }

    //------------------------------------
   //Lister des acteurs
   //------------------------------------
   public function listActeurs() {
    $pdo = Connect::seConnecter();
    $requete = $pdo->query("
        SELECT i.prenom_individu, i.nom_individu
        FROM individu i
        INNER JOIN acteur a ON i.id_individu = a.id_individu
    ");
        require "view/listActeurs.php";
    }

}

?>