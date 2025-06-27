<?php require "../layout/header.php"; ?>
<?php require "../config/config.php";?>
<?php 

function checkEmailExists($conn, $email) {
    $query = $conn->prepare("SELECT COUNT(*) FROM admins WHERE email = :email");
    $query->execute([":email" => $email]);
    return $query->fetchColumn() > 0;
}

if(!isset($_SESSION["adminname"])){
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}
if($_SESSION["position"]!="IT"){
    echo "<script>window.location.href='".ADMINURL."/'; </script>";
}

 if(isset($_POST['submit'])){
    if(empty($_POST['email']) || empty($_POST['password']) || empty($_POST['adminname']) || empty($_POST['position'])){
        echo'<script>alert("one or more inputs are empty")</script>';
 }else{
        $email = $_POST['email'];
        $password = $_POST['password'];
        $adminname = $_POST['adminname'];
        $position = $_POST['position'];
        if(checkEmailExists($conn, $email)){
            echo "<script>alert('User Already Exist Please Log in')</script>";
        }else{
          $insert = $conn->prepare("INSERT INTO admins(adminname,email, mypassword, position) VALUES(:adminname,:email,:mypassword,:position);");
          $insert->execute([
              ":email"=>$email,
              ":adminname"=>$adminname,
              ":mypassword"=>password_hash($password, PASSWORD_DEFAULT),
              ":position"=>$position,
          
          ]);
        }

        // header("location: localhost/auth/login.php");

        echo "<script>window.location.href='".ADMINURL."/admins/admins.php'</script>";
    }


 }

?>
    <div class="container-fluid">
       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Admins</h5>
          <form method="POST" action="create-admins.php">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" />
                 
                </div>

                <div class="form-outline mb-4">
                  <input type="text" name="adminname" id="form2Example1" class="form-control" placeholder="username" />
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Position</label>
                    <select name="position" class="form-control" id="exampleFormControlSelect1">
                      <option value="User">--select category--</option>
                      <option value="IT">1. IT</option>
                      <option value="User">2. User</option>
                    </select>
                </div>

                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password" />
                </div>

               
            
                
              


                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
  </div>
<?php require "../layout/footer.php"; ?>
