<?php
try {
    $cnx = new PDO('mysql:host=localhost;dbname=rendez-vous', 'root', '');
    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (!isset($_GET['id'])) {
    die("ID manquant !");
}

$id = $_GET['id'];

// Récupération des données du produit
$stmt = $cnx->prepare("SELECT * FROM reserver WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$produit = $stmt->fetch();

if (!$afficher) {
    die("introuvable !");
}

// Mise à jour  du formulaire
if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $dates = $_POST['date'];
    $heures = $_POST['heures'];
    $objet = $_POST['objet'];

    $update = $cnx->prepare("UPDATE reserver SET nom = :nom, dates = :dates, heures = :Heure, objet = :objet WHERE id = :id");
    $update->bindParam(':nom', $nom);
    $update->bindParam(':dates', $dates);
    $update->bindParam(':Heure', $heures);
    $update->bindParam(':objet', $objet);
    $update->bindParam(':id', $id);
    $update->execute();

    header("Location: afficher.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier</title>

</head>
<body>
    <h2>Modifier le produit</h2>
    <form method="post">
        <label>Nom :</label>
        <select name="nom">
            <option value="INOV-CAMEROUN" <?= $afficher['nom'] == 'INOV-CAMEROUN' ? 'selected' : '' ?>>INOV-CAMEROUN</option>
            <option value="CAMTEL" <?= $afficher['nom'] == 'CAMTEL' ? 'selected' : '' ?>>CAMTEL</option>
            <option value="AFRILAND FIRST BANK" <?= $afficher['nom'] == 'AFRILAND FIRST BANK' ? 'selected' : '' ?>>AFRILAND FIRST BANK</option>
            <option value="SONARA" <?= $afficher['nom'] == 'SONARA' ? 'selected' : '' ?>>SONARA</option>
            <option value="CIMENCAM" <?= $afficher['nom'] == 'CIMENCAM' ? 'selected' : '' ?>>CIMENCAM</option>
        </select><br><br>

        <label>date :</label>
        <input type="date" name="dates" value="<?= htmlspecialchars($afficher['dates']) ?>"><br><br>

        <label>HEURE :</label>
         <input type="time" name="heures" value="<?= htmlspecialchars($afficher['heures']) ?>"><br><br>

        <label>OBJET:</label>
        <input type="text" name="objet" value="<?= htmlspecialchars($produit['objet']) ?>"><br><br>

        <input type="submit" name="submit" value="Enregistrer les modifications">
    </form>
</body>
</html>