<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php 

    if(!isset($_SESSION["username"])) {
        echo "<script> window.location.href='".APPURL."';</script>";
    }

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        if($id != $_SESSION['user_id']){
            echo "<script> window.location.href='".APPURL."';</script>";
        }

        $select = $conn->query("SELECT * FROM users WHERE id = '$id'");
        $select -> execute();

        $users = $select -> fetch(PDO::FETCH_OBJ);

        if(isset($_POST['submit'])) {
        if(empty($_POST['fullname']) || empty($_POST['address']) || empty($_POST['city']) || empty($_POST['country']) || empty($_POST['zip_code']) || empty($_POST['phone_number'])){
            echo "<script>alert('Update Completed');</script>";
            echo "<script>window.location.href='".APPURL."/index.php'; </script>";
        }else{
            $fullname= $_POST['fullname'];  
            $address= $_POST['address'];  
            $city= $_POST['city'];  
            $country= $_POST['country'];  
            $zip_code= $_POST['zip_code'];  
            $phone_number= $_POST['phone_number'];
            
            $update = $conn->prepare("UPDATE users SET fullname='$fullname', address='$address', city='$city', country='$country', zip_code='$zip_code', phone_number='$phone_number' WHERE id='$id' ");

            $update -> execute();
            echo "<script>alert('Update Completed');</script>";
            echo "<script>window.location.href='".APPURL."/index.php'; </script>";
        }
        }
    }else{
        echo "<script>window.location.href='".APPURL."/404.php'; </script>";
    }

?>

    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL;?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Settings
                    </h1>
                    <p class="lead">
                        Update Your Account Info
                    </p>
                </div>
            </div>
        </div>

        <section id="checkout">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-sm-6">
                        <h5 class="mb-3">ACCOUNT DETAILS</h5>
                        <!-- Bill Detail of the Page -->
                        <form action="setting.php?id=<?php echo $id?>" class="bill-detail" method="POST">
                            <fieldset>
                                <div class="form-group row">
                                    <div class="col">
                                        <input class="form-control" placeholder="Full Name" name="fullname" value="<?php echo $users->fullname;?>" type="text">
                                    </div>
                                   
                                </div>
                               
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Address" name="address" value="<?php echo $users->address;?>"></textarea>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Town / City" type="text" name="city" value="<?php echo $users->city;?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="State / Country" type="text" name="country" value="<?php echo $users->country;?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Postcode / Zip" type="text" name="zip_code" value="<?php echo $users->zip_code;?>">
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <input class="form-control" placeholder="Phone Number" type="tel" name="phone_number" value="<?php echo $users->phone_number;?>">
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    <button class="btn btn-primary" name="submit">UPDATE</button>
                                    <div class="clearfix">
                                </div>
                            </fieldset>
                        </form>
                        <!-- Bill Detail of the Page end -->
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php require "../includes/footer.php";?>