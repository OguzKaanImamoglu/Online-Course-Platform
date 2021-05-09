<?php
    session_start();
	include('../sign-up/database.php');

	$person_id = $_SESSION['person_id'];
	$name = $_SESSION['name'];
	$surname = $_SESSION['surname'];

    //get refund request id
    $rid = $_GET['rid'];

    $sql = "UPDATE refund
            SET is_assessed = TRUE, is_approved = FALSE
            WHERE refund_id = '$rid'";
    $result = mysqli_query($link, $sql);

    if(!$result){
		echo '<script>alert("Refund rejection failed.");</script>';
	}
	else {
		echo '<script>alert("Refund request is rejected.");';
		echo 'document.location = "refund-requests.php";</script>';
	}
    mysqli_close($link);

?>