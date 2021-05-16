<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$course_id = $_SESSION['course_id'];

$sql = "SELECT course_name FROM course WHERE course_id='$course_id'";

$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$course_name = $row['course_name'];

if (isset($_POST['sendQuestion'])) {
    $question= $_POST['question'];

    if($question == ""){
        $message = "Enter your question before sending!";
    }
    else {
        $sql = "INSERT INTO question(question_text, date) VALUES('$question', CURDATE())";

        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo "<script>alert('" . $link->error . "');</script>";
        }

        $question_id = mysqli_insert_id($link);

        $sql = "INSERT INTO asks(question_id,student_id, course_id) VALUES('$question_id', '$person_id','$course_id')";
        $result = mysqli_query($link, $sql);
         if (!$result) {
            echo "<script>alert('" . $link->error . "');</script>";
        }

        $message = "Question is sent to the teacher";

        header('location:q&aforcourse.php');

    }

    echo "<script>alert('$message');</script>";
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
    <a class="navbar-brand" href="../student/home.php">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Course Market </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Your Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/add-money.php">Add Money</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/myCertificates.php">Your Certificates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Q&A/myQuestions.php">Your Questions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/course-page.php">Course Page</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="jumbotron mt-4">
        <form action="" method="post">
            <h2 class="display-4">What do you want to ask in <?php echo "$course_name"?></h2>
            <!--<p class="lead">You can add money to your wallet below.</p>-->
            <hr class="my-4">
            <p class="lead">
                <i class="" aria-hidden="true"></i>
                <?php echo "Type your question below" ?>
            </p>
            <textarea id="question" name="question" rows="6" cols="100"></textarea>
            <p>
                <button type="submit" name="sendQuestion" class="btn btn-success btn-md mt-4" role="button">Submit your question</button>
                <a class="btn btn-success btn-md mt-4" href="q&aforcourse.php" role="button">Return Course Questions</a>
                <a class="btn btn-success btn-md mt-4" href="../student/course-page.php" role="button">Return to the Course Page</a>
                <a class="btn btn-success btn-md mt-4 float-right" href="../Q&A/myQuestions.php" role="button">Open Your Questions</a>

            </p>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>