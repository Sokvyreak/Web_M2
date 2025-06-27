<?php require "../layout/header.php"; ?>
<?php require "../config/config.php";?>
<?php 
if(!isset($_SESSION["adminname"])){
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}

// Pagination variables
$recordsPerPage = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
if($page ==0) { $page = 1; }

// Fetch total number of records
$stmt = $conn->query("SELECT COUNT(*) FROM admins");
$totalRecords = $stmt->fetchColumn();
$totalPages = ceil($totalRecords / $recordsPerPage); // Total number of pages
if($page>$totalPages){ $page = $totalPages; }

$count = ($page-1) * $recordsPerPage+1;
$offset = ($page - 1) * $recordsPerPage; 
// Fetch records for the current page
$stmt = $conn->prepare("SELECT * FROM admins LIMIT $recordsPerPage OFFSET $offset");
$stmt->execute();
$allAdmins = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
    <div class="container-fluid">

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Admins</h5>
              <?php if($_SESSION["position"]=="IT"):?>
             <a  href="create-admins.php" class="btn btn-primary mb-4 text-center float-right">Create Admins</a>
             <?php endif;?>
              <table class="table table-responsive-sm table-striped">
                <thead>
                  <tr>
                    <th scope="col">Admin ID</th>
                    <th scope="col">username</th>
                    <th scope="col">email</th>
                    <th scope="col">position</th>
                    <?php if($_SESSION["position"]=="IT"):?>
                    <th scope="col">status</th>
                    <th scope="col">update</th>
                    <?php endif;?>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($allAdmins as $admin): ?>
                  <tr>
                    <th scope="row"><?php echo $admin->id;?></th>
                    <td><?php echo $admin->adminname;?></td>
                    <td><?php echo $admin->email;?></td>
                    <td><?php echo $admin->position;?></td>
                      <?php if($_SESSION["position"] == "IT" AND $admin->id==$_SESSION["admin_id"]):?>
                        <td><button class="btn btn-success  text-center " disabled>Enabled</button></td>
                        <td><a href="update-admins.php?id=<?php echo $admin->id?>" class="btn btn-warning  text-center ">update</a></td>
                    <?php elseif($_SESSION["position"]=="IT"):?>
                      <?php if($admin->status==1):?>
                     <td><a href="status.php?id=<?php echo $admin->id?>&status=<?php echo $admin->status;?>" class="btn btn-success  text-center ">Enabled</a></td>
                     <?php else:?>
                     <td><a href="status.php?id=<?php echo $admin->id?>&status=<?php echo $admin->status;?>" class="btn btn-danger  text-center ">Disabled</a></td>
                     <?php endif;?>
                    <td><a href="update-admins.php?id=<?php echo $admin->id?>" class="btn btn-warning  text-center ">update</a></td>
                    <?php endif;?>
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
            <li class="page-item"><a class="page-link" href="admins.php?page=<?php echo $page-1?>">Previous</a></li>
            <?php for( $i = 1; $i <= $totalPages; $i++ ): ?>
            <li class="page-item"><a class="page-link" href="admins.php?page=<?php echo $i?>"><?php echo $i?></a></li>
            <?php endfor; ?>
            <li class="page-item"><a class="page-link" href="admins.php?page=<?php echo $page+1?>">Next</a></li>
        </ul>
      </nav>
      <?php endif; ?>   


  </div>
<?php require "../layout/footer.php"; ?>
