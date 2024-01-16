<?php
// Start the session
session_start();

// Database connection information
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'evenimente';

// Attempt to connect to the database
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check for database connection errors
if (mysqli_connect_errno()) {
    exit('Esec conectare MySQL: ' . mysqli_connect_error());
}

// Check if username and password are provided in the form
if (!isset($_POST['username'], $_POST['password'])) {
    exit('Completati username si password !');
}

// Prepare SQL query to retrieve user information
if ($stmt = $con->prepare('SELECT userId, password FROM users WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc.)
    $stmt->bind_param('s', $_POST['username']);

    // Execute the query
    $stmt->execute();
    // Store the result so we can check if the account exists in the database
    $stmt->store_result();
    // Check if a matching user is found
    if ($stmt->num_rows > 0) {
        // Bind the result variables
        $stmt->bind_result($userId, $password);
        // Fetch the result
        $stmt->fetch();

        // Verify the password using password_verify
        
        if (password_verify($_POST['password'], $password)) {
            // Password is correct, create sessions to indicate the user is logged in
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $userId;
            echo 'Bine ati venit ' . $_SESSION['name'] . '!';
            // Redirect to the home page
            header('Location: cos.php');
        } else {
            // Incorrect password
            echo 'Incorrect username sau password!';
        }
    } else {
        // Incorrect username
        echo 'Incorrect username sau password!';
    }

    // Close the statement
    $stmt->close();
}
// Close the database connection
mysqli_close($con);
?>
