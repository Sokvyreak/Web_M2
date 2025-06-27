<?php 
if(!isset($_SERVER['HTTP_REFERER'])){
    //redirect them to your desired location
    header('location: https://divine-whippet-thankfully.ngrok-free.app/freshcery%20-%20Online/index.php');
    exit;
}
?>
<?php require '../includes/header.php'; ?>
<?php require '../config/config.php'; ?>
<?php 
$status=1;
    
if(!isset($_SESSION["username"])){
    echo "<script>window.location.href='".APPURL."/index.php'; </script>";
}
    if(isset($_SESSION['user_id'])){
        $delete = $conn->prepare("DELETE FROM cart WHERE user_id='$_SESSION[user_id]'");
        $delete->execute();
        $update = $conn->prepare("UPDATE order_detail SET status=:status,order_id='$_SESSION[order_id]' WHERE user_id ='$_SESSION[user_id]' AND status=0;");
        $update->execute([":status"=> $status]);
        $update2 = $conn->prepare("UPDATE orders SET is_paid=:is_paid WHERE id = '$_SESSION[order_id]';");
        $update2->execute([":is_paid"=>1]);
        $delete2 = $conn->prepare("DELETE FROM orders WHERE user_id='$_SESSION[user_id]' AND is_paid=0;");
        $delete2->execute();
    }

?>
<div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL; ?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Payment has been a success 
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                    <a href="<?php echo APPURL; ?>" class="btn btn-primary text-uppercase">home</a>

                  
                </div>
            </div>
</div>

<?php require '../includes/footer.php'; ?>