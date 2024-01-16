<?php require_once "ShoppingCart.php";?>

<HTML>
<HEAD>
    <TITLE>Create ticket cart</TITLE>
    <link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
    <div>
        <div>
            <div class="txt-headinglabel">Events</div>
        </div>

        <?php
        $ticketCart = new TicketCart();
        $query = "SELECT * FROM events";
        $ticket_array = $ticketCart->getAllTickets($query);

        if (!empty($ticket_array)) {
            foreach ($ticket_array as $key => $value) {
        ?>
                <div>
                    <form method="post" action="cos.php?action=add&eventId=<?php echo $ticket_array[$key]["eventId"]; ?>">
                        <div>
                            <strong><?php echo $ticket_array[$key]["title"]; ?></strong>
                        </div>
                        <div>
                            <strong><?php echo $ticket_array[$key]["date"]; ?></strong>
                        </div>
                        <div><?php echo "$" . $ticket_array[$key]["price"]; ?></div>
                        <div>
                            <input type="text" name="nr_tickets" value="1" size="2" />
                            <input type="submit" value="Add to cart" class="btnAddAction" />
                        </div>
                    </form>
                </div>
        <?php
            }
        }
        ?>
    </div>
</BODY>
</HTML>
