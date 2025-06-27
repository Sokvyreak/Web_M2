  <?php require "../includes/header.php"; ?>
 <?php require "../config/config.php";?>
 
 <?php
 
function checkEmailExists($conn, $email) {
    $query = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $query->execute([":email" => $email]);
    return $query->fetchColumn() > 0;
}

if(isset($_SESSION["username"])){
    echo "<script>window.location.href='".APPURL."/index.php'; </script>";
}

 if(isset($_POST['submit'])){
    if(empty(($_POST['fullname']) OR ($_POST['email']) OR ($_POST['password']) OR ($_POST['username']) OR ($_POST['email']))){
        echo'<script>alert("one or more inputs are empty")</script>';
 }else{

    if($_POST['password']== $_POST['confirm_password']){
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $image = "user.png";
        if(checkEmailExists($conn, $email)){
            echo "<script>alert('User Already Exist Please Log in')</script>";
        }
        else{
            $insert = $conn->prepare("INSERT INTO users(fullname, email, username, mypassword, image) VALUES(:fullname,:email,:username,:mypassword,:image);");
            $insert->execute([
                ":fullname"=>$fullname,
                ":email"=>$email,
                ":username"=>$username,
                ":mypassword"=>password_hash($password, PASSWORD_DEFAULT),
                ":image"=>$image,
            
            ]);
        }
        // header("location: localhost/auth/login.php");

        echo "<script>window.location.href='login.php'</script>";
    } else {
        echo "<script>alert('Password doesn't match!')</script>";
    }


 }
}

 ?>
 
 

 <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL;?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Register Page
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>

                    <div class="card card-login mb-5">
                        <div class="card-body">
                            <form class="form-horizontal" action="register.php" method="POST">
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" name="fullname" type="text" required="" placeholder="Full Name">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" name="email" type="email" required="" placeholder="Email">
                                    </div>
                                </div>
                                
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" name="username" type="text" required="" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input class="form-control" name="password" type="password" required="" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input class="form-control" name="confirm_password" type="password" required="" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="form-group row text-center mt-4">
                                    <div class="col-md-12">
                                        <button type="submit" name="submit" class="btn btn-primary btn-block text-uppercase">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require "../includes/footer.php"; ?>