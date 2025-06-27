<?php
 require "../includes/header.php";
 require "../config/config.php";

 
if(!isset($_SESSION["username"])){
    echo "<script>window.location.href='".APPURL."/index.php'; </script>";
}
?>  
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL;?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Pay with Paypal Page
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                    
                    <!-- Replace "test" with your own sandbox Business account app client ID -->
                    <script src="https://www.paypal.com/sdk/js?client-id=Ac_Wv3laZ7Nhg6R5EOeeXEbhjXlF7VJCNlaQ1hpZOaXa-SQ3d6-L7G9PT5bR4uMp3u37W_H5Qtr2uhN9&currency=USD"></script>
                    <!-- Set up a container element for the button -->
                    <div class="card card-login mb-5">
                        <div id="paypal-button-container"></div>
                    </div>
                    <script>
                        paypal.Buttons({
                        // Sets up the transaction when a payment button is clicked
                        createOrder: (data, actions) => {
                            return actions.order.create({
                            purchase_units: [{
                                amount: {
                                value: '<?php echo $_SESSION['TotalPrice'];?>' // Can also reference a variable or function
                                }
                            }]
                            });
                        },
                        // Finalize the transaction after payer approval
                        onApprove: (data, actions) => {
                            return actions.order.capture().then(function(orderData) {
                             window.location.href='<?php echo APPURL;?>/products/success.php';
                            });
                        }
                        }).render('#paypal-button-container');
                    </script>

                </div>
            </div>
        </div>
<?php require "../includes/footer.php";?>


