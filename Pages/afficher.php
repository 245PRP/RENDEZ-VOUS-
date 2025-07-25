<?php 

try{
//connexion base de donnees
$cnx=new PDO('mysql:host=localhost;dbname=rendez-vous','root','');
$cnx->setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//recupère les produits
$sql="SELECT * FROM reserver";
$stmt=$cnx->prepare($sql);
if($stmt===false){
    throw new PDOException("Erreur lors de la preparation de la requete");
}
$stmt->execute();
$afficher=$stmt->fetchAll();
if($afficher===false){
    throw new PDOException("Erreur lors de la recuperation de la requete");
}
//affichage des produits
/*$stmt=$pdo->query('SELECT*FROM produits');
$produits=$stmt->fetchAll();*/
}
catch(PDOException $e){
    echo"Erreur:".$e->getMessage();
} 


if (isset($_GET['supprimerid'])) {
        $id = $_GET['supprimerid'];
        // Supprimer le produit de la base de données
        $requte = $cnx->prepare("DELETE FROM reserver WHERE id = :id");
        $requte->bindParam(':id', $id);
        $requte->execute();
        header('Location: afficher.php');
    
    
}
?>
<!DOCTYPE html>
<html lang="fr">
 <head>
    <meta charset="UTF_8"/>
    <meta name="viewport" content="<width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <title>
        TABLEAU DE RENDEZ VOUS PLANIFIES
    </title>
    </head>
    <body>   
<table>
    <thead>
        <tr>
            <th>identifiant</th>
            <th>Nom de l'entreprise</th>
            <th>Dates</th>
            <th>Heures</th>
            <th>Objets</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($afficher as $afficher) : ?>
            <tr>
                <td><?=$afficher['id']?></td>
                <td><?= $afficher['nom'] ?></td>
                <td><?= $afficher['dates'] ?></td>
                <td><?= $afficher['heures'] ?></td>
                <td><?= $afficher['objet'] ?></td>
                <td>
                    <a href="modifier.php?id=<?= $afficher['id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                    <a href="afficher.php?supprimerid=<?= $afficher['id'] ?>"onclick="return confirm('etes vous sur de vouloir supprimer cet element')"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<style>
    table{
        border-collapse:collapse;
        width: 100%;
    }
    th td{
        border: 22px solid #ddd;
        padding: 10px;
        text-align:center;
    }
    th{
        background-color:#f0f0f0;
        font-weight:bold;
    }
    td{
        color:white;
        font-weight:bold;
    }
    i{
        color:black;
    }
</style>
</body>
</html>





























































