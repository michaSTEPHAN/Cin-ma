<?php

namespace Controller;
use Model\Connect;

class CinemaController {

    //------------------------------------
    // Liste des films
    //------------------------------------
    public function listFilms() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT titre_film, annee_sortie_film, affiche_film, id_film, note_film
            FROM film 
            WHERE affiche_film <> ''
        ");
        require "view/listFilms.php";
    }

   //------------------------------------
   // Lister des genres
   //------------------------------------
   public function listGenres() {
       $pdo = Connect::seConnecter();
       $requete = $pdo->query("SELECT * FROM genre");
       require "view/listGenres.php";
   }

   //------------------------------------
   // Liste des réalisateurs
   //------------------------------------
   public function listRealisateurs() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT i.prenom_individu, i.nom_individu, i.photo_individu, i.id_individu
            FROM individu i
            INNER JOIN realisateur r ON i.id_individu = r.id_individu
            WHERE i.photo_individu is NOT NULL
        ");
        require "view/listRealisateurs.php";
    }

  //------------------------------------
  // Liste des acteurs
  //------------------------------------
   public function listActeurs() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT i.prenom_individu, i.nom_individu, i.photo_individu, a.id_acteur
            FROM individu i
            INNER JOIN acteur a ON i.id_individu = a.id_individu
            WHERE i.photo_individu is NOT NULL
        ");
            require "view/listActeurs.php";
    }

    //------------------------------------
    // Liste des rôles
    //------------------------------------
    public function listRoles() {
    $pdo = Connect::seConnecter();
    $requete = $pdo->query("
        SELECT CONCAT(i.prenom_individu, ' ', i.nom_individu) AS personne, 
        r.nom_role, 
        f.titre_film
        FROM individu i
        INNER JOIN acteur a ON a.id_individu = i.id_individu
        INNER JOIN jouer_dans jd ON jd.id_acteur = a.id_acteur
        INNER JOIN role r ON r.id_role = jd.id_role
        INNER JOIN film f ON f.id_film = jd.id_film
    ");
        require "view/listRoles.php";
    }

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$    
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$    

   //------------------------------------
   // Détail d'un acteur
   //------------------------------------
   public function detailActeur($id) { 

    $pdo = Connect::seConnecter();

    $detailActeur = $pdo->prepare("
         SELECT CONCAT(i.prenom_individu, ' ', i.nom_individu) AS personne, 
         i.date_naissance_individu, 
         i.photo_individu
         FROM individu i
         INNER JOIN acteur a ON a.id_individu = i.id_individu
         WHERE a.id_acteur = :id_acteur
    ");
     $detailActeur->execute(["id_acteur" => $id]);
     
    $detailFilmsActeur = $pdo->prepare("
        SELECT f.titre_film, r.nom_role 
        FROM individu i
        INNER JOIN acteur a ON a.id_individu = i.id_individu
        INNER JOIN jouer_dans jd ON jd.id_acteur = a.id_acteur
        INNER JOIN film f ON f.id_film = jd.id_film 
        INNER JOIN role r ON r.id_role = jd.id_role
        WHERE a.id_acteur = :id_acteur
    ");
    $detailFilmsActeur->execute(["id_acteur" => $id]);

     require "view/detailActeur.php";
}

   //------------------------------------
   // Détail d'un réalisateur
   //------------------------------------
   public function detailRealisateur($id) { 

       $pdo = Connect::seConnecter();

       $detailRealisateur = $pdo->prepare("
            SELECT CONCAT(i.prenom_individu, ' ', i.nom_individu) AS personne, 
            i.date_naissance_individu, 
            i.photo_individu
            FROM individu i
            INNER JOIN realisateur re ON re.id_individu = i.id_individu
            INNER JOIN film f ON f.id_realisateur = re.id_realisateur
            WHERE f.id_realisateur = :id_realisateur
        ");
        $detailRealisateur->execute(["id_realisateur" => $id]);
        
        $detailFilmsRealisateur = $pdo->prepare("
            SELECT f.titre_film
            FROM individu i
            INNER JOIN realisateur re ON re.id_individu = i.id_individu
            INNER JOIN film f ON f.id_realisateur = re.id_realisateur
            WHERE f.id_realisateur = :id_realisateur
    ");
         $detailFilmsRealisateur->execute(["id_realisateur" => $id]);

        require "view/detailRealisateur.php";
   }

   //------------------------------------
   // Détail d'un film
   //------------------------------------
    public function detailFilms($id) {
        $pdo = Connect::seConnecter();

        $detailFilms = $pdo->prepare("
            SELECT *, REPLACE(SUBSTRING(SEC_TO_TIME(f.duree_film*60), 2, 4), ':', 'h') AS dureeFormat, 
            CONCAT(i.prenom_individu, ' ', i.nom_individu) AS personne,
            i.date_naissance_individu, 
            i.photo_individu,
            f.annee_sortie_film,
            f.id_realisateur        
            FROM film f
            INNER JOIN realisateur r ON f.id_realisateur = r.id_realisateur
            INNER JOIN individu i ON r.id_individu = i.id_individu
            WHERE id_film = :id_film
        ");
        $detailFilms->execute(["id_film" => $id]);

        $acteursFilms = $pdo->prepare("
            SELECT i.id_individu, 
            i.photo_individu, 
            CONCAT(prenom_individu, ' ', nom_individu) AS individu, 
            r.id_role, 
            nom_role, 
            a.id_acteur,
            i.date_naissance_individu
            FROM jouer_dans jd
            INNER JOIN acteur a ON jd.id_acteur = a.id_acteur
            INNER JOIN individu i ON a.id_individu = i.id_individu
            INNER JOIN film f ON jd.id_film = f.id_film
            INNER JOIN role r ON jd.id_role = r.id_role
            WHERE jd.id_film = :id_film
        ");
        $acteursFilms->execute(["id_film" => $id]);

        $genreFilm = $pdo->prepare("
            SELECT g.id_genre, g.libelle_genre 
            FROM genre g
            INNER JOIN appartenir a ON g.id_genre = a.id_genre
            WHERE a.id_film = :id_film"
        );
        $genreFilm->execute(["id_film" => $id]);

        require "view/detailFilms.php";
    }

}

?>