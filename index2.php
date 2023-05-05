<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<title>Gadget Shop Website Template</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<div id="header">
		<div>
			<div id="logo">
				<a href="index.html"><img src="images/logo.png" alt="Logo"></a>
			</div>
			<ul>
				<li class="home current">
					<a href="index2.php"><span>Home</span></a>
				</li>
				<li class="products">
					<a href="products.php"><span>Products</span></a>
				</li>
				<li class="register">
					<?php
					if (isset($_COOKIE['email']) && isset($_COOKIE['type'])) {
						echo '<a>Welcome! (' . $_COOKIE['type'] . ') ' . $_COOKIE['email'] . '</a>';
					} else {
						echo '<a>Welcome!</a>';
					}
					?>
				</li>
				<li class="logout">
					<a href="logout.php"><span>Logout</span></a>
				</li>
			</ul>
		</div>
		<div>
			<div id="figure">
				<div>
					<h1>Live Music</h1>
					<h2>This is just a place holder</h2>
				</div>
			</div>
		</div>
	</div>
	<div id="body">
		<div>
			<div>
				<div>
					<div>
						<?php



						$hostname = "localhost";
						$database = "shopee";
						$db_login = "root";
						$db_pass = "";

						$dlink = mysqli_connect($hostname, $db_login, $db_pass) or die("Could not connect");
						mysqli_select_db($dlink, $database) or die("Could not select database");

						if ($_COOKIE['type'] == 'admin'):
							$year = date('Y');
							$month = date('m');

							// Get the number of days in the current month
							$num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

							// Get the name of the current month, F in format('F') means the full name of the month
							$date = new DateTime("$year-$month-01");
							$month_name = $date->format('F');

							// Get the index of the first day of the month (0 = Sunday, 1 = Monday, etc.)
							//The first argument, 'w', specifies that we want to retrieve the day of the week as a numeric value (0 for Sunday, 1 for Monday, and so on).
							//strtotime function creates a timestamp representing the first day of the given month and year.
							$first_day_index = (int) date('w', strtotime("$year-$month-01"));

							// Start the table and print the month name
							echo "<table width=80% border=1><caption>$month_name $year</caption>";

							// Print the table headers (days of the week)
							echo "<tr>";
							echo "<th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th>";
							echo "<th>Thu</th><th>Fri</th><th>Sat</th>";
							echo "</tr>";

							// Start a new row for the first week
							echo "<tr>";

							// Print blank cells for the days before the first day of the month
							for ($i = 0; $i < $first_day_index; $i++) {
								echo "<td></td>";
							}

							// Print the cells for the days of the month
							for ($day = 1; $day <= $num_days; $day++) {
								// Start a new row at the beginning of each week
								if ($day > 1 && ($day - 1 + $first_day_index) % 7 == 0) {
									echo "</tr><tr>";
								}

								// Print the cell for the current day
								echo "<td align=center>$day</td>";
							}

							// Print blank cells for the days after the last day of the month
							for ($i = $num_days + $first_day_index; $i < 32; $i++) {
								echo "<td></td>";
							}

							// End the last row and the table
							echo "</tr></table>"; ?>
						<?php else: ?>
							<h1>Featured Products</h1>
							<h4>This is just a place holder, so you can see what the site would look like.</h4>
							<ul>
								<li>
									<a href="products.php"><img src="images/headphone1.png" alt="Image"></a>
									<h2><a href="products.php">Gray</a></h2>
								</li>
								<li>
									<a href="products.php"><img src="images/headphone2.png" alt="Image"></a>
									<h2><a href="products.php">Purple</a></h2>
								</li>
								<li>
									<a href="products.php"><img src="images/headphone3.png" alt="Image"></a>
									<h2><a href="products.php">Black</a></h2>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
			<div>
				<div>
					<?php
					//exer 3 clickable products, cart, each product with href = goes to cart ambot
					//exer 3 delete products table, if clicking place order
					//put href for products to products.php, different product id
					$action = $_REQUEST['action'] ?? '';
					$register_name = $_REQUEST['uname'] ?? '';
					$register_email = $_REQUEST['email'] ?? '';
					$register_password = $_REQUEST['password'] ?? '';
					$register_contact = $_REQUEST['contact'] ?? '';
					$register_address = $_REQUEST['address'] ?? '';
					$entering = $_REQUEST['entering'] ?? false;


					// registration 
					if ($register_name != "" && $register_email != "" && $register_password != "" && $register_contact != "" && $register_address != "") {
						$query = "select * from user where email='" . $register_email . "'";
						$result = mysqli_query($dlink, $query) or die(mysqli_error($dlink));
						$total_results = mysqli_num_rows($result);

						if ($total_results == 0) {
							$all_query = "select * from user";
							$all_result = mysqli_query($dlink, $all_query) or die(mysqli_error($dlink));
							$total_all = mysqli_num_rows($all_result);
							$usertype = "customer";
							if ($total_all == 0) {
								$usertype = "admin";

								$query = "insert into user(email, paswrd, contact, custname, address, usertype, user_date, user_ip) values('" . $register_email . "','" . $register_password . "','" . $register_contact . "','" . $_REQUEST['uname'] . "','" . $register_address . "','" . $usertype . "','" . date("Y-m-d h:i:s") . "','" . $_SERVER['REMOTE_ADDR'] . "')";
								$result = mysqli_query($dlink, $query) or die(mysqli_error($dlink));

							} else {
								$query = "insert into user(email, paswrd, contact, custname, address, usertype, user_date, user_ip) values('" . $register_email . "','" . $register_password . "','" . $register_contact . "','" . $_REQUEST['uname'] . "','" . $register_address . "','" . $usertype . "','" . date("Y-m-d h:i:s") . "','" . $_SERVER['REMOTE_ADDR'] . "')";
								$result = mysqli_query($dlink, $query) or die(mysqli_error($dlink));
							}
							echo "<meta http-equiv='refresh' content='0;url=index.php?action=login&#loginForm'>";
							echo '<script>alert("Account Registered!!!!")</script>';
						} else {
							echo "<meta http-equiv='refresh' content='0;url=index.php?action=register&#register'>";
							echo '<script>alert("Account Taken!!!!")</script>';
						}
					}

					//registration form
					if ($action == 'register') {
						print('<h1 id="register">REGISTER FORM</h1>');
						print('<form action="index.php" method=post>');
						print('Enter Name <input type="text" name="uname"><br>');
						print('Enter Address <input type="text" name="address"><br>');
						print('Enter Email <input type="text" name="email"><br>');
						print('Enter Contact <input type="text" name="contact"><br>');
						print('Enter Password <input type="text" name="password">');
						print('<input type="submit" value="Send" id="submit">');
						print('</form>');

					}
					//login
					if ($entering == true) {
						$query = "select * from user where email='" . $register_email . "' and paswrd = '" . $register_password . "'";
						$result = mysqli_query($dlink, $query) or die(mysqli_error($dlink));
						$num_results = mysqli_num_rows($result);
						$row = mysqli_fetch_array($result);

						if ($num_results == 0) {
							echo '<meta http-equiv="refresh" content="0;url=index.php?action=register&#register">';
							echo '<script>alert("Account not yet registered")</script>';
						} else {
							setcookie("email", $row['email'], time() + 3600, "/");
							setcookie("type", $row['usertype'], time() + 3600, "/");
							echo '<meta http-equiv="refresh" content="0;url=index2.php">';


						}
					}

					//login form
					if ($action == 'login') {
						print('<h1 id="loginForm">LOGIN FORM</h1>');
						print('<form action=index.php?entering=true method=post>');
						print('Enter Email <input type="text" name="email"><br>');
						print('Enter Password <input type="text" name="password">');
						print('<input type="submit" value="Send" id="submit">');
						print('</form>');

					}
					?>
				<?php endif ?>

			</div>

		</div>
		<p class="footnote">
			&copy; Copyright 2012. All rights reserved.
		</p>
	</div>
</body>

</html>