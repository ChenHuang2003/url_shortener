<?php
class Connect{
    function ConnectToSQLDB(){
        $servername = "localhost:4306";
        $username = "urlshortener";
        $password = "urlshorten123";
        $database = "url_shortener";
    
        // Create connection
        $connect = new mysqli($servername, $username, $password, $database);
    
        // Check connection
        if ($connect->connect_error) {
            die("Connection failed: " . $connect->connect_error);
        }

        return $connect;
    }
}
?> 