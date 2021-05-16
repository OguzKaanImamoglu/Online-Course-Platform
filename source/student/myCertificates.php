<?php

session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];

$sql = "SELECT certificate_id, course_id FROM earns WHERE student_id = '$person_id'";

$result = mysqli_query($link, $sql);

$total_id = "#";

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
                <a class="nav-link" href="../student/course-market.php">Course Market</a>
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
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="jumbotron mt-4">
        <h1 class="display-4">Certificates</h1>
        <hr class="my-4">
        <p class="lead"></p>
        <?php

        if(!$result){
            echo "Error on trying to reach the certificates!";
            echo " " . $link -> error;
        }
        else{

            $count = mysqli_num_rows($result);
            if ($count > 0) {
                echo "<div><table class='table table-striped container-fluid' data-toggle='table' data-pagination='true' data-search='true' data-show-pagination-switch='true'>
                        <thead>
                                <th>Course Name</th>
                                <th>Date</th>
                        </thead>
                <tbody>";

                $i=0;
                while ($q_result = mysqli_fetch_array($result)) {
                    $search = $q_result['certificate_id'];
                    $course_search = $q_result['course_id'];

                    $sql_date_name = "SELECT cer.date FROM certificate cer WHERE cer.certificate_id = '$search'";
                    $result3 = mysqli_query($link, $sql_date_name);
                    $r = mysqli_fetch_array($result3);
                    $date = $r['date'];

                    $sql_date_name = "SELECT course_name FROM course WHERE course_id = '$course_search'";
                    $result3 = mysqli_query($link, $sql_date_name);
                    $r = mysqli_fetch_array($result3);
                    $course_name = $r['course_name'];

                    if($total_id == "#")     $total_id = $total_id . $course_search;
                    else        $total_id = $total_id . ",#" . $course_search;
                    echo
                    "<script>
                    alert($total_id);
                    </script>";

                    echo '<tr>';
                    echo '<td>' . $course_name . '</td>';
                    echo '<td>' . $date. '</td>';
                    echo '<td>'.
"<button  class='btn btn-primary' id = '$course_search' value = '$course_search'>View Certificate</button>".
"</td></tr>";
                    $i = $i+1;
                }
                echo "</tbody>";
                echo "</table></div>";
            } else {
                echo "You don't earn any Certificate!";
            }
        }
        ?>
        <br></br>
        <a class="btn btn-success btn-lg" href="../student/home.php" role="button">Return Home</a>




    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>


<script>
    var change_id = "<?php Print( $total_id); ?>";
        $(change_id).click(function(e){
$changed = $(this).val();
//alert($(this).val());
$.ajax({
type:"POST",
url:"saveCourseid.php",
data:{course_id: $changed},

success: function(result){
//alert('Rejected');
window.location.replace("get-certificate.php");
},
error: function(result) {
alert("Certificate Error");
}
});
});
</script>


</body>
</html>

