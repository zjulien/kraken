<?php
// On démarre une session
session_start();



// On inclut la connexion à la base
require_once('FonctionsSQL.php');

$sql = 'SELECT * FROM `corp`';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();




// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/accueil.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
    <main class="container">
      <div class="row">
       <section class="col-12" id="tableau_accueil">
       <?php
            if(!empty ($_SESSION['erreur'])){
                        echo'<div class="alert alert-danger" role="alert">'. $_SESSION['erreur'].'</div>';
                        $_SESSION['erreur']="";
                    }
                ?>
        <h1> Choisis ton kraken</h1>
            
            <table class="table">
            <thead>
             <th> ID</th>
             <th> Nom</th>
             <th>actions</th>
             </thead>
             <tbody>
             <?php
                            // on fait une boucle sur la variable result
                            foreach($result as $kraken){
                                ?>
                   <tr>
                   <td><?=$kraken['id_kraken'] ?></td>
                   <td><?=$kraken['name'] ?></td>
                   <td><a href="krakenVue.php?id=<?=$kraken['id_kraken'] ?>">voir</a></td>
                   </tr>
             </tbody>
             <?php 
               }
             ?>
            </table>
            <a href="add.php" class="btn btn-primary">Ajouter un kraken</a>
       </section>
      </div>
    </main>
</body>
</html>