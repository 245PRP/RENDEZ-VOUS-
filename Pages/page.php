<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Rendez-vous</title>
    <link rel="stylesheet" href="../CSS/style de page.css">
</head>
<body>
    <form action="ajout.php" method="post">
        <div class="ror">
            <h1>Formulaire</h1>

            <h2><?= $id ? "Modifier le rendez-vous" : "Nouveau rendez-vous" ?></h2>
<form method="post">
    <?php if ($id): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php endif; ?>

    <label>Nom Entreprise :</label><br>
    <select name="Nom" required>
        <option value="">-- Choisir une entreprise --</option>
        <option value="INOV CAMEROON" <?= $nom == 'INOV CAMEROON' ? 'selected' : '' ?>>INOV CAMEROON</option>
        <option value="CAMTEL" <?= $nom == 'CAMTEL' ? 'selected' : '' ?>>CAMTEL</option>
        <option value="AFRILAND FIRST BANK" <?= $nom == 'AFRILAND FIRST BANK' ? 'selected' : '' ?>>AFRILAND FIRST BANK</option>
        <option value="SONARA" <?= $nom == 'SONARA' ? 'selected' : '' ?>>SONARA</option>
        <option value="CIMENCAM" <?= $nom == 'CIMENCAM' ? 'selected' : '' ?>>CIMENCAM</option>
    </select><br><br>

    <label>Date :</label><br>
    <input type="date" name="dates" value="<?= htmlspecialchars($dates) ?>" required><br><br>

    <label>Heure :</label><br>
    <input type="time" name="heure" value="<?= htmlspecialchars($heures) ?>" required><br><br>

    <label>Objet :</label><br>
    <input type="text" name="objet" value="<?= htmlspecialchars($objet) ?>" required><br><br>

    <button type="submit"><?= $id ? "Enregistrer les modifications" : "Ajouter le rendez-vous" ?></button>
</form>
</body>
</html>