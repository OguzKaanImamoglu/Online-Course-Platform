<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

$lecture_id = $_SESSION['lecture_id'];
$course_id = $_SESSION['course_id'];

# lecture name
$sql1 =  "SELECT lecture_name FROM lecture WHERE lecture_id= '$lecture_id' ";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);


# last lecture

# first lecture





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="home.php">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="course-market.php">Course Market<span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="my-courses.php">My Courses<span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="add-money.php">Add Money</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Q&A/myQuestions.php">My Questions</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="course-page.php">Course Page</a>
            </li>

        </ul>
    </div>
</nav>

<div class="container">
    <div class="jumbotron mt-4">
        <h3 class="display-5 mb-4"><?php echo $row1['lecture_name']?></h3>
    <img src="os.jpg" alt="Italian Trulli">
        <form action='' method='post' id='formHiddenInputValue' name='formHiddenInputValue'>
            <button type='button' class='btn btn-success' data-toggle='modal' id='play' name='play' value='play'>Play</button>
        </form>

        <p class="lead mt-4">
            <a class="btn btn-success btn-lg" href="pre-lecture.php" role="button">Previous Lecture</a>
            <a class="btn btn-success btn-lg" href="next-lecture.php" role="button">Next Lecture</a>
        </p>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>

    <script>
        var lecture = "<?php Print( $lecture_id); ?>";

        $("#play").click(function(e){
        e.preventDefault();
          $.ajax({
                type: "POST",
                url: "set-progress.php",
                data: { lecture_watch: lecture},
                error: function(msg) {
                    alert("There is a problem about lecture");
                }
            });
        });
    </script>




</html>


