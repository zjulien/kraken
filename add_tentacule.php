<?php
// On démarre une session
session_start();



if(isset($_GET['id']) && !empty($_GET['id'])){
$id_kraken = $_GET['id'];
}



if($_POST){
    if(!isset($_POST['nom_tentacule']) && !empty($_POST['nom_tentacule']))
    if (isset($_POST['id_kraken']) && !empty($_POST['id_kraken']))
    if (isset($_POST['pv']) && !empty($_POST['pv']))
    if (isset($_POST['forc']) && !empty($_POST['forc']))
    if (isset($_POST['dex']) && !empty($_POST['dex']))
    if (isset($_POST['con']) && !empty($_POST['con']))
    if($forc<=12 || $forc>=16){
        header('Location: https://www.disneylandparis.com/fr-fr/');
    }
    if($dex<=12 || $dex>=16){
        header('Location: https://www.disneylandparis.com/fr-fr/');
    }
    if($con<=12 || $con>=16){
        header('Location: https://www.disneylandparis.com/fr-fr/');
    }
    if($pv<=6 || $pv>=36){
        header('Location: https://www.disneylandparis.com/fr-fr/');
    }
        // On inclut la connexion à la base
        require_once('FonctionsSQL.php');

        //protection différent champ formulaire
        //on nettoie les données envoyées
        $choix_kraken = (int)$_POST['id_kraken'];
        $name = $_POST['nom_tentacule'];
        $pv =(int)$_POST['pv'];
        $forc =(int)$_POST['forc'];
        $dex =(int)$_POST['dex'];
        $con =(int)$_POST['con'];

        $sql = 'INSERT INTO `tentacules` (`nom_tentacule`,`kraken_id`,`pv`,`forc`,`dex`,`con`) VALUES(:nom_tentacule, :kraken_id, :pv, :forc, :dex, :con )';

      
     
        //on prépare la requête
        $query = $db->prepare($sql);
       
     

        //on "accroche" les paramètres (ici : nom de tentacule)
        $query->bindParam(':nom_tentacule', $name, \PDO::PARAM_STR);
        $query->bindParam(':kraken_id', $choix_kraken, \PDO::PARAM_INT);
        $query->bindParam(':pv', $pv, \PDO::PARAM_INT);
        $query->bindParam(':forc', $forc, \PDO::PARAM_INT);
        $query->bindParam(':dex', $dex, \PDO::PARAM_INT);
        $query->bindParam(':con', $con, \PDO::PARAM_INT);




        //on récupère le produit
       $toto= $query->execute();
       
        //message si crée ou non
        $_SESSION['message'] = "tentacule crée";
        header('Location: KrakenVue.php?id='.$choix_kraken);
        
       

    
    }
 else {
    $_SESSION['erreur'] = "La création est incomplet";
 }

 
?>



<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content ="width=device-width, initial-scale=1.0">
<title>ajout de kraken</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" type="text/css"  href="css/add_tentacule.css">


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

                    Création de tentacule

            ///////////////////////////////////////////////////////////////////////////////////////// -->

           


           
                <h1>création de tentacule du kraken</h1>
                   
      
   <!-- ////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////

                    NOM DES TENTACULES

            ///////////////////////////////////////////////////////////////////////////////////////// -->

                <form method="post">
                 
                    </div>
                     <div class="form-group">
                     <label for="nom_tentacule" >nom de tentacule</label>
                     <input type="text"  id="nom_tentacule" name="nom_tentacule" class="form-control" required>
                     </div> <div class="form-group">
                     <label for="pv" >points de vie (entre 6 et 36)</label>
                     <input type="number" min="6" max="36" id="pv" name="pv" class="form-control" required>
                     </div> 
                     <div class="form-group">
                     <label for="forc" >force(entre 12 et 16)</label>
                     <input type="number" min="12" max="16" id="forc" name="forc" class="form-control" required>
                     </div> 
                     <div class="form-group">
                     <label for="dex" >dextérité(entre 12 et 16)</label>
                     <input type="number"  id="dex" min="12" max="16" name="dex" class="form-control" required>
                     </div> 
                     <div class="form-group">
                     <label for="con" >constitution(entre 12 et 16)</label>
                     <input type="number"  id="con" min="12" max="16" name="con" class="form-control" required>
                     </div>
                    <input type="hidden" name="id_kraken" value="<?= $id_kraken ?>">
                     <button class="btn btn-primary">Créer</button>
                     </form>
                   
                   
                </section>
                
            </div>

        </main>
    </body>
</html>