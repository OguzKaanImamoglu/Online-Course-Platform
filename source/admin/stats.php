<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

$sql1 =  "SELECT COUNT(*) FROM student";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$studentcount = $row1["COUNT(*)"];


$sql1 =  "SELECT COUNT(*) FROM course_creator";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$instructorcount = $row1["COUNT(*)"];

$sql1 =  "SELECT COUNT(*) FROM course";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$coursecount = $row1["COUNT(*)"];


$sql1 = "SELECT course_id, COUNT(course_id) AS occurence FROM enrolls GROUP BY course_id ORDER BY occurence DESC LIMIT 1";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$popular_id = $row1["course_id"];

$sql1 = "SELECT course_name FROM course WHERE course_id = '$popular_id'";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$popular_course = $row1["course_name"];

$sql1 = "SELECT course_name
FROM course
WHERE average_rating = (SELECT MAX(average_rating) FROM course)";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$best_course = $row1["course_name"];

$sql1 = "SELECT course_name
FROM course
WHERE average_rating = (SELECT MIN(average_rating) FROM course)";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$worst_course = $row1["course_name"];


$sql1 = "SELECT name, surname FROM person WHERE person_id = (SELECT course_creator_id
FROM course_creator
WHERE RATING = (SELECT MIN(RATING) FROM course_creator))";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$worst_name = $row1["name"];
$worst_surname = $row1["surname"];


$sql1 = "SELECT name, surname FROM person WHERE person_id = (SELECT course_creator_id
FROM course_creator
WHERE RATING = (SELECT MAX(RATING) FROM course_creator))";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$best_name = $row1["name"];
$best_surname = $row1["surname"];


$sql1 =  "SELECT COUNT(*) FROM refund WHERE is_approved <> 1";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$pending = $row1["COUNT(*)"];



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
                <a class="nav-link" href="refund-requests.php">Refund Requests<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="discount-courses.php">Discounts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="stats.php">Stats</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>


<style>

    h2 {text-align: center;
        text-decoration: underline;}
    /*div {text-align: center;}*/
</style>


<div class="container">
    <div class="jumbotron mt-4">
        <h2 class="display-5 mb-4">Stats</h2>

        <p class="lead mt-4" style="padding-left: 70px; margin-top: 50px;">
        <table>
            <tr><td>
                    <div align="left"><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
                            <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                            <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg></td></div>
                </td><td>
                    <div align="right"><h3 class="display-5 mb-4">Student Count: <?php echo $studentcount?> </h3></div>
                </td></tr>
        </table>
    </p>

    <p class="lead mt-4" style="padding-left: 70px; margin-top: 50px;">
    <table>
        <tr><td>
                <div align="left"><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                    </svg></td></div>
        </td><td>
            <div align="right"><h3 class="display-5 mb-4">Instructor Count: <?php echo $instructorcount?> </h3></div>
        </td></tr>
    </table>
</p>


<p class="lead mt-4" style="padding-left: 70px; margin-top: 50px;">
<table>
    <tr><td>
            <div align="left"><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                </svg></td></div>
        </td><td>
            <div align="right"><h3 class="display-5 mb-4">Total Courses in the System: <?php echo $coursecount?> </h3></div>
        </td></tr>
</table>
</p>


<p class="lead mt-4" style="padding-left: 70px; margin-top: 50px;">
<table>
    <tr><td>
            <div align="left"><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-emoji-heart-eyes" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M11.315 10.014a.5.5 0 0 1 .548.736A4.498 4.498 0 0 1 7.965 13a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .548-.736h.005l.017.005.067.015.252.055c.215.046.515.108.857.169.693.124 1.522.242 2.152.242.63 0 1.46-.118 2.152-.242a26.58 26.58 0 0 0 1.109-.224l.067-.015.017-.004.005-.002zM4.756 4.566c.763-1.424 4.02-.12.952 3.434-4.496-1.596-2.35-4.298-.952-3.434zm6.488 0c1.398-.864 3.544 1.838-.952 3.434-3.067-3.554.19-4.858.952-3.434z"/>
                </svg></td></div>
        </td><td>
            <div align="right"><h3 class="display-5 mb-4">Most Popular Course: <?php echo $popular_course?> </h3></div>
        </td></tr>
</table>
</p>


