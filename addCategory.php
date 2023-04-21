<?php
include "php/connect.php";
include "php/auth.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'status' => 1,
    ];
    $sql = "INSERT INTO categories (name, description, status) VALUES (:name, :description, :status)";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);

    header('location: /category.php'); 
}

$title = "Category";
include "header.php";

?>
    <div class="row">
        <div class="col-md-3 col-12">
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                
                <div class="card-header">
                    <h4 class="card-title">Add Category</h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical"  method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea class="form-control" id="description" name="description" required></textarea>
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
