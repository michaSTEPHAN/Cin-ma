<?php

namespace Controller;
use Model\Connect;

class IndividuController {

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  AFFICHAGE DES LISTES                         
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$   

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
        ORDER by i.nom_individu
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
            ORDER by i.nom_individu
        ");
            require "view/listActeurs.php";
    }

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  AFFICHAGE DES DETAILS                                
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 

    //------------------------------------
   // Détail d'un acteur
   //------------------------------------
   public function detailActeur($id) { 

    $pdo = Connect::seConnecter();
 
     $detailActeur = $pdo->prepare("
          SELECT CONCAT(i.prenom_individu, ' ', i.nom_individu) AS personne, 
          DATE_FORMAT(i.date_naissance_individu,'%d/%m/%Y') AS dateNaissAct, 
          i.photo_individu,
          i.sexe_individu,
          i.id_individu
          FROM individu i
          INNER JOIN acteur a ON a.id_individu = i.id_individu
          WHERE a.id_acteur = :id_acteur
     ");
     $detailActeur->execute(["id_acteur" => $id]);
      
     $detailFilmsActeur = $pdo->prepare("
         SELECT f.id_film, f.titre_film, r.id_role, r.nom_role 
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

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  GESTION DES INSERT INTO
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$    

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


        $updIndividu = $pdo->prepare("
            UPDATE individu 
            SET nom_individu = :nomIndividu
            , prenom_individu = :prenomIndividu
            , sexe_individu = :sexeIndividu
            , date_naissance_individu = :dateNaissIndividu
            WHERE id_individu = :id_individu
        ");

        $updIndividu->execute([
            "prenomIndividu" => $prenomIndividu,
            "nomIndividu" => $nomIndividu,
            "sexeIndividu" => $sexeIndividu,
            "dateNaissIndividu" => $dateNaissIndividu,
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

        $updIndividu = $pdo->prepare("
            UPDATE individu 
            SET nom_individu = :nomIndividu
            , prenom_individu = :prenomIndividu
            , sexe_individu = :sexeIndividu
            , date_naissance_individu = :dateNaissIndividu
            WHERE id_individu = :id_individu
        ");

        $updIndividu->execute([
            "prenomIndividu" => $prenomIndividu,
            "nomIndividu" => $nomIndividu,
            "sexeIndividu" => $sexeIndividu,
            "dateNaissIndividu" => $dateNaissIndividu,
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
           DELETE FROM acteur
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

   //------------------------------------
   // Delete d'un rôle d'un acteur dans un film
   //------------------------------------
   public function delRoleActeur($id,$idFilm,$idRole)
   {
       $pdo = Connect::seConnecter();

        $selActeur = $pdo->prepare("
            SELECT id_acteur
            FROM acteur a
            WHERE a.id_individu = :id_individu
        ");
        $selActeur->execute(["id_individu" => $id]);
        $noActeur = $selActeur->fetch();
        $idActeur = $noActeur['id_acteur'];

       $deleteJouerDans = $pdo->prepare("
           DELETE FROM jouer_dans 
           WHERE id_role = :id_role
           AND id_film = :id_film
           AND id_acteur = :id_acteur
       ");
       $deleteJouerDans->execute([
            "id_role" => $idRole,
            "id_film" => $idFilm,
            "id_acteur" => $idActeur,
        ]);

       header("Location:index.php?action=detailFilms&id=$idFilm");
   }

}    