<?php
include "php/connect.php";
include "php/auth.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    print_r($_POST);
    // exit;
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        
    ];

    $sql = "UPDATE categories SET name=:name, description=:description WHERE id=:id";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);

    header('location: /category.php');
}

$sql = $conn->query('SELECT * FROM categories where id='. $_GET['id']);
$category = $sql->fetch(PDO::FETCH_ASSOC);

$title = "Category";
include "header.php";

?>
    <div class="row">
        <div class="col-md-3 col-12">
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                
                <div class="card-header">
                    <h4 class="card-title">Update Category</h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical"  method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $category['name']?>" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea class="form-control" id="description" name="description" required><?php echo $category['description']?></textarea>
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