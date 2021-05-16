<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$course_id = $_SESSION['course_id'];

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
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="jumbotron mt-4">
        <p action="" method="post">
            <h2 class="display-4">Your Comments Matter</h2>
            <hr class="my-4">
            <p class="lead">
                <i class="" aria-hidden="true"></i>
            <div class="form-group"><div>
                    <?php
                        $html = "";
                        $sql = "SELECT feedback_id FROM student_feedbacks WHERE student_id = '$person_id' AND course_id = '$course_id'";

                        $result = mysqli_query($link, $sql);
                        if(!$result){
                            echo "SQL ERROR";
                        }else{
                            $count = mysqli_num_rows($result);

                            if($count == 0){
                                $field = "$". "_SESSION['comment']";

                                echo"<label for='rating'>Your Rating</label>
                    <input type='number' class='form-control' id='rating' name='rating' min='0' max='5'  required='required'>
                    <p>Your Comment</p>
            <textarea id='comment' name='comment' rows='6' cols='100'></textarea>
            <p>
               <div class='text-center'>
                <button type='button' class='btn btn-success btn-md mt-4 middle'  id='submit' name='submit' value='submit' role='button'>Send Your Feedback</button></div></p>";

                            }
                            else{
                                $row = mysqli_fetch_array($result);
                                $f_id = $row['feedback_id'];


                                $sql = "SELECT feedback_note, rating FROM feedback WHERE feedback_id = '$f_id'";

                                $result = mysqli_query($link,$sql);
                                if(!$result){
                                    echo "Error occurred";
                                }
                                $row = mysqli_fetch_array($result);

                                $rating = $row['rating'];
                                $f_text = $row['feedback_note'];
                                echo "<label>Your Rating: $rating</label>
                                   <p>Your Comment</p><p>$f_text</p><p>
<div class='text-center'>
                <button type='button' class='btn btn-success btn-md mt-4'  id='$f_id' name='$f_id' value='$f_id' role='button'>Change Your Feedback</button></div>
                            
            </p>";
                            }
                        }
                        ?>
                    <button type="submit" class='btn btn-success btn-mg' onclick="location.href = 'course-page.php'">Return to the Course Page</button>
                </div></div></p>
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
    let total_id = "#<?php Print( $f_id); ?>";
    let pr = "<?php print($_SESSION['float']);?>";

    $("#submit").click(function(e) {
        text = document.getElementById("comment").value;
        rate = document.getElementById("rating").value;
        //alert(text);
        //alert(rate);
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "insertfeedback.php",
            data: {
                feedback_note: text,
                rating: rate
            },
            success: function (result) {
                alert('Successfully send your feedback!');
                location.reload();
            },
            error: function (result) {
                alert("Couldn't send the feedback");
            }
        });
    });

    $(total_id).click(function(e) {
        $id = $(this).val();
        //alert(document.getElementById($text).value);
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "feedback_id.php",
            data: {
                feedback_id: $id
            },
            success: function(result) {
                //alert('Approved');
                window.location.replace("changefeedback.php");
            },
            error: function(result) {
                alert("Couldn't change the feedback");
            }
        });
    });

</script>



</body>
</html>

