<?php
//on démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('FonctionsSQL.php');

    // on nettoie l'id envoyé
    $id = strip_tags($_GET['id']);



     $sql = 'SELECT * FROM `tentacules` WHERE `id` =:id;';

    // on prépare la requête
    $query = $db->prepare($sql);

    // on "accroche" les paramère (id)
    $query->bindValue(':kraken_id', $id, PDO::PARAM_INT);

    //on exécute la requête
    $query->execute();

    //on vérifie si l'objet existe

    $produit = $query->fetch();


if(!$produit){
    $_SESSION['erreur'] = "cet id n'existe pas";
    header('Location: krakenVue.php');

}

$sql ='DELETE FROM `tentacules` WHERE `id` = :id;';

// on prépare la requête
$query = $db->prepare($sql);

// on "accroche" les paramère (id)
$query->bindValue(':id', $id, PDO::PARAM_INT);

//on exécute la requête
$query->execute();
$_SESSION['message'] = "tentacule supprimé";
header('Location: krakenVue.php');




} else{
    // $_SESSION['erreur'] = "URL invalide";
    // header('Location: krakenVue.php');
}
?>

