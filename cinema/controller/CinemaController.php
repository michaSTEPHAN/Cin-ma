<?php

namespace Controller;
use Model\Connect;

class CinemaController {

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  AFFICHAGE DES LISTES                         
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$    
   //------------------------------------
   // Lister des genres
   //------------------------------------
   public function listGenres() {
    $pdo = Connect::seConnecter();
    $requete = $pdo->query("SELECT * FROM genre");
    require "view/listGenres.php";
}

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  AFFICHAGE DES DETAILS                                
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 

    //------------------------------------
   // Détail d'un genre
   //------------------------------------
   public function detailGenre($id) { 

        $pdo = Connect::seConnecter();

        $detailNomGenre = $pdo->prepare("
            SELECT g.id_genre, g.libelle_genre
            FROM genre g
            WHERE g.id_genre = :id_genre
        ");
        $detailNomGenre->execute(["id_genre" => $id]);

        $detailFilmsGenre = $pdo->prepare("
            SELECT f.titre_film 
            FROM genre g
            INNER JOIN appartenir a ON a.id_genre = g.id_genre
            INNER JOIN film f ON f.id_film = a.id_film
            WHERE g.id_genre = :id_genre
        ");
        $detailFilmsGenre->execute(["id_genre" => $id]);

        require "view/detailGenre.php";
    }

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  GESTION DES INSERT INTO
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$    

    //------------------------------------
   // Ajout d'un genre
   //------------------------------------
   public function addGenre()
   {
       $pdo = Connect::seConnecter();
       if (isset ($_POST["submit"])) {
           $nomGenre = filter_var($_POST["nomGenre"], FILTER_SANITIZE_SPECIAL_CHARS);

           $addGenre = $pdo->prepare("
               INSERT INTO genre
               VALUES (default, :nomGenre)
           ");

           $addGenre->bindValue(":nomGenre", $nomGenre);
           $addGenre->execute();
           header("Location:index.php?action=listGenres");
       } 

       require "view/addGenre.php";
   }


//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  GESTION DES UPDATE
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$   

   //------------------------------------
   // Update d'un genre
   //------------------------------------
   public function updGenre($id)
   {
       $pdo = Connect::seConnecter();

       $genreAModifier = $pdo->prepare("
           SELECT * FROM genre 
           WHERE id_genre = :id_genre
       ");
       $genreAModifier->execute(["id_genre" => $id]);

       if (isset ($_POST['submit'])) {
           $libelleGenre = filter_var($_POST["libelleGenre"], FILTER_SANITIZE_SPECIAL_CHARS);
           
           $updGenre = $pdo->prepare("
               UPDATE genre 
               SET libelle_genre = :libelleGenre
               WHERE id_genre = :id_genre
           ");

           $updGenre->execute([
               "libelleGenre" => $libelleGenre,
               "id_genre" => $id
           ]);
           // $updGenre->execute(["id_genre" => $id]);

           header("Location:index.php?action=listGenres&id=$id");
       }         
       require "view/updGenre.php";
   }

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  GESTION DES DELETE
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$   

   //------------------------------------
   // Delete d'un genre
   //------------------------------------
   public function delGenre($id)
   {
       $pdo = Connect::seConnecter();

       $deleteAppartenir = $pdo->prepare("
           DELETE FROM Appartenir 
           WHERE id_genre = :id_genre
       ");
       $deleteAppartenir->execute(["id_genre" => $id]);

       $deleteGenre = $pdo->prepare("
           DELETE FROM genre 
           WHERE id_genre = :id_genre
       ");
       $deleteGenre->execute(["id_genre" => $id]);

       header("Location:index.php?action=listGenres");
   }

}    