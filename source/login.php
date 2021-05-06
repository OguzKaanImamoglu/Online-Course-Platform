<?php 
    $username_email_error = "";
    $password_error = "";
    session_start();

    include('sign-up/database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username_or_email = mysqli_real_escape_string($link,$_POST['username_or_email']);
        $password = mysqli_real_escape_string($link,$_POST['password']);

        $sql = "SELECT person_id, name, surname FROM person WHERE (email = '$username_or_email' OR 
                                                username = '$username_or_email') AND 
                                                password = '$password'";

        $result = mysqli_query($link,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
          
        $count = mysqli_num_rows($result);
          
        // If result matched $myusername and $mypassword, table row must be 1 row
        
        if($count == 1) {
            $person_id = $row['person_id'];
            $name = $row['name'];
            $surname = $row['surname'];

            $sql = "SELECT person_id, name, surname FROM person P, student S 
                    WHERE P.person_id=S.student_id AND S.student_id='$person_id'";

            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
          
            $count = mysqli_num_rows($result);

            if ($count == 1) { // The person is a student.
                $_SESSION["user-type"] = "student";
                header("Location: ./student/home.php");
            } else {
                $sql = "SELECT P.person_id, P.name, P.surname 
                        FROM person P, course_creator C
                        WHERE P.person_id=C.course_creator_id AND C.course_creator_id='$person_id'";

                $result = mysqli_query($link, $sql);
                $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                $count = mysqli_num_rows($result);

                if ($count == 1) { // The person is a course creator
                    $_SESSION['user-type'] = 'course-creator';
                    header("Location: ./course-creator/home.php");
                } else {
                    $_SESSION['user-type'] = 'admin';
                    header("Location: ./admin/home.php");
                }
            }
            $_SESSION['person_id'] = $person_id;
            $_SESSION['name'] = $name;
            $_SESSION['surname'] = $surname;
        } else {
            $username_email_error = "* Your Login Name or Password is invalid";
        }
    }
 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="login">
            <h1>Login</h1>
            <form action="" method="post">
                <label for="username">
                    <i class="fas fa-user"></i>
                </label>
                <input type="text" name="username_or_email" placeholder="Username or Email" id="username_or_email" required>
                <label for="password">
                    <i class="fas fa-lock"></i>
                </label>
                <input type="password" name="password" placeholder="Password" id="password" required>
                                <span class="error"><?php echo $username_email_error;?></span>
                <span class="error"><?php echo $password_error;?></span>
                <input type="submit" value="Login">

            </form>
        </div>
    </body>
</html>