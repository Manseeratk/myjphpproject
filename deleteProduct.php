<?php

include "php/connect.php";
include "php/auth.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'status' => 0,
        'id' => $_POST['product_id'] 
    ];
    
    $sql = "UPDATE products SET status=:status WHERE id=:id";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);

}
header("Location: /product.php");
?>
