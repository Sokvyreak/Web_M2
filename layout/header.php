<?php session_start(); ?>
<?php define("ADMINURL","https://raven-intense-supposedly.ngrok-free.app/admin-panel%20-%20Online"); ?>
<?php define("URL","https://raven-intense-supposedly.ngrok-free.app/");?>
<?php define("ONLINE","../../img_product/");?>
<?php define("ONLINE1","../../img_category/");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="<?php echo ADMINURL?>/assets/fonts/sb-bistro/sb-bistro.css" rel="stylesheet" type="text/css">
    <link href="<?php echo ADMINURL?>/assets/fonts/font-awesome/font-awesome.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" media="all" href="<?php echo ADMINURL?>/assets/packages/bootstrap/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo ADMINURL?>/assets/packages/o2system-ui/o2system-ui.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo ADMINURL?>/assets/packages/owl-carousel/owl-carousel.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo ADMINURL?>/assets/packages/cloudzoom/cloudzoom.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo ADMINURL?>/assets/packages/thumbelina/thumbelina.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo ADMINURL?>/assets/packages/bootstrap-touchspin/bootstrap-touchspin.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo ADMINURL?>/styles/style.css">
    <link rel="icon" href="<?php echo ADMINURL?>/assets/img/logo/logo-white.png">
    <script src="<?php echo ADMINURL?>/assets/js/bootbox.min.js"></script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar header-top fixed-top navbar-expand-lg navbar-light background-primary">
      <div class="container">
      <a class="navbar-brand" href="<?php echo ADMINURL?>/"><img src="<?php echo URL;?>admin-panel%20-%20Online/assets/img/logo/logo-white.png" alt="logo" class="img-fluid" style="width:5rem;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarText">
        <?php if(isset($_SESSION['adminname'])): ?>
        <ul class="navbar-nav side-nav background-secondary">
          <li class="nav-item">
            <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) =='index.php'?'active' : '' ?>" style="margin-left: 20px;" href="<?php echo ADMINURL?>/index.php">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF'])== 'admins.php'?'active' : ''?>" href="<?php echo ADMINURL?>/admins/admins.php" style="margin-left: 20px;">Admins</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF'])== 'show-categories.php'? 'active' : ''?>" href="<?php echo ADMINURL?>/categories-admins/show-categories.php" style="margin-left: 20px;">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'show-products.php' ? 'active' : ''; ?>" href="<?php echo ADMINURL?>/products-admins/show-products.php" style="margin-left: 20px;">Products</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'show-orders.php' ? 'active' : ''; ?>" href="<?php echo ADMINURL?>/orders-admins/show-orders.php" style="margin-left: 20px;">Orders</a>
          </li>
        
        </ul>
        <?php endif; ?>
        
        <ul class="navbar-nav ml-md-auto d-md-flex">
          <?php if(!isset($_SESSION['adminname'])): ?>
          <li class="nav-item">
            <a class="nav-link text-white" href="<?php echo ADMINURL?>/admins/login-admins.php">login
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <?php else: ?>
          <li class="nav-item dropdown">
            <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION['adminname'];?>
            </a>
            <div class="dropdown-menu background-secondary" aria-labelledby="navbarDropdown">
              <a class="dropdown-item text-white" href="<?php echo ADMINURL?>/admins/logout.php">Logout</a>
            </div>
          </li>           
          <?php endif; ?>
        </ul>
      </div>
    </div>
    </nav>