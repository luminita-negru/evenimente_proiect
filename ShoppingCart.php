<?php

require_once "DBController.php";

class TicketCart extends DBController {

    function getAllTickets() {
        $query = "SELECT * FROM events";
        $ticketResult = $this->getDBResult($query);
        return $ticketResult;
    }

    function getMemberCartItem($userId) {
        $query = "SELECT events.*, tickets.ticketId as cart_id, tickets.nr_tickets FROM tickets, events WHERE events.eventId = tickets.eventId AND tickets.userId = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $userId
            )
        );

        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
    }

    function getEventById($eventId) {
        $query = "SELECT * FROM events WHERE eventId=?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventId
            )
        );

        $productResult = $this->getDBResult($query, $params);
        return $productResult;
    }

    function getCartItemByTicket($eventId, $userId) {
        $query = "SELECT * FROM tickets WHERE eventId = ? AND userId = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventId
            ),
            array(
                "param_type" => "i",
                "param_value" => $userId
            )
        );

        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
    }

    function addToCart($eventId, $nr_tickets, $userId) {
        $query = "INSERT INTO tickets (eventId, userId, nr_tickets) VALUES (?, ?, ?)";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventId
            ),
            array(
                "param_type" => "i",
                "param_value" => $userId
            ),
            array(
                "param_type" => "i",
                "param_value" => $nr_tickets
            )
        );

        $this->updateDB($query, $params);
    }

    function updateCartQuantity($nr_tickets, $cart_id) {
        $query = "UPDATE tickets SET nr_tickets = ? WHERE ticketId= ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $nr_tickets
            ),
            array(
                "param_type" => "i",
                "param_value" => $cart_id
            )
        );

        $this->updateDB($query, $params);
    }

    function deleteCartItem($cartId) {
        $query = "DELETE FROM tickets WHERE ticketId = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $cartId
            )
        );

        $this->updateDB($query, $params);
    }

    function emptyCart($userId) {
        $query = "DELETE FROM tickets WHERE userId = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $userId
            )
        );

        $this->updateDB($query, $params);
    }
}

?>
