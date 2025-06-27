<?php require "../layout/header.php"; ?>
<?php require "../config/config.php";?>

<?php 

if(isset($_SESSION["adminname"])){
    echo "<script>window.location.href='".ADMINURL."'; </script>";
}

if(isset($_POST['submit'])){
    if(empty(($_POST['email']) OR ($_POST['password']))){
        echo'<script>alert("one or more inputs are empty")</script>';
 }else{

    $email=$_POST['email'];
    $password=$_POST['password'];
    
    //query
    $login=$conn->query("SELECT * FROM admins WHERE email='$email'");
    $login->execute();
    $fetch =$login->fetch(PDO::FETCH_ASSOC);

    //validate email
    if($fetch["status"]==0){
      echo "<script>alert('User Is Disabled!')</script>";
    }

    elseif($login->rowCount()>0){
        //validate pass

        if(password_verify($password,$fetch["mypassword"])){
            $_SESSION['adminname']= $fetch['adminname'];
            $_SESSION['email']= $fetch['email'];
            $_SESSION['admin_id']= $fetch['id'];
            $_SESSION['position']= $fetch['position'];
            echo "<script>window.location.href='".ADMINURL."/index.php'; </script>";
        }else{
            echo "<script>alert('Wrong Password')</script>";
        }

    }else{
        echo "<script>alert('email or password is empty')</script>";
    }

  }
}

?>

<div class="container-fluid vh-100"> 
  <div class="row h-100 mt-5">
    <div class="col d-flex justify-content-center align-items-center text-center">
      <div class="card w-50">
        <div class="card-body">
          <h5 class="card-title mt-5">Login</h5>
          <form method="POST" class="p-auto" action="login-admins.php">
              <!-- Email input -->
              <div class="form-outline mb-4">
                <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
              </div>

              <!-- Password input -->
              <div class="form-outline mb-4">
                <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />
              </div>

              <!-- Submit button -->
              <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require "../layout/footer.php";?>