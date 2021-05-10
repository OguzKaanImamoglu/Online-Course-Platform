<?php 
    include('../sign-up/database.php');
    session_start();
	session_unset();
	session_destroy();  
	header("Location: login.php");
 ?>