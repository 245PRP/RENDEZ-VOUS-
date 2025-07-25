<?php
//connexion à la base de donnée
try {
    $cnx= new PDO("mysql:host=localhost;dbname=rendez-vous","root","");
}
catch(PDOException $e){
    echo"Erreur de connexion à la base de donnée veuillez réesayer plutard:".$e->getMessage();
}
// ajouter un produit
if(isset($_POST['nom'])&& isset($_POST['dates'])&& isset($_POST['heure'])&& isset($_POST['objet'])){
    $nom=$_POST['nom'];
    $dates=$_POST['dates'];
    $heures=$_POST['heure'];
    $objet=$_POST['objet'];

    try {
        $stmt=$cnx->prepare('INSERT INTO reserver(nom, dates,heures,objet)VALUES (:nom, :dates, :heure, :objet)');
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':dates', $dates);
        $stmt->bindParam(':heure', $heures);
        $stmt->bindParam(':objet', $objet);
        $stmt->execute();
        header('Location:afficher.php');
    } catch (PDOException $e) {
        echo"Erreur d'insertion des produits à la base de donnée".$e->getMessage();
    }

}


?>