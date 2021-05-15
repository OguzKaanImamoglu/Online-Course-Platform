<?php

session_start();

include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];

if(isset($_POST['question_id'])) {
    $_SESSION['question_id'] = $_POST['question_id'];
}

$question_id = $_SESSION['question_id'];

//echo "<script>alert('$question_id');</script>";

$sql = "SELECT question_text FROM question WHERE question_id='$question_id'";

$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$question_text = $row['question_text'];


$sql = "SELECT answer_text FROM answers WHERE question_id = '$question_id'";

$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$question_answer = $row['answer_text'];


if (isset($_POST['sendAnswer'])) {
    $answer= $_POST['answer'];

    if($answer == ""){
        $message = "Enter answer before sending!";
    }
    else {
        $sql = "UPDATE answers SET answer_text = '$answer' WHERE question_id = '$question_id'";

        $result = mysqli_query($link, $sql);

        $message = "Answer saved";
    }

    //echo "<script>alert('$message');</script>";
    header("Refresh:0");
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../course-creator/discount-offers.php">Discount Offers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../course-creator/publish-course.php">Publish New Course</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="jumbotron mt-4">
        <form action="" method="post">
            <h2 class="display-4">Answer</h2>
            <!--<p class="lead">You can add money to your wallet below.</p>-->
            <hr class="my-4">
            <p class="lead">
                <i class="" aria-hidden="true"></i>
                <?php echo "Question is: $question_text" ?> </p><p class = 'lead'><b>
                    <?php echo "Answer: $question_answer" ?></b>
            </p>
            <textarea id="answer" name="answer" rows="6" cols="100"></textarea>
            <p>
                <button type="submit" name="sendAnswer" class="btn btn-success btn-md mt-4" role="button">Submit Answer</button>
                <a class="btn btn-success btn-md mt-4" href="course_creator_view_Questions.php" role="button">Return Course Questions</a>
            <a class="btn btn-success btn-md mt-4 float-right" href="#" role="button">Return Course Page</a>

            </p>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>