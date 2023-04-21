<?php

include "php/connect.php";
include "php/auth.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'status' => 0,
        'id' => $_POST['category_id']
    ];
    
    $sql = "UPDATE categories SET status=:status WHERE id=:id";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);

}
header("Location: /category.php");
?>