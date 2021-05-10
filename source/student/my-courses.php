<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
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
        </ul>
    </div>
</nav>

<div class="container">
    <div class="jumbotron mt-4">
        <h3 class="display-5 mb-4">My Courses</h3>
        <hr class="my-4">
        <?php
        $sql = "SELECT co.course_id, co.course_name, co.course_creator_id, p.name, p.surname FROM course co, enrolls e, person p WHERE co.course_id = e. course_id 
                AND p.person_id = co.course_creator_id AND e.student_id='$person_id'";
        //$sql = "SELECT * FROM course";
        $result = mysqli_query($link, $sql);



        if (!$result) {
            echo "There is no course found.";
            echo " " . $link -> error;
        } else {
            $count = mysqli_num_rows($result);

            if ($count > 0) {
                echo /** @lang text */
                "<table class='table'>
							<thead>
							<th scope='col'>Course Id</th>
							<th scope='col'>Course Name</th>
							<th scope='col'>Instructor Name</th>
							</thead>
							<tbody>
							";

                while ($q_result = mysqli_fetch_array($result)) {
                    echo "<tr><th scope='row'>" . $q_result["course_id"] .
                        "</th><td>" . $q_result["course_name"] .
                        "</td><td>" . $q_result["name"]. " " . $q_result["surname"];
                    echo /** @lang text */
                        "<td>
                        <form action='' method='post' id='formHiddenInputValue' name='formHiddenInputValue'>

                            <input type='hidden' id='' name='cid' value='" . $q_result["course_id"] . "' />

                            <button type='button' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' id='submit'>
                                Course Page
                            </button>                        </form></td>";

                    echo "</td></tr>";

                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "There is no course found.";
            }
        }
        ?>
        <br></br>
    </div>
</div>
</html>

