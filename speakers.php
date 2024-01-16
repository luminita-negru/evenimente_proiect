<?php
// Conectare la baza de date
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evenimente";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

// Interogare pentru a obține speakerii și numele evenimentului
$sql = "SELECT speakers.speakerId, speakers.name AS speakerName, speakers.categories, events.title AS eventName 
        FROM speakers 
        INNER JOIN events ON speakers.eventId = events.eventId";

$result = $conn->query($sql);

// Verificare dacă interogarea a avut succes
if ($result === false) {
    die("Eroare la interogare: " . $conn->error);
}

// Verificare dacă s-au găsit rezultate
if ($result->num_rows > 0) {
    // Afisare date pentru fiecare rând
    while($row = $result->fetch_assoc()) {
        echo "Speaker Name: " . $row["speakerName"]. "<br>";
        echo "Categories: " . $row["categories"]. "<br>";
        echo "Event Name: " . $row["eventName"]. "<br>";
        echo "<br>";
    }
} else {
    echo "Nu s-au găsit speakeri pentru evenimente.";
}

// Închidere conexiune
$conn->close();
?>
