<?php
require_once "ShoppingCart.php";
session_start();

// Dacă utilizatorul nu este conectat, redirecționează la pagina de autentificare
if (!isset($_SESSION['loggedin'])) {
    header('Location: indexuser.html');
    exit;
}

// Pentru membrii înregistrați
$userId = $_SESSION['id'];
$ticketCart = new TicketCart();

if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["nr_tickets"])) {
                $cartResult = $ticketCart->getCartItemByTicket($_GET["eventId"], $userId);
                if (!empty($cartResult)) {
                    // Modificare cantitate în coș
                    $newQuantity = $cartResult[0]["nr_tickets"] + $_POST["nr_tickets"];
                    $ticketCart->updateCartQuantity($newQuantity, $cartResult[0]["userId"]);
                } else {
                    // Adăugare în tabelul coș
                    
                    $ticketCart->addToCart($_GET["eventId"], $_POST["nr_tickets"], $userId);
                }
            }
            break;
        case "remove":
            // Ștergere o singură înregistrare
            $ticketCart->deleteCartItem($_GET["ticketId"]);
            break;
        case "empty":
            // Ștergere coș
            $ticketCart->emptyCart($userId);
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Creare coș permanent în PHP</title>
    <link href="style.css" type="text/css" rel="stylesheet" />
    <style>
      
    body {
        font-family: Arial, sans-serif;
        background-color: #4b0082; /* Dark violet background */
        color: black; /* White text */
        margin: 0;
        padding: 20px; /* Add some padding for better appearance */
    }

    h1 {
        font-size: 36px;
        text-align: center;
    }

    /* Styles for the cart */
    div {
        margin: 20px; /* Add margin to the cart container */
    }

    div > div {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #6a0572; /* Violet shade for the inner div */
        padding: 10px;
    }

    div table {
        width: 100%;
        margin-top: 20px;
        background-color: #fff; /* White background for the table */
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 15px;
        text-align: left;
    }

    th {
        background-color: #45062e; /* Darker violet for table headers */
        color: #fff;
    }

    td {
        border-bottom: #F0F0F0 1px solid;
    }

    td:last-child {
        border-bottom: none; /* Remove border for the last column */
    }

    .btnRemoveAction img {
        width: 20px;
        height: 20px;
    }

    /* Styles for the links */
    div a {
        display: block;
        margin-top: 10px;
        padding: 8px;
        text-align: center;
        text-decoration: none;
        color: #fff;
        background-color: #6a0572; /* Violet shade for the links */
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    div a:hover {
        background-color: #45062e; /* Darker violet on hover */
    }


    </style>
    <script async
  src="https://js.stripe.com/v3/buy-button.js">
</script>

<stripe-buy-button
  buy-button-id="buy_btn_1OFJ4QD39bWvVHiKN9JgP866"
  publishable-key="pk_test_51OFIk1D39bWvVHiKJHnKY589REZ3HRlfxLCh2DKOrz8mrY9StViL9MR8VB3oIlKS64xTkuEp3TWhFsvjPNv8RNm300ywDsa5qb"
>
</stripe-buy-button>
<script async
  src="https://js.stripe.com/v3/buy-button.js">
</script>

<stripe-buy-button
  buy-button-id="buy_btn_1OFJ2XD39bWvVHiKVKZSAjkA"
  publishable-key="pk_test_51OFIk1D39bWvVHiKJHnKY589REZ3HRlfxLCh2DKOrz8mrY9StViL9MR8VB3oIlKS64xTkuEp3TWhFsvjPNv8RNm300ywDsa5qb"
>
</stripe-buy-button>
</head>
<body>
    <div>
        <div>
            <div>Ticket Cart</div>
            <a id="btnEmpty" href="cos.php?action=empty">Empty Cart</a>
        </div>

        <?php
        $cartItem = $ticketCart->getMemberCartItem($userId);
        if (!empty($cartItem)) {
            $item_total = 0;
        ?>
        <table cellpadding="10" cellspacing="1">
            <tbody>
                <tr>
                    <th style="text-align: left;"><strong>Title</strong></th>
                    <th style="text-align: left;"><strong>Date</strong></th>
                    <th style="text-align: right;"><strong>Quantity</strong></th>
                    <th style="text-align: right;"><strong>Price</strong></th>
                    <th style="text-align: center;"><strong>Action</strong></th>
                </tr>
                <?php
                foreach ($cartItem as $item) {
                ?>
                <tr>
                    <td style="text-align: left; border-bottom: #F0F0F0 1px solid;"><strong><?php echo $item["title"]; ?></strong></td>
                    <td style="text-align: left; border-bottom: #F0F0F0 1px solid;"><?php echo $item["date"]; ?></td>
                    <td style="text-align: right; border-bottom: #F0F0F0 1px solid;"><?php echo $item["nr_tickets"]; ?></td>
                    <td style="text-align: right; border-bottom: #F0F0F0 1px solid;"><?php echo "$" . $item["price"]; ?></td>
                    <td style="text-align: center; border-bottom: #F0F0F0 1px solid;">
                        <a href="cos.php?action=remove&ticketId=<?php echo $item["cart_id"]; ?>" class="btnRemoveAction">
                        DELETE
                        </a>
                    </td>
                </tr>
                <?php
                    $item_total += ($item["price"] * $item["nr_tickets"]);
                }
                ?>
                <tr>
                    <td colspan="3" align="right"><strong>Total:</strong></td>
                    <td align="right"><?php echo "$" . $item_total; ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <?php
        }
        ?>
    </div>

    <div><a href="ticket.php">Choose another event</a></div>
    <div><a href="logout_user.php">Leave the session</a></div>
</body>
</html>
