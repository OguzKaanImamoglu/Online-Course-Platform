<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

$sql = "SELECT wallet FROM student WHERE student_id='$person_id'";

$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$wallet = $row["wallet"];
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
                <a class="nav-link" href="course-market.php">Course Market</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Notifications.php">Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="my-courses.php">My Courses</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="add-money.php">Add Money</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/myCertificates.php">My Certificates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Q&A/myQuestions.php">My Questions</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<style>
    h3 {text-align: center;
        text-decoration: underline;}
    td{text-align: center;}

    h4 {text-align: center;}
    h1 {text-align: center;}
    h2 {text-align: center;
        text-decoration: underline;}
    h5 {text-align: center;}
    h6 {text-align: center;}
    p {text-align: center;}
    /*div {text-align: center;}*/
</style>

<div class="container">
    <div class="jumbotron mt-4">
        <h3 class="display-5 mb-4">Refund Request Notifications</h3>
        <?php
$sql = "SELECT RR.course_id, RR.refund_id, R.is_approved FROM refund R, refund_requests RR WHERE RR.student_id = '$person_id' AND R.refund_id = RR.refund_id AND R.is_assessed = 1  ORDER BY r.refund_id DESC LIMIT 3";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo "There is no refund notifications found.";
    echo " " . $link -> error;
} else {
    $count = mysqli_num_rows($result);

    if ($count > 0) {

        while ($q_result = mysqli_fetch_array($result)) {
            $str = "";
            $name ="";
            $id = $q_result['course_id'];
            $sql1 = "SELECT course_name FROM course WHERE course_id = '$id'";
            $result1 = mysqli_query($link, $sql1);
            $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
            $course_name = $row1["course_name"];

            if ($q_result["is_approved"]==1)
            {
                $str = "Accepted";
            }
            else{
                $str = "Rejected";
            }


            echo '<td><br>'. "Your refund request for " . $course_name . " is " . $str . '</td>';


        }

    } else {
        echo "There is no refund notification found.";
    }
}
?>
        </p>
    </div>

    <div class="jumbotron mt-4">
        <h3 class="display-5 mb-4">Announcement Notifications</h3>
        <?php
        $sql = "SELECT DISTINCT c.course_id FROM announcement a, course c, enrolls e WHERE e.student_id = '$person_id' AND a.course_id = c.course_id AND e.course_id = c.course_id AND c.course_id = a.course_id ORDER BY a.announcement_id DESC LIMIT 3";
        $result = mysqli_query($link, $sql);

        if (!$result) {
            echo "There is no announcement notifications found.";
            echo " " . $link -> error;
        } else {
            $count = mysqli_num_rows($result);

            if ($count > 0) {

                while ($q_result = mysqli_fetch_array($result)) {
                    $str = "";
                    $name ="";
                    $id = $q_result['course_id'];
                    $sql1 = "SELECT course_name FROM course WHERE course_id = '$id'";
                    $result1 = mysqli_query($link, $sql1);
                    $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
                    $course_name = $row1["course_name"];



                    echo '<td><br>'. "New announcements for " . $course_name . '</td>';
                }

            } else {
                echo "There is no announcement notification found.";
            }
        }
        ?>
        </p>

    </div>
    <a class="btn btn-success btn-lg" href="home.php" role="button">Return Home</a>




</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
