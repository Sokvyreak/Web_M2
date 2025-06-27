<?php 
require "../config/config.php";
require "../layout/header.php"; 

if(!isset($_SESSION["adminname"])){
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php';</script>";
    exit; // Ensure the script stops here.
}

$category= $conn->query("SELECT * FROM categories;");
$category->execute();
$AllCategory = $category->fetchAll(PDO::FETCH_OBJ);

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $select = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $select->execute([':id' => $id]);
    $row = $select->fetch(PDO::FETCH_OBJ);
}

if(isset($_POST['submit'])){
    // Validate required fields
    if(empty($_POST['title']) || empty($_POST['price']) || empty($_POST['exp_date'])){
        echo '<script>alert("One or more inputs are empty.")</scrip>';
    }elseif(!empty($_FILES['image']['name'])){
        if(!is_numeric($_POST['price']) OR !is_numeric($_POST['discount']) OR !is_numeric($_POST['quantity'])){
        echo '<script>alert("Price, Discount or Quantity must be number!")</script>';
        }else{
        $image = $_POST['image'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $discount = $_POST['discount'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'];
        $exp_date = $_POST['exp_date'];
        $user = $_SESSION['adminname'];

        // Handle image upload
        $image = $_FILES['image']['name'];
        $dir = ONLINE. basename($image);

        // Prepare UPDATE query
        $update = $conn->prepare("UPDATE products SET 
            title = :title, 
            description = :description, 
            price = :price, 
            discount = :discount, 
            quantity = :quantity, 
            exp_date = :exp_date, 
            update_by = :update_by, 
            update_at = :update_at, 
            image = :image 
            WHERE id = '$id'");

        // Execute query
        $update->execute([
            ":title" => $title,
            ":description" => $description,
            ":price" => $price,
            ":discount" => $discount,
            ":quantity" => $quantity,
            ":exp_date" => $exp_date,
            ":update_by" => $user,
            ":update_at" => date("Y-m-d H:i:s"),
            ":image" => $image,
        ]);

        unlink(ONLINE.$row->image);

        // Move uploaded file
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $dir)){
            echo "<script>alert('Update Completed!')</script>";
            echo "<script>window.location.href='".ADMINURL."/products-admins/show-products.php'</script>";
        } else {
            echo '<script>alert("Failed to upload image.")</script>';
        }
    }
    } else {
        if(!is_numeric($_POST['price']) OR !is_numeric($_POST['discount']) OR !is_numeric($_POST['quantity'])){
        echo '<script>alert("Price, Discount or Quantity must be number!")</script>';
        }else{
        $title = $_POST['title'];
        $price = $_POST['price'];
        $discount = $_POST['discount'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'];
        $exp_date = $_POST['exp_date'];
        $user = $_SESSION['adminname'];

        // Prepare UPDATE query
        $update = $conn->prepare("UPDATE products SET 
            title = :title, 
            description = :description, 
            price = :price, 
            discount = :discount, 
            quantity = :quantity, 
            exp_date = :exp_date,
            update_by = :update_by, 
            update_at = :update_at  
            WHERE id = '$id'");

        // Execute query
        $update->execute([
            ":title" => $title,
            ":description" => $description,
            ":price" => $price,
            ":discount" => $discount,
            ":quantity" => $quantity,
            ":exp_date" => $exp_date,
            ":update_by"=> $user,
            ":update_at"=> date("Y-m-d H:i:s"),
        ]);
        echo "<script>alert('Update Completed!')</script>";
        echo "<script>window.location.href='".ADMINURL."/products-admins/show-products.php?page=$_SESSION[page]'</script>";
    }}
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Update Product</h5>
                <form method="POST" action="update-product.php?id=<?php echo $_GET['id'];?>" enctype="multipart/form-data">
                    <!-- Title -->
                    <div class="form-outline mb-4 mt-4">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Title" value="<?php echo $row->title;?>" />
                    </div>

                    <!-- Price -->
                    <div class="form-outline mb-4 mt-4">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control" placeholder="Price" value="<?php echo $row->price;?>" />
                    </div>
                    
                    <!-- Discount -->
                    <div class="form-outline mb-4 mt-4">
                        <label>Discount %</label>
                        <input type="text" name="discount" class="form-control" placeholder="Discount %" value="<?php echo $row->discount;?>" />
                    </div>
                    
                    <div class="form-outline mb-4 mt-4">
                        <label>Quantity</label>
                        <input type="text" name="quantity" class="form-control" placeholder="Quantity" value="<?php echo $row->quantity;?>" />
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3"><?php echo $row->description;?></textarea>
                    </div>

                    <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Category</label>
                        <select name="category_id" class="form-control" id="exampleFormControlSelect1">
                        <option value="<?php echo $row->category_id?>">--select category--</option>
                        <?php foreach($AllCategory as $category): ?>
                        <option value="<?php echo $category->id;?>"><?php echo $category->id?> <?php echo $category->name;?></option>
                        <?php endforeach; ?>
                        </select>
                     </div>

                    <!-- Expiration Date -->
                    <div class="form-group">
                        <label for="exp_date">Expiration Date</label>
                        <select name="exp_date" class="form-control" id="exp_date" required>
                            <option value="">-- Select year --</option>
                            <?php 
                            $current_year = date('Y');
                            for($i = $current_year; $i <= $current_year + 3; $i++): 
                            ?>
                                <option value="<?php echo $i; ?>" 
                                    <?php if($i == $row->exp_date) echo 'selected'; ?>>
                                    <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Image -->
                    <div class="form-outline mb-4 mt-4">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" />
                    </div>

                    <!-- Submit -->
                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Update</button>
                    <a class="btn btn-danger mb-4 text-center" href="show-products.php">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require "../layout/footer.php"; ?>
