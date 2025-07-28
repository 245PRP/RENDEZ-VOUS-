<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=rendez-vous", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM reserver");
    $rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Liste des rendez-vous</h2>";
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse;'>";
    echo "<tr style='background-color:#333;color:#fff;'>
        <th>Nom Entreprise</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Objet</th>
        <th>Modifier</th>
        <th>Supprimer</th>
      </tr>";


    if (empty($rdvs)) {
        echo "<tr><td colspan='4' style='text-align:center;'>Aucun rendez-vous trouvé</td></tr>";
    } else {
       foreach ($rdvs as $rdv) {
    echo "<tr>
            <td>{$rdv['nom']}</td>
            <td>{$rdv['dates']}</td>
            <td>{$rdv['heures']}</td>
            <td>{$rdv['objet']}</td>
            <td><a href='formulaire.php?id={$rdv['idPrimaire']}'>Modifier</a></td>
            <td><a href='supprimer.php?id={$rdv['idPrimaire']}' onclick=\"return confirm('Confirmer la suppression ?');\">Supprimer</a></td>
          </tr>";
}

    }
    echo "</table>";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<!-- suprimer-->$_COOKIE<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=rendez-vous", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM reserver WHERE idPrimaire = ?");
        $stmt->execute([$id]);
    }

    header("Location: afficher.php");
    exit();

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<?php
// Connexion à la base
$conn = new PDO("mysql:host=localhost;dbname=rendez_vous", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Initialisation des valeurs par défaut
$id = null;
$nom = "";
$dates = "";
$heures = "";
$objet = "";

// Si on reçoit un id en GET, on est en mode "modification"
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM reserver WHERE idPrimaire = ?");
    $stmt->execute([$id]);
    $rdv = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rdv) {
        $nom = $rdv['nom'];
        $dates = $rdv['dates'];
        $heures = $rdv['heures'];
        $objet = $rdv['objet'];
    }
}

// Traitement du formulaire à l'envoi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['Nom'];
    $dates = $_POST['dates'];
    $heures = $_POST['heure'];
    $objet = $_POST['objet'];

    if (!empty($_POST['id'])) {
        // Mode modification
        $idModif = intval($_POST['id']);
        $stmt = $conn->prepare("UPDATE reserver SET nom=?, dates=?, heures=?, objet=? WHERE idPrimaire=?");
        $stmt->execute([$nom, $dates, $heures, $objet, $idModif]);
    } else {
        // Mode ajout
        $stmt = $conn->prepare("INSERT INTO reserver (nom, dates, heures, objet) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $dates, $heures, $objet]);
    }

    // Redirection après traitement
    header("Location: afficher.php");
    exit();
}
?>
