<?php
include "php/connect.php";
include "php/auth.php";

$sql = $conn->query('SELECT * FROM products where id='. $_GET['id']);
$product = $sql->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $targetPath = $product['image'];
    
    if(isset($_POST['delete_image']) && $_POST['delete_image'] == 'on' ) {
        
        if (is_file($targetPath)){
            unlink($targetPath);
        }
        $targetPath = '';
    }elseif($_FILES["image"]) {
        $image_file = $_FILES["image"];
        $targetPath = "images/" . $image_file["name"];
        move_uploaded_file($image_file["tmp_name"], __DIR__ . "/".$targetPath);
    }


    $data = [
        'title' => $_POST['title'],
        'image' => $targetPath,
        'price'=> $_POST['price'],
        'description' => $_POST['description'],
        'category_id' => $_POST['category_id'],
        'in_stock' => $_POST['in_stock'],
        'id' => $_POST['id']
    ];

    $sql = "UPDATE products SET title=:title, price=:price, image=:image, category_id=:category_id, description=:description, in_stock=:in_stock WHERE id=:id";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);

    header('location: /product.php');
}



$categoriesSql = $conn->query('SELECT * FROM categories');
$categories = $categoriesSql->fetchAll();

$title = "Product";
include "header.php";

?>
    <div class="row">
        <div class="col-md-3 col-12">
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                
                <div class="card-header">
                    <h4 class="card-title">Update Product</h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical"  method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title" class="form-label">Title:</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $product['title']?>" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="category_id" class="form-label">Category:</label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="">-- Select Category --</option>
                                        <?php
                                        foreach($categories as $category) { ?>
                                            <option <?php if($category['id']==$product['category_id']) {?> selected <?php } ?> value="<?php echo $category['id']?>"><?php echo $category['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- <div class="col-12">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image:</label>
                                    <input type="text" class="form-control" id="image" name="image" required>
                                </div>
                            </div> -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="price" class="form-label">Price:</label>
                                    <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $product['price']?>" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="in_stock" class="form-label">In Stock:</label>
                                    <select class="form-control" id="in_stock" name="in_stock" required>
                                        <option <?php if($product['in_stock']==1) {?> selected <?php } ?> value="1">Yes</option>
                                        <option <?php if($product['category_id']==0) {?> selected <?php } ?> value="0">No</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea class="ckeditor form-control" id="description" name="description" required><?php echo $product['description']?></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image:</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-control-primary custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="colorCheck1" name="delete_image" >
                                    <label class="custom-control-label" for="colorCheck1">Delete Image</label>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="id" value="<?php echo $product['id']?>">
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary mr-1">Update</button>
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
