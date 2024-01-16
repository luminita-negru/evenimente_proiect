<?php

class DBController {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "evenimente";
    private $conn;

    function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
    }

    public static function getConnection() {
        if (empty($this->conn)) {
            new Database();
        }
    }

    function getDBResult($query, $params = array())
    {
        $sql_statement = $this->conn->prepare($query);
    
        if (!$sql_statement) {
            die('Error in query: ' . $this->conn->error);
        }
    
        if (!empty($params)) {
            $this->bindParams($sql_statement, $params);
        }
    
        $sql_statement->execute();
        $result = $sql_statement->get_result();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
    
        if (!empty($resultset)) {
            return $resultset;
        }
    }
    

    function updateDB($query, $params = array()) {
        $sql_statement = $this->conn->prepare($query);

        if (!empty($params)) {
            $this->bindParams($sql_statement, $params);
        }

        $sql_statement->execute();
    }

    function bindParams($sql_statement, $params)
    {
        if (!empty($params)) {
            $param_type = "";
            $bind_params = [];
    
            foreach ($params as $query_param) {
                $param_type .= $query_param["param_type"];
                $bind_params[] = &$query_param["param_value"];
            }
    
            array_unshift($bind_params, $param_type);
    
            call_user_func_array(array($sql_statement, 'bind_param'), $bind_params);
        }
    }
      
}

?>
