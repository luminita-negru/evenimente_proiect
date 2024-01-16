<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Speakers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        header {
            background-color: #2980b9; /* Albastru deschis pentru antet */
            padding: 1em;
            text-align: center;
        }

        .speakers-list {
            max-width: 800px;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.8); /* Fundal alb transparent */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .speaker-item {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            margin: 10px 0;
        }

        .speaker-item h3 {
            color: #45062e; /* Mov intens pentru titlu */
        }

        .speaker-item p {
            color: #666;
        }
    </style>
</head>

<body>

    <header>
        <h1>Event Artists</h1>
    </header>

    <div class="speakers-list">
        <?php
        // Verificați dacă parametrul eventId există în URL
        if (isset($_GET['eventId'])) {
            $eventId = $_GET['eventId'];

            // Conectare la baza de date
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "evenimente";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificare conexiune
            if ($conn->connect_error) {
                die("Conexiune esuata: " . $conn->connect_error);
            }

            // Interogare pentru a prelua detalii despre speakeri din baza de date
            $sqlSpeakers = "SELECT * FROM speakers WHERE eventId = $eventId";
            $resultSpeakers = $conn->query($sqlSpeakers);

            // Închiderea conexiunii
            $conn->close();

            // Afișează lista de speakeri dacă există rezultate
            if ($resultSpeakers->num_rows > 0) {
                while ($rowSpeaker = $resultSpeakers->fetch_assoc()) {
                    echo '<div class="speaker-item">';
                    echo '<h3>' . htmlspecialchars($rowSpeaker['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($rowSpeaker['description']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo 'There are no artists for this event.';
            }
        } else {
            echo 'The event is not specified.';
        }
        ?>
    </div>

</body>

</html>
