<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendrier Planning</title>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <link href="../CSS/calendrier.css" rel="stylesheet">
</head>
<body>

<div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 20px;">
  <img src="../Images/icon.jpg" alt="Logo" style="width: 40px; height: 40px; object-fit: contain;">
  <h2>Calendrier des Plannings</h2>
</div>

<div id="calendar"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            locale: 'fr',
            initialView: 'dayGridMonth',
            events: 'even.php'
        });
        calendar.render();
    });
</script>
   <p>
       <i>
          📅 Ce calendrier affiche les heures disponibles<br>
          ⏰ Pour choisir facilement ton créneau de rendez-vous<br>
          🤝 Prends rendez-vous rapidement sans stress !
       </i>
   </p>
</body>
</html>
