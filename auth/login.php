<?php require "../config/config.php"; ?>
<?php require "../includes/header.php"; ?>
<?php

if(isset($_SESSION["username"])){
    echo "<script>window.location.href='".APPURL."/index.php'; </script>";
}

if(isset($_POST['submit'])){
    if(empty($_POST['email']) OR empty($_POST['password'])){
        echo'<script>alert("one or more inputs are empty")</script>';
 }else{

    $email=$_POST['email'];
    $password=$_POST['password'];
    
    //query
    $login=$conn->query("SELECT * FROM users WHERE email='$email'");
    $login->execute();
    $fetch =$login->fetch(PDO::FETCH_ASSOC);

    //validate email

    if($login->rowCount()>0){
        //validate pass

        if(password_verify($password,$fetch["mypassword"])){
            $_SESSION['username']= $fetch['username'];
            $_SESSION['email']= $fetch['email'];
            $_SESSION['user_id']= $fetch['id'];
            $_SESSION['image']= $fetch['image'];

            echo "<script>window.location.href='".APPURL."/index.php'; </script>";
        }else{
            echo "<script>alert('Wrong Password')</script>";
        }

    }else{
        echo "<script>alert('email or password is empty')</script>";
    }

 }
}

?>

    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL; ?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Login Page
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>

                    <div class="card card-login mb-5">
                        <div class="card-body">
                            <form class="form-horizontal" action="login.php" method="POST">
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" type="email" required="" placeholder="Email" name="email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input class="form-control" type="password" required="" placeholder="Password" name="password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                                        <!-- <div class="checkbox">
                                            <input id="checkbox0" type="checkbox" name="remember">
                                            <label for="checkbox0" class="mb-0"> Remember Me? </label>
                                        </div> -->
                                        <!-- <a href="login.html" class="text-light"><i class="fa fa-bell"></i> Forgot password?</a> -->
                                    </div>
                                </div>
                                <div class="form-group row text-center mt-4">
                                    <div class="col-md-12">
                                        <button type="submit" name="submit" class="btn btn-primary btn-block text-uppercase">Log In</button>
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
