<?php require "../layout/header.php"; ?>
<?php require "../config/config.php";?>
<?php 
if(!isset($_SESSION["adminname"])){
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $select = $conn->query("SELECT * FROM orders WHERE id='$id';");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
}

if(isset($_GET['id'])){
  $id = $_GET['id'];

    if(isset($_POST['submit'])){
        if(empty($_POST['status'])){
            echo '<script>alert("The input can not be empty")</script>';
        } else {
            $status = $_POST['status'];
            $user = $_SESSION['adminname'];

            $update = $conn->prepare("UPDATE orders SET status=:status,update_by=:update_by,update_at=:update_at WHERE id ='$id';");
            $update->execute([
                ":status" => $status,
                ":update_by"=> $user,
                ":update_at"=> date("Y-m-d H:i:s"),
            ]);

            echo "<script>alert('Update Completed');</script>";
            echo "<script>window.location.href='".ADMINURL."/orders-admins/show-orders.php?page=$_SESSION[page]';</script>";

        }
    }
}


?>
<div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Update Orders Status</h5>
              <form method="POST" action="update-order.php?id=<?php echo $id?>">
                
              <div class="form-group mt-5">
                    <select name="status" class="form-control" id="exampleFormControlSelect1">
                      <option value="<?php echo $row->status;?>"><?php echo $row->status;?></option>
                      <option value="In Progress">In Progress</option>
                      <option value="Delivered">Delivered</option>
                    </select>
                </div>

                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-success  mb-4 text-center mt-5">Update</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
<?php require "../layout/footer.php"; ?>