<?
ob_start()
	?>
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
					<a href="index.php"><span>Home</span></a>
				</li>
				<li class="products">
					<a href="products.php"><span>Products</span></a>
				</li>
				<li class="register">
					<a href="index.php?action=register&#register"><span>Register</span></a>
				</li>
				<li class="login">
					<a href="index.php?action=login&#loginForm"><span>Login</span></a>
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
						<h1>Featured Products</h1>
						<h4>This is just a place holder, so you can see what the site would look like.</h4>
						<ul>
							<li>
								<a href="products.php"><img src="images/headphone1.png" alt="Image"></a>
								<h2><a href="products.php">Product</a></h2>
							</li>
							<li>
								<a href="products.php"><img src="images/headphone2.png" alt="Image"></a>
								<h2><a href="products.php">Product</a></h2>
							</li>
							<li>
								<a href="products.php"><img src="images/headphone3.png" alt="Image"></a>
								<h2><a href="products.php">Product</a></h2>
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
				//serialize shit
				$hostname = "localhost";
				$database = "shopee";
				$db_login = "root";
				$db_pass = "";

				$dlink = mysqli_connect($hostname, $db_login, $db_pass) or die("Could not connect");
				mysqli_select_db($dlink, $database) or die("Could not select database");

				// registration 
				$action = $_REQUEST['action'] ?? '';
				$register_name = $_REQUEST['uname'] ?? '';
				$register_email = $_REQUEST['email'] ?? '';
				$register_password = $_REQUEST['password'] ?? '';
				$register_contact = $_REQUEST['contact'] ?? '';
				$register_address = $_REQUEST['address'] ?? '';
				$entering = $_REQUEST['entering'] ?? false;


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

							$query = "insert into user(email, paswrd, contact, custname, address, usertype, user_date, user_ip) values('" . $register_email . "','" . $register_password . "','" . $_REQUEST['contact'] . "','" . $_REQUEST['uname'] . "','" . $register_address . "','" . $usertype . "','" . date("Y-m-d h:i:s") . "','" . $_SERVER['REMOTE_ADDR'] . "')";
							$result = mysqli_query($dlink, $query) or die(mysqli_error($dlink));

						} else {
							$query = "insert into user(email, paswrd, contact, custname, address, usertype, user_date, user_ip) values('" . $register_email . "','" . $register_password . "','" . $_REQUEST['contact'] . "','" . $_REQUEST['uname'] . "','" . $register_address . "','" . $usertype . "','" . date("Y-m-d h:i:s") . "','" . $_SERVER['REMOTE_ADDR'] . "')";
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
						setcookie("user_id", $row['userid'], time() + 86400, '/');
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
			</div>
			<div>
				<h3>Get Social</h3>
				<ul>
					<li>
						<a href="http://freewebsitetemplates.com/go/googleplus/" target="_blank"
							id="googleplus">Google&#43;</a>
					</li>
					<li>
						<a href="http://freewebsitetemplates.com/go/twitter/" target="_blank" id="twitter">Twitter</a>
					</li>
					<li>
						<a href="http://freewebsitetemplates.com/go/facebook/" target="_blank"
							id="facebook">Facebook</a>
					</li>
				</ul>
			</div>
		</div>
		<p class="footnote">
			&copy; Copyright 2012. All rights reserved.
		</p>
	</div>
</body>

</html>