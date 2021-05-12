<?php
    session_start();
	include('../sign-up/database.php');

	$person_id = $_SESSION['person_id'];
	$name = $_SESSION['name'];
	$surname = $_SESSION['surname'];

    //get discount id
    $did = $_GET['did'];

    $sql = "DELETE FROM discount
            WHERE discount_id = '$did'";

    $result = mysqli_query($link, $sql);

    if(!$result){
		echo '<script>alert("Discount offer cancellation failed.");</script>';
	}
	else {
		echo '<script>alert("Discount offer is successfully cancelled.");';
		echo 'document.location = "pending-offers.php";</script>';
	}
    mysqli_close($link);
?>