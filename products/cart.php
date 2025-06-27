<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

    
    if(!isset($_SESSION["username"])){
        echo "<script>window.location.href='".APPURL."/index.php'; </script>";
    }

    $products = $conn->query("SELECT * FROM cart WHERE user_id='$_SESSION[user_id]'");
    $products->execute();

    $allProducts = $products->fetchAll(PDO::FETCH_OBJ);

    $qty = $conn->query("SELECT * FROM products;");
    $qty->execute();
    $resultqty = $qty->fetchAll(PDO::FETCH_OBJ);

    if(isset($_POST['submit'])){
        $inp_price=$_POST['inp_price'];

        $_SESSION['price']= $inp_price;
        echo "<script>window.location.href='".APPURL."/products/checkout.php'; </script>";
    }
?>

    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL;?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Your Cart
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
                                        <th width="10%"></th>
                                        <th>Products</th>
                                        <th>Price (USD)</th>
                                        <th width="15%">Quantity</th>
                                        <th width="15%">Update</th>
                                        <th>Discount %</th>
                                        <th>Subtotal (USD)</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($allProducts) > 0) :?>
                                    <?php foreach($allProducts as $product): ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo IMGURLPRO;?><?php echo $product->pro_image;?>" width="60">
                                        </td>
                                        <td>
                                            <?php echo $product->pro_title;?><br>
                                            <small>1000g</small>
                                        </td>
                                        <td class="pro_price">
                                            <?php echo $product->pro_price;?>
                                        </td>
                                        <td>
                                            <input class="pro_qty form-control" type="number" min="1" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="<?php echo $product->pro_qty;?>" name="vertical-spin">
                                            <input class="pro_id" type="hidden" value="<?php echo $product->pro_id;?>">
                                            <?php foreach($resultqty as $result):?>
                                            <?php if($result->id==$product->pro_id):?>
                                            <input class="pro_qtys" type="hidden" value="<?php echo $result->quantity;?>">
                                            <?php endif;?>
                                            <?php endforeach;?>
                                        </td>
                                        <td>
                                            <button value = "<?php echo $product->id;?>" class="btn btn-primary btn-update" name="update">UPDATE</button>
                                        </td>
                                        <td class="discount">
                                            <?php echo $product->discount;?>
                                        </td>
                                        <td class="subtotal">
                                            <?php echo $product->pro_subtotal;?>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-delete" value="<?php echo $product->id;?>" name="delete"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                    <?php else:?>
                                        <div class="alert alert-success bg-success text=white text-center">
                                            There are no product in cart just yet!
                                        </div>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <a href="<?php echo APPURL;?>/shop.php" class="btn btn-default mt-3">Continue Shopping</a>
                    </div>
                    <div class="col text-right">
                   
                        <div class="clearfix"></div>
                        <h6 class="full_price mt-3"></h6>
                        <form action="cart.php" method="POST">
                            <input class="inp_price form-control" type="hidden" value="" name="inp_price">
                            <?php if(count($allProducts) > 0) :?>
                                <button href="<?php echo APPURL;?>/checkout.php" class="btn btn-lg btn-primary" type="submit" name="submit" id="btnCO">Checkout <i class="fa fa-long-arrow-right"></i></button>
                            <?php endif;?>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php require "../includes/footer.php";?>
<script>
    $(document).ready(function() {
        $(".form-control").keyup(function(){
            var value = $(this).val();
            value = value.replace(/^(0*)/,"");
            $(this).val(1);
    });

        function reload(){
            $("body").load("cart.php");
        }

        function fetch() {

        setInterval(function () {
                  var sum = 0.0;
                  $('.subtotal').each(function()
                  {
                      sum += parseFloat($(this).text());
                  });
                  $(".full_price").html("Total Price: "+sum+"$");
                  $(".inp_price").val(sum);
               }, 100);
            } 

        $(".pro_qty").mouseup(function () {
                  
            var $el = $(this).closest('tr');    

                var pro_qty = $el.find(".pro_qty").val();
                var pro_price = $el.find(".pro_price").html();
                var pro_discount = $el.find(".discount").html();

                var subtotal = (pro_price-(pro_price*(pro_discount/100)))*pro_qty;
                $el.find(".subtotal").html("");        

                $el.find(".subtotal").append(subtotal);                     
      });

      
    $(".btn-update").on('click', function() {
        var $el = $(this).closest('tr');
        var pro_qty = $el.find(".pro_qty").val();
        var check_qty = $el.find(".pro_qtys").val();
        var pro_id = $el.find(".pro_id").val();
        var pro_price = $el.find(".pro_price").html();
        var pro_discount = $el.find(".discount").html();

        var result = check_qty-pro_qty;

        var subtotal = (pro_price-(pro_price*(pro_discount/100)))*pro_qty;
        var id = $(this).val();

        if(result<0){
            alert("Not Enough Product!");
        }else{
            $.ajax({
            type: "POST",
            url: "update-product.php",
            data: {
                update: "update",
                id: id,
                pro_id: pro_id,
                pro_qty: pro_qty,
                subtotal: subtotal
            },
            success: function() {
                alert("Product updated successfully!");
                reload();
            }
        });
        }
    });
      
      $(".btn-delete").on('click', function() {
        var id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "delete-product.php",
                    data:{
                        delete: "delete",
                        id: id,
                        },

                    success: function() {
                        alert("Product Deleted Successfully!");
                        reload();
                    }
                    })
        });
        fetch(); 
    })
</script>