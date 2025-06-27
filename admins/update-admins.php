<?php 
require "../layout/header.php"; 
require "../config/config.php";

if(!isset($_SESSION["adminname"]) OR $_SESSION["position"]!="IT"){
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php';</script>";
    exit; // Ensure the script stops here.
}
if($_SESSION["position"]!="IT"){
    echo "<script>window.location.href='".ADMINURL."/';</script>";
    exit; // Ensure the script stops here.
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $select = $conn->prepare("SELECT * FROM admins WHERE id =$id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);


    if(isset($_POST['submit'])){
        // Validate required fields
        if(empty($_POST['email']) || empty($_POST['adminname']) || empty($_POST['position'])){
            echo '<script>alert("Email or Username Can be empty.")</script>';
        }elseif(!empty($_POST['password'])){
            $email = $_POST['email'];
            $adminname = $_POST['adminname'];
            $password = $_POST['password'];
            $position = $_POST['position'];

            // Prepare UPDATE query
            $update = $conn->prepare("UPDATE admins SET 
                adminname = :adminname, 
                email = :email, 
                mypassword = :password,
                position = :position 
                WHERE id = $id");

            // Execute query
            $update->execute([
                ":adminname" => $adminname,
                ":email" => $email,
                ":password" => password_hash($password,PASSWORD_DEFAULT),
                ":position" => $position,
            ]);

            if($id==$_SESSION["admin_id"]){
                $_SESSION["adminname"]= $adminname;
            }
            echo "<script>alert('Update completed!')</script>";
            echo "<script>window.location.href='admins.php'</script>";
        } 
        else {
            $email = $_POST['email'];
            $adminname = $_POST['adminname'];
            $position = $_POST['position'];

            // Prepare UPDATE query
            $update = $conn->prepare("UPDATE admins SET 
                adminname = :adminname, 
                email = :email,
                position = :position 
                WHERE id = $id");

            // Execute query
            $update->execute([
                ":adminname" => $adminname,
                ":email" => $email,
                ":position"=> $position,
            ]);

            if($id==$_SESSION["admin_id"]){
                $_SESSION["adminname"]= $adminname;
            }
            echo "<script>alert('Update completed!')</script>";
            echo "<script>window.location.href='admins.php'</script>";
        }
    }
}
?>

    <div class="container-fluid">
       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Admins</h5>
          <form method="POST" action="update-admins.php?id=<?php echo $row->id;?>">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" value="<?php echo $row->email?>"/>
                 
                </div>

                <div class="form-outline mb-4">
                  <input type="text" name="adminname" id="form2Example1" class="form-control" placeholder="username" value="<?php echo $row->adminname?>"/>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Position</label>
                    <select name="position" class="form-control" id="exampleFormControlSelect1">
                      <option value="<?php echo $row->position;?>">--select category--</option>
                      <option value="IT">1. IT</option>
                      <option value="User">2. User</option>
                    </select>
                </div>
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password"/>
                </div>

               
            
                
              


                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-success  mb-4 text-center">Update</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
  </div>
<?php require "../layout/footer.php"; ?>
