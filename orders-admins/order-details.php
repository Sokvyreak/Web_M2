<?php require "../layout/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php 
if(!isset($_SESSION["adminname"])) {
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}

// Get order details
if(isset($_GET['id'])) {
    $order_id = $_GET['id'];
    
    // Get main order information
    $order_query = $conn->prepare("SELECT * FROM orders WHERE id = :id");
    $order_query->execute([':id' => $order_id]);
    $order = $order_query->fetch(PDO::FETCH_OBJ);
    
    if(!$order) {
        echo "<script>window.location.href='show-orders.php';</script>";
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
    echo "<script>window.location.href='show-orders.php';</script>";
    exit;
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Order Details #<?php echo $order->id; ?></h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6>Customer Information</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td><?php echo htmlspecialchars($order->name . ' ' . $order->lname); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo htmlspecialchars($order->email); ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?php echo htmlspecialchars($order->phone_number ?? 'N/A'); ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>
                                    <?php 
                                    echo htmlspecialchars(
                                        $order->address . ', ' . 
                                        $order->city . ', ' . 
                                        $order->country . ', ' . 
                                        $order->zip_code
                                    ); 
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Order Information</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th>Order Date</th>
                                <td><?php echo $order->created_at; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?php echo htmlspecialchars($order->status); ?></td>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td>$<?php echo number_format($total, 2); ?></td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td><?php echo htmlspecialchars($order->payment_method ?? 'PayPal'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <h6 class="mt-4">Order Items</h6>
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item->pro_name); ?></td>
                            <td><?php echo $item->quantity; ?></td>
                            <td>$<?php echo number_format($item->price, 2); ?></td>
                            <td>$<?php echo number_format($item->discount, 2); ?></td>
                            <td>$<?php echo number_format($item->sub_total, 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Subtotal</strong></td>
                            <td>$<?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Shipping</strong></td>
                            <td>$<?php echo number_format($shipping_fee, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <td>$<?php echo number_format($total, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="mt-4">
                    <a href="show-orders.php" class="btn btn-secondary">Back to Orders</a>
                    <a href="update-order.php?id=<?php echo $order->id; ?>" class="btn btn-warning text-white">Update Status</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "../layout/footer.php"; ?>