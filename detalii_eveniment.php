<?php
// Verifică dacă parametrul event_id există în URL
if (isset($_GET['eventId'])) {
    $eventId = $_GET['eventId'];

    // Conectare la baza de date (codul de conectare poate rămâne neschimbat)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "evenimente";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificare conexiune
    if ($conn->connect_error) {
        die("Conexiune esuata: " . $conn->connect_error);
    }

    // Interogare pentru a prelua detaliile evenimentului din baza de date
    $sqlEvent = "SELECT * FROM events WHERE eventId = $eventId";
    $resultEvent = $conn->query($sqlEvent);

    // Închiderea conexiunii (codul de închidere poate rămâne neschimbat)
    $conn->close();
} else {
    // Redirectează către pagina principală dacă nu este furnizat un ID de eveniment
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("photo-1492684223066-81342ee5ff30.jpg");
            margin: 0;
            padding: 0;
            background-size: cover;
            background-position: center;
        }

        header {
            background-color: #442b55;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        .event-details {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .event-details h2 {
            color: #45062e;
        }

        .event-details p {
            color: #666;
        }

        /* Butoanele de vizualizare sponsori și speakeri */
        .event-details a {
            display: block;
            margin-top: 10px;
            padding: 8px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .event-details a.view-sponsors {
            background-color: #6a0572; /* Violet intens pentru butonul de sponsori */
        }

        .event-details a.view-sponsors:hover {
            background-color: #45062e; /* Violet mai intens la hover */
        }

        .event-details a.view-speakers {
            background-color: #2980b9; /* Albastru deschis pentru butonul de speakeri */
        }

        .event-details a.view-speakers:hover {
            background-color: #1a5276; /* Albastru mai intens la hover */
        }
    </style>
</head>

<body>

    <header>
        <h1>Party Details</h1>
    </header>

    <div class="event-details">
        <?php
        // Afișează detaliile evenimentului dacă există rezultate
        if ($resultEvent->num_rows > 0) {
            $rowEvent = $resultEvent->fetch_assoc();
            echo '<h2>' . htmlspecialchars($rowEvent['title']) . '</h2>';
            echo '<p>Date: ' . htmlspecialchars($rowEvent['date']) . '</p>';
            echo '<p>Location: ' . htmlspecialchars($rowEvent['location']) . '</p>';
            echo '<p>Contact: ' . htmlspecialchars($rowEvent['contact']) . '</p>';
            echo '<p>Price: ' . htmlspecialchars($rowEvent['price']) . '</p>';
            echo '<p>' . htmlspecialchars($rowEvent['description']) . '</p>';
            echo '<form method="post" action="cos.php?action=add&eventId=' . $eventId . '">';
            echo '<input type="text" name="nr_tickets" value="1" size="2" />';
            echo '<input type="submit" value="Add to Cart" class="btnAddAction" />';
            echo '</form>';
        } else {
            echo 'The party was not found.';
        }

        // Adaugă butoanele pentru sponsori și speakeri
        echo '<a class="view-sponsors" href="sponsori_eveniment.php?eventId=' . $eventId . '">View Sponsors</a>';
        echo '<a class="view-speakers" href="speakeri_eveniment.php?eventId=' . $eventId . '">View Artists</a>';
        echo '<a class="view-speakers" href="indexuser.html?eventId=' . $eventId . '">Go to cart</a>';
        ?>
    </div>

</body>

</html>
