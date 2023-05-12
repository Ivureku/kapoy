<?php
ob_start();
$user_type = $_COOKIE['type'] ?? '';


?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
    <meta charset="UTF-8">
    <title>About - Gadget Shop Website Template</title>
    <link rel="stylesheet" type="text/css" href="css/orderStyle.css">
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

                <li class="logout">
                    <a href="logout.php"><span>Logout</span></a>
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
                            $carted_prod = $_REQUEST['id'] ?? null;
                            $hostname = "localhost";
                            $database = "shopee";
                            $db_login = "root";
                            $db_pass = "";


                            // 
                            
                            $dlink = mysqli_connect($hostname, $db_login, $db_pass, $database) or die("Could not connect");

                            ?>
                            <div id="orderHead">
                                <?php
                                if (isset($_COOKIE['user_id'])) {
                                    /**
                                     * Query statements for count of pending, accepted, completed, and returned/refunded orders
                                     */
                                    $user_id = $_COOKIE['user_id'];
                                    $pending_query = "SELECT COUNT(*) AS count FROM purchases WHERE status='pending' AND user_id=$user_id";
                                    $accepted_query = "SELECT COUNT(*) AS count FROM purchases WHERE status='accepted' AND user_id=$user_id";
                                    $completed_query = "SELECT COUNT(*) AS count FROM purchases WHERE status='completed' AND user_id=$user_id";
                                    $returned_refunded_query = "SELECT COUNT(*) AS count FROM purchases WHERE (status='returned' OR status='refunded') AND user_id=$user_id";

                                    /**
                                     * contains the count of pending, accepted, completed, and returned/refunded orders
                                     */
                                    $count_pending = mysqli_fetch_assoc(mysqli_query($dlink, $pending_query))['count'];
                                    $count_accepted = mysqli_fetch_assoc(mysqli_query($dlink, $accepted_query))['count'];
                                    $count_completed = mysqli_fetch_assoc(mysqli_query($dlink, $completed_query))['count'];
                                    $count_returned_refunded = mysqli_fetch_assoc(mysqli_query($dlink, $returned_refunded_query))['count'];
                                    ?>
                                    <div id="orderStatusesContainer">
                                        <a id="orderStatuses" href="?status=pending">
                                            <p style="text-align: center; font-size: large; font-weight: 700;">
                                                Pending(
                                                <?php echo $count_pending ?>)
                                            </p>
                                        </a>
                                        <a id="orderStatuses" href="?status=accepted">
                                            <p style="text-align: center; font-size: large; font-weight: 700;">
                                                Accepted(
                                                <?php echo $count_accepted ?>)
                                            </p>
                                        </a>
                                        <a id="orderStatuses" href="?status=completed">
                                            <p style="text-align: center; font-size: large; font-weight: 700;">
                                                Completed(
                                                <?php echo $count_completed ?>)
                                            </p>
                                        </a>
                                        <a id="orderStatuses" href="?status=return_refund">
                                            <p style="text-align: center; font-size: large; font-weight: 700;">
                                                Return/Refund(
                                                <?php echo $count_returned_refunded ?>)
                                            </p>
                                        </a>
                                    </div>
                                <?php } ?>

                                <table id="myOrder">
                                    <thead>
                                        <tr>
                                            <th style="padding: 10px;">Image</th>
                                            <th style="padding: 10px;">Name</th>
                                            <th style="padding: 10px;">Quantity</th>
                                            <th style="padding: 10px;">Price</th>
                                            <th style="padding: 10px;">Order Date</th>
                                            <th style="padding: 10px;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cummulative_price = 0;

                                        $order_status = $_REQUEST['status'] ?? '';
                                        if ($order_status === 'accepted') {
                                            $orders_query_statement = "SELECT prod.images AS image_link, prod.name AS name, prod.category AS category, pur.qty AS quantity, pur.total_price AS price, date, status FROM purchases pur INNER JOIN products prod ON pur.product_id=prod.id WHERE user_id=$user_id AND status='accepted'";
                                        } elseif ($order_status === 'completed') {
                                            $orders_query_statement = "SELECT prod.images AS image_link, prod.name AS name, prod.category AS category, pur.qty AS quantity, pur.total_price AS price, date, status FROM purchases pur INNER JOIN products prod ON pur.product_id=prod.id WHERE user_id=$user_id AND status='completed'";
                                        } elseif ($order_status === 'return_refund') {
                                            $orders_query_statement = "SELECT prod.images AS image_link, prod.name AS name, prod.category AS category, pur.qty AS quantity, pur.total_price AS price, date, status FROM purchases pur INNER JOIN products prod ON pur.product_id=prod.id WHERE user_id=$user_id AND (status='returned' OR status='refunded')";
                                        } else {
                                            /**
                                             * pending orders is the default status shown to the user
                                             */
                                            $orders_query_statement = "SELECT prod.images AS image_link, prod.name AS name, prod.category AS category, pur.qty AS quantity, pur.total_price AS price, date, status FROM purchases pur INNER JOIN products prod ON pur.product_id=prod.id WHERE user_id=$user_id AND status='pending'";
                                        }
                                        /**
                                         * contains list of customer's orders based on selected status (see conditionals above)
                                         */
                                        $order_list = mysqli_fetch_all(mysqli_query($dlink, $orders_query_statement), MYSQLI_ASSOC);

                                        /**
                                         * List of ordered products by the customers, categorized by order's status
                                         */
                                        foreach ($order_list as $key => $order) {
                                            $order_image = $order['image_link'];
                                            $order_name = $order['name'];
                                            $order_category = $order['category'];
                                            $order_quantity = $order['quantity'] . 'x';
                                            $total_price = $order['price'];
                                            $order_date = $order['date'];
                                            $order_status = $order['status'];
                                            $cummulative_price += $total_price;

                                            $table_row = <<<HTML
                                            <tr id="trOrder">
                                                <td id="tdOrder">
                                                    <img src="images/$order_image" alt="$order_name">
                                                </td>
                                                <td id="tdOrder">
                                                    [$order_category] $order_name
                                                </td>
                                                <td id="tdOrder">
                                                    $order_quantity
                                                </td>
                                                <td id="tdOrder">
                                                    $total_price
                                                </td>
                                                <td id="tdOrder">
                                                    $order_date
                                                </td>
                                                <td id="tdOrder">
                                                    $order_status
                                                </td>
                                            </tr>
                                            HTML;
                                            echo $table_row;
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="6" align="center">
                                                <span style="font-size: large;"><strong>Total:</strong>
                                                    <?php echo $cummulative_price ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


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