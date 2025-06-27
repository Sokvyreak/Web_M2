<?php 
if(!isset($_SERVER['HTTP_REFERER'])){
    //redirect them to your desired location
    header('location: https://divine-whippet-thankfully.ngrok-free.app/freshcery%20-%20Online/index.php');
    exit;
}
?>
<?php require "../includes/header.php"; ?>
<?php require "../config/config.php";?>

<?php


if(!isset($_SESSION["username"])){
    echo "<script>window.location.href='".APPURL."/auth/login.php'; </script>";
}

if(isset($_GET["id"])){
    $id = $_GET["id"];

    $select = $conn->query("SELECT * FROM products WHERE status=1 AND id='$id'");
    $select->execute();

    $product = $select->fetch(PDO::FETCH_OBJ);

    //relatedProducts

    $relatedProducts = $conn->query("SELECT * FROM products WHERE status=1 AND category_id='$product->category_id' AND id !='$id'");
    $relatedProducts->execute();

    $allRelatedProduct = $relatedProducts->fetchAll(PDO::FETCH_OBJ);

    //var_dump($allRelatedProduct);

    //validating cart products
    if(isset($_SESSION['user_id'])){
        $validate =  $conn->query("SELECT * FROM cart WHERE pro_id='$id' AND user_id='$_SESSION[user_id]';");
        $validate->execute();
    }



}else{
    echo "<script>window.location.href='".APPURL."/404.php'; </script>";
}

if(isset($_POST["submit"])) {
    $checkqty = $product->quantity-$_POST['pro_qty'];
    if($checkqty<0){

        echo "<script>Not Enough Product!</script>";

    }else{

        $pro_id=$_POST['pro_id'];
        $pro_title=$_POST['pro_title'];
        $pro_image=$_POST['pro_image'];
        $pro_price=$_POST['pro_price'];
        $pro_discount=$_POST['pro_discount'];
        $pro_qty=$_POST['pro_qty'];
        $user_id=$_POST['user_id'];
        $pro_subtotal=$_POST['subtotal_price'];

        $insert = $conn->prepare('INSERT INTO cart (pro_id, pro_title, pro_image,pro_price, discount, pro_qty, pro_subtotal, user_id) VALUES(:pro_id,:pro_title,:pro_image,:pro_price,:pro_discount,:pro_qty,:pro_subtotal,:user_id)');
        $insert->execute([
            ':pro_id'=> $pro_id,
            ':pro_title'=> $pro_title,
            ':pro_image'=> $pro_image,
            ':pro_price'=> $pro_price,
            ':pro_discount'=> $pro_discount,
            ':pro_qty'=> $pro_qty,
            ':user_id'=> $user_id,
            ':pro_subtotal'=> $pro_subtotal,
        ]);
        
        $s_id = $conn->lastInsertId();

        $insert2 = $conn->prepare('INSERT INTO order_detail (cart_id,user_id,pro_id,pro_name,quantity,price,discount,sub_total) VALUES(:cart_id,:user_id,:pro_id,:pro_name,:quantity,:price,:discount,:sub_total)');
        $insert2 ->execute([
        ':cart_id'=> $s_id,
        ':user_id'=> $user_id,
        ':pro_id'=> $pro_id,
        ':pro_name'=> $pro_title,
        ':quantity'=> $pro_qty,
        ':price'=> $pro_price,
        ':discount'=> $pro_discount,
        ':sub_total'=> $pro_subtotal,
        ]);

        $update = $conn->prepare("UPDATE products SET quantity=$checkqty WHERE id=$id;");
        $update->execute();
    }
}

?>
<style>
/* CSS for responsive adjustments */
@media (max-width: 576px) {
    .slider-zoom {
        pointer-events: none; /* Disables interaction */
    }

    .slider-zoom img {
        cursor: default; /* Prevents zoom cursor */
    }
}

