<?php require "../layout/header.php"; ?>
<?php require "../config/config.php";?>
<?php 
if(!isset($_SESSION["adminname"])){
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}

if(isset($_POST['submit'])){
    if(empty(($_POST['name']) OR ($_POST['icon']) OR ($_POST['description']) OR ($_FILES['image']['name']))){
        echo '<script>alert("one or more inputs are empty")</script>';
    } else {
        $name = $_POST['name'];
        $icon = $_POST['icon'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];
        $dir = ONLINE1 . basename($image);

        $insert = $conn->prepare("INSERT INTO categories(name, image, icon, description) VALUES(:name, :image, :icon, :description);");
        $insert->execute([
            ":name" => $name,
            ":image" => $image,
            ":icon" => $icon,
            ":description" => $description,
        ]);

        if(move_uploaded_file($_FILES["image"]["tmp_name"], $dir)){
            echo "<script>window.location.href='".ADMINURL."/categories-admins/show-categories.php'</script>";
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
                <h5 class="card-title mb-5 d-inline">Create Categories</h5>
                <form method="POST" action="create-category.php" enctype="multipart/form-data">
                    <!-- Name input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="name" id="nameInput" class="form-control" placeholder="name" />
                    </div>
                    <!-- Icon input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="icon" id="iconInput" class="form-control" placeholder="icon" />
                    </div>
                    <!-- Description input -->
                    <div class="form-group">
                        <label for="descriptionTextarea">Description</label>
                        <textarea name="description" placeholder="description" class="form-control" id="descriptionTextarea" rows="3"></textarea>
                    </div>
                    <!-- Image input -->
                    <div class="form-outline mb-4 mt-4">
                        <label>Image</label>
                        <input type="file" name="image" id="imageInput" class="form-control" placeholder="image" />
                    </div>
                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require "../layout/footer.php"; ?>
