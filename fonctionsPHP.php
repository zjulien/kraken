
<?php


////////Fonctions pour obtenir tout les krakens

function getAllKrakens(){
         
         // On inclut la connexion à la base
         require_once('FonctionsSQL.php');
         
         //requête sql choix du kraken
         $choix ='SELECT id_kraken, name FROM `corp`';
          
         //on prépare la requête
          $choix_id = $db->prepare($choix);
              
         $choix_id->execute();
         
       $id = $choix_id->fetchAll(PDO::FETCH_ASSOC);
         
         
          }
        }


///Fonctions pour obtenir toutes les tentaules

Function getAllTentacules(){


          ?>