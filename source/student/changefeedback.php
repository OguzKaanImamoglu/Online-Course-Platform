<?php


session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$course_id = $_SESSION['course_id'];

$f_id = "";
//$aa  = $_SESSION['float'] ;
//echo "<script>alert($aa);</script>";

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
                <a class="nav-link" href="../student/course-market.php">Course Market </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Notifications.php">Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/my-courses.php">Your Courses</a>
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
                <a class="nav-link" href="course-page.php">Course Page</a>
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
            <h2 class="display-4">Change Comment</h2>
            <!--<p class="lead">You can add money to your wallet below.</p>-->
            <hr class="my-4">
            <p class="lead">
                <i class="" aria-hidden="true"></i>
            <div class="form-group"><p>
                    <?php
                    $sql = "SELECT s.feedback_id, f.feedback_note, f.rating FROM student_feedbacks s,feedback f WHERE f.feedback_id = s.feedback_id AND s.course_id = '$course_id' AND student_id = '$person_id'";

                    $result = mysqli_query($link, $sql);
                    $row=mysqli_fetch_array($result);

                    $rating = $row['rating'];
                    $f_Text = $row['feedback_note'];
                    $f_id = $row['feedback_id'];
                    if(!$result){
                        echo "SQL ERROR" . $link->error;
                    }else {
                        echo "<label for='rating'>Your Rating </label>
                    <input type='number' class='form-control' id='rating' name='rating' min='0' max='5' value='$rating' required='required'>
                    <p>Your Comment</p>
            <textarea id='comment' name='comment' rows='6' cols='120'>$f_Text</textarea>
            <p>
               <div class='text-center'>
                <button class='btn btn-success btn-mg mt-4 middle'  id='update' name='update'>Send Your Feedback</button></div></p>";
                    }
                    ?>
                    <button type='button' class='btn btn-success btn-mg' onclick="location.href = 'course-page.php'" role='button'>Return to the Course Page</button>
                        </p>
            </div>
        </form>
    </div>
    </p>
    </form>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>


<script>
    let id = "<?php Print($f_id); ?>";

    $("#update").click(function(e) {

        text = document.getElementById("comment").value;
        rate = document.getElementById("rating").value;
        //alert(id);
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "updatefeedback.php",
            data: {
                feedback_id: id,
                feedback_note: text,
                rating: rate
            },
            success: function (result) {
                //alert(id);
                window.location.replace("feedback.php");
            },
            error: function (result) {
                alert("Couldn't send the feedback");
            }
        });
    });

</script>



</body>
</html>