<p class="lead mt-4" style="padding-left: 70px; margin-top: 50px;">
<table>
    <tr><td>
            <div align="left"><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                    <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                </svg></td></div>
        </td><td>
            <div align="right"><h3 class="display-5 mb-4">Best Course: <?php echo $best_course?> </h3></div>
        </td></tr>
</table>
</p>


<p class="lead mt-4" style="padding-left: 70px; margin-top: 50px;">
<table>
    <tr><td>
            <div align="left"><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-hand-thumbs-down" viewBox="0 0 16 16">
                    <path d="M8.864 15.674c-.956.24-1.843-.484-1.908-1.42-.072-1.05-.23-2.015-.428-2.59-.125-.36-.479-1.012-1.04-1.638-.557-.624-1.282-1.179-2.131-1.41C2.685 8.432 2 7.85 2 7V3c0-.845.682-1.464 1.448-1.546 1.07-.113 1.564-.415 2.068-.723l.048-.029c.272-.166.578-.349.97-.484C6.931.08 7.395 0 8 0h3.5c.937 0 1.599.478 1.934 1.064.164.287.254.607.254.913 0 .152-.023.312-.077.464.201.262.38.577.488.9.11.33.172.762.004 1.15.069.13.12.268.159.403.077.27.113.567.113.856 0 .289-.036.586-.113.856-.035.12-.08.244-.138.363.394.571.418 1.2.234 1.733-.206.592-.682 1.1-1.2 1.272-.847.283-1.803.276-2.516.211a9.877 9.877 0 0 1-.443-.05 9.364 9.364 0 0 1-.062 4.51c-.138.508-.55.848-1.012.964l-.261.065zM11.5 1H8c-.51 0-.863.068-1.14.163-.281.097-.506.229-.776.393l-.04.025c-.555.338-1.198.73-2.49.868-.333.035-.554.29-.554.55V7c0 .255.226.543.62.65 1.095.3 1.977.997 2.614 1.709.635.71 1.064 1.475 1.238 1.977.243.7.407 1.768.482 2.85.025.362.36.595.667.518l.262-.065c.16-.04.258-.144.288-.255a8.34 8.34 0 0 0-.145-4.726.5.5 0 0 1 .595-.643h.003l.014.004.058.013a8.912 8.912 0 0 0 1.036.157c.663.06 1.457.054 2.11-.163.175-.059.45-.301.57-.651.107-.308.087-.67-.266-1.021L12.793 7l.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315l-.353-.354.353-.354c.047-.047.109-.176.005-.488a2.224 2.224 0 0 0-.505-.804l-.353-.354.353-.354c.006-.005.041-.05.041-.17a.866.866 0 0 0-.121-.415C12.4 1.272 12.063 1 11.5 1z"/>
                </svg></td></div>
        </td><td>
            <div align="right"><h3 class="display-5 mb-4">Worst Course: <?php echo $worst_course?> </h3></div>
        </td></tr>
</table>
</p>

<p class="lead mt-4" style="padding-left: 70px; margin-top: 50px;">
<table>
    <tr><td>
            <div align="left"><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                </svg></td></div>
        </td><td>
            <div align="right"><h3 class="display-5 mb-4">Best Instructor: <?php echo $best_name, " ", $best_surname?> </h3></div>
        </td></tr>
</table>
</p>


<p class="lead mt-4" style="padding-left: 70px; margin-top: 50px;">
<table>
    <tr><td>
            <div align="left"><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                </svg></td></div>
        </td><td>
            <div align="right"><h3 class="display-5 mb-4">Worst Instructor: <?php echo $worst_name, " ", $worst_surname?> </h3></div>
        </td></tr>
</table>
</p>


<p class="lead mt-4" style="padding-left: 70px; margin-top: 50px;">
<table>
    <tr><td>
            <div align="left"><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                </svg></td></div>
        </td><td>
            <div align="right"><h3 class="display-5 mb-4">Pending Refund Requests: <?php echo $pending?> </h3></div>
        </td></tr>
</table>
</p>

<style>

    .center {
        margin: 0;
        position: absolute;
        top: 75%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
</style>

<div class="center">
<button type='submit' onclick="location.href='home.php'" name='home' class='btn btn-success btn-lg float.right'>Go to Home</button>";
</div>



    </div>

</div>
</body>
</html>
