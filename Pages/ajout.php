<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $conn = new PDO("mysql:host=localhost;dbname=rendez-vous", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['Nom'], $_POST['dates'], $_POST['heure'], $_POST['objet'])) {
        $nom = $_POST['Nom'];
        $date = $_POST['dates'];
        $heure = $_POST['heure'];
        $objet = $_POST['objet'];

        $stmt = $conn->prepare("INSERT INTO reserver (nom, dates, heures, objet) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nom, $date, $heure, $objet])) {
            header("Location: afficher.php");
            exit();
        } else {
            echo "Erreur lors de l'insertion.";
        }
    } else {
        echo "Tous les champs sont requis.";
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
