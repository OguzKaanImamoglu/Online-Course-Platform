<?php 
    session_start();
	echo $_SESSION['person_id'] . " " . $_SESSION['name'] . $_SESSION['surname'];

	$person_id = $_SESSION['person_id'];
	$name = $_SESSION['name'];
	$surname = $_SESSION['surname'];
 ?>
