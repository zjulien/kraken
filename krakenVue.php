<?php
// On démarre une session
session_start();

//est-ce que l'id existe est n'est pas vide dans l'url
if(isset($_GET['id']) && !empty($_GET['id'])){
        require_once('FonctionsSQL.php');

    //on nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `corp` WHERE `id_kraken` =:id_kraken;';
    
    // On prépare la requête pour le kraken
$query = $db->prepare($sql);

// On accroche les paramètre (id) pour le kraken
$query->bindValue(':id_kraken', $id, PDO::PARAM_INT);

//on execute la requête pour le kraken
$query->execute();

//on récupère le kraken
$kraken = $query->fetch();
//on vérifie si le kraken existe
if(!$kraken){
    $_SESSION['erreur'] ="cet id n'existe pas";
        header('location: accueil.php');
}

    }
     else{
         $_SESSION['erreur'] ="URL invalide";
         header('location: accueil.php');
     }


//////////////////////////////////////////////////////////////////////////////////////////////////
/////////////Séléctionne tout les éléments dans tentacules selon l'id dans l'url///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////

//est-ce que l'id existe est n'est pas vide dans l'url
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('FonctionsSQL.php');

//on nettoie l'id envoyé
$id = strip_tags($_GET['id']);

$sql = 'SELECT * FROM `tentacules` WHERE `kraken_id` =:kraken_id;';

// On prépare la requête pour le kraken
$query = $db->prepare($sql);

// On accroche les paramètre (id) pour les tentacules
$query->bindValue(':kraken_id', $id, PDO::PARAM_INT);

//on execute la requête pour les tentacules
$query->execute();

//on récupère les tentacules
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$test = $result ;

}
//////////////////////////////////////////////////////////////////////////////////////////////////
/////////////Compte le nombre de tentacules selon l'id séléctionner///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//est-ce que l'id existe est n'est pas vide dans l'url


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
 $nbrtentacules = $query->fetch(PDO::FETCH_ASSOC);
 $nbrtentacules = (int)$nbrtentacules["COUNT(id)"];

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////// éléments du kraken //////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////




$sql ="SELECT * FROM pouvoir INNER JOIN kraken_pouvoir ON kraken_pouvoir.kraken_id=:kraken_id WHERE pouvoir.id=kraken_pouvoir.pouvoir_id;";

$query = $db->prepare($sql);

$query->bindValue(':kraken_id', $id, PDO::PARAM_INT);

$query->execute();

$pouvoirs = $query->fetchAll(PDO::FETCH_ASSOC);

$pouvoirsKraken ='';

for($i =0; $i < count($pouvoirs); $i++){
    $pouvoirsKraken .= '<div>' . $pouvoirs[$i]["name"].'</div>'; 
}






////////////////////////////////////////////////////////////
//////////////////// COMPTER NOMBRE POUVOIR ////////////////
////////////////////////////////////////////////////////////

$sql = "SELECT COUNT(id) FROM kraken_pouvoir WHERE kraken_id =:kraken_id; ";



$query = $db->prepare($sql);

$query->bindValue(':kraken_id',$id, PDO::PARAM_INT );

$query->execute();

$nbrpouvoirs = $query->fetch(PDO::FETCH_ASSOC);
$nbrpouvoirs = (int)$nbrpouvoirs["COUNT(id)"];

}


require_once('close.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content ="width=device-width, initial-scale=1.0">
<title>Liste des krakens</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" type="text/css"  href="css/KrakenVue.css"> 

</head>
<body id="index" >
    <main class="container" id="principal">
        <div class="row">
            <section class="col-md-12 col-xs-6 col-sm-6">
            <?php
            if(!empty ($_SESSION['message'])){
                        echo'<div class="alert alert-success" role="alert">'. $_SESSION['message'].'</div>';
                        $_SESSION['message']="";
                    }
                ?>
                <h1>Gestion du kraken</h1>
                <table class="table" id="gestion">
                    <thead>
                   
                        <th>Gestion des tentacules</th>
                        <th>ajout de pouvoir</th>
                        <th>kraken</th>
                       </thead> 
                       <tbody>

                                    <td>
                                    <a 
                                    <?php if ($nbrtentacules <= 7){ ?>
                                       
                                     href="add_tentacule.php?id=<?= $kraken['id_kraken']?> 
                                     
                                  "<?php } ?>>    Ajout de tentacule
                                  </a> 
                                    <a href="delete_tentacule.php?id=<?= $kraken['id_kraken'] ?>"> supression de tentacule</a>
                                   </td>             
                                   
                                    <td>
                                    <a 
                                     <?php if (!(($nbrtentacules < 4 && $nbrpouvoirs ===1) || ( $nbrtentacules >=4 && $nbrtentacules < 8 && $nbrpouvoirs == 2 ) || 
                                        ($nbrtentacules === 8 && $nbrpouvoirs === 3) )) { ?> 
                                    
                                    href="add_pouvoir.php?id=<?= $kraken['id_kraken'] ?> 
                                   
                                    "<?php } ?> >  ajout de pouvoir
                                    </a>
                                    
                                    </td>
                                   <td><a href="add.php" >création d'un kraken</a>   </td>
                                    </tr>

                       </tbody>
                    </table>
                        
                </section>
                <section class="col-md-12 col-xs-6 col-sm-6" id="resume">
            <?php
            if(!empty ($_SESSION['message'])){
                        echo'<div class="alert alert-success" role="alert">'. $_SESSION['message'].'</div>';
                        $_SESSION['message']="";
                    }
                ?>
                <h2>résumé de tous les éléments constistuant le kraken : <?=$kraken['name']?></h2>
                <table class="table table-responsive" id="resume">
                    <thead>
                        <th>nom</th>
                        <th>age</th>
                        <th>taille en mètre</th>
                        <th>poids en tonne</th>
                        <th>nombre tentacule</th>
                        <th>pouvoirs</th>
                        
                       </thead> 
                       <tbody >
                           
                                    <tr>
                                    <td><?= $kraken ['name'] ?></td>
                                    <td><?= $kraken ['age'] ?></td>
                                    <td><?= $kraken ['taille'] ?>M</td>
                                    <td><?= $kraken ['poid'] ?>T</td>
                                    <td><?= $nbrtentacules ?></td>
                                    <td><?= $pouvoirsKraken ?></td>
                                    </tbody>
                                    </table>  
                                    

                         
            
            <table class="table" id="caracteristique">
            <thead>
            <th>nom tentacule</th>
            <th> pv</th>
            <th>force</th>
            <th>dextérité</th>
            <th>consitution</th>
            </thead>
                <tbody>
                <?php //on fait une boucle sur la variable result
            foreach ($result as $tentacules){
            ?>
            <tr>
                <td><?=$tentacules['nom_tentacule']?></td>
                <td><?=$tentacules['pv']?></td>
                <td><?=$tentacules['forc']?></td>
                <td><?=$tentacules['dex']?></td>
                <td><?=$tentacules['con']?></td>
            
            </tr>
            
            <?php
        } ?>
</table>
        
                </section>
            </div>
        </main>
    </body>
</html>