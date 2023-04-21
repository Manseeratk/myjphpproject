<?php
include "php/connect.php";
include "php/auth.php";

$stmt = $conn->query('SELECT * FROM categories where id='. $_GET['id']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    print_r($_POST);
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'id' => $_POST['id']
    ];
    
    $sql = "UPDATE categories SET name=:name, description=:description WHERE id=:id";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);

    header("Location: index.php");
}

$title = "Category";
include "header.php";

?>


<h1>Edit Category</h1>

<form method="post" action="category_edit.php?id=<?php echo $row['id']?>">
    <div class="mb-3">
        <label for="title" class="form-label">name:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']?>"  required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea class="form-control" id="description" name="description" required><?php echo $row['description']?></textarea>
    </div>
    <input type="hidden" name="id" value="<?php echo $row['id']?>" />
    
    <button type="submit" name="submit" value="submit" class="btn btn-primary">Update Category</button>
</form>


<?php include "footer.php" ?>
