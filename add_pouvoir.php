<?php
// On démarre une session
session_start();

///////////////////////////////////////////////////////////


if(isset($_GET['id']) && !empty($_GET['id'])){
$id_kraken = $_GET['id'];
}
if($_POST){

        
     if(!isset($_post['id_kraken']) && !empty($_post['id_kraken']))   {

            
     $_SESSION['erreur'] = "impossible, il manque l'id du kraken";
     header('Location: KrakenVue.php');
     }   

     if(!isset($_post['pouvoir_id']) && !empty($_post['pouvoir_id'])){

        $_SESSION['erreur'] = "impossible, il manque l'id du kraken";
        header('Location: KrakenVue.php');

     }


        ////on inclut la connexion à la base
        require_once('fonctionsSQL.php');

        

        $choix_kraken = (int)$_POST['id_kraken'];
        $choix_pouvoir = (int)$_POST['pouvoir_id'];

////////////requête sql  add pouvoir au kraken//////////////////////
$sql = 'INSERT INTO `kraken_pouvoir`(`kraken_id`, `pouvoir_id`) VALUES(:kraken_id, :pouvoir_id)';
           

/////////////on prépare la requête
$query = $db->prepare($sql);


//////////on "accroche" les paramètres (ici : kraken_id, pouvoir_id)
   $query->bindParam(':kraken_id', $choix_kraken, \PDO::PARAM_INT);
   $query->bindParam(':pouvoir_id', $choix_pouvoir, \PDO::PARAM_INT);


   $titi= $query->execute();
       



$_SESSION['message'] ="pouvoir ajouté";
header('Location: KrakenVue.php');

    }

  else {
     $_SESSION['erreur'] = "La création est incomplet";
}
//////////////////////////////////////////////////////////////////////////
///////////////////// NOMBRE DE TENTACULES //////////////////////////////// 
///////////////////////////////////////////////////////////////

if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('FonctionsSQL.php');

// //on nettoie l'id envoyé
 $id = strip_tags($_GET['id']);

$sql = 'SELECT COUNT(id) FROM `tentacules` WHERE `kraken_id` =:kraken_id;';


// // On prépare la requête pour le kraken
 $query = $db->prepare($sql);

// // On accroche les paramètre (id) pour les tentacules
 $query->bindValue(':kraken_id', $id, PDO::PARAM_INT);

// //on execute la requête pour les tentacules
 $query->execute();


// //on récupère les tentacules//
$nbrpouvoir = $query->fetch(PDO::FETCH_ASSOC);
$nbrpouvoir = (int)$nbrpouvoir["COUNT(id)"];

}

//////////////////////////////////////////////////////////
//////////////// NOMBRE DE POUVOIR //////////////////////////
//////////////////////////////////////////////////////////////

if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('FonctionsSQL.php');

// //on nettoie l'id envoyé
 $id = strip_tags($_GET['id']);

$sql = 'SELECT COUNT(id) FROM `kraken_pouvoir` WHERE `kraken_id` =:kraken_id;';


// // On prépare la requête pour le kraken
 $query = $db->prepare($sql);

// // On accroche les paramètre (id) pour les tentacules
 $query->bindValue(':kraken_id', $id, PDO::PARAM_INT);

// //on execute la requête pour les tentacules
 $query->execute();


// //on récupère les tentacules//
 $nbrtentacules = $query->fetch(PDO::FETCH_ASSOC);
 $nbrtentacules = (int)$nbrtentacules["COUNT(id)"];

}

//////////////////////////SELECT POUVOIR/////////////////////////////
 
     
 require_once('FonctionsSQL.php');

 $sql ='SELECT * FROM `pouvoir`';


// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////// éléments du kraken //////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

$sql ="SELECT * FROM pouvoir INNER JOIN kraken_pouvoir ON kraken_pouvoir.kraken_id=:kraken_id WHERE pouvoir.id=kraken_pouvoir.pouvoir_id;";

$query = $db->prepare($sql);

$query->bindValue(':kraken_id', $id, PDO::PARAM_INT);

$query->execute();

$pouvoirs = $query->fetchAll(PDO::FETCH_ASSOC);




////////////////////////////////////////
/////       comparaison pouvoir        ///////////
/////////////////////////////////////



    $pouvoirDispo=[];

foreach ($result as $id){

    $pouvoirTrouver = false;

        foreach($pouvoirs as $pouvoir_id){
            if ($id["id"] === $pouvoir_id["pouvoir_id"])
            $pouvoirTrouver = true;
        }

    if($pouvoirTrouver === false) 
    array_push($pouvoirDispo, $id);
 

}

?>





<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content ="width=device-width, initial-scale=1.0">
<title>ajout de kraken</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" type="text/css"  href="css/add_pouvoir.css"> 


</head>
<body>

    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php 
                    if(!empty ($_SESSION['erreur'])){
                        echo'<div class="alert alert-danger" role="alert">'. $_SESSION['erreur'].'</div>';
                        $_SESSION['erreur']="";
                    }
                
                ?>

    <!-- ////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////

                    Ajout d'un pouvoir

            ///////////////////////////////////////////////////////////////////////////////////////// -->

           
                <h2>Ajout d'un pouvoir</h2>
                   
      
                 <form method="post" class="mb-3  w-100">
                   
                     <div class="form-group">
                     <label for="" >pouvoir à ajouter</label>
                     <select name="pouvoir_id" id="ajout_pouvoir" required>
                            <option value="pouvoir_id" selected> choisis un pouvoir</option>
                          
                                <?php 

                            foreach($pouvoirDispo as $pouvoir) {
                                ?> 

                           <option value="<?=$pouvoir['id']?>"><?=$pouvoir['name']?></option>

                           <?php 
                           } 
                           ?>
                        </select> 
                        
                    <input type="hidden" name="id_kraken" value="<?= $id_kraken ?>">
                     <button class="btn btn-primary">Créer</button>
                     </form>
                   
                   
                </section>
                
            </div>

        </main>
    </body>
</html>
