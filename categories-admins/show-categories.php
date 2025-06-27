<?php require "../layout/header.php"; ?>
<?php require "../config/config.php";?>
<?php 
if(!isset($_SESSION["adminname"])){
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}


// Pagination variables
$recordsPerPage = 10; // Number of records per page
$_SESSION['page'] = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
if($_SESSION['page'] ==0) { $_SESSION['page'] = 1; }

// Fetch total number of records
$stmt = $conn->query("SELECT COUNT(*) FROM categories");
$totalRecords = $stmt->fetchColumn();
$totalPages = ceil($totalRecords / $recordsPerPage); // Total number of pages
if($_SESSION['page']>$totalPages){ $_SESSION['page'] = $totalPages; }

$count = ($_SESSION['page']-1) * $recordsPerPage+1;
$offset = ($_SESSION['page'] - 1) * $recordsPerPage; 
// Fetch records for the current page
$stmt = $conn->prepare("SELECT * FROM categories LIMIT $recordsPerPage OFFSET $offset");
$stmt->execute();
$allCategories = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Categories</h5>
             <a  href="create-category.php" class="btn btn-primary mb-4 text-center float-right">Create Categories</a>
              <table class="table table-responsive-sm table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">update</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allCategories as $category): ?>
                  <tr>
                    <th scope="row"><?php echo $count++;?></th>
                    <td><?php echo $category->name?></td>
                    <td><a  href="update-category.php?id=<?php echo $category->id;?>" class="btn btn-warning text-white text-center ">Update </a></td>
                  </tr>
                  <tr>
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
            <li class="page-item"><a class="page-link" href="show-categories.php?page=<?php echo $_SESSION['page']-1?>">Previous</a></li>
            <?php for( $i = 1; $i <= $totalPages; $i++ ): ?>
            <li class="page-item"><a class="page-link" href="show-categories.php?page=<?php echo $i?>"><?php echo $i?></a></li>
            <?php endfor; ?>
            <li class="page-item"><a class="page-link" href="show-categories.php?page=<?php echo $_SESSION['page']+1?>">Next</a></li>
        </ul>
      </nav>
      <?php endif; ?>   


<?php require "../layout/footer.php"; ?>
