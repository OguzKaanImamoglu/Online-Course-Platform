<?php 
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

$lecture_error = "";

if (isset($_POST['publish'])) {

	if (count($_SESSION['lecture_array']) == 0) {
		$lecture_error = "* You must create at least 1 lecture to create a course.";
	} else {
		$course_name = $_POST['course-name'];
		$price = $_POST['price'];
		$language = $_POST['language'];
		$category = $_POST['category'];
		$description = $_POST['description'];
		$cert_price = $_POST['certificate-price'];

		$sql = "INSERT INTO course(course_name, language, course_price, create_date, average_rating, category, course_description, certificate_price, course_creator_id)
		VALUES ('$course_name', '$language', '$price', CURDATE(), '0', '$category', '$description', '$cert_price', '$person_id')";

		if (!mysqli_query($link, $sql)) {
			echo "ERROR : COULD NOT BE ADDED" . mysqli_error($link);
		} else {
			$course_id = mysqli_insert_id($link);

			for ($i = 0; $i < count($_SESSION['lecture_array']); $i++) {
				$lecture_name = $_SESSION['lecture_array'][$i]->lecture_name;
				$lecture_description = $_SESSION['lecture_array'][$i]->lecture_description;
				$lecture_duration = $_SESSION['lecture_array'][$i]->lecture_duration;

				$sql = "INSERT INTO lecture(course_id, lecture_id, lecture_name, duration, description) 
						VALUES ('$course_id', '$i', '$lecture_name', '$lecture_duration', '$lecture_description')";

				if (!mysqli_query($link, $sql)) {
					echo "ERROR : COULD NOT BE ADDED" . mysqli_error($link);
				}	
			}

			for ($i = 0; $i < count($_SESSION['assignment_array']); $i++) {
				$assignment_question = $_SESSION['assignment_array'][$i]->assignment_question;
				$assignment_threshold = $_SESSION['assignment_array'][$i]->assignment_threshold;

				$sql = "INSERT INTO assignment(assignment_question, assignment_threshold, course_id)
						VALUES  ('$assignment_question', '$assignment_threshold', '$course_id')";

				if (!mysqli_query($link, $sql)) {
					echo "ERROR : COULD NOT BE ADDED" . mysqli_error($link);
				}
			}
			header("Location: home.php");
		}

		$_SESSION['lecture_array'] = array();
		$_SESSION['assignment_array'] = array();
	}
}
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
					<a class="nav-link" href="discount-offers.php">Discount Offers<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="">Publish New Course</a>
				</li>
			</ul>
		</div>
	</nav>
	<h1 class="display-4 text-center mt-4 mb-4">New Course</h1>
	<div class="container">
		<form method="post">
			<div class="form-group">
				<label for="formGroupExampleInput">Course Name</label>
				<input type="text" class="form-control" id="course-name" name="course-name" placeholder="Enter Course Name" required="required" maxlength="60">
			</div>
			<div class="form-group">
				<label for="price">Price (between 0 and 500):</label>
				<input type="number" class="form-control" id="price" name="price" min="0" max="500" value="0" required="required">
			</div>
			<div class="form-group">
				<label for="language">Language</label>
				<select name="language" class="custom-select" required>
					<option value="">Select Language of the Course</option>
					<option value="English">English</option>
					<option value="Turkish">Turkish</option>
					<option value="German">German</option>
				</select>
			</div>
			<div class="form-group">
				<label for="category">Category</label>
				<select name="category" class="custom-select" required>
					<option value="">Select the Category of the Course</option>
					<option value="Web Development">Web Development</option>
					<option value="Mobile Software Development">Mobile Software Development</option>
					<option value="Programming Languages">Programming Languages</option>
					<option value="Game Development">Game Development</option>
					<option value="Database Management System">Database Management System</option>
					<option value="Business">Business</option>
					<option value="Management">Management</option>
					<option value="Economics">Economics</option>
					<option value="Finance">Finance</option>
					<option value="Information Technology">Information Technology</option>
					<option value="Cyber Security">Cyber Security</option>
					<option value="Gastronomy">Gastronomy</option>
					<option value="Maths">Maths</option>
					<option value="Others">Others</option>
				</select>
			</div>
			<div class="form-group">
				<label for="certificate-price">Certificate Price (between 0 and 300)</label>
				<input type="number" class="form-control" id="certificate-price" name="certificate-price" min="0" max="300" value="0" required="required">
			</div>
			<div class="form-group">
				<label for="description">Course Description</label>
				<textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Course Description" required="required" maxlength="200"></textarea>
			</div>

			<p>
				<span class="error text-danger"><?php echo $lecture_error;?></span>
			</p>

			<button type="submit" name="publish" id="publish" class="btn btn-primary">Publish Course</button>
			<div class="dropdown-divider"></div>

		</form>

		<?php 
		class Lecture
		{
			public $lecture_name;
			public $lecture_duration;
			public $lecture_description;
		}

		if (isset($_POST['publish-lecture'])) {
			$lecture = new Lecture();
			echo "L name: " . $_POST['lecture-name'] . " L duration: " . $_POST['lecture-duration'] . " L description: " . $_POST['lecture-description'];

			$lecture->lecture_name = $_POST['lecture-name'];
			$lecture->lecture_duration = $_POST['lecture-duration'];
			$lecture->lecture_description = $_POST['lecture-description'];

			array_push($_SESSION['lecture_array'], $lecture);
		}
		?>

		<p class="font-weight-bold mt-4 text-center">Lectures</p>
		<table class="table">
			<thead>
				<tr>
					<th>Lecture Name</th>
					<th>Description</th>
					<th>Duration</th>
				</tr>
			</thead>
			<tbody>
				<tr>

					<?php 

					for ($i = 0; $i < count($_SESSION['lecture_array']); $i++) {
						echo '<tr>';
						echo '<td>' . $_SESSION['lecture_array'][$i]->lecture_name . '</td>';
						echo '<td>' . $_SESSION['lecture_array'][$i]->lecture_description . '</td>';
						echo '<td>' . $_SESSION['lecture_array'][$i]->lecture_duration . '</td>';
						echo '</tr>';
					}
					?>
				</tr>
			</tbody>
		</table>


		<form method="post">
			<p class="font-weight-bold">Add Lecture(s)</p>
			<div class="form-group">
				<label for="formGroupExampleInput">Lecture Name</label>
				<input type="text" class="form-control" id="lecture-name" name="lecture-name" placeholder="Enter Lecture Name" maxlength="64">
			</div>
			<div class="form-group">
				<label for="price">Lecture Duration:</label>
				<input type="number" class="form-control" id="lecture-duration" name="lecture-duration" step="0.01">
			</div>
			<div class="form-group">
				<label for="description">Lecture Description</label>
				<textarea class="form-control" id="lecture-description" name="lecture-description" rows="3" placeholder="Enter Lecture Description" maxlength="360"></textarea>
			</div>
			<button type="submit" name="publish-lecture" id="publish-lecture" class="btn btn-success">Add Lecture</button>
		</form>

		<?php 
		class Assignment
		{
			public $assignment_question;
			public $assignment_threshold;
		}

		if (isset($_POST['publish-assignment'])) {
			$assignment = new Assignment();

			$assignment->assignment_question = $_POST['assignment_question'];
			$assignment->assignment_threshold = $_POST['assignment_threshold'];

			array_push($_SESSION['assignment_array'], $assignment);
		}
		?>

		<p class="font-weight-bold mt-4 text-center">Assignments</p>
		<table class="table">
			<thead>
				<tr>
					<th>Assignment Question</th>
					<th>Threshold</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php 
					for ($i = 0; $i < count($_SESSION['assignment_array']); $i++) {
						echo '<tr>';
						echo '<td>' . $_SESSION['assignment_array'][$i]->assignment_question . '</td>';
						echo '<td>' . $_SESSION['assignment_array'][$i]->assignment_threshold . '</td>';
						echo '</tr>';
					}
					?>
				</tr>
			</tbody>
		</table>
		<form method="post">
			<p class="font-weight-bold">Add Assignment(s)</p>
			<div class="form-group">
				<label for="formGroupExampleInput">Assignment Question</label>
				<input type="text" class="form-control" id="assignment_question" name="assignment_question" placeholder="Enter Assignment Question" maxlength="100">
			</div>
			<div class="form-group">
				<label for="price">Assignment Threshold</label>
				<input type="number" class="form-control" id="assignment_threshold" name="assignment_threshold" min="0" max="100" value="0">
			</div>
			<button type="submit" name="publish-assignment" id="publish-assignment" class="btn btn-success">Add Assignment</button>
		</form>


		<div style="height: 100px"></div>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>