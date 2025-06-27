<?php require "../config/config.php";?>
<?php require "../layout/header.php"; ?>
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
$stmt = $conn->query("SELECT COUNT(*) FROM products");
$totalRecords = $stmt->fetchColumn();
$totalPages = ceil($totalRecords / $recordsPerPage); // Total number of pages
if($_SESSION['page']>$totalPages){ $_SESSION['page'] = $totalPages; }

$count = ($_SESSION['page']-1) * $recordsPerPage+1;
$offset = ($_SESSION['page'] - 1) * $recordsPerPage; 
// Offset for SQL query
// Fetch records for the current page
$stmt = $conn->prepare("SELECT * FROM products LIMIT $recordsPerPage OFFSET $offset");
$stmt->execute();
$Allproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

function Select_Category($conn,$id){
  $select = $conn->prepare("SELECT * FROM categories WHERE id='$id';");
  $select->execute();
  $result = $select->fetch(PDO::FETCH_OBJ);
  return $result->name;
}
?>

      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Products</h5>
              <a  href="create-products.php" class="btn btn-primary mb-4 text-center float-right">Create Products</a>
            
              <table class="table table-responsive-md table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">product</th>
                    <th scope="col">Category</th>
                    <th scope="col">price in USD</th>
                    <th scope="col">discount %</th>
                    <th scope="col">quantity</th>
                    <th scope="col">expiration date</th>
                    <th scope="col">status</th>
                    <th scope="col">Update</th>
                    <th scope="col">Detail</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($Allproducts as $row): ?>
                  <tr>
                    <th scope="row"><?php echo $count++ ?></th>
                    <td><?php echo $row->title;?></td>
                    <td><?php echo Select_Category($conn,$row->category_id);?></td>
                    <td><?php echo $row->price?></td>
                    <td><?php echo $row->discount."%"?></td>
                    <td><?php echo $row->quantity?></td>
                    <td><?php echo $row->exp_date?></td>
                    <?php if($row->status == 0): ?>
                     <td><a href="status.php?id=<?php echo $row->id?>&status=<?php echo $row->status;?>" class="btn btn-danger  text-center " id="status">Unavailable</a></td>
                    <?php else:?>
                     <td><a href="status.php?id=<?php echo $row->id?>&status=<?php echo $row->status;?>" class="btn btn-success  text-center " id="status">Available</a></td>
                    <?php endif;?>
                     <td><a href="update-product.php?id=<?php echo $row->id?>" class="btn btn-warning  text-center ">update</a></td>
                     <td><a href="product-details.php?id=<?php echo $row->id?>" class="btn btn-info text-center">Details</a></td>
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
            <li class="page-item"><a class="page-link" href="show-products.php?page=<?php echo $_SESSION['page']-1?>">Previous</a></li>
            <?php for( $i = 1; $i <= $totalPages; $i++ ): ?>
            <li class="page-item"><a class="page-link" href="show-products.php?page=<?php echo $i?>"><?php echo $i?></a></li>
            <?php endfor; ?>
            <li class="page-item"><a class="page-link" href="show-products.php?page=<?php echo $_SESSION['page']+1?>">Next</a></li>
        </ul>
      </nav>
      <?php endif; ?>

<?php require "../layout/footer.php"; ?>
