<?php
//on démarre une sessionù
session_start();

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

    }
    else{
        $_SESSION['erreur'] ="la supression est invalide";
        header('location:krakenVue.php');
    } 

   
    ///////////////////////////// Kraken/////////////////////////////
   

    $sql = 'SELECT * FROM `corp` WHERE `id_kraken` =:id_kraken;';
    
    // On prépare la requête pour le kraken
$query = $db->prepare($sql);

// On accroche les paramètre (id) pour le kraken
$query->bindValue(':id_kraken', $id, PDO::PARAM_INT);

//on execute la requête pour le kraken
$query->execute();

//on récupère le kraken
$kraken = $query->fetch();

    
    require_once('close.php');

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"  href="css/delete_tentacule.css"> 

</head>
<body>
<div class="row">
    <section class="col-12">
        <h2>Liste des tentacules de votre kraken</h2>
            <table class="table">
                <thead>
                    <th> id</th>
                    <th> nom de la tentacule</th>
                    <th> pv</th>
                    <th> force</th>
                    <th> déxtérité</th>
                    <th> constitution</th>
                    <th>supprimer</th>
                    
                </thead>
            <tbody>
            <?php //on fait une boucle sur la variable result
            foreach ($result as $tentacules){
            ?>
            <tr>
                <td><?=$tentacules['id']?></td>
                <td><?=$tentacules['nom_tentacule']?></td>
                <td><?=$tentacules['pv']?></td>
                <td><?=$tentacules['forc']?></td>
                <td><?=$tentacules['dex']?></td>
                <td><?=$tentacules['con']?></td>
               <td> <a href="delete.php?id=<?= $tentacules['id']?>">supprimer</a></td>
            
            </tr>
            <?php
        } ?>
            </tbody>
            
            </table>
    </section>
    
    <div class="col-6" id="retour">
    <a href="krakenVue.php?id=<?= $kraken ['id_kraken'] ?>">retour</a>
    </div>
</div>


</form>
</body>
</html>