<?php require "../layout/header.php"; ?>
<?php require "../config/config.php";?>

<?php 
    if(isset($_GET['id']) AND isset($_GET['status'])){
        $id = $_GET['id'] ;
        $status = $_GET['status'] ;

        if($status == 0){
            $update = $conn->prepare("UPDATE admins SET status = 1 WHERE id='$id';");
            $update->execute();
        }
        else{
            $update = $conn->prepare("UPDATE admins SET status = 0 WHERE id = '$id';");
            $update->execute();
        }
        echo "<script>window.location.href='".ADMINURL."/admins/admins.php'</script>";
    }
?>