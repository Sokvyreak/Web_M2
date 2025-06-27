<?php require "../config/config.php";?>
<?php require "../layout/header.php"; ?>
<?php 
if(!isset($_SESSION["adminname"])){
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}

// Function to check if product name already exists
function isProductExists($conn, $productName) {
    // Convert to lowercase and remove spaces for comparison
    $cleanName = strtolower(str_replace(' ', '', $productName));
    
    // Get all products from database
    $stmt = $conn->query("SELECT title FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    foreach ($products as $product) {
        $cleanDbName = strtolower(str_replace(' ', '', $product->title));
        if ($cleanDbName === $cleanName) {
            return true;
        }
    }
    return false;
}

//fetching categories
$category= $conn->query("SELECT * FROM categories;");
$category->execute();
$AllCategory = $category->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['submit'])){
    if(empty($_POST['title']) OR empty($_POST['price']) OR empty($_POST['description']) OR empty($_POST['category_id']) OR empty($_POST['exp_date']) OR empty($_FILES['image']['name'])){
        echo '<script>alert("one or more inputs are empty")</script>';
    } elseif(!is_numeric($_POST['price']) OR !is_numeric($_POST['discount']) OR !is_numeric($_POST['quantity'])){
        echo '<script>alert("Price, Discount or Quantity must be number!")</script>';
    } elseif(isProductExists($conn, $_POST['title'])) {
        echo '<script>alert("Product with this name already exists!")</script>';
    } else {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $discount = $_POST['discount'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];
        $exp_date = $_POST['exp_date'];
        $image = $_FILES['image']['name'];
        $dir = ONLINE . basename($image);

        $insert = $conn->prepare("INSERT INTO products(title, description, price, discount, quantity, exp_date, category_id,image) VALUES(:title, :description, :price, :discount, :quantity, :exp_date, :category_id,:image);");
        $insert->execute([
            ":title" => $title,
            ":description" => $description,
            ":price" => $price,
            ":discount" => $discount,
            ":quantity" => $quantity,
            ":exp_date"=> $exp_date,
            ":category_id"=> $category_id,
            ":image" => $image,
        ]);

        if(move_uploaded_file($_FILES["image"]["tmp_name"], $dir)){
            echo "<script>window.location.href='".ADMINURL."/products-admins/show-products.php'</script>";
        } else {
            echo '<script>alert("Failed to upload image")</script>';
        }
    }
}
?>
       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Products</h5>
              <form method="POST" action="create-products.php" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <label>Title</label>
                  <input type="text" name="title" id="form2Example1" class="form-control" placeholder="title" required />
                </div>

                <div class="form-outline mb-4 mt-4">
                    <label>Price</label>
                    <input type="text" name="price" id="form2Example1" class="form-control" placeholder="price" required />
                </div>
                
                <div class="form-outline mb-4 mt-4">
                    <label>Discount</label>
                    <input type="text" name="discount" id="form2Example1" class="form-control" placeholder="discount %" required />
                </div>
                
                <div class="form-outline mb-4 mt-4">
                    <label>Quantity</label>
                    <input type="text" name="quantity" id="form2Example1" class="form-control" placeholder="quantity" required />
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Description</label>
                    <textarea name="description" placeholder="description" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Category</label>
                    <select name="category_id" class="form-control" id="exampleFormControlSelect1" required>
                      <option value="">--select category--</option>
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
                                    <?php if($i == $current_year) echo 'selected'; ?>>
                                    <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                <div class="form-outline mb-4 mt-4">
                    <label>Image</label>
                    <input type="file" name="image" id="form2Example1" class="form-control" placeholder="image" required />
                </div>

                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>
                <a class="btn btn-danger mb-4 text-center" href="show-products.php">Cancel</a>
              </form>
            </div>
          </div>
        </div>
      </div>
<?php require "../layout/footer.php"; ?>