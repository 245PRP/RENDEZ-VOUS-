<?php
$message = "";

try {
    $conn = new PDO("mysql:host=localhost;dbname=rendez-vous", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mois = trim($_POST['mois']);
        $jour = intval($_POST['jour']);
        $heur = $_POST['heur'];
        $name = trim($_POST['name']);
        $fin = $_POST['fin'];

        if ($mois !== "" && $jour > 0 && $heur !== "" && $fin !== "" && $name !== "") {
            // Contrôle de la validité des heures
            $heureDebut = strtotime($heur);
            $heureFin = strtotime($fin);

            if ($heureDebut !== false && $heureFin !== false && $heureFin > $heureDebut) {
                $stmt = $conn->prepare("INSERT INTO disponibilites (name, mois, jour, heur, fin) VALUES (:name, :mois, :jour, :heur, :fin)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':mois', $mois);
                $stmt->bindParam(':jour', $jour);
                $stmt->bindParam(':heur', $heur);
                $stmt->bindParam(':fin', $fin);

                if ($stmt->execute()) {
                    header("Location: calendrier.php");
                    exit();
                } else {
                    $message = "Erreur lors de l'insertion.";
                }
            } else {
                $message = "L'heure de fin doit être après l'heure de début.";
            }
        } else {
            $message = "Merci de remplir tous les champs correctement.";
        }
    }
} catch (PDOException $e) {
    $message = "Erreur : " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Ajouter Planning</title></head>
<link rel="stylesheet" href="../CSS/insert.css">
<body>

<?php if ($message != ""): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="post" action="">
    <h2>Planning de Disponibiliter</h2>
    Entreprise : <input type="text" name="name" required><br>
    Mois (2 chiffres) : <input type="text" name="mois" maxlength="2" pattern="[0-9]{2}" required><br>
    Jour : <input type="number" name="jour" min="1" max="31" required><br>
    Heure Debut : <input type="time" name="heur" required><br><br> 
    Heure Fin : <input type="time" name="fin" required><br><br>
    <button type="submit">Ajouter</button>
</form>
</body>
</html>
