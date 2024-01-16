<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evenimente";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune esuata: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$headers = "From: lumy.negru02@gmail.com";

if (isset($_POST['send_message_btn'])) {
    $msg = $_POST['msg'];
    $subject = $_POST['subject'];

    if ($result->num_rows > 0) {
        // Fetch all rows from the result set
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // Loop through each row
        foreach ($rows as $row) {
            $to = $row['email'];
            $name = $row['username'];
            $message = "A visitor to your site has sent the following email address to be added to your mailing list.\n";

            $userheaders = "From: lumy.negru02@gmail.com\n";
            $userheaders .= "MIME-Version: 1.0" . "\n";
            $userheaders .= "Content-type:text/html;charset=UTF-8" . "\n";
            $usermessage = "Thank you for subscribing to our mailing list.";

            $usermessage = "
                <html>
                <head>
                    <title>HTML email</title>
                </head>
                <body>
                    <p>This email contains HTML Tags!</p>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                        <tr>
                            <td>$name</td>
                            <td>$to</td>
                        </tr>
                    </table>
                    <p>$msg</p>
                </body>
                </html>
            ";

            if (mail($to, $subject, $usermessage, $userheaders)) {
                // Email sent successfully, you may want to log this information
            } else {
                // Failed to send email, you may want to log this information
                echo "Failed to send email.";
            }
        }

        // Redirect to confirmation page after processing all users
        header("Location: confirmation.php");
        exit();
    } else {
        echo "No users found in the database.";
    }
}

$conn->close();
?>
