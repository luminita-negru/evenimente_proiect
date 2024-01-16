<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Sponsors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("background.jpg"); /* Schimbă cu calea către imaginea de fundal dorită */
            margin: 0;
            padding: 0;
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        header {
            background-color: #6a0572; /* Mov deschis pentru antet */
            padding: 1em;
            text-align: center;
        }

        .sponsors-list {
            max-width: 800px;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.8); /* Fundal alb transparent */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .sponsor-item {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            margin: 10px 0;
        }

        .sponsor-item h3 {
            color: #45062e; /* Mov intens pentru titlu */
        }

        .sponsor-item p {
            color: #666;
        }
    </style>
</head>

<body>

    <header>
        <h1>Event Sponsors</h1>
    </header>

    <div class="sponsors-list">
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

            // Interogare pentru a prelua detalii despre sponsori din baza de date
            $sqlSponsors = "SELECT * FROM sponsors WHERE eventId = $eventId";
            $resultSponsors = $conn->query($sqlSponsors);

            // Închiderea conexiunii
            $conn->close();

            // Afișează lista de sponsori dacă există rezultate
            if ($resultSponsors->num_rows > 0) {
                while ($rowSponsor = $resultSponsors->fetch_assoc()) {
                    echo '<div class="sponsor-item">';
                    echo '<h3>' . htmlspecialchars($rowSponsor['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($rowSponsor['description']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo 'Nu există sponsori pentru acest eveniment.';
            }
        } else {
            echo 'Evenimentul nu este specificat.';
        }
        ?>
    </div>

</body>

</html>
