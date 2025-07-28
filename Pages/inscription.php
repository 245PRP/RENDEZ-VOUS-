<?php
session_start();
$message = ''; // Pour les messages d'erreur ou succès

// Connexion à la base de données
try {
    $conn = new PDO("mysql:host=localhost;dbname=rendez-vous", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération du statut depuis l'URL
$statut = isset($_GET['statut']) ? $_GET['statut'] : null;
if ($statut !== 'client' && $statut !== 'entreprise') {
    die("Statut incorrect pour cet utilisateur.");
}

// Gestion de l'affichage du formulaire (login par défaut)
$showForm = isset($_GET['show']) && $_GET['show'] === 'register' ? 'register' : 'login';

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $motdepasse = trim($_POST["motdepasse"]);

    if (isset($_POST["action"]) && $_POST["action"] === "register") {
        $nom = trim($_POST["nom"]);
        $confirm = trim($_POST["confirm"]);

        if (!empty($nom) && !empty($email) && !empty($motdepasse) && !empty($confirm)) {
            if ($motdepasse !== $confirm) {
                $message = "Les mots de passe ne correspondent pas.";
                $showForm = 'register';
            } else {
                $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
                $stmt->execute([$email]);

                if ($stmt->rowCount() === 0) {
                    $hash = password_hash($motdepasse, PASSWORD_DEFAULT);
                    $insert = $conn->prepare("INSERT INTO utilisateur (nom, email, password, statut) VALUES (?, ?, ?, ?)");
                    $insert->execute([$nom, $email, $hash, $statut]);
                    $message = "Inscription réussie. Connectez-vous.";
                    $showForm = 'login';
                } else {
                    $message = "Cet email est déjà utilisé.";
                    $showForm = 'register';
                }
            }
        } else {
            $message = "Tous les champs sont obligatoires.";
            $showForm = 'register';
        }
    }

    if (isset($_POST["action"]) && $_POST["action"] === "login") {
        if (!empty($email) && !empty($motdepasse)) {
            $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($motdepasse, $user['password'])) {
                if ($user['statut'] !== $statut) {
                    $message = "Statut incorrect pour cet utilisateur.";
                } else {
                    $_SESSION['user'] = [
                        'id' => $user['idPrimaire'],  // Bien respecter le nom exact de ta colonne
                        'nom' => $user['nom'],
                        'email' => $user['email'],
                        'statut' => $user['statut']
                    ];
                    if ($statut === "client") {
                        header("Location: Acceuil.html ");
                        exit();
                    } elseif ($statut === "entreprise") {
                        header("Location: entreprise.html");
                        exit();
                    }
                }
            } else {
                $message = "Email ou mot de passe incorrect.";
            }
        } else {
            $message = "Veuillez remplir tous les champs.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion - Bookmetime</title>
    <link rel="stylesheet" href="../CSS/inscription.css">
</head>
<body>
    <?php if (!empty($message)): ?>
        <p style="color:red; text-align:center; margin: 10px 0;"> <?= htmlspecialchars($message) ?> </p>
    <?php endif; ?>

    <div class="super-container">
        <header>
            <img src="../Images/e102260c-14c5-4ad3-a39f-652c0b992a1c.jfif" alt="logo" />
        </header>
        <section>
            <div class="wrapper">
                <div class="container">
                    <div class="form-header">
                        <div id="login" class="connexion <?= $showForm === 'login' ? 'active' : '' ?>">Connexion</div>
                        <div id="register" class="connexion <?= $showForm === 'register' ? 'active' : '' ?>">Inscription</div>
                    </div>
                    <div class="form-body" id="formContainer">
                        <!-- Formulaire Connexion -->
                        <form method="post" id="login-form" style="<?= $showForm === 'login' ? 'display:block;' : 'display:none;' ?>">
                            <input type="hidden" name="action" value="login">
                            <input type="email" name="email" placeholder="Votre email" required />
                            <input type="password" name="motdepasse" placeholder="Votre mot de passe" required />
                            <button type="submit">Connexion</button>
                            <p style="text-align:center;">Pas de compte ? <a href="#" onclick="showRegister()">Inscrivez-vous maintenant</a></p>
                        </form>

                        <!-- Formulaire Inscription -->
                        <form method="post" id="register-form" class="toggle" style="<?= $showForm === 'register' ? 'display:block;' : 'display:none;' ?>">
                            <input type="hidden" name="action" value="register">
                            <input type="text" name="nom" placeholder="Nom" required />
                            <input type="email" name="email" placeholder="Email" required />
                            <input type="password" name="motdepasse" placeholder="Mot de passe" required />
                            <input type="password" name="confirm" placeholder="Confirmez le mot de passe" required />
                            <button type="submit">S'inscrire</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        const show = urlParams.get('show');

        if (show === 'register') {
            showRegister();
        } else {
            showLogin();
        }

        document.getElementById('register').addEventListener('click', showRegister);
        document.getElementById('login').addEventListener('click', showLogin);
    };

    function showLogin() {
        document.getElementById('register-form').style.display = "none";
        document.getElementById('login-form').style.display = "block";
        document.getElementById('register').classList.remove("active");
        document.getElementById('login').classList.add("active");
    }

    function showRegister() {
        document.getElementById('login-form').style.display = "none";
        document.getElementById('register-form').style.display = "block";
        document.getElementById('login').classList.remove("active");
        document.getElementById('register').classList.add("active");
    }
    </script>
</body>
</html>
