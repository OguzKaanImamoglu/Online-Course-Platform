<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];

$course_id = $_SESSION['course_id'];
$course_id = 4;

$sql = "SELECT course_name FROM course WHERE course_id = '$course_id'";
$result = mysqli_query($link,$sql);

$row = mysqli_fetch_array($result);
$course_name = $row['course_name'];

$sql = "SELECT A.question_id, Q.question_text FROM asks A, question Q 
        WHERE A.course_id = '$course_id' AND A.question_id = Q.question_id";

$sql2 = "SELECT A.question_id FROM asks A WHERE A.course_id = '$course_id'";

$result = mysqli_query($link,$sql2);

$count = mysqli_num_rows($result);

$val = $_REQUEST['request'];

/*
if($count > 0){
    while($button_ids = mysqli_fetch_array($result)){
        $message = "";
        $ans = "sendAnswer_". $button_ids['question_id'];
        $q_id = $button_ids['question_id'];
        if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$ans] )) {

            $name = 'newAnswer_' . $q_id;
            $answer = $_REQUEST[$name];

            if ($answer == "") {
                $message = 'Enter your answer before sending!';
            } else {
                $sql = "INSERT INTO answers(question_id, course_creator_id, answer_text) VALUES( '$q_id','$person_id' , '$answer')";
                $result3 = mysqli_query($link, $sql);
                $message = "Question answered";
            }
        }
        $ans = "updateAnswer_" . $q_id;
        if (isset($_POST[$ans])) {
            echo "<script>alert('$q_id');</script>";
        }
        echo "<script>alert('$message');</script>";

    }
}else{
    echo 'BBB';
}
*/

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
                <a class="nav-link" href="../course-creator/discount-offers.php">Discount Offers<span class="sr-only">(current)</span></a>
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
<script type="text/javascript">
    function newAnswer(question_id){
        document.cookie = "front =" + question_id;

        /*
        if(question_id === ""){
            alert("Please enter answer before sending!");
            return false;
        }
        var search = "newAnswer_" + question_id;
        var answer = document.getElementById(search).value;

        $.wait = true;
        alert(answer);
        alert(search);

        $('#sql').val() = "INSERT INTO answers(question_id, course_creator_id, answer_text) VALUES(" + question_id + "," + $('#person_id').val() +","+ answer + ")";

        alert("New answer added!");
    */}


</script>

<div class="container">
    <div class="jumbotron mt-4">
        <h1 class="display-4"><?php echo "$course_name"?> </h1>
        <hr class="my-4">
        <p class="lead"></p>
        <?php
        $result = mysqli_query($link,$sql);

        if(!$result){
            echo "Error on trying to reach the questions!";
            echo " " . $link -> error;
        }
        else{

            $count = mysqli_num_rows($result);
            //echo "$count2";
            if ($count > 0) {
                echo "<div><table class='table table-striped container-fluid' data-toggle='table' data-pagination='true' data-search='true' data-show-pagination-switch='true'>
                        <thead>
                                <th>Questions</th>
                        </thead>
                <tbody>";

                $i=0;
                $j = 0;
                $k = 0;
                while ($q_result = mysqli_fetch_array($result)) {
                    $search = $q_result['question_id'];

                    $sql = "SELECT A.answer_text FROM answers A WHERE A.question_id = '$search'";

                    $result3 = mysqli_query($link, $sql);
                    $count2 = mysqli_num_rows($result3);

                    if ($count2 == 0) {

                        $html ="<div>
                            <textarea id='newAnswer_$search' name='newAnswer_$search' rows='6' cols='100'></textarea>
                            <button type='submit' name='sendAnswer_$search' class='btn btn-success btn-md mt-4' role='button'>Submit answer</button>
                            </div>";
                    }
                    else{
                        $q_result2 = mysqli_fetch_array($result3);

                        $html = "<div>" .
                            $q_result2['answer_text']
                            . "</div><div><button type='submit' name='updateAnswer_$search' class='btn btn-success btn-md mt-4' role='button'>Change answer</button>
</div>";
                    }

                    echo "<tr data-toggle='collapse' data-target='#collapsedRow_$i' class='accordion-toggle'><td>" . $q_result["question_text"] .
                        "</td><td>" . "<a class=\"btn btn-primary accordion-toggle collapsed\" data-parent='#accordion2' data-toggle=\"collapse\" data-target=\"#collapseOne_$i\" href=\"#collapseOne_$i\" >Answer</a></td>" .
                        "</tr><tr><td coldspan='12' class='hiddenRow' ><div class='accordion-body collapse' id='collapsedRow_$i'>
                        $html</div></td></tr>";
                    //"<button type='button' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' id='submit'> Answer</button>";
                    //"<a class 'btn btn-success btn-lg' href='publish-course.php' data-toggle='modal' data-target='#exampleModal' id='submit' type = \"button\">See the answer</a>";

                    $i = $i+1;
                }
                echo "</tbody>";
                echo "</table></div>";
            } else {
                echo "No one asked any question at the moment.";
            }

            function func(){

                echo "<script>alert('AAAAAASDASD');</script>";
            }
        }
        ?>
        <br></br>
        <!--<a class="btn btn-success btn-lg" href="publish-course.php" role="button">Return to the Course Page</a>-->
        <a class="btn btn-success btn-lg ml-4" href="#" role="button">Return Course</a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

