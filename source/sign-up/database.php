<?php
/*    define('DB_SERVER', 'dijkstra.ug.bcc.bilkent.edu.tr');
    define('DB_USERNAME', 'can.alpay');
    define('DB_PASSWORD', 'lY38nY8F');
    define('DB_NAME', 'can_alpay');
*/


define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'project353');
    $charset = "utf8mb4";
    try {
        $link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $link -> set_charset($charset);
    } catch(\mysqli_sql_exception $e) {
        throw new \mysqli_sql_exception($e -> getMessage(), $e -> getCode());
    }

    if ($link -> connect_errno) {
        echo "Failed to connect to MySQL: " . $link -> connect_error;
        die("Could not connect: " . mysqli_connect_error());
    }
    
    if (!$link) {
        die("Link is empty");
    }
?>