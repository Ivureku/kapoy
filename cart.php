<?php
$products_cart = isset($_COOKIE['products_cart']) ? unserialize($_COOKIE['products_cart']) : [];

$uncarted_prod = $_REQUEST["del_prod"] ?? 0;
if ($uncarted_prod > 0) {
	foreach ($products_cart as $key => $product) {
		if ($uncarted_prod == $product['id']) {
			unset($products_cart[$key]);
			setcookie("products_cart", serialize($products_cart), time() + 86400, '/');
		}
	}
}
?>
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
							$products_cart = isset($_COOKIE['products_cart']) ? unserialize($_COOKIE['products_cart']) : [];
							$carted_prod = $_REQUEST['prod_id'] ?? null;
							$hostname = "localhost";
							$database = "shopee";
							$db_login = "root";
							$db_pass = "";

							print_r($products_cart);

							$dlink = mysqli_connect($hostname, $db_login, $db_pass, $database) or die("Could not connect");

							$to_cart = $_REQUEST['cart'] ?? false; // $to_cart = isset($_REQUEST['cart']) ? $_REQUEST['cart'] : false;
							if ($to_cart) { ?>
								<p style="font-size: x-large; font-weight: bold; text-align: center; margin: 100px;">CART
								</p>
								<div style="display: flex; justify-content: center; align-items: center;">
									<form action="cart.php?cart=true" method="post">
										<table>
											<!-- Cart header -->
											<thead>
												<tr>
													<th colspan="2"></th>
													<th>Description</th>
													<th> Name</th>
													<th>Quantity</th>
													<th>Total Price</th>
													<th>Actions</th>
												</tr>
											</thead>
											<!-- Carted products -->
											<tbody>
												<?php
												$total_price = 0;
												foreach ($products_cart as $id => $in_cart) {
													$product_id = $in_cart['id'];
													$product_name = $in_cart['name'];
													$product_description = $in_cart['description'];
													$product_img = $in_cart['image'];
													$carted_quantity = $in_cart['cart_qty'];
													$product_price = $in_cart['price'] * $carted_quantity;
													$total_price += $product_price;
													?>
													<tr>
														<td>
															<input type="checkbox" name="cart_product[]" value=<?php echo $product_id ?>>
														</td>
														<td>
															<img src="images/<?php echo $product_img ?>" alt="product">
														</td>
														<td>
															<?php echo $product_description ?>
														</td>
														<td>
															<?php echo $product_name ?>
														</td>
														<td>
															<form action="cart.php?cart=true" method="post">
																<select name="product_quantity" onchange="this.form.submit()">
																	<?php
																	// Queries available quantity in database for product, using its product id
																	$quantity_query = "SELECT qty FROM products where id=$product_id";
																	$quantity_search = mysqli_query($dlink, $quantity_query);
																	$product_quantity = mysqli_fetch_row($quantity_search);

																	// dynamically creates options for the select object based on the quantity of the product in the products database
																	// @product_quantity - product quantity of the carted product
																	for ($range = 1; $range <= $product_quantity[0]; $range++) {
																		if ($range == $carted_quantity) { ?>
																			<option value=<?php echo $range ?> selected><?php echo $range ?></option>
																			<?php continue;
																		} ?>
																		<option value=<?php echo $range ?>><?php echo $range ?>
																		</option>
																	<?php } ?>

																	<!-- @update_prod - product id of the quantity to be updated when select option for quantity  -->
																</select>
																<input type="hidden" name="update_prod" value=<?php echo $product_id ?>>
															</form>
														</td>
														<td>
															<?php echo $product_price ?>
														</td>
														<td style="padding-left: 70px; padding-right: 70px;">
															<button type="submit" name="del_prod" value=<?php echo $product_id ?>>Delete</button>
														</td>
													</tr>
												<?php } ?>
												<tr>
													<td colspan="7"
														style="text-align: center; padding-top: 10px; padding-bottom: 70px;">
														<strong>TOTAL: </strong>
														<?php echo $total_price ?>
													</td>
												</tr>
											</tbody>
										</table>
										<input
											style="width: 100%; padding-top: 10px; padding-bottom: 10px; background-color: pink;"
											type="submit" value="Place orders">
									</form>
								</div>

								<?php
							}
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