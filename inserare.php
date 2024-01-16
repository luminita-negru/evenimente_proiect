<?php
include("Conectare.php");

$error = '';

if (isset($_POST['submit'])) {
    $title = htmlentities($_POST['title'], ENT_QUOTES);
    $description = htmlentities($_POST['description'], ENT_QUOTES);
    $date = htmlentities($_POST['date'], ENT_QUOTES);
    $location = htmlentities($_POST['location'], ENT_QUOTES);
    $contact = htmlentities($_POST['contact'], ENT_QUOTES);
    $price = htmlentities($_POST['price'], ENT_QUOTES);
    $sponsors = isset($_POST['sponsors']) ? $_POST['sponsors'] : array();
    $speakers = isset($_POST['speakers']) ? $_POST['speakers'] : array();


    if ($title == '' || $description == '' || $date == '' || $location == '' || $contact == '' || $price == '' || empty($sponsors) || empty($speakers)) {
        $error = 'ERROR: Campuri goale!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT INTO events (title, description, date, location, contact, price) VALUES (?, ?, ?, ?, ?, ?)")) {
            $stmt->bind_param("sssssd", $title, $description, $date, $location, $contact, $price);
            $stmt->execute();
            $eventId = $stmt->insert_id;
            $stmt->close();
            foreach ($sponsors as $sponsor) {
                if ($stmt = $mysqli->prepare("INSERT INTO sponsors (name, eventId) VALUES (?, ?)")) {
                    $stmt->bind_param("si", $sponsor, $eventId);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    echo "ERROR: Nu se poate executa insert pentru sponsori.";
                }
            }
            foreach ($speakers as $speaker) {
                if ($stmt = $mysqli->prepare("INSERT INTO speakers (name, eventId) VALUES (?, ?)")) {
                    $stmt->bind_param("si", $speaker, $eventId);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    echo "ERROR: Nu se poate executa insert pentru speaker.";
                }
            }
        } else {
            echo "ERROR: Nu se poate executa insert.";
        }
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Adaugare eveniment</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
        <h1>Add Party</h1>

        <?php if ($error != '') : ?>
            <div style='padding: 10px; background-color: #ff4d4d; border-radius: 5px; margin-bottom: 10px;'><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div>
                <strong>Title:</strong> <input type="text" name="title" value="" />
            </div>
            <div>
                <strong>Description:</strong> <textarea name="description" rows="10"></textarea>
            </div>
            <div>
                <strong>Date:</strong> <input type="date" name="date" value="" placeholder="YYYY-MM-DD" />
            </div>
            <div>
                <strong>Location:</strong> <input type="text" name="location" value="" />
            </div>
            <div>
                <strong>Contact:</strong> <input type="text" name="contact" value="" />
            </div>
            <div>
                <strong>Price:</strong> <input type="text" name="price" value="" />
            </div>
            <div>
                <strong>Sponsors:</strong>
                <div id="sponsor-container">
                    <input type="text" name="sponsors[]" placeholder="Numele sponsorului" />
                </div>
                <button type="button" onclick="addSponsorField()">Add Sponsor</button>
                <button type="button" onclick="removeSponsorField()">Remove Sponsor</button>
            </div>
            <div>
                <strong>Artists:</strong>
                <div id="speaker-container">
                    <input type="text" name="speakers[]" placeholder="Numele speaker" />
                </div>
                <button type="button" onclick="addSpeakerField()">Add Speaker</button>
                <button type="button" onclick="removeSpeakerField()">Remove Speaker</button>
            </div>

            <input type="submit" name="submit" value="Add Party" />
            <a href="vizualizare.php">View Parties</a>
        </form>
    </div>
</body>

</html>
