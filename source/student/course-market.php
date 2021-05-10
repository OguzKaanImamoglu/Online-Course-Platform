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
		<a class="navbar-brand" href="home.php">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link active" href="">Course Market<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="my-courses.php">My Courses</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="add-money.php">Add Money</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<div class="container">
			<h3 class="display-4 text-center mt-5">List of Available Courses</h3>

			<form class="mt-5" method="post">
				<div class="row mb-4">
					<div class="col-12">
						<input type="text" class="form-control" name="search-name" placeholder="Search by Course Name or Course Creator Name">
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<input type="number" class="form-control" name="min-price" placeholder="Minimum Price">
					</div>
					<div class="col-md-3">
						<input type="number" class="form-control" name="max-price" placeholder="Maximum Price">
					</div>
					<div class="col-md-3">
						<input type="number" class="form-control" name="min-discount" placeholder="Minimum Discount">
					</div>
					<div class="col-md-3">
						<input type="number" class="form-control" name="max-discount" placeholder="Maximum Discount">
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-4">
						<div class="form-group">
							<label for="language">Language</label>
							<select name="language" class="custom-select">
								<option value="">Select Language of the Course</option>
								<option value="English">English</option>
								<option value="Turkish">Turkish</option>
								<option value="German">German</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="sort-by">Sort By</label>
							<select name="sort-by" class="custom-select">
								<option value="">Sort By</option>
								<option value="rating-hl">Rating - High to Low</option>
								<option value="price-hl">Price - High to Low</option>
								<option value="price-lh">Price - Low to High</option>
								
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="category">Category</label>
							<select name="category" class="custom-select">
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
					</div>
				</div>
				<div class="col-md-12 text-center">
					<button  type="submit" name="apply-filter" id="apply-filter" class="mt-2 text-center btn btn-success">Apply Filter Options</button>
				</div>
			</form>

			<div class="mt-5">
				<?php 

				if (!isset($_POST['apply-filter'])) {
					$sql = "SELECT 	C.course_id, C.course_name, C.language, C.average_rating, C.category,\n"

					. "   		P.name, P.surname, D.percentage, D.start_date, D.end_date, \n"

					. "D.is_allowed, (CASE WHEN CURRENT_DATE <= D.end_date AND \n"

					. "CURRENT_DATE >= D.start_date AND D.is_allowed\n"

					. "           				THEN C.course_price * (( 100 - D.percentage ) / 100)\n"

					. "           				ELSE C.course_price END) as price\n"

					. "FROM 		course C LEFT OUTER JOIN discount D ON \n"

					. "C.course_id = D.discounted_course_id LEFT JOIN person P ON C.course_creator_id = P.person_id";

					$result = mysqli_query($link, $sql);

					if (!$result) {
						echo "There is no course found.";
						echo " " . $link -> error;
					} else {
						$count = mysqli_num_rows($result);

						if ($count > 0) {
							echo "<table class='table'>
							<thead>
							<th scope='col'>Course Id</th>
							<th scope='col'>Course Name</th>
							<th scope='col'>Price</th>
							<th scope='col'>Language</th>
							<th scope='col'>Rating</th>
							<th scope='col'>Category</th>
							<th scope='col'>Instructor Name</th>
							<th scope='col'>Discount</th>
							</thead>
							<tbody>
							";

							while ($q_result = mysqli_fetch_array($result)) {
								echo "<tr><th scope='row'>" . $q_result["course_id"] .
								"</th><td>" . $q_result["course_name"] .
								"</td><td>" . $q_result["price"] . 
								"</td><td>" . $q_result["language"] .
								"</td><td>" . $q_result["average_rating"] . 
								"</td><td>" . $q_result["category"] . 
								"</td><td>" . $q_result["name"] . " " . $q_result["surname"];

								if (is_null($q_result["percentage"])) {
									echo "</td><td> 0";
								} else {
									echo "</td><td>" . $q_result["percentage"];
								}
								echo "</td></tr>";
							}
							echo "</tbody>";
							echo "</table>";
						} else {
							echo "There is no course found.";
						}
					}
				}

				

				if (isset($_POST['apply-filter'])) {
					$min_price = $_POST['min-price'];
					$max_price = $_POST['max-price'];
					$min_discount = $_POST['min-discount'];
					$max_discount = $_POST['max-discount'];
					$language = $_POST['language'];
					$sort_by = $_POST['sort-by'];
					$select_category = $_POST['category'];
					$search_name = $_POST['search-name'];

					$filter_count = 0;

					if($search_name != "") {
						$filter_count = $filter_count + 1;
					}
					if ($min_price != "") {
						$filter_count = $filter_count + 1;
					}
					if ($max_price != "") {
						$filter_count = $filter_count + 1;
					}
					if ($min_discount != "") {
						$filter_count = $filter_count + 1;
					}
					if ($max_discount != "") {
						$filter_count = $filter_count + 1;
					}
					if ($language != "") {
						$filter_count = $filter_count + 1;
					}
					if ($sort_by != "") {
						$filter_count = $filter_count + 1;
					}
					if ($select_category != "") {
						$filter_count = $filter_count + 1;
					}

					if ($filter_count == 0) {
						echo "Please select at least 1 filter.";
					} else {
						$sql = "SELECT 	C.course_id, C.course_name, C.language, C.average_rating, C.category,
						P.name, P.surname, D.percentage, D.start_date, D.end_date, 
						D.is_allowed, (CASE WHEN CURRENT_DATE <= D.end_date AND 
						CURRENT_DATE >= D.start_date AND D.is_allowed
						THEN C.course_price * (( 100 - D.percentage ) / 100)
						ELSE C.course_price END) as price
						FROM 		course C LEFT OUTER JOIN discount D ON 
						C.course_id = D.discounted_course_id LEFT JOIN person P ON C.course_creator_id = P.person_id";

						$filtered_post = array_filter($_POST);
						$keynames = array_keys($filtered_post);

						$filtered_post_count = count($filtered_post);

						$price_found = 0;
						$price_count = 0;
						$others_found = 0;
						$others_count = 0;

						$others = array();
						$prices = array();


						foreach ($filtered_post as $key => $value) {
							if ($key == "min-price" || $key == "max-price") {
								$prices[$key] = $value;
							} else if ($key == 'sort-by') {
								continue;
							} else {
								$others[$key] = $value;
							}
						}

						foreach ($filtered_post as $key => $value) {

							if ($key == "min-price" || $key == "max-price") {
								$price_found = 1;
								$price_count += 1;
							}

							if ($key != "min-price" && $key != "max-price" && $key != "sort-by") {
								$others_found = 1;
								$others_count += 1;
							}
						}

						if ($others_found == 1) {
							$sql .= " WHERE";

							$i = 0;
							foreach ($others as $key => $value) {
								if ($key == "min-discount") {
									$sql .= " percentage >= '$value'";
								}

								if ($key == "search-name") {
									$value = trim($value);
									$sql .= " course_name LIKE '%$value' OR name LIKE '%$value' OR surname LIKE '%$value'";
								}

								if ($key == "max-discount") {
									$sql .= " percentage <= '$value'";
								}

								if ($key == "language") {
									$sql .= " language = '$value'";
								}

								if ($key == "category") {
									$sql .= " category = '$value'";
								}

								if ($key == "sort-by") {
									continue;
								}

								if ($others_count > 1 && ($i < $others_count - 1)) {
									$sql .= " AND";
								}

								$i = $i + 1;
							}
						}



						if ($price_found == 1) {
							$sql .= " HAVING";

							$i = 0;
							foreach ($prices as $key => $value) {
								if ($key == "min-price") {
									$sql .= " price >= '$value'";
								}

								if ($key == "max-price") {
									$sql .= " price <= '$value'";
								}

								if ($price_count > 1 && ($i < $price_count - 1)) {
									$sql .= " AND";
								}

								$i = $i + 1;
							}
						}

						if ($_POST["sort-by"] != "") {
							if ($_POST["sort-by"] == "rating-hl") {
								$sql .= " ORDER BY average_rating DESC";
							} else if ($_POST["sort-by"] == "price-hl") {
								$sql .= " ORDER BY price DESC";
							} else if ($_POST["sort-by"] == "price-lh") {
								$sql .= " ORDER BY price";
							}
						}

						$result = mysqli_query($link, $sql);

						if (!$result) {
							echo "There is no course found.";
							echo " " . $link -> error;
						} else {
							$count = mysqli_num_rows($result);

							if ($count > 0) {
								echo "<table class='table'>
								<thead>
								<th scope='col'>Course Id</th>
								<th scope='col'>Course Name</th>
								<th scope='col'>Price</th>
								<th scope='col'>Language</th>
								<th scope='col'>Rating</th>
								<th scope='col'>Category</th>
								<th scope='col'>Instructor Name</th>
								<th scope='col'>Discount</th>
								</thead>
								<tbody>
								";

								while ($q_result = mysqli_fetch_array($result)) {
									echo "<tr><th scope='row'>" . $q_result["course_id"] .
									"</th><td>" . $q_result["course_name"] .
									"</td><td>" . $q_result["price"] . 
									"</td><td>" . $q_result["language"] .
									"</td><td>" . $q_result["average_rating"] . 
									"</td><td>" . $q_result["category"] . 
									"</td><td>" . $q_result["name"] . " " . $q_result["surname"];

									if (is_null($q_result["percentage"])) {
										echo "</td><td> 0";
									} else {
										echo "</td><td>" . $q_result["percentage"];
									}
									echo "</td></tr>";
								}
								echo "</tbody>";
								echo "</table>";
							} else {
								echo "There is no course found.";
							}
						}


					}
				}



				?>
			</div>
			<button onclick="location.href='course-market.php'" class="mt-2 text-center btn btn-success">Refresh</button>


		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
