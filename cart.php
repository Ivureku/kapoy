<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<title>About - Gadget Shop Website Template</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<div id="header">
		<div>
			<div id="logo">
				<a href="index.html"><img src="images/logo.png" alt="Logo"></a>
			</div>
			<ul>
				<li class="home">
					<a href="index2.php"><span>Home</span></a>
				</li>
				<li class="products">
					<a href="products.php"><span>Products</span></a>
				</li>
				<li class="about current">
					<a href="about.html"><span>About</span></a>
				</li>
				<li class="blog">
					<a href="blog.html"><span>Blog</span></a>
				</li>
			</ul>
		</div>
		<div>
			<span id="background"></span>
		</div>
	</div>
	<div id="body">
		<div>
			<div>
				<div>
					<div>
						<div>
							<?php

							$hostname = "localhost";
							$database = "shopee";
							$db_login = "root";
							$db_pass = "";
							$dlink = mysqli_connect($hostname, $db_login, $db_pass, $database) or die("Could not connect");

							$products_cart = isset($_COOKIE['products_cart']) ? unserialize($_COOKIE['products_cart']) : array();
							print_r($products_cart);
							echo '<table>';
							echo '<tr><th>Name</th><th>Description</th><th>Image</th><th>Quantity</th><th>Price</th><th>Total</th></tr>';

							// Loop through products in cart
							foreach ($products_cart as $product) {
								$product_id = isset($product[0]) ? $product[0] : '';
								$product_quantity = isset($product[7]) ? $product[7] : '';

								// Fetch product details from database
								$sql = "SELECT * FROM products WHERE id = '$product_id'";
								$result = mysqli_query($dlink, $sql);

								if ($result) {
									$row = mysqli_fetch_assoc($result);
									$product_name = $row['name'];
									$product_description = $row['description'];
									$product_image = $row['image'];
									$product_price = $row['price'];

									// Calculate total price for product
									$product_total = intval($product_quantity) * floatval($product_price);

									// Output table row for product
									echo '<tr>';
									echo '<td>' . $product_name . '</td>';
									echo '<td>' . $product_description . '</td>';
									echo '<td><img src="' . $product_image . '"></td>';
									echo '<td>
										<form method="post">
											<input type="hidden" name="product_id" value="' . $product_id . '">
											<select name="quantity" onchange="this.form.submit()">
												<option value="1" ' . ($product_quantity == 1 ? 'selected' : '') . '>1</option>
												<option value="2" ' . ($product_quantity == 2 ? 'selected' : '') . '>2</option>
												<option value="3" ' . ($product_quantity == 3 ? 'selected' : '') . '>3</option>
												<option value="4" ' . ($product_quantity == 4 ? 'selected' : '') . '>4</option>
												<option value="5" ' . ($product_quantity == 5 ? 'selected' : '') . '>5</option>
											</select>
										</form>
									</td>';
									echo '<td>$' . number_format($product_price, 2) . '</td>';
									echo '<td>$' . number_format($product_total, 2) . '</td>';
									echo '</tr>';
								}
							}

							// Output table footer
							echo '</table>';

							$carted_prod = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : null;
							$carted_quantity = isset($_REQUEST['quantity']) ? (int) $_REQUEST['quantity'] : 1;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div>
			<div>
				<h3>Blog</h3>
				<p>
					This website template has been designed by <a href="http://www.freewebsitetemplates.com/">Free
						Website Templates</a> for you, for free. You can replace all this text with your own text. You
					can remove any link to our website from this website template, you&#39;re free to use this website
					template without linking back to us. If you&#39;re having problems editing this website template,
					then don&#39;t hesitate to ask for help on the <a
						href="http://www.freewebsitetemplates.com/forums/">Forums</a>.
				</p>
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