<?php
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

// Interogare pentru a prelua evenimentele din baza de date
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

// Inchiderea conexiunii
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenimente - Pagina de Start</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("photo-1492684223066-81342ee5ff30.jpg");
            background-size: cover; 
            background-position: center;
            
        }

        header {
            background-color: #442b55;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        .event-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }

        .event-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            width: 300px;
            text-align: center;
            transition: transform 0.3s;
            opacity: 0.8;
        }

        .event-card:hover {
            transform: scale(1.05);
        }

        .event-card h2 {
            color: #333;
        }

        .event-card p {
            color: #666;
        }

        .event-link {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Parties</h1>
        <p>Are you ready for fun?!</p>
    </header>

    <div class="event-container">
        <?php
            // Afisarea evenimentelor
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="event-card">';
                    echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
                    echo '<p>Data: ' . htmlspecialchars($row['date']) . '</p>';
                    echo '<a class="event-link" href="detalii_eveniment.php? eventId=' . $row['eventId'] . '">Detalii Eveniment</a>';
                    echo '</div>';
                }
            } else {
                echo 'Nu există evenimente în acest moment.';
            }
        ?>
    </div>

</body>
</html>
