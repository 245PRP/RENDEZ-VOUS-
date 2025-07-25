
<?php
//connexion à la base de donnée
try {
    $cnx= new PDO("mysql:host=localhost;dbname=rendez-vous","root","");
}
catch(PDOException $e){
    echo"Erreur de connexion à la base de donnée veuillez réesayer plutard:".$e->getMessage();
}
// ajouter un rendez-vous

if(isset($_POST['nom'])&& isset($_POST['date'])&& isset($_POST['Heure'])&& isset($_POST['objet'])){
    $nom=$_POST['nom'];
    $prix=$_POST['date'];
    $categorie=$_POST['Heure'];
    $quantite=$_POST['objet'];

    try {
        $stmt=$cnx->prepare('INSERT INTO reserver(nom, dates,heures,objet)VALUES (:nom, :dates, :Heure, :objet)');
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':dates', $date);
        $stmt->bindParam(':Heure', $heure);
        $stmt->bindParam(':objet', $objet);
        $stmt->execute();
        header('Location:afficher.php');
    } catch (PDOException $e) {
        echo"Erreur d'insertion des rendez-vous à la base de donnée".$e->getMessage();
    }

}


?>