/* Remove unnecessary side spaces */
body, .container-fluid {
    margin: 0;
    padding: 0;
    overflow-x: hidden; /* Prevent horizontal scrolling */
}
</style>

    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL;?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        <?php echo $product->title?>
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>
        <div class="product-detail">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="slider-zoom">
                            <a href="<?php echo IMGURLPRO;?><?php echo $product->image;?>" class="cloud-zoom" rel="transparentImage: 'data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==', useWrapper: false, showTitle: false, zoomWidth:'500', zoomHeight:'500', adjustY:0, adjustX:10" id="cloudZoom">
                                <img alt="Detail Zoom thumbs image" src="<?php echo IMGURLPRO;?><?php echo $product->image;?>" style="width: 100%;">
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong>Overview</strong><br>
                            <?php echo $product->description;?>
                        </p>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>
                                    <strong>Price</strong> (/Pack)<br>
                                    <?php if($product->discount>0): ?>
                                    <span class="price"><?php echo $product->price - $product->price*($product->discount/100);?>$</span>
                                    <span class="old-price"><?php echo $product->price;?>$</span>
                                    <?php else: ?>
                                    <span class="price"><?php echo $product->price;?>$</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                           
                        </div>
                        <p class="mb-1">
                            <strong>Quantity</strong>
                        </p>
                        <form method="POST" id="form-data">
                            
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="hidden" name="pro_title" value="<?php echo $product->title?>">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="hidden" class="pro_discount" name="pro_discount" value="<?php echo $product->discount?>">
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="hidden" name="pro_image" value="<?php echo $product->image?>">
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="col-sm-5">
                                    <input class="pro_price" type="hidden" name="pro_price" value="<?php echo $product->price?>">
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="hidden" name="pro_id" value="<?php echo $product->id?>">
                                </div>
                            </div>
                            <?php if(isset($_SESSION["user_id"])):?>
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>">
                                </div>
                            </div>
                            <?php endif;?>
                            <div class="row">
                                <div class="col-sm-5">
                                    <input class="form-control pro_qty" type="number" min="1" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="1" name="pro_qty">
                                </div>
                                    <input class="pro_qtys" type="hidden"value=<?php echo $product->quantity;?>>
                                <div class="col-sm-6"><span class="pt-1 d-inline-block">Pack (1000 gram)</span></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="hidden" name="subtotal_price" class="subtotal_price" value="<?php echo ($product->price-($product->price*($product->discount/100)))*1?>">
                                </div>
                            </div>

                            <?php if(isset($_SESSION['username'])): ?>
                            <?php if($validate->rowCount()>0):?>
                                <button class="mt-3 btn btn-primary btn-lg btn-insert" type="submit" name="submit" disabled>
                                    <i class="fa fa-shopping-basket" ></i> Added to Cart
                                </button>
                            <?php else:?>
                                <button class="mt-3 btn btn-primary btn-lg btn-insert" type="submit" name="submit">
                                    <i class="fa fa-shopping-basket"></i> Add to Cart
                                </button>
                            <?php endif;?>
                            <?php else:?>
                                <div class="alert alert-success bg-success text=white text-center mt-3">
                                    Log in to buy this product or add it to cart!
                                </div>
                            <?php endif;?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <section id="related-product">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Related Products</h2>
                        <div class="product-carousel owl-carousel">
                            <?php foreach($allRelatedProduct as $relatedProduct): ?>
                            <div class="item">
                                <div class="card card-product">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">SPECIAL</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                Until <?php echo $relatedProduct->exp_date;?>
                                            </span>
                                            <?php if($relatedProduct->discount>0):?>
                                            <span class="badge badge-primary">
                                                <?php echo $relatedProduct->discount."% OFF"; ?>
                                            </span>
                                            <?php endif;?>
                                        </div>
                                        <img src="<?php echo IMGURLPRO;?><?php echo $relatedProduct->image;?>" alt="Card image 2" class="card-img-top">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="<?php echo APPURL;?>/products/detail-product.php?id=<?php echo $relatedProduct->id; ?>"><?php echo $relatedProduct->title;?></a>
                                        </h4>
                                        <div class="card-price">
                                            <?php if($relatedProduct->discount> 0):?>
                                            <span class="discount"><?php echo $relatedProduct->price;?>$</span>
                                            <span class="reguler"><?php echo $relatedProduct->price-($relatedProduct->price*($relatedProduct->discount/100));?>$</span>
                                            <?php else:?>
                                            <span class="reguler"><?php echo $relatedProduct->price;?>$</span>
                                            <?php endif ;?>
                                        </div>
                                        <a href="<?php echo APPURL;?>/products/detail-product.php?id=<?php echo $relatedProduct->id; ?>" class="btn btn-block btn-primary">
                                            Add to Cart
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php require "../includes/footer.php";?>

    <script>
        $(document).ready(function() {

            function reload(){
                $("body").load("cart.php");
            }

            $(".form-control").keyup(function(){
                var value = $(this).val();
                value = value.replace(/^(0*)/,"");
                $(this).val(1);
            });

            $(".btn-insert").on("click",function(e){
                e.preventDefault();
                var $el = $(this).closest('form');
                var form_data = $("#form-data").serialize()+'&submit=submit';
                var check_qty = $el.find(".pro_qtys").val();
                var pro_qty = $el.find(".pro_qty").val();
                var result = check_qty-pro_qty;
                if(result<0){
                    alert("Product Not Enought!");
                }else{
                    $.ajax({
                    url: "detail-product.php?id=<?php echo $id;?>",
                    method: "post",
                    data: form_data,

                    success: function(){
                        alert("product added to cart");
                        $(".btn-insert").html(" <i class='fa fa-shopping-basket'></i> Added to Cart").prop("disabled",true);
                        reload();
                    }

                });
                }
            });

            $(".pro_qty").mouseup(function () {
                  
                 

                var $el = $(this).closest('form');


                  var pro_qty = $el.find(".pro_qty").val();
                  var pro_price = $el.find(".pro_price").val();
                  var pro_discount = $el.find(".pro_discount").val();

                  var subtotal = (pro_price-(pro_price*(pro_discount/100)))*pro_qty;
                  $el.find(".subtotal_price").val("");        

                  $el.find(".subtotal_price").val(subtotal);
            });

        })
    </script>