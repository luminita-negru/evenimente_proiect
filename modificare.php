<?php
include("Conectare.php");

$error = '';

$eventId = isset($_GET['eventId']) ? $_GET['eventId'] : '';
$title = '';
$description = '';
$date = '';
$location = '';
$contact = '';
$price = '';

if (!empty($eventId)) {
    $result = $mysqli->query("SELECT * FROM events WHERE eventId='" . $eventId . "'");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_object();
        $title = $row->title;
        $description = $row->description;
        $date = $row->date;
        $location = $row->location;
        $contact = $row->contact;
        $price = $row->price;
    } else {
        $error = "ERROR: Evenimentul nu exista.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlentities($_POST['title'], ENT_QUOTES);
    $description = htmlentities($_POST['description'], ENT_QUOTES);
    $date = htmlentities($_POST['date'], ENT_QUOTES);
    $location = htmlentities($_POST['location'], ENT_QUOTES);
    $contact = htmlentities($_POST['contact'], ENT_QUOTES);
    $price = htmlentities($_POST['price'], ENT_QUOTES);
    $sponsors = isset($_POST['sponsors']) ? $_POST['sponsors'] : array();
    $speakers = isset($_POST['speakers']) ? $_POST['speakers'] : array();

    if ($title == '' || $description == '' || $date == '' || $location == '' || $contact == '' || $price == '' || empty($sponsors) || empty($speakers)) {
        $error = "ERROR: Completati campurile obligatorii!";
    } else {
        if ($stmt = $mysqli->prepare("UPDATE events SET title=?, description=?, date=?, location=?, contact=?, price=? WHERE eventId=?")) {
            $stmt->bind_param("ssssssi", $title, $description, $date, $location, $contact, $price, $eventId);
            if ($stmt->execute()) {
                // Stergere sponsor și speakeri asociati evenimentului
                $mysqli->query("DELETE FROM sponsors WHERE eventId='$eventId'");
                $mysqli->query("DELETE FROM speakers WHERE eventId='$eventId'");

                // Adăugare sponsori
                    foreach ($sponsors as $sponsor) {
                        if ($stmtSponsor = $mysqli->prepare("INSERT INTO sponsors (name, eventId) VALUES (?, ?)")) {
                            $stmtSponsor->bind_param("si", $sponsor, $eventId);
                            $stmtSponsor->execute();
                            $stmtSponsor->close();
                        } else {
                            echo "ERROR: Nu se poate executa insert pentru sponsori.";
                        }
                    }
                

                // Adăugare speakeri
                    foreach ($speakers as $speaker) {
                        if ($stmtSpeaker = $mysqli->prepare("INSERT INTO speakers (name, eventId) VALUES (?, ?)")) {
                            $stmtSpeaker->bind_param("si", $speaker, $eventId);
                            $stmtSpeaker->execute();
                            $stmtSpeaker->close();
                        } else {
                            echo "ERROR: Nu se poate executa insert pentru speaker.";
                        }
                    }                

                header("Location: vizualizare.php");
                exit();
            } else {
                $error = "ERROR: cannot update";
            }
            $stmt->close();
        } else {
            $error = "ERROR:cannot update";
        }
    }
}

?>

<html>

<head>
    <title>Edit Party</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            background-color: #442b55; /* Violet intens */
            color: #2c3e50; /* Violet inchis pentru text */
        }

        .container {
            width: 400px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Fundal alb transparent */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        div {
            margin-bottom: 15px;
        }

        strong {
            display: inline-block;
            width: 120px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ccc; /* Bordura gri deschis */
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #6a0572; /* Mov deschis */
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
            border: none;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45062e; /* Mov intens */
        }

        a {
            text-decoration: none;
            color: #45062e; /* Mov intens */
            font-weight: bold;
        }
    </style>
    <script>
        function addSponsorField() {
            var container = document.getElementById("sponsor-container");
            var input = document.createElement("input");
            input.type = "text";
            input.name = "sponsors[]";
            input.placeholder = "Numele sponsorului";
            container.appendChild(input);
        }

        function removeSponsorField() {
            var container = document.getElementById("sponsor-container");
            var inputs = container.getElementsByTagName("input");
            if (inputs.length > 1) {
                container.removeChild(inputs[inputs.length - 1]);
            }
        }

        function addSpeakerField() {
            var container = document.getElementById("speaker-container");
            var input = document.createElement("input");
            input.type = "text";
            input.name = "speakers[]";
            input.placeholder = "Numele speaker";
            container.appendChild(input);
        }

        function removeSpeakerField() {
            var container = document.getElementById("speaker-container");
            var inputs = container.getElementsByTagName("input");
            if (inputs.length > 1) {
                container.removeChild(inputs[inputs.length - 1]);
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Edit Party</h1>

        <?php if ($error != '') : ?>
            <div style='padding: 10px; background-color: #ff4d4d; border-radius: 5px; margin-bottom: 10px;'><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <input type="hidden" name="eventId" value="<?php echo $eventId; ?>" />
            <strong>Title: </strong> <input type="text" name="title" value="<?php echo htmlspecialchars($title, ENT_QUOTES); ?>" /><br />
            <strong>Description: </strong> <textarea name="description" rows="10"><?php echo htmlspecialchars($description, ENT_QUOTES); ?></textarea><br />
            <strong>Date: </strong> <input type="text" name="date" value="<?php echo htmlspecialchars($date, ENT_QUOTES); ?>" /><br />
            <strong>Location: </strong> <input type="text" name="location" value="<?php echo htmlspecialchars($location, ENT_QUOTES); ?>" /><br />
            <strong>Contact: </strong> <input type="text" name="contact" value="<?php echo htmlspecialchars($contact, ENT_QUOTES); ?>" /><br />
            <strong>Price: </strong> <input type="text" name="price" value="<?php echo htmlspecialchars($price, ENT_QUOTES); ?>" /><br />
            <br />
            <div>
                <strong>Sponsors:</strong>
                <div id="sponsor-container">
                    <?php
                    $resultSponsors = $mysqli->query("SELECT name FROM sponsors WHERE eventId = '$eventId'");
                    while ($rowSponsor = $resultSponsors->fetch_assoc()) {
                        echo '<input type="text" name="sponsors[]" value="' . htmlspecialchars($rowSponsor['name'], ENT_QUOTES) . '" />';
                    }
                    ?>
                </div>
                <button type="button" onclick="addSponsorField()">Add Sponsor</button>
                <button type="button" onclick="removeSponsorField()">Remove Sponsor</button>
            </div>

            <div>
                <strong>Artists:</strong>
                <div id="speaker-container">
                    <?php
                    $resultSpeakers = $mysqli->query("SELECT name FROM speakers WHERE eventId = '$eventId'");
                    while ($rowSpeaker = $resultSpeakers->fetch_assoc()) {
                        echo '<input type="text" name="speakers[]" value="' . htmlspecialchars($rowSpeaker['name'], ENT_QUOTES) . '" />';
                    }
                    ?>
                </div>
                <button type="button" onclick="addSpeakerField()">Add Artist</button>
                <button type="button" onclick="removeSpeakerField()">Remove Artist</button>
            </div>

            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare.php">View Parties</a>
        </form>
    </div>
</body>

</html>
<?php
$mysqli->close();
?>
