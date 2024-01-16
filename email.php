<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sending email with PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #4b0082;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        input, textarea, button {
            display: block;
            margin-bottom: 15px;
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #4b0082;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form method="post" action="send_script.php">
        <label for="subject">Subject:</label>
        <input type="text" name="subject" required>

        <label for="msg">Message:</label>
        <textarea name="msg" required></textarea>

        <button type="submit" name="send_message_btn">Send</button>
    </form>
</body>
</html>
