<!DOCTYPE html>
<html lang="en">

<head>
    <title>Current Parties</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            background-color: #442b55; /* Violet intens */
            color: #2c3e50; /* Violet inchis pentru text */
        }

        h1, p a{
            color: #fff; /* Text alb pentru titlu și textul bold */
        }

        .event-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            margin: 10px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            vertical-align: top;
            background-color: rgba(255, 255, 255, 0.8); /* Fundal alb transparent */
        }

        .event-card h2 {
            margin-bottom: 5px;
            color: #45062e; /* Mov intens pentru titlu */
        }

        .event-card p {
            margin-top: 0;
        }

        .event-card a {
            text-decoration: none;
            color: #333;
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        .edit-link {
            background-color: #c67aed; /* Alb pentru fundalul linkului de editare */
            color: #fff; /* Alb pentru textul linkului de editare */
            padding: 8px;
            border-radius: 5px;
            text-decoration: underline; /* Eliminăm sublinierea implicită a linkului */
        }

        .delete-link {
            background-color: #ff4d4d; /* Rosu deschis pentru linkul de stergere */
            color: white;
            padding: 8px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>Current Parties</h1>
    <p><a href="dashboard.php">Go to Dashboard</a></p>
    <?php
    include("Conectare.php");

    if ($result = $mysqli->query("SELECT * FROM events ORDER BY eventId ")) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                // Afisare detalii eveniment
                echo "<div class='event-card'>";
                echo "<h2>" . $row->title . "</h2>";
                echo "<p><strong>Date:</strong> " . $row->date . "</p>";
                echo "<p><strong>Location:</strong> " . $row->location . "</p>";
                echo "<p><strong>Contact:</strong> " . $row->contact . "</p>";
                echo "<p><strong>Price:</strong> " . $row->price . "</p>";

                // Afisare sponsori
                echo "<p><strong>Sponsors:</strong> ";
                $resultSponsors = $mysqli->query("SELECT name FROM sponsors WHERE eventId='$row->eventId'");
                while ($rowSponsor = $resultSponsors->fetch_assoc()) {
                    echo $rowSponsor['name'] . ", ";
                }
                echo "</p>";

                // Afisare speakeri
                echo "<p><strong>Artists:</strong> ";
                $resultSpeakers = $mysqli->query("SELECT name FROM speakers WHERE eventId='$row->eventId'");
                while ($rowSpeaker = $resultSpeakers->fetch_assoc()) {
                    echo $rowSpeaker['name'] . ", ";
                }
                echo "</p>";

                echo "<a class='edit-link' href='modificare.php?eventId=" . $row->eventId . "'>Edit</a>";
                echo "<a class='delete-link' href='stergere.php?eventId=" . $row->eventId . "'>Delete</a>";
                echo "</div>";
            }
        } else {
            echo "There is no data in the table";
        }
    } else {
        echo "Error: " . $mysqli->error;
    }

    $mysqli->close();
    ?>
</body>

</html>
