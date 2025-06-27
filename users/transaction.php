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

        $select = $conn->query("SELECT * FROM orders WHERE user_id = '$id' AND is_paid= 1");
        $select -> execute();

        $data = $select -> fetchAll(PDO::FETCH_OBJ);
    }else{
        echo "<script>window.location.href='".APPURL."/404.php'; </script>";
    }

?>

    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL;?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Your Transactions
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <section id="cart">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="10%">Tran. ID</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($data) > 0):?> 
                                    <?php foreach($data as $row): ?>
                                    <tr>
                                        <td><?php echo $row->id?></td>
                                        <td>
                                            <?php echo $row->name;?>
                                        </td>
                                        <td>
                                            <?php echo $row->created_at;?>
                                        </td>
                                        <td>
                                            <?php echo $row->price;?> $
                                        </td>
                                        <td>
                                            <?php echo $row->status;?>
                                        </td>
                                        <td>
                                            <a href="order-detailed.php?id=<?php echo $row->id; ?>" class="btn btn-primary">Detail</a>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="alert alert-success bg-success text=white text-center">
                                            There are no transaction here just yet!
                                        </div>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                      
                    </div>
                </div>
            </div>
        </section>

       
    </div>
<?php require "../includes/footer.php"; ?>
