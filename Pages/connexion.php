<?php
session_start();

// Redirection si déjà connecté
if (isset($_SESSION['user']['statut'])) {
    if ($_SESSION['user']['statut'] === 'client') {
        header("Location: Acueill.php");
        exit();
    } elseif ($_SESSION['user']['statut'] === 'entreprise') {
        header("Location: accueil_entreprise.php");
        exit();
    }
}

// Connexion à la base de données
try {
    $conn = new PDO("mysql:host=localhost;dbname=rendez-vous", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $motdepasse = isset($_POST['motdepasse']) ? $_POST['motdepasse'] : '';

    if (empty($email) || empty($motdepasse)) {
        echo "Erreur : Email ou mot de passe vide !";
    } else {
        $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification utilisateur trouvé
        if ($user && password_verify($motdepasse, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['idPrimaire'], // ✅ Nom correct de la colonne
                'nom' => $user['nom'],
                'email' => $user['email'],
                'statut' => $user['statut']
            ];

            // Redirection selon le statut
            if ($user['statut'] === 'client') {
                header("Location: Acueill");
                exit();
            } elseif ($user['statut'] === 'entreprise') {
                header("Location: accueil_entreprise.php");
                exit();
            } else {
                echo "Erreur : Statut utilisateur inconnu !";
            }
        } else {
            echo "Erreur : Email ou mot de passe incorrect !";
        }
    }
}
?>
