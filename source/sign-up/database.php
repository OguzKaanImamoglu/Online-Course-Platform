<?php
    define('DB_SERVER', '');
    define('DB_USERNAME', '');
    define('DB_PASSWORD', '');
    define('DB_NAME', '');

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
