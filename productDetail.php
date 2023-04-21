<?php
include "php/connect.php";
include "php/auth.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'name' => $_POST['name'],
        'product_id' => $_POST['product_id'],
        'comment' => $_POST['comment'],
        'status' => 1,
    ];
    $sql = "INSERT INTO comments (name, comment, product_id, status) VALUES (:name, :comment, :product_id, :status)";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);

    header('location: /productDetail.php?id='.$_POST['product_id']);
}

$sql = $conn->query('SELECT p.*, c.name as category_name FROM products p inner join categories c on c.id=p.category_id where p.id='. $_GET['id']);
$product = $sql->fetch(PDO::FETCH_ASSOC);

$commentSql = $conn->query('SELECT * FROM comments where product_id='.$_GET['id'].' order by id desc');
$comments = $commentSql->fetchAll();

$title = "Product Detail";
include "header.php";

?>
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Product Details</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="product.php">Products</a>
                                    </li>
                                    <li class="breadcrumb-item active">Details
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

                
            </div>
            <div class="content-body">
                <!-- app e-commerce details start -->
                <section class="app-ecommerce-details">
                    <div class="card">
                        <!-- Product Details starts -->
                        <div class="card-body">
                            <div class="row my-2">
                                <div class="col-12 col-md-5 d-flex align-items-center justify-content-center mb-2 mb-md-0">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="<?php echo $product['image'] ?? 'images/no-image.jpg'?>" class="img-fluid product-img" alt="product image" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-7">
                                    <h4><?php echo $product['title'] ?></h4>
                                    <span class="card-text item-company">By <a href="#" class="company-name"><?php echo $product['category_name'] ?></a></span>
                                    <div class="ecommerce-details-price d-flex flex-wrap mt-1">
                                        <h4 class="item-price mr-1">$<?php echo $product['price'] ?></h4>
                                        
                                    </div>
                                    <?php if($product['in_stock'] == 1) {?>
                                        <p class="card-text">Available - <span class="text-success">In stock</span></p>
                                    <?php } else { ?>
                                        <p class="card-text">Available - <span class="text-grey">Out of stock</span></p>
                                    <?php } ?>
                                    <p class="card-text">
                                        <?php echo $product['description'] ?>
                                    </p>
                                    

                                    
                                </div>
                            </div>
                        </div>
                        <!-- Product Details ends -->
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <!-- comments -->
                            <?php
                            foreach ($comments as $comment) { ?>
                            <div class="d-flex align-items-start mb-1">
                                <div class="avatar mt-25 mr-50">
                                    <img src="images/small-avatar.jpg" alt="Avatar" height="34" width="34" />
                                </div>
                                <div class="profile-user-info w-100">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 class="mb-0"><?php echo $comment['name']; ?></h6>
                                        
                                    </div>
                                    <small><?php echo $comment['comment']; ?> </small>
                                </div>
                            </div>
                            <?php } ?>
                            <!--/ comments -->

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
                                            <label for="comment" class="form-label">Comment:</label>
                                            <textarea class="form-control" id="comment" name="comment" required></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" id="product_id" name="product_id" value="<?php echo $product['id'] ?>">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mr-1">Post Comment</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </section>

            </div>

            <?php include "footer.php" ?>
