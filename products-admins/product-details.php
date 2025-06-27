<?php require "../config/config.php";?>
<?php require "../layout/header.php"; ?>
<?php 
if(!isset($_SESSION["adminname"])){
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}

// Check if product ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])){
    echo "<script>window.location.href='".ADMINURL."/products-admins/show-products.php'; </script>";
    exit();
}

$id = $_GET['id'];

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch(PDO::FETCH_OBJ);

// Check if product exists
if(!$product){
    echo "<script>window.location.href='".ADMINURL."/products-admins/show-products.php'; </script>";
    exit();
}

// Fetch category name
$category_stmt = $conn->prepare("SELECT name FROM categories WHERE id = :category_id");
$category_stmt->execute([':category_id' => $product->category_id]);
$category = $category_stmt->fetch(PDO::FETCH_OBJ);
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Product Details</h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <h4>Basic Information</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Product Name</th>
                                <td><?php echo htmlspecialchars($product->title); ?></td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td><?php echo htmlspecialchars($category->name); ?></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>$<?php echo htmlspecialchars($product->price); ?></td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td><?php echo htmlspecialchars($product->discount); ?>%</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h4>Inventory & Status</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Quantity Available</th>
                                <td><?php echo htmlspecialchars($product->quantity); ?></td>
                            </tr>
                            <tr>
                                <th>Expiration Date</th>
                                <td><?php echo htmlspecialchars($product->exp_date); ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php if($product->status == 1): ?>
                                        <span class="badge badge-success">Available</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Unavailable</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h4>Description</h4>
                        <div class="border p-3 bg-light rounded">
                            <?php echo nl2br(htmlspecialchars($product->description)); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4>Product Image</h4>
                        <div class="border p-3 bg-light rounded text-center">
                            <?php if(!empty($product->image)): ?>
                                <img src="../../img_product/<?php echo htmlspecialchars($product->image); ?>" 
                                     class="img-fluid rounded" 
                                     style="max-height: 300px; width: auto; object-fit: contain;"
                                     alt="<?php echo htmlspecialchars($product->title); ?>">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span class="text-muted">No image available</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <a href="show-products.php" class="btn btn-secondary">Back to Products</a>
                        <a href="update-product.php?id=<?php echo $product->id; ?>" class="btn btn-warning">Edit Product</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "../layout/footer.php"; ?>