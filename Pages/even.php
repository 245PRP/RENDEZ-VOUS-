<?php
header('Content-Type: application/json');

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=localhost;dbname=rendez-vous", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des plannings
    $stmt = $conn->query("SELECT * FROM disponibilites");
    $events = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Construction d’un format compatible FullCalendar
        $events[] = [
            'title' => $row['name'],
            'start' => "2025-" . str_pad($row['mois'], 2, "0", STR_PAD_LEFT) . "-" . str_pad($row['jour'], 2, "0", STR_PAD_LEFT) . "T" . $row['heur'],
            'end' => "2025-" . str_pad($row['mois'], 2, "0", STR_PAD_LEFT) . "-" . str_pad($row['jour'], 2, "0", STR_PAD_LEFT) . "T" . $row['fin'],
        ];
    }

    echo json_encode($events);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
