<?php

namespace Controller;
use Model\Connect;

class CinemaController {

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  AFFICHAGE DES LISTES                         
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$    
    
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
        f.titre_film,
        r.id_role
        FROM individu i
        INNER JOIN acteur a ON a.id_individu = i.id_individu
        INNER JOIN jouer_dans jd ON jd.id_acteur = a.id_acteur
        INNER JOIN role r ON r.id_role = jd.id_role
        INNER JOIN film f ON f.id_film = jd.id_film
    ");
        require "view/listRoles.php";
    }

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  AFFICHAGE DES DETAILS                                
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$    

   //------------------------------------
   // Détail d'un rôle
   //------------------------------------
   public function detailRole($id) { 

        $pdo = Connect::seConnecter();

        $detailRole = $pdo->prepare("
            SELECT r.id_role, r.nom_role, f.titre_film, 
            CONCAT(prenom_individu, ' ', nom_individu) AS individu
            FROM role r
            INNER JOIN jouer_dans jd ON jd.id_role = r.id_role
            INNER JOIN acteur a ON a.id_acteur = jd.id_acteur
            INNER JOIN film f ON f.id_film = jd.id_film
            INNER JOIN individu i ON i.id_individu = a.id_individu
            WHERE r.id_role = :id_role
        ");
        $detailRole->execute(["id_role" => $id]);

        require "view/detailRole.php";
    }

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

   //------------------------------------
   // Détail d'un acteur
   //------------------------------------
   public function detailActeur($id) { 

   $pdo = Connect::seConnecter();

    $detailActeur = $pdo->prepare("
         SELECT CONCAT(i.prenom_individu, ' ', i.nom_individu) AS personne, 
         DATE_FORMAT(i.date_naissance_individu,'%d/%m/%Y') AS dateNaissAct, 
         i.photo_individu,
         i.id_individu
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
            DATE_FORMAT(i.date_naissance_individu,'%d/%m/%Y') AS dateNaissRea,             
            i.photo_individu,
            i.id_individu
            FROM individu i
            INNER JOIN realisateur re ON re.id_individu = i.id_individu
            WHERE i.id_individu = :id_individu           
        ");
        $detailRealisateur->execute(["id_individu" => $id]);
        
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
            DATE_FORMAT(i.date_naissance_individu,'%d/%m/%Y') AS dateNaissRea,
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
            DATE_FORMAT(i.date_naissance_individu,'%d/%m/%Y') AS dateNaissAct
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

   //------------------------------------
   // Ajout d'un réalisateur
   //------------------------------------
   public function addRealisateur()
    {
        $pdo = Connect::seConnecter();
        if (isset ($_POST["submit"])) {
            
            // INSERT INTO INDIVIDU
            $prenomIndividu     = filter_var($_POST["prenomRea"], FILTER_SANITIZE_SPECIAL_CHARS);
            $nomIndividu        = filter_var($_POST["nomRea"], FILTER_SANITIZE_SPECIAL_CHARS);
            $sexeIndividu       = filter_var($_POST["sexeRea"], FILTER_SANITIZE_SPECIAL_CHARS);
            $dateNaissIndividu  = filter_var($_POST["dateNaissRea"], FILTER_SANITIZE_SPECIAL_CHARS);   

            if(isset($_FILES['file'])){
                $cheminPhoto = "public\img\\réalisateurs\\".$_FILES['file']['name']; 
            }    
            
            $addIndividu = $pdo->prepare("
                INSERT INTO individu (nom_individu, prenom_individu, sexe_individu, date_naissance_individu, photo_individu)
                VALUES (:nomIndividu, :prenomIndividu, :sexeIndividu, :dateNaissIndividu, :photoIndividu)
            ");

            $addIndividu->execute([
                "prenomIndividu" => $prenomIndividu,
                "nomIndividu" => $nomIndividu,
                "sexeIndividu" => $sexeIndividu,
                "dateNaissIndividu" => $dateNaissIndividu,
                "photoIndividu" => $cheminPhoto
            ]);

            // On récupère le dernier ig inseré
            $idIndividu = $pdo->lastInsertId();

            // INSERT INTO REALISATEUR
            $addRealisateur = $pdo->prepare("
                INSERT INTO realisateur (id_individu)
                VALUES (:idIndividu)
            ");
            $addRealisateur->execute([
                "idIndividu" => $idIndividu
            ]);

            // On revient à la liste des réalisateurs
            header("Location:index.php?action=listRealisateurs");
        }    
        require "view/addRealisateur.php";
    }

   //------------------------------------
   // Ajout d'un acteur
   //------------------------------------
   public function addActeur()
   {
       $pdo = Connect::seConnecter();
       if (isset ($_POST["submit"])) {
           
           // INSERT INTO INDIVIDU
           $prenomIndividu     = filter_var($_POST["prenomAct"], FILTER_SANITIZE_SPECIAL_CHARS);
           $nomIndividu        = filter_var($_POST["nomAct"], FILTER_SANITIZE_SPECIAL_CHARS);
           $sexeIndividu       = filter_var($_POST["sexeAct"], FILTER_SANITIZE_SPECIAL_CHARS);
           $dateNaissIndividu  = filter_var($_POST["dateNaissAct"], FILTER_SANITIZE_SPECIAL_CHARS);   

           if(isset($_FILES['file'])){
               $cheminPhoto = "public\img\\acteurs\\".$_FILES['file']['name']; 
           }    
           
           $addIndividu = $pdo->prepare("
               INSERT INTO individu (nom_individu, prenom_individu, sexe_individu, date_naissance_individu, photo_individu)
               VALUES (:nomIndividu, :prenomIndividu, :sexeIndividu, :dateNaissIndividu, :photoIndividu)
           ");

           $addIndividu->execute([
               "prenomIndividu" => $prenomIndividu,
               "nomIndividu" => $nomIndividu,
               "sexeIndividu" => $sexeIndividu,
               "dateNaissIndividu" => $dateNaissIndividu,
               "photoIndividu" => $cheminPhoto
           ]);

           // On récupère le dernier ig inseré
           $idIndividu = $pdo->lastInsertId();

           // INSERT INTO ACTEUR
           $addActeur = $pdo->prepare("
               INSERT INTO acteur (id_individu)
               VALUES (:idIndividu)
           ");
           $addActeur->execute([
               "idIndividu" => $idIndividu
           ]);

           // On revient à la liste des réalisateurs
           header("Location:index.php?action=listActeurs");
       }    
       require "view/addActeur.php";
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

   //------------------------------------
   // Update d'un réalisateur
   //------------------------------------
   public function updRealisateur($id)
    {
        $pdo = Connect::seConnecter();

        $realisateurAModifier = $pdo->prepare("
            SELECT * FROM individu
            WHERE id_individu = :id_individu
        ");
        $realisateurAModifier->execute(["id_individu" => $id]);

        if (isset ($_POST['submit'])) {
           $prenomIndividu     = filter_var($_POST["prenomRea"], FILTER_SANITIZE_SPECIAL_CHARS);
           $nomIndividu        = filter_var($_POST["nomRea"], FILTER_SANITIZE_SPECIAL_CHARS);
           $sexeIndividu       = filter_var($_POST["sexeRea"], FILTER_SANITIZE_SPECIAL_CHARS);
           $dateNaissIndividu  = filter_var($_POST["dateNaissRea"], FILTER_SANITIZE_SPECIAL_CHARS);

            if(isset($_FILES['file'])){
                $cheminPhoto = "public\img\\réalisateurs\\".$_FILES['file']['name']; 
            }          

        $updIndividu = $pdo->prepare("
            UPDATE individu 
            SET nom_individu = :nomIndividu
            , prenom_individu = :prenomIndividu
            , sexe_individu = :sexeIndividu
            , date_naissance_individu = :dateNaissIndividu
            , photo_individu = :photoIndividu
            WHERE id_individu = :id_individu
        ");

        $updIndividu->execute([
            "prenomIndividu" => $prenomIndividu,
            "nomIndividu" => $nomIndividu,
            "sexeIndividu" => $sexeIndividu,
            "dateNaissIndividu" => $dateNaissIndividu,
            "photoIndividu" => $cheminPhoto,
            "id_individu" => $id            
        ]);

        header("Location:index.php?action=listRealisateurs&id=$id");    

        }    

        require "view/updRealisateur.php";
    }    

   //------------------------------------
   // Update d'un acteur
   //------------------------------------
   public function updActeur($id)
    {
        $pdo = Connect::seConnecter();

        $acteurAModifier = $pdo->prepare("
            SELECT * FROM individu
            WHERE id_individu = :id_individu
        ");
        $acteurAModifier->execute(["id_individu" => $id]);

        if (isset ($_POST['submit'])) {
           $prenomIndividu     = filter_var($_POST["prenomAct"], FILTER_SANITIZE_SPECIAL_CHARS);
           $nomIndividu        = filter_var($_POST["nomAct"], FILTER_SANITIZE_SPECIAL_CHARS);
           $sexeIndividu       = filter_var($_POST["sexeAct"], FILTER_SANITIZE_SPECIAL_CHARS);
           $dateNaissIndividu  = filter_var($_POST["dateNaissAct"], FILTER_SANITIZE_SPECIAL_CHARS);

           if(isset($_FILES['file'])){
                $cheminPhoto = "public\img\\acteurs\\".$_FILES['file']['name']; 
           }  

        $updIndividu = $pdo->prepare("
            UPDATE individu 
            SET nom_individu = :nomIndividu
            , prenom_individu = :prenomIndividu
            , sexe_individu = :sexeIndividu
            , date_naissance_individu = :dateNaissIndividu
            , photo_individu = :photoIndividu
            WHERE id_individu = :id_individu
        ");

        $updIndividu->execute([
            "prenomIndividu" => $prenomIndividu,
            "nomIndividu" => $nomIndividu,
            "sexeIndividu" => $sexeIndividu,
            "dateNaissIndividu" => $dateNaissIndividu,
            "photoIndividu" => $cheminPhoto,
            "id_individu" => $id            
        ]);

        header("Location:index.php?action=listActeurs&id=$id");    

        }    
        
        require "view/updActeur.php";
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

   //------------------------------------
   // Delete d'un réalisateur
   //------------------------------------
   public function delRealisateur($id)
   {
       $pdo = Connect::seConnecter();

       $deleteRealisateur = $pdo->prepare("
           DELETE FROM realisateur 
           WHERE id_individu = :id_individu
       ");
       $deleteRealisateur->execute(["id_individu" => $id]);

       $deleteIndividu = $pdo->prepare("
           DELETE FROM individu
           WHERE id_individu = :id_individu
       ");
       $deleteIndividu->execute(["id_individu" => $id]);

       header("Location:index.php?action=listRealisateurs");
   }

   //------------------------------------
   // Delete d'un acteur
   //------------------------------------
   public function delActeur($id)
   {
       $pdo = Connect::seConnecter();

       $deleteActeur = $pdo->prepare("
           DELETE FROM realisateur 
           WHERE id_individu = :id_individu
       ");
       $deleteActeur->execute(["id_individu" => $id]);

       $deleteIndividu = $pdo->prepare("
           DELETE FROM individu
           WHERE id_individu = :id_individu
       ");
       $deleteIndividu->execute(["id_individu" => $id]);

       header("Location:index.php?action=listActeurs");
   }

}
?>