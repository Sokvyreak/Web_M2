<?php require "../layout/header.php"; ?>
<?php require "../config/config.php";?>
<?php 
if(!isset($_SESSION["adminname"])){
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}

if(isset($_GET['id'])){
  $id = $_GET['id'];

  $select = $conn->query("SELECT * FROM categories WHERE id='$id';");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);
}
if(isset($_POST['submit'])){
    if(empty($_POST['name']) OR empty($_POST['icon']) OR empty($_POST['description'])){
        echo '<script>alert("one or more inputs are empty")</script>';
    } else {
        $name = $_POST['name'];
        $icon = $_POST['icon'];
        $description = $_POST['description'];
        $user = $_SESSION['adminname'];
        $id = $_POST['id'];

        $update = $conn->prepare("UPDATE categories SET name = :name, icon = :icon, description = :description,update_by = :update_by,update_at=:update_at WHERE id ='$id';)");
        $update->execute([
            ":name" => $name,
            ":icon" => $icon,
            ":description" => $description,
            ":update_by"=> $user,
            ":update_at"=> date("Y-m-d H:i:s"),
        ]);

        echo "<script>window.location.href='".ADMINURL."/categories-admins/show-categories.php?page=$_SESSION[page]';</script>";

    }
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Update Category</h5>
                <form method="POST" action="update-category.php">
                  <div class="form-outline mb-4 mt-4">
                        <input type="hidden" name="id" id="nameInput" class="form-control" placeholder="name" value="<?php echo $row->id;?>"/>
                    </div>
                    <!-- Name input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="name" id="nameInput" class="form-control" placeholder="name" value="<?php echo $row->name;?>"/>
                    </div>
                    <!-- Icon input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="icon" id="iconInput" class="form-control" placeholder="icon" value="<?php echo $row->icon;?>"/>
                    </div>
                    <!-- Description input -->
                    <div class="form-group">
                        <label for="descriptionTextarea">Description</label>
                        <textarea name="description" placeholder="description" class="form-control" id="descriptionTextarea" rows="3"><?php echo $row->description;?></textarea>
                    </div>
                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require "../layout/footer.php"; ?>
