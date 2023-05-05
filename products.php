<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<title>Products - Gadget Shop Website Template</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<div id="header">
		<div>
			<div id="logo">
				<a href="index2.php"><img src="images/logo.png" alt="Logo"></a>
			</div>
			<ul>
				<li class="home">
					<a href="index2.php"><span>Home</span></a>
				</li>
				<li class="products current">
					<a href="products.php"><span>Products</span></a>
				</li>
				<li class="register">
					<a href="cart.php"><span>Cart</span></a>
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

						<?php
						$hostname = "localhost";
						$database = "shopee";
						$db_login = "root";
						$db_pass = "";

						$products_cart = isset($_COOKIE['products_cart']) ? unserialize($_COOKIE['products_cart']) : [];

						$dlink = mysqli_connect($hostname, $db_login, $db_pass, $database) or die("Could not connect");

						// check if a category is selected
						if (isset($_GET['category'])) {
							$category = mysqli_real_escape_string($dlink, $_GET['category']);
							$product_query = "SELECT * FROM products WHERE category = '$category'";
							$category_query = "SELECT category FROM products WHERE category = '$category' GROUP BY category";
						} else {
							$product_query = "SELECT * FROM products";
							$category_query = "SELECT category FROM products GROUP BY category";
						}

						$category_search = mysqli_query($dlink, $category_query);

						while ($category_list = mysqli_fetch_assoc($category_search)) {
							$category = $category_list['category'];
							$product_query = "SELECT * FROM products WHERE category = '$category'";

							echo '<div>';
							echo '<h1><a href="?category=' . $category . '">' . strtoupper($category) . '</a></h1>';
							echo '<ul>';

							$product_search = mysqli_query($dlink, $product_query);

							while ($product = mysqli_fetch_assoc($product_search)) {
								$product_name = $product['name'];
								$product_description = $product['description'];
								$product_link = $product['link'];
								$product_image = $product['images'];
								$product_qty = $product['qty'];
								$product_lastprice = $product['lastprice'];
								$product_currprice = $product['currprice'];
								$product_id = $product['id'];

								echo '<li>';
								echo '<form method="post">';
								echo '<a href="products.php"><img src="images/' . $product_image . '" alt="Image"></a>';
								echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
								echo '<h2 onclick="this.parentNode.submit(); return false;"><a href="?product_id=$product_id" >' . $product_name . "</a></h2>";
								echo '</form>';
								echo '<p>' . $product_description . '</p>';
								echo '<p>Qty: ' . $product_qty . '</p>';
								echo '<p>Last Price: ' . $product_lastprice . '</p>';
								echo '<p>Curr Price: ' . $product_currprice . '</p>';
								echo '</li>';

							}

							if (isset($_POST['product_id'])) {
								$product_id = $_POST['product_id'];
								$product = mysqli_query($dlink, "SELECT * FROM products WHERE id = $product_id");
								$product = mysqli_fetch_assoc($product);
								$product_cart = [
									'id' => $product_id,
									'name' => $product['name'],
									'description' => $product['description'],
									'images' => $product['images'],
									'qty' => $product['qty'],
									'currprice' => $product['currprice']
								];
								if (!in_array($product_cart, $products_cart)) {
									$products_cart[] = $product_cart;
								}
								setcookie('products_cart', serialize($products_cart), time() + 3600, '/');
							}

						}

						echo '</ul>';
						echo '</div>';

						?>




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