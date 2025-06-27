<?php require "../config/config.php";?>
<?php 
    $select = $conn->query("SELECT * FROM orders");
    $select -> execute();
    $allOrders = $select->fetchAll(PDO::FETCH_OBJ);
?>

<h2>Order Management Table</h2>
<?php echo "Date:" .date("d/m/Y") . "<br>";?>
<table border="1">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email</th>
            <th scope="col">Country</th>
            <th scope="col">Status</th>
            <th scope="col">Price in USD</th>
            <th scope="col">Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($allOrders as $order): ?>
        <tr>
            <th scope="row"><?php echo $order->id?></th>
            <td><?php echo $order->name?></td>
            <td><?php echo $order->lname?></td>
            <td><?php echo $order->email?></td>
            <td><?php echo $order->country?></td>
            <td><?php echo $order->status?></td>
            <td><?php echo $order->price?></td>
            <td><?php echo $order->created_at?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
