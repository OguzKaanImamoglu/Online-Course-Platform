<?php
// define variables and set to empty values
$passErr = "";
$usernameErr = "";
$first_name = "";
$duplicate_email = "";
$duplicate_username = "";

if (isset($_POST['save'])) {
  extract($_POST);
  if ($_POST["password"] != $_POST["cpass"]) {
     $passErr = "Passwords should match";
  } 
  else {
    extract($_POST);

    include("database.php");

    $first_name = ucfirst($first_name);
    $last_name = ucfirst($last_name);

//    echo "\nemail: " . $email . "\n";
//    echo "\nusername: " . $username . "\n";
//    echo "\nfirst_name " . $first_name . "\n";
//    echo "\nlast_name " . $last_name . "\n";
//    echo "\npassword " . $password . "\n";
//    echo "\ncpass " . $cpass . "\n";
//    echo "\nbirth: " . $date_of_birth . "\n";

    $sql = "INSERT INTO person (username, email, name, surname, password, date_of_birth)
            VALUES ('$username', '$email', '$first_name', '$last_name', '$password', '$date_of_birth')";

    if (!mysqli_query($link, $sql)) {
//        echo "ERROR : COULD NOT BE ADDED" . mysqli_error($link);
        if ( strpos(mysqli_error($link), 'username')) {
            $duplicate_username = "* Username already exists.";
        }

        if ( strpos(mysqli_error($link), 'email')) {
            $duplicate_email = "* Email already exists.";
        }
    } else {
        echo " SUCCESSFULLY ADDED ";
        $person_id = mysqli_insert_id($link);
        echo " Person id: " . $person_id;

        $sql = "INSERT INTO course_creator(course_creator_id, wallet, RATING) VALUES ('$person_id', '0', '0')";

        if ( !mysqli_query($link, $sql) ) {
            echo "ERROR : COULD NOT BE ADDED " . mysqli_error($link);
        } else {
            header("Location: ../index.php");
        }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <title>Coursemy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
      $( function() {
        $( "#datepicker" ).datepicker();
    } );
</script>
</head>
<body>
    <div class="container">
        <div class="signup-form">
            <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <h2>Sign Up to Coursemy</h2>
                <h5>As a Course Creator</h5>
                <button id="myBtn" class="btn btn-primary btn-lg" style="margin-bottom: 1em;">Register as a Student</button>
                  <script>
                    var btn = document.getElementById('myBtn');
                    btn.addEventListener('click', function() {
                      document.location.href = '<?php echo "student.php"; ?>';
                    });
                  </script>
                <div class="form-group">
                    <div class="row">
                        <div class="col"><input type="text" class="form-control" name="first_name" placeholder="First Name" pattern="[a-zA-Z]{1,}" title="First name must contain only letters." required="required"></div>
                        <div class="col"><input type="text" class="form-control" name="last_name" placeholder="Last Name" pattern="[a-zA-Z]{1,}" title="Last name must contain only letters." required="required"></div>
                    </div>          
                </div>
                <div class="form-group">
                    <input type="username" pattern="\s*(\S\s*){6,24}" title="Username must contain at least 6 characters, and at most 24 characters. If there is any space character, remove it." class="form-control" name="username" placeholder="Username" required="required">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email" required="required">
                </div>
                <label for="date_of_birth">Date of Birth: </label>
                <input type="date" id="date_of_birth" name="date_of_birth" required="required">
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" id="password" required="required">
                </div>
                <div class="form-group">
                    <input type="password" id="confirm_password" class="form-control" name="cpass" placeholder="Confirm Password" required="required">
                </div>     
                <span class="error"><?php echo $passErr;?></span>
                <span class="error"><?php echo $usernameErr;?></span>
                <span class="error"><?php echo $duplicate_username;?></span>
                <span class="error"><?php echo $duplicate_email;?></span>
                <div class="form-group">
                    <button type="submit" name="save" class="btn btn-success btn-lg btn-block">Register Now</button>
                </div>
                <div class="text-center">Already have an account? <a href="../index.php">Login</a></div>
            </form>
        </div>
    </div>
</body>
</html>