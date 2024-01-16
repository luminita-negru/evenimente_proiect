<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            text-align: center;
            margin-top: 50px;
            background-color: #442b55;
            background-size: cover;
            background-position: center center; 
            background-attachment: fixed;
            color: #fafafa; 
        }
        
        header {
            text-align: left;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.2); /* Container alb cu opacitate mica */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px; /* Spațiu între header și conținutul următor */
        }

        header h1 {
            margin: 0;
            color: #fafafa; 
        }
        
        nav {
            flex: 1;
            text-align: right;
            border-color: #000;
        }

        nav ul li {
            list-style: none;
            display: inline-block;
            text-align: right;
            margin-left: 60px;
            padding-right: 100px;
            margin-bottom: 0;
            font-size: 20px;
            transition: transform 0.5s;
        }

        nav ul li:hover {
            transform: translateY(-5px);
        }

        nav ul li a {
            text-decoration: none;
            color: #fafafa;
            border-color: red;
        }

        nav ul li a:hover {
            color: #d4d4d4;
        }

        nav #AS {
            font-size: 13px;
        }

        h1 {
            margin-top: 20px; 
            transition: transform 0.5s;
            cursor: pointer;
        }

        h1:hover {
            transform: translateY(-5px);
            color: #fafafa;
        }

        p {
            margin: 35px;
            font-size: 20px;
        }   
    </style>
</head>
<body>
    <header>
        <h1>Euforia Parties</h1>
    </header>
    <div class="navbar">
        <nav>
            <ul id="ul">
                <li><a href="indexuser.html">LOG IN</a></li>
                <li><a href="reg.html">REGISTER</a></li>
                <li><a href="evenimente.php">PARTIES</a></li>
                <li><a href="indexadmin.html" id="AS">ADMIN | STAFF</a></li>            
                <li><a href="indexuser.html">CART</a></li>
                <li><a href="logout_user.php">LOG OUT</a></li>
            </ul>
        </nav>
    </div>
    <h1>Welcome to BEST Cluj parties!</h1>           
    <h2>About us:</h2>
    <p>Welcome to Euforia Events, your premier destination for memorable experiences and unforgettable parties in the heart of Cluj-Napoca!</p>

    <p>Euforia Events is a dedicated team of passionate professionals with a clear mission - to bring joy, fun, and magic to your special events. Based in the vibrant city of Cluj-Napoca, we specialize in organizing private, corporate, and special events, featuring diverse artists and internationally acclaimed entertainment.</p>

    <p>Whether it's an elegant corporate party, an intimate private event, or an energy-packed outdoor celebration, we are here to turn your dreams into reality. We work closely with our clients to create personalized experiences, blending our creativity with your visions.</p>

    <p>
        At Euforia Events, we collaborate with top artists from various fields: live music, DJs, dancers, illusionists, and more. We take pride in offering captivating shows and performances that delight and surprise the audience, adding a distinctive touch to our events.
    </p>
</body>
</html>
