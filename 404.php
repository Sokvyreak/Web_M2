<?php 
if(!isset($_SERVER['HTTP_REFERER'])){
    //redirect them to your desired location
    header('location: https://divine-whippet-thankfully.ngrok-free.app/freshcery%20-%20Online/index.php');
    exit;
}
?>
<?php require 'includes/header.php'; ?>
<?php require 'config/config.php'; ?>

<div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL; ?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        404 Page, we cannot find the page that you are looking for.
                    </h1>
                    <!-- <p class="lead">
                        Save time and leave the groceries to us.
                    </p> -->
                    <a href="<?php echo APPURL; ?>" class="btn btn-primary text-uppercase">home</a>

                  
                </div>
            </div>
</div>

<?php require 'includes/footer.php'; ?>