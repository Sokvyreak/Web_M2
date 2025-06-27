<?php
 require "../includes/header.php";
 require "../config/config.php";
?>

<?php 
if(!isset($_SERVER['HTTP_REFERER'])){
    //redirect them to your desired location
    header('location: https://divine-whippet-thankfully.ngrok-free.app/freshcery%20-%20Online/index.php');
    exit;
}
?>

<?php
    $products = $conn->query("SELECT * FROM cart WHERE user_id='$_SESSION[user_id]'");
    $products->execute();

    $allProducts = $products->fetchAll(PDO::FETCH_OBJ);
    if(isset($_SESSION['price'])){
        $_SESSION['TotalPrice']=$_SESSION['price']+20;
    }
    if(isset($_POST['submit'])){
        if(empty($_POST['name']) OR empty($_POST['lname']) OR empty($_POST['company_name']) OR empty($_POST['city']) OR empty($_POST['address']) OR empty($_POST['country']) OR empty($_POST['zip_code']) OR empty($_POST['email']) OR empty($_POST['phone']) OR empty($_POST['order_notes'])){
            echo'<script>alert("one or more inputs are empty")</script>';
        }elseif(!is_numeric($_POST["zip_code"])){
            echo'<script>alert("zip_code must be number")</script>';
        }else{
            $name = $_POST['name'];
            $lname = $_POST['lname'];
            $compnay_name = $_POST['company_name'];
            $city = $_POST['city'];
            $country = $_POST["country"];
            $zip_code = $_POST["zip_code"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $order_notes = $_POST["order_notes"];
            $address = $_POST["address"];
            $price = $_SESSION["price"];
            $user_id = $_SESSION["user_id"];

        $insert = $conn->prepare("INSERT INTO orders(name,lname,company_name,address,city,country,zip_code,email,phone_number,order_noteds,price,user_id) VALUES(:name,:lname,:company_name,:address,:city,:country,:zip_code,:email,:phone_number,:order_notes,:price,:user_id);");
        $insert->execute([
            ":name"=>$name,
            ":lname"=>$lname,
            ":company_name"=>$compnay_name,
            ":address"=>$address,
            ":city"=>$city,":country"=>$country,
            ":zip_code"=>$zip_code,
            ":email"=>$email,
            ":phone_number"=>$phone,
            ":order_notes"=>$order_notes,
            ":price"=>$price+20,
            ":user_id"=> $user_id
        ]);
        $_SESSION['order_id']=$conn->lastInsertId();
        echo "<script>window.location.href='".APPURL."/products/charge.php'; </script>";


    }
    }
?>
    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL;?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Checkout
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <section id="checkout">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-7">
                        <h5 class="mb-3">BILLING DETAILS</h5>
                        <!-- Bill Detail of the Page -->
                        <form action="checkout.php" method="POST" class="bill-detail">
                            <fieldset>
                                <div class="form-group row">
                                    <div class="col">
                                        <input class="form-control" placeholder="Name" type="text" name="name">
                                    </div>
                                    <div class="col">
                                        <input class="form-control" placeholder="Last Name" type="text" name="lname">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Company Name" type="text" name="company_name">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Address" name="address"></textarea>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Town / City" type="text" name="city">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="State / Country" type="text" name="country">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Postcode / Zip" type="text" name="zip_code">
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <input class="form-control" placeholder="Email Address" type="email" name="email">
                                    </div>
                                    <div class="col">
                                        <input class="form-control" placeholder="Phone Number" type="tel" name="phone">
                                    </div>
                                </div>
                              
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Order Notes" name="order_notes"></textarea>
                                </div>
                            </fieldset>
                                <button name="submit" type="submit" href="#" class="btn btn-primary float-left">PROCEED TO CHECKOUT <i class="fa fa-check"></i></button>
                        </form>
                        <!-- Bill Detail of the Page end -->
                    </div>
                    <div class="col-xs-12 col-sm-5">
                        <div class="holder">
                            <h5 class="mb-3">YOUR ORDER</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Products</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($allProducts as $product):?>
                                        <tr>
                                            <td>
                                                <?php echo $product->pro_title;?> X <?php echo $product->pro_qty;?>
                                            </td>
                                            <td class="text-right">
                                                <?php echo $product->pro_price;?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                    <tfooter>
                                        <tr>
                                            <td>
                                                <strong>Cart Subtotal</strong>
                                            </td>
                                            <td class="text-right">
                                                <?php if(isset($_SESSION['price'])): ?>
                                                $<?php echo $_SESSION['price']; ?>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Shipping</strong>
                                            </td>
                                            <td class="text-right">
                                                $20
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>ORDER TOTAL</strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>$<?php echo $_SESSION['price']+20; ?></strong>
                                            </td>
                                        </tr>
                                    </tfooter>
                                </table>
                            </div>

                         
                        </div>
                        <!-- <p class="text-right mt-3">
                            <input checked="" type="checkbox"> I’ve read &amp; accept the <a href="#">terms &amp; conditions</a>
                        </p> -->
                        <div class="clearfix">
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php require "../includes/footer.php";?>