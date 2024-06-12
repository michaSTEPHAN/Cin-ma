<?php

namespace Controller;
use Model\Connect;

class FilmController {

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
    // Liste des rôles
    //------------------------------------
    public function listRoles() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT r.nom_role, r.id_role
            FROM role r                  
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

        $detailNomRole = $pdo->prepare("
            SELECT r.nom_role, r.id_role
            FROM role r                  
            WHERE r.id_role = :id_role
        ");
        $detailNomRole->execute(["id_role" => $id]);

        $detailRoleActeur = $pdo->prepare("
            SELECT f.titre_film, 
            CONCAT(prenom_individu, ' ', nom_individu) AS individu
            FROM role r
            INNER JOIN jouer_dans jd ON jd.id_role = r.id_role
            INNER JOIN acteur a ON a.id_acteur = jd.id_acteur
            INNER JOIN film f ON f.id_film = jd.id_film
            INNER JOIN individu i ON i.id_individu = a.id_individu
            WHERE r.id_role = :id_role
        ");
        $detailRoleActeur->execute(["id_role" => $id]);

        require "view/detailRole.php";
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
   // Ajout d'un rôle
   //------------------------------------
   public function addRole()
   {
       $pdo = Connect::seConnecter();
       if (isset ($_POST["submit"])) {
           $nomRole = filter_var($_POST["nomRole"], FILTER_SANITIZE_SPECIAL_CHARS);

           $addRole = $pdo->prepare("
               INSERT INTO role
               VALUES (default, :nomRole)
           ");

           $addRole->bindValue(":nomRole", $nomRole);
           $addRole->execute();
           header("Location:index.php?action=listRoles");
       } 

       require "view/addRole.php";
   }

   //------------------------------------
   // Ajout d'un film
   //------------------------------------
   public function addFilm()
   {
       $pdo = Connect::seConnecter();

       $listeGenre = $pdo->query("
            SELECT * FROM genre                
        ");

        $listeRealisateur = $pdo->query("
            SELECT id_realisateur, CONCAT(prenom_individu, ' ', nom_individu) AS personne
            FROM individu i
            INNER JOIN realisateur r ON i.id_individu = r.id_individu
        ");

       if (isset ($_POST["submit"])) {
           
           // INSERT INTO FILM
           $titreFilm          = filter_var($_POST["titreFilm"], FILTER_SANITIZE_SPECIAL_CHARS);
           $dureeFilm          = filter_var($_POST["dureeFilm"], FILTER_SANITIZE_SPECIAL_CHARS);
           $noteFilm           = filter_var($_POST["noteFilm"], FILTER_SANITIZE_SPECIAL_CHARS);
           $synopsisFilm       = filter_var($_POST["synopsisFilm"], FILTER_SANITIZE_SPECIAL_CHARS);
           $anneSortieFilm     = filter_var($_POST["anneeSortieFilm"], FILTER_SANITIZE_SPECIAL_CHARS);
           $realisateurFilm    = filter_var($_POST["id_realisateur"], FILTER_SANITIZE_SPECIAL_CHARS);    
           $idGenre            = filter_var($_POST["genreFilm"], FILTER_SANITIZE_SPECIAL_CHARS);           

           if(isset($_FILES['file'])){
               $cheminPhoto = "public\img\\films\\".$_FILES['file']['name']; 
           }    
           
           $addIndividu = $pdo->prepare("
               INSERT INTO film (titre_film, duree_film, note_film, synopsis_film, annee_sortie_film, id_realisateur, affiche_film)
               VALUES (:titreFilm, :dureeFilm, :noteFilm, :synopsisFilm, :anneeSortieFilm, :realisateurFilm, :photoFilm)
           ");

           $addIndividu->execute([
               "titreFilm" => $titreFilm,
               "dureeFilm" => $dureeFilm,
               "noteFilm" => $noteFilm,
               "synopsisFilm" => $synopsisFilm,
               "anneeSortieFilm" => $anneSortieFilm,
               "realisateurFilm" => $realisateurFilm,
               "photoFilm" => $cheminPhoto
           ]);

           // On récupère le dernier idinseré
           $idFilm = $pdo->lastInsertId();

           if(isset($_POST['submit']))
           {
              foreach($_POST['genreFilm'] as $valeur)
              {
                 
                // INSERT INTO APPARTENIR
                $addGenre = $pdo->prepare("
                    INSERT INTO appartenir (id_film, id_genre)
                    VALUES (:idFilm, :idGenre)
                ");

                $addGenre->execute([
                    "idFilm" => $idFilm,
                    "idGenre" => $valeur,
                ]);

              }
           }           

           // On revient à la liste des films
           header("Location:index.php?action=listFilms");
       }    
       require "view/addFilm.php";
    }   

   //------------------------------------
   // Ajout d'un acteur à un film
   //------------------------------------
   public function addFilmActeur($id)
   {
       $pdo = Connect::seConnecter();

       $listeActeur = $pdo->query("
            SELECT CONCAT(prenom_individu, ' ', nom_individu) AS personne, 
            i.id_individu
            FROM individu i
            INNER JOIN acteur a ON i.id_individu = a.id_individu                
        ");

        $listeRole = $pdo->query("
            SELECT * FROM role                
        ");

        $filmAModifier = $pdo->prepare("
           SELECT * FROM film
           WHERE id_film = :id_film
       ");
       $filmAModifier->execute(["id_film" => $id]);
        
        if (isset ($_POST["submit"])) {
           
           // INSERT INTO JOUER_DANS
           $idActeur    = filter_var($_POST["id_individu"], FILTER_SANITIZE_SPECIAL_CHARS);
           $idRole      = filter_var($_POST["id_role"], FILTER_SANITIZE_SPECIAL_CHARS);   

            // On récupere le numéro de l'acteur à partir du numéro d'individu
            $recupNoActeur = $pdo->prepare("
                SELECT id_acteur FROM acteur
                WHERE id_individu = :id_individu
            ");
            $recupNoActeur->execute(["id_individu" => $idActeur]);

            $aaa = $recupNoActeur->fetch();
            $idAct = $aaa['id_acteur'];

            // INSERT INTO JOUER_DANS
            $addActeurFilm = $pdo->prepare("
                INSERT INTO jouer_dans (id_film, id_acteur, id_role)
                VALUES (:idFilm, :idActeur, :idRole)
            ");
                
            $addActeurFilm->execute([                
                "idFilm" => $id,
                "idActeur" => $idAct,
                "idRole" => $idRole
            ]);

           // On revient à la liste des réalisateurs
           header("Location:index.php?action=listFilms");
        }    
       require "view/addFilmActeur.php";
   }

//    public function addFilmActeur()
//    {
//        $pdo = Connect::seConnecter();
//        if (isset ($_POST["submit"])) {
            

//             $listeActeur = $pdo->query("
//                 SELECT CONCAT(prenom_individu, ' ', nom_individu) AS personne, 
//                 i.id_individu
//                 FROM individu i
//                 INNER JOIN acteur a ON i.id_individu = a.id_individu
//             ");

//             $listeRole = $pdo->query("
//                 SELECT * FROM role                
//             ");
                
//             // INSERT INTO JOUER_DANS
//             $idActeur    = filter_var($_POST["id_individu"], FILTER_SANITIZE_SPECIAL_CHARS);
//             $idRole      = filter_var($_POST["id_role"], FILTER_SANITIZE_SPECIAL_CHARS);
                
//                 // // INSERT INTO JOUER_DANS
//                 // $addActeurFilm = $pdo->prepare("
//                 //     INSERT INTO jouer_dans (id_film, id_acteur, id_role)
//                 //     VALUES (:idFilm, :idActeur, :idRole)
//                 // ");
                
//                 // $addActeurFilm->execute([                
//                 //     "idFilm" => $id,
//                 //     "idActeur" => $idActeur,
//                 //     "idRole" => $idRole
//                 // ]);

//                 // On revient à la liste des films
//                 // header("Location:index.php?action=listFilms");
//         }                   
//         require "view/addFilmActeur.php";
//     }   

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  GESTION DES UPDATE
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$   

    //------------------------------------
   // Update d'un rôle
   //------------------------------------
   public function updRole($id)
   {
       $pdo = Connect::seConnecter();

       $roleAModifier = $pdo->prepare("
           SELECT * FROM role 
           WHERE id_role = :id_role
       ");
       $roleAModifier->execute(["id_role" => $id]);

       if (isset ($_POST['submit'])) {
           $nomRole = filter_var($_POST["nomRole"], FILTER_SANITIZE_SPECIAL_CHARS);
           
           $updRole = $pdo->prepare("
               UPDATE role 
               SET nom_Role = :nomRole
               WHERE id_role = :id_role
           ");

           $updRole->execute([
               "nomRole" => $nomRole,
               "id_role" => $id
           ]);           

           header("Location:index.php?action=listRoles&id=$id");
       }         
       require "view/updRole.php";
   }

    //------------------------------------
   // Update d'un film
   //------------------------------------
   public function updFilm($id)
   {
       $pdo = Connect::seConnecter();

       $filmAModifier = $pdo->prepare("
           SELECT * FROM film
           WHERE id_film = :id_film
       ");
       $filmAModifier->execute(["id_film" => $id]);

       $genreAModifier = $pdo->prepare("
           SELECT * FROM appartenir
           WHERE id_film = :id_film
       ");
       $genreAModifier->execute(["id_film" => $id]);

       $listRealisateurs = $pdo->query("
            SELECT id_realisateur, CONCAT(prenom_individu, ' ', nom_individu) AS personne
            FROM individu i
            INNER JOIN realisateur r ON i.id_individu = r.id_individu
       ");

       $listGenres = $pdo->query("
            SELECT *
            FROM genre
       ");

    //    $genresDuFilm = $pdo->prepare("
    //         SELECT * FROM appartenir
    //         WHERE id_film = :id_film
    //     ");
    //     $genresDuFilm->execute(["id_film" => $id]);

       if (isset ($_POST['submit'])) {

            // POUR UPDATE FILM
            $titreFilm          = filter_var($_POST["titreFilm"], FILTER_SANITIZE_SPECIAL_CHARS);
            $dureeFilm          = filter_var($_POST["dureeFilm"], FILTER_SANITIZE_SPECIAL_CHARS);
            $noteFilm           = filter_var($_POST["noteFilm"], FILTER_SANITIZE_SPECIAL_CHARS);
            $synopsisFilm       = filter_var($_POST["synopsisFilm"], FILTER_SANITIZE_SPECIAL_CHARS);
            $anneSortieFilm     = filter_var($_POST["anneeSortieFilm"], FILTER_SANITIZE_SPECIAL_CHARS);
            $realisateurFilm    = filter_var($_POST["realisateurFilm"], FILTER_SANITIZE_SPECIAL_CHARS);    
            $idGenre            = filter_var($_POST["genreFilm"], FILTER_SANITIZE_SPECIAL_CHARS);

            $updFilm = $pdo->prepare("
                    UPDATE film 
                    SET titre_film = :titreFilm
                    , duree_film = :dureeFilm
                    , note_film = :noteFilm
                    , synopsis_film = :synopsisFilm
                    , annee_sortie_film = :anneeSortieFilm
                    , id_realisateur = :realisateurFilm
                    WHERE id_film = :id_film
                ");

            $updFilm->execute([
                "titreFilm" => $titreFilm,
                "dureeFilm" => $dureeFilm,
                "noteFilm" => $noteFilm,
                "synopsisFilm" => $synopsisFilm,
                "anneeSortieFilm" => $anneSortieFilm,
                "realisateurFilm" => $realisateurFilm,
                "id_film" => $id  
            ]);

            
            $deleteAppartenir = $pdo->prepare("
                DELETE FROM appartenir
                WHERE id_film = :id_film
            ");
            $deleteAppartenir->execute(["id_film" => $id]);

            foreach($_POST['genreFilm'] as $valeur)
            {                  
                // INSERT INTO APPARTENIR
                $addGenre = $pdo->prepare("
                     INSERT INTO appartenir (id_film, id_genre)
                     VALUES (:idFilm, :idGenre)
                "); 
                $addGenre->execute([
                     "idFilm" => $id,
                     "idGenre" => $valeur,
                ]); 
            }

            // $updAppartenir = $pdo->prepare("
            //     UPDATE appartenir
            //     SET id_genre = :id_genre
            //     WHERE id_film = :id_film
            // ");

            // $updAppartenir->execute([                
            //     "id_film" => $id,
            //     "id_genre" => $idGenre 
            // ]);

         header("Location:index.php?action=listFilms&id=$id");    

       }    
       
       require "view/updFilm.php";
   }       

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 
//  GESTION DES DELETE
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$   

   //------------------------------------
   // Delete d'un rôle
   //------------------------------------
   public function delRole($id)
   {
       $pdo = Connect::seConnecter();      

       $deleteRole = $pdo->prepare("
           DELETE FROM role 
           WHERE id_role = :id_role
       ");
       $deleteRole->execute(["id_role" => $id]);

       header("Location:index.php?action=listRoles");
   }

   //------------------------------------
   // Delete d'un film
   //------------------------------------
   public function delFilm($id)
   {
       $pdo = Connect::seConnecter();

       $deleteAppartenir = $pdo->prepare("
           DELETE FROM appartenir
           WHERE id_film = :id_film
       ");
       $deleteAppartenir->execute(["id_film" => $id]);

       $deleteJouerDans = $pdo->prepare("
           DELETE FROM jouer_dans
           WHERE id_film = :id_film
       ");
       $deleteJouerDans->execute(["id_film" => $id]);
       
       $deleteFilm = $pdo->prepare("
           DELETE FROM film
           WHERE id_film = :id_film
       ");
       $deleteFilm->execute(["id_film" => $id]);

       header("Location:index.php?action=listFilms");
   }


}    