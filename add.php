<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['name']) && !empty($_POST['name'])
    && isset($_POST['age']) && !empty($_POST['age'])
    && isset($_POST['taille']) && !empty($_POST['taille'])
    && isset($_POST['poid']) && !empty($_POST['poid'])){
        
        // On inclut la connexion à la base
        require_once('FonctionsSQL.php');

        //protection différent champ formulaire
        //on nettoie les données envoyées
        $name = strip_tags($_POST['name']);
        $age = strip_tags($_POST['age']);
        $taille= strip_tags($_POST['taille']);
        $poid = strip_tags($_POST['poid']);
      

        $sql = 'INSERT INTO `corp` (`name`,`age`,`taille`,`poid`) VALUES(:name, :age,:taille,:poid );';


        //on prépare la requête
        $query = $db->prepare($sql);
       

        //on "accroche" les paramètres (ici : name, age, taille, poid)
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->bindValue(':age', $age, PDO::PARAM_STR);
        $query->bindValue(':taille', $taille, PDO::PARAM_STR);
        $query->bindValue(':poid', $poid, PDO::PARAM_STR);
      

        //on récupère le produit
        $query->execute();

        //message si crée ou non
        $_SESSION['message'] = "Kraken crée";
        require_once('close.php');
         header('Location: KrakenVue.php');

    } else {
        $_SESSION['erreur'] = "La création est incomplet";
    }
}




?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content ="width=device-width, initial-scale=1.0">
<title>ajout de kraken</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" type="text/css"  href="css/add.css"> 


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
                <h2>création d'un kraken</h2>
                     <form method="post">


                    
                     <div class="form-group">
                     <label for="name">nom</label>
                     <input type="text" id="name" name="name" class="form-control">
                     </div>

                     <div class="form-group">
                     <label for="age">age</label>
                     <input type="text" id="age" name="age" class="form-control">
                     </div>

                     <div class="form-group">
                     <label for="taille">taille</label>
                     <input type="text" id="taille" name="taille" class="form-control">
                     </div>

                     <div class="form-group">
                     <label for="poid">poids</label>
                     <input type="text" id="poid" name="poid" class="form-control">
                     </div>
                    
                     <input type="hidden" name="id_pouvoir" value="<?= $id_kraken ?>">
                     <button class="btn btn-primary">Créer</button>
                     </form>
                     
                </section>
                
            </div>
          <!-- <a href="KrakenVue.php" class="btn btn-primary">retour</a>  -->
        </main>
    </body>
</html>