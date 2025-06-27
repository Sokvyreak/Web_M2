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
    if(isset($_POST["update"])){
        $id= $_POST["id"];
        $pro_id=$_POST["pro_id"];
        $pro_qty = $_POST['pro_qty'];
        $subtotal = $_POST['subtotal'];

        $select = $conn->prepare("SELECT * FROM cart WHERE id=$id");
        $select->execute();
        $check = $select->fetch(PDO::FETCH_OBJ);
        if($pro_qty==$check->pro_qty){

        }elseif($check->pro_qty<$pro_qty){
            $minus = $pro_qty-$check->pro_qty;

            $update3 = $conn->prepare("UPDATE products SET quantity = quantity -'$minus' WHERE id='$pro_id';");
            $update3->execute();
            $update = $conn->prepare("UPDATE cart SET pro_qty = $pro_qty, pro_subtotal=$subtotal WHERE id=$id;");
            $update->execute();
            $update2 = $conn->prepare("UPDATE order_detail SET quantity= $pro_qty, sub_total=$subtotal WHERE cart_id=$id;");
            $update2 ->execute();

        }else{
            $plus = $check->pro_qty-$pro_qty;
            $update3 = $conn->prepare("UPDATE products SET quantity = quantity + '$plus' WHERE id='$pro_id';");
            $update3->execute();
            $update = $conn->prepare("UPDATE cart SET pro_qty = $pro_qty, pro_subtotal=$subtotal WHERE id=$id;");
            $update->execute();
            $update2 = $conn->prepare("UPDATE order_detail SET quantity= $pro_qty, sub_total=$subtotal WHERE cart_id=$id;");
            $update2 ->execute();

        }
           
    }

?>


<?php require "../includes/footer.php";?>