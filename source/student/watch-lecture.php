<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

$lecture_id = $_SESSION['lecture_id'];
$course_id = $_SESSION['course_id'];

# course name
# lecture name
$sql0 =  "SELECT course_name FROM course WHERE course_id= '$course_id' ";
$result0 = mysqli_query($link, $sql0);
$row0 = mysqli_fetch_array($result0,MYSQLI_ASSOC);

# lecture name
$sql1 =  "SELECT lecture_name, description FROM lecture WHERE lecture_id= '$lecture_id' AND course_id = '$course_id'";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);


# last lecture
$sql2 = "SELECT MAX(lecture_id) FROM lecture WHERE course_id= '$course_id'";
$result2 = mysqli_query($link, $sql2);
$row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
$islast = 0;

if($row2["MAX(lecture_id)"]== $lecture_id){
    $islast =1;
}

# first lecture
$sql3 = "SELECT MIN(lecture_id) FROM lecture WHERE course_id= '$course_id'";
$result3 = mysqli_query($link, $sql3);
$row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
$isfirst = 0;

if($row3["MIN(lecture_id)"]== $lecture_id){
    $isfirst =1;
}


if (isset($_POST['create'])) {
$note_text = $_POST['description'];
$sql4 = "INSERT INTO note(student_id, lecture_id, course_id, note_text) VALUES ('$person_id', '$lecture_id', '$course_id', '$note_text')";

    if (!mysqli_query($link, $sql4)) {
        echo "ERROR : COULD NOT BE ADDED" . mysqli_error($link);
    } else {
        $note_id = mysqli_insert_id($link);
        header("Location: watch-lecture.php");
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="../student/home.php">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../student/course-market.php">Course Market <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/my-courses.php">My Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/add-money.php">Add Money</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/myCertificates.php">My Certificates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Q&A/myQuestions.php">My Questions</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="course-page.php">Course Page</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="watch-lecture.php">Course Lectures</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>


<h3 class="display-5 mb-4">My Notes</h3>
<div class="dropdown " align=center>
    <button class="btn btn-dark btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Select Note
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <?php
        $query ="SELECT	lecture_id, note_text, note_id FROM note WHERE student_id='$person_id' AND lecture_id='$lecture_id'  AND course_id = '$course_id'";

        if (!$query) {
            printf("There is an error: %s\n", mysqli_error($link));
            exit();
        }
        $result = mysqli_query($link, $query);
        while($row = mysqli_fetch_array($result)){
            echo "<li><a href=\"#\" data-value=$row[note_id]>$row[note_text]</a></li></a>";
        }
        echo "</select>";
        ?>
    </ul>


</div>


<div class="container">
    <div class="col-xl-50" style="padding-left: 10px; margin-top: 20px;">



    <style>
        h3 {text-align: center;
            border: 3px solid green;}

        h4 {text-align: center;}
        h1 {text-align: center;}
        h2 {text-align: center;
            text-decoration: underline;}
        h5 {text-align: center;}
        h6 {text-align: center;}
        p {text-align: center;}
        /*div {text-align: center;}*/
    </style>

    <div class="jumbotron mt-4">
        <h1 class="display-5 mb-4 center"><?php echo $row0['course_name']?></h1>

    <img src="os.jpg" alt="Italian Trulli" class="center">
        <style>
        .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
        }
        </style>


        <p class="lead mt-4">
            <?php
            if($isfirst == 1)
            {
                echo "<button type='button' disabled class='btn btn-secondary float-left'  data-dismiss='modal'><<</button>";
            }

            else
            {
                echo "<button type='submit' onclick=\"location.href='pre-lecture.php'\" name='pre-lecture' class='btn btn-success float-left'><<</button>";
            }




            if($islast == 1)
            {
                echo "<button type='button' disabled class='btn btn-secondary float-right'  data-dismiss='modal'>>></button>";
            }

            else
            {
                echo "<button type='submit' onclick=\"location.href='next-lecture.php'\" name='next-lecture' class='btn btn-success float-right'>>></button>";
            }

//            echo"<a class="btn btn-dark btn-lg" href="next-lecture.php" role="button">>></a>";

            ?>

        <form action='' method='post' id='formHiddenInputValue' name='formHiddenInputValue'>
            <button type='button' class='btn btn-danger btn-lg' data-toggle='modal' id='play' name='play' value='play'>&#9658</button>
        </form>
        <style>
            form {
                text-align: center;
            }  margin-left: 40px;
            }

        </style>

        </p>
        <h2 class="display-5 mb-4 center"><?php echo $row1['lecture_name']?></h2>
        <h6 class="display-5 mb-4 center"><?php echo $row1['description']?></h6>
    </div>


</div>

    <form method="post">
        <div class="form-group">
            <label for="note">Take Note</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="You can take notes" required="required" maxlength="200"></textarea>
        </div>

        <button type="submit" name="create" id="create" class="btn btn-primary">Create Note</button>
        <div class="dropdown-divider"></div>

    </form>


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

<script>
    $(".dropdown-menu li a").click(function(){
        $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
        $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
    });

</script>

</html>


