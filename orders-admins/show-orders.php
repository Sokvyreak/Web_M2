<?php require "../layout/header.php"; ?>
<?php require "../config/config.php";?>
<?php 
if(!isset($_SESSION["adminname"])){
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}
?>
<?php 

// Pagination variables
$recordsPerPage = 10; // Number of records per page
$_SESSION['page'] = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
if($_SESSION['page'] ==0) { $_SESSION['page'] = 1; }
// Fetch total number of records
$stmt = $conn->query("SELECT COUNT(*) FROM orders");
$totalRecords = $stmt->fetchColumn();
$totalPages = ceil($totalRecords / $recordsPerPage); // Total number of pages
if($_SESSION['page']>$totalPages){ $_SESSION['page'] = $totalPages; }

$count = ($_SESSION['page']-1) * $recordsPerPage+1;
$offset = ($_SESSION['page'] - 1) * $recordsPerPage; 
// Fetch records for the current page
$stmt = $conn->prepare("SELECT * FROM orders WHERE is_paid= 1 LIMIT $recordsPerPage OFFSET $offset");
$stmt->execute();
$allOrders = $stmt->fetchAll(PDO::FETCH_OBJ);
$num=1;
?>
    <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Orders</h5>
             <a  href="export.php" class="btn btn-primary mb-4 text-center float-right">Export</a>
              <table class="table table-responsive-lg table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">first name</th>
                    <th scope="col">last name</th>
                    <th scope="col">email</th>
                    <th scope="col">country</th>
                    <th scope="col">status</th>
                    <th scope="col">price in USD</th>
                    <th scope="col">date</th>
                    <th scope="col">update</th>
                    <th scope="col">details</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($allOrders as $order): ?>
                  <tr>
                    <th scope="row"><?php echo $num++?></th>
                    <td><?php echo $order->id?></td>
                    <td><?php echo $order->name?></td>
                    <td><?php echo $order->lname?></td>
                    <td><?php echo $order->email?></td>
                    <td><?php echo $order->country?></td>
                    <td><?php echo $order->status?></td>
                    <td><?php echo $order->price?></td>
                    <td><?php echo $order->created_at?></td>
                    <td>                
                        <a href="update-order.php?id=<?php echo $order->id;?>" class="btn btn-warning text-white mb-4 text-center">update</a>
                    </td>
                    <td>
                        <a href="order-details.php?id=<?php echo $order->id;?>" class="btn btn-info text-white mb-4 text-center">details</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>
      <?php if($totalPages>1): ?>
      <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="show-orders.php?page=<?php echo $_SESSION['page']-1?>">Previous</a></li>
            <?php for( $i = 1; $i <= $totalPages; $i++ ): ?>
            <li class="page-item"><a class="page-link" href="show-orders.php?page=<?php echo $i?>"><?php echo $i?></a></li>
            <?php endfor; ?>
            <li class="page-item"><a class="page-link" href="show-orders.php?page=<?php echo $_SESSION['page']+1?>">Next</a></li>
        </ul>
      </nav>
      <?php endif; ?>            

  </div>
<?php require "../layout/footer.php"; ?>