<?php 
if(!isset($_SERVER['HTTP_REFERER'])){
    //redirect them to your desired location
    header('location: https://divine-whippet-thankfully.ngrok-free.app/freshcery%20-%20Online/index.php');
    exit;
}
?>
<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

    
if(!isset($_SESSION["username"])){
    echo "<script>window.location.href='".APPURL."/index.php'; </script>";
}
    if(isset($_POST['delete'])){
        $id= $_POST['id'];

        $select = $conn->prepare("SELECT * from cart WHERE id='$id';");
        $select->execute();
        $product = $select->fetch(PDO::FETCH_OBJ);

        $delete = $conn->prepare("DELETE FROM cart WHERE id='$id'");
        $delete->execute();
        $delete2 = $conn->prepare("DELETE FROM order_detail WHERE cart_id='$id'");
        $delete2 ->execute();

        $update = $conn->prepare("UPDATE products SET quantity=quantity+$product->pro_qty WHERE id=$product->pro_id;");
        $update->execute();
    }

?>


<?php require "../includes/footer.php";?>