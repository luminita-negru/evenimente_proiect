<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DASHBOARD</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-image: url('admin.jpg');
            background-size: cover;
            background-position: center;
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        }

        .container {
            text-align: center;
            background-color: #45062e; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            color: #fff; 
            margin-bottom: 20px;
        }

        nav {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        nav a {
            margin: 10px 0;
            color: #fff; 
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s ease-in-out;
            padding: 10px;
            border-radius: 5px;
            width: 80%;
            background-color: #6a0572;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        nav a:hover {
            background-color: #45062e; 
        }

        .content {
            margin-top: 20px;
            color: #fff; 
        }

        .fa {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>DASHBOARD</h1>
        <nav>
            <a href="logout_admin.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <a href="inserare.php"><i class="fas fa-plus-circle"></i> Add Party</a>
            <a href="vizualizare.php"><i class="fas fa-list"></i> View Parties</a>
            <a href="email.php"><i class="fas fa-list"></i> Send Email</a>
        </nav>
        <div class="content">
            <h2>Welcome, <?=$_SESSION['name']?>!</h2>
        </div>
    </div>
</body>

</html>
