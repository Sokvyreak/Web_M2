<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php 
if(!isset($_SESSION["username"])) {
    echo "<script>window.location.href='".APPURL."'; </script>";
}

// Get order details
if(isset($_GET['id'])) {
    $order_id = $_GET['id'];
    
    // Verify the order belongs to the logged-in user
    $verify_query = $conn->prepare("SELECT user_id FROM orders WHERE id = :id");
    $verify_query->execute([':id' => $order_id]);
    $verify = $verify_query->fetch(PDO::FETCH_OBJ);
    
    if(!$verify || $verify->user_id != $_SESSION['user_id']) {
        echo "<script>window.location.href='".APPURL."';</script>";
        exit;
    }
    
    // Get main order information
    $order_query = $conn->prepare("SELECT * FROM orders WHERE id = :id");
    $order_query->execute([':id' => $order_id]);
    $order = $order_query->fetch(PDO::FETCH_OBJ);
    
    if(!$order) {
        echo "<script>window.location.href='".APPURL."';</script>";
        exit;
    }
    
    // Get order items/details
    $items_query = $conn->prepare("
        SELECT pro_name, quantity, od.price, discount, sub_total 
        FROM order_detail od 
        WHERE order_id = :order_id
    ");
    $items_query->execute([':order_id' => $order_id]);
    $items = $items_query->fetchAll(PDO::FETCH_OBJ);
    
    // Calculate totals
    $subtotal = 0;
    foreach($items as $item) {
        $subtotal += $item->sub_total;
    }
    
    // Set shipping fee
    $shipping_fee = 20.00;
    $total = $subtotal + $shipping_fee;
} else {
    echo "<script>window.location.href='".APPURL."';</script>";
    exit;
}
?>

<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL;?>/assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">
                    Order Details
                </h1>
                <p class="lead">
                    Detailed information about your order.
                </p>
            </div>
        </div>
    </div>

    <section id="checkout" class="pb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Order #<?php echo $order->id; ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Discount</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($items as $item): ?>
                                        <tr>
                                            <td><?php echo $item->pro_name; ?></td>
                                            <td>$<?php echo number_format($item->price, 2); ?></td>
                                            <td><?php echo $item->quantity; ?></td>
                                            <td><?php echo $item->discount; ?>%</td>
                                            <td>$<?php echo number_format($item->sub_total, 2); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-6">Order Date:</dt>
                                <dd class="col-sm-6"><?php echo date('M j, Y', strtotime($order->created_at)); ?></dd>
                                
                                <dt class="col-sm-6">Order Status:</dt>
                                <dd class="col-sm-6">
                                    <span class="badge badge-<?php 
                                        echo $order->status == 'delivered' ? 'success' : 
                                             ($order->status == 'shipped' ? 'primary' : 'warning'); 
                                    ?>">
                                        <?php echo ucfirst($order->status); ?>
                                    </span>
                                </dd>
                                
                                <dt class="col-sm-6">Subtotal:</dt>
                                <dd class="col-sm-6">$<?php echo number_format($subtotal, 2); ?></dd>
                                
                                <dt class="col-sm-6">Shipping Fee:</dt>
                                <dd class="col-sm-6">$<?php echo number_format($shipping_fee, 2); ?></dd>
                                
                                <dt class="col-sm-6 text-success">Total:</dt>
                                <dd class="col-sm-6 text-success">$<?php echo number_format($total, 2); ?></dd>
                            </dl>
                            
                            <h6 class="mt-4">Shipping Address</h6>
                            <address>
                                <?php echo $order->name; ?><br>
                                <?php echo $order->address; ?><br>
                                <?php echo $order->phone; ?><br>
                                <?php echo $order->email; ?>
                            </address>
                            
                            <a href="transaction.php" class="btn btn-primary btn-block mt-3">Back to Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require "../includes/footer.php"; ?>