<?php
include "php/connect.php";
include "php/auth.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetPath = '';
    if($_FILES["image"]) {
        $image_file = $_FILES["image"];
        $targetPath = "images/" . $image_file["name"];
        move_uploaded_file($image_file["tmp_name"], __DIR__ . "/".$targetPath);
    }

    $data = [
        'title' => $_POST['title'],
        //'url' => $_POST['url'],
        'image' => $targetPath,
        'price'=> $_POST['price'],
        'description' => $_POST['description'],
        'category_id' => $_POST['category_id'],
        'status' => 1,
    ];
    $sql = "INSERT INTO products (title, image, price, description, category_id, status) VALUES (:title, :image, :price, :description, :category_id, :status)";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);

    header('location: /product.php');
}

$categoriesSql = $conn->query('SELECT * FROM categories');
$categories = $categoriesSql->fetchAll();
$title = "Category";
include "header.php";

?>
    <div class="row">
        <div class="col-md-3 col-12">
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                
                <div class="card-header">
                    <h4 class="card-title">Add Product</h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical"  method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title" class="form-label">Title:</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="category_id" class="form-label">Category:</label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="">-- Select Category --</option>
                                        <?php
                                        foreach($categories as $category) { ?>
                                            <option value="<?php echo $category['id']?>"><?php echo $category['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-12">
                                <div class="form-group">
                                    <label for="url" class="form-label">URL:</label>
                                    <input type="text" class="form-control" id="url" name="url" required>
                                </div>
                            </div> -->
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="price" class="form-label">Price:</label>
                                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="in_stock" class="form-label">In Stock:</label>
                                    <select class="form-control" id="in_stock" name="in_stock" required>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea class="ckeditor form-control" id="description" name="description" required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image:</label>
                                    <input type="file" class="form-control" id="image" name="image" >
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
        </div>
    </div>
          
    <?php include "footer.php" ?>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
