<?php
// Conectare la baza de date
include("Conectare.php");

// Se verifica daca eventId a fost primit
if (isset($_GET['eventId']) && is_numeric($_GET['eventId'])) {
    // Preluam variabila 'eventId' din URL
    $eventId = $_GET['eventId'];

    // Stergem inregistrarea cu eventId = $eventId
    if ($stmt = $mysqli->prepare("DELETE FROM events WHERE eventId = ? LIMIT 1")) {
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $stmt->close();
        $success_message = "Party deleted succesfully";
    } else {
        $error_message = "ERROR: cannot execute delete";
    }

    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Party Deleted</title>
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
            background-color: #442b55; 
            color: #2c3e50; 
        }

        .container {
            width: 400px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); 
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
        }

        .success {
            padding: 10px;
            background-color:#45062e  ; 
            color: #fff;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .error {
            padding: 10px;
            background-color: #d9534f; 
            color: #fff;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #45062e; 
            font-weight: bold;
            
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this party?");
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Delete Party</h1>

        <?php if (isset($success_message)) : ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)) : ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <p><a href="vizualizare.php">Back to existing parties</a></p>
    </div>
</body>

</html>
