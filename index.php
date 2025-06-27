<?php require "config/config.php";?>
<?php

// Include the header file
require "layout/header.php";

// Redirect if admin is not logged in
if (!isset($_SESSION["adminname"])) {
    echo "<script>window.location.href='" . ADMINURL . "/admins/login-admins.php';</script>";
    exit(); // Stop further execution
}

// Fetch counts from the database
$product = $conn->query("SELECT count(*) as products_num FROM products");
$product->execute();
$numProduct = $product->fetch(PDO::FETCH_OBJ);

$orders = $conn->query("SELECT count(*) as orders_num FROM orders");
$orders->execute();
$numOrders = $orders->fetch(PDO::FETCH_OBJ);

$categories = $conn->query("SELECT count(*) as categories_num FROM categories");
$categories->execute();
$numCategories = $categories->fetch(PDO::FETCH_OBJ);

$admins = $conn->query("SELECT count(*) as admins_num FROM admins");
$admins->execute();
$numAdmins = $admins->fetch(PDO::FETCH_OBJ);

// Fetch all data from order_detail with status = 1
$query = $conn->prepare("
    SELECT pro_name, SUM(quantity) AS total_quantity 
    FROM order_detail 
    WHERE status = 1 
    GROUP BY pro_name
");
$query->execute();
$orderDetails = $query->fetchAll(PDO::FETCH_OBJ);

// Prepare data points for charts
$dataPoints = array();
foreach ($orderDetails as $detail) {
    $dataPoints[] = array(
        "label" => $detail->pro_name, // Use product ID as label
        "y" => $detail->total_quantity // Total quantity for the product
    );
}
?>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: false,
	title:{
		text: "Winning Products"
	},
	subtitles: [{
		text: "The most wanted products is:"
	}],
	data: [{
		type: "pie",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - #percent%",
		yValueFormatString: "#0",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

            
      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Products</h5>
              <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
              <p class="card-text">number of products: <?php echo $numProduct->products_num;?></p>
             
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Orders</h5>
              <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
              <p class="card-text">number of orders: <?php echo $numOrders->orders_num;;?></p>
             
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Categories</h5>
              
              <p class="card-text">number of categories: <?php echo $numCategories->categories_num;;?></p>
              
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admins</h5>
              
              <p class="card-text">number of admins: <?php echo $numAdmins->admins_num;;?></p>
              
            </div>
          </div>
        </div>
      </div>
  
          
    </div>

    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
<?php require "layout/footer.php"; ?>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>