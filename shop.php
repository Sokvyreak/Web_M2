<?php require "includes/header.php"; ?>
<?php require "config/config.php";?>
<?php 
    //Categories
    $categories = $conn->query("SELECT * FROM categories");
    $categories->execute();

    $allCategories = $categories->fetchAll(PDO::FETCH_OBJ);

    //Products
    $mostProduct = $conn->query("SELECT * FROM products WHERE status=1;");
    $categories->execute();

    $allProduct = $mostProduct->fetchAll(PDO::FETCH_OBJ);
    
    //FrozenFood
    function Cat_Pro($conn,$id){
        $frozenFood = $conn->prepare("SELECT * FROM products WHERE status=1 AND category_id=:id;");
        $frozenFood->execute([":id"=>$id]);

        return $allFrozenFood = $frozenFood->fetchAll(PDO::FETCH_OBJ);
    }

    //discount
    function dis_pro($discount,$price){
    return $discount_p=$price - ($price * ($discount/100)); 
    }
?>

    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Shopping Page
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">  
                    <div class="shop-categories owl-carousel mt-5">
                        <?php foreach ($allCategories as $category) : ?>
                            <div class="item">
                                <a href="#<?php echo $category->name;?>">
                                    <div class="media d-flex align-items-center justify-content-center">
                                        <span class="d-flex mr-2"><i class="<?php echo $category->icon?>"></i></span>
                                        <div class="media-body">
                                            <h5><?php echo $category->name?></h5>
                                            <p><?php echo $category->description?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <section id="most-wanted">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Most Wanted</h2>
                            <div class="product-carousel owl-carousel">
                                <?php foreach ($allProduct as $product) : ?>
                                    <div class="item">
                                        <div class="card card-product">
                                            <div class="card-ribbon">
                                                <div class="card-ribbon-container right">
                                                    <span class="ribbon ribbon-primary">SPECIAL</span>
                                                </div>
                                            </div>
                                            <div class="card-badge">
                                                <div class="card-badge-container left">
                                                    <?php if ($product->discount>0) : ?>
                                                    <span class="badge badge-default">
                                                        Until <?php echo $product->exp_date?>
                                                    </span>
                                                    <span class="badge badge-primary">
                                                        <?php echo $product->discount. "% OFF"; ?>
                                                    </span>
                                                    <?php else : ?>
                                                    <span class="badge badge-default">
                                                        Until <?php echo $product->exp_date?>
                                                    </span>
                                                    <?php endif; ?>
                                                </div>
                                                <img src="<?php echo IMGURLPRO;?><?php echo $product->image; ?>" alt="Card image 2" class="card-img-top">
                                            </div>
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    <a href="detail-product.html"><?php echo $product->title?></a>
                                                </h4>
                                            <div class="card-price">
                                                <?php if($product->discount> 0) : ?>
                                                    <span class="discount"><?php echo $product->price ."$"?></span>
                                                    <span class="reguler"><?php echo dis_pro($product->discount,$product->price)."$"?></span>
                                                <?php else: ?>
                                                    <span class="reguler"><?php echo $product->price?>$</span>
                                                <?php endif ; ?>
                                            </div>
                                            <?php if($product->quantity==0):?>
                                            <button class="btn btn-block btn-danger text-white" disabled>
                                                Out of Stock
                                            </button>
                                            <?php else:?>
                                            <a href="<?php echo APPURL;?>/products/detail-product.php?id=<?php echo $product->id; ?>" class="btn btn-block btn-primary">
                                                Add to Cart
                                            </a>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php foreach ($allCategories as $category) : ?>
            <section id="<?php echo $category->name;?>">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="title"><?php echo $category->name?></h2>
                            <div class="product-carousel owl-carousel">
                                <?php foreach (Cat_Pro($conn,$category->id) as $product) : ?>
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
                                                        Until <?php echo $product->exp_date?>
                                                    </span>
                                                    <?php if($product->discount>0):?>
                                                    <span class="badge badge-primary">
                                                        <?php echo $product->discount."% OFF";?>
                                                    </span>
                                                    <?php endif;?>
                                                </div>
                                                <img src="<?php echo IMGURLPRO;?><?php echo $product->image; ?>" alt="Card image 2" class="card-img-top">
                                            </div>
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    <a href="detail-product.html"><?php echo $product->title?></a>
                                                </h4>
                                                <div class="card-price">
                                                    <?php if($product->discount>0):?>
                                                    <span class="discount"><?php echo $product->price."$"; ?></span>
                                                    <span class="reguler"><?php echo dis_pro($product->discount,$product->price)."$"; ?></span>
                                                    <?php else:?>
                                                    <span class="reguler"><?php echo $product->price?>$</span>
                                                    <?php endif;?>
                                                </div>
                                                <?php if($product->quantity==0):?>
                                                <button class="btn btn-block btn-danger text-white" disabled>
                                                    Out of Stock
                                                </button>
                                                <?php else:?>
                                                <a href="<?php echo APPURL;?>/products/detail-product.php?id=<?php echo $product->id; ?>" class="btn btn-block btn-primary">
                                                    Add to Cart
                                                </a>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endforeach;?>

    </div>
<?php require "includes/footer.php"; ?>