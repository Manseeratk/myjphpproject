<?php
include "php/connect.php";
include "php/auth.php";

$name = isset($_GET['title']) ? $_GET['title'] : null;
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

$sql = 'SELECT p.*, c.name as category_name FROM products p inner join categories c on c.id=p.category_id where p.status = 1';

if ($name) {
    $sql .= " and title like '%".$name."%'";
}

if ($category_id) {
    $sql .= " and category_id =".$category_id;
}

$pagninationSql = $sql;

if(isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$limit = 10;
$offset = ($page-1) * $limit;

$sql .= ' order by title, created_at, updated_at desc LIMIT '.$offset.','.$limit;

$products = $conn->query($sql);
$rows = $products->fetchAll();

$categoriesSql = $conn->query('SELECT * FROM categories');
$categories = $categoriesSql->fetchAll();

$paginate = $conn->prepare($pagninationSql);
$paginate->execute();
$total_record = $paginate->fetchAll();

$title = "Category";
include "header.php";

?>
    <div class="card">
        <div class="card-body">
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-2 form-group">
                        <input type="text" id="fp-default" class="form-control" value="<?php echo $name?>" placeholder="Search By Title" name="title" />
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">Search By Category</option>
                            <?php
                            foreach($categories as $category) { ?>
                                <option <?php if($category['id']==$category_id){?>selected <?php } ?> value="<?php echo $category['id']?>"><?php echo $category['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2 text-left">
                        <button class="btn btn-primary"><i data-feather='search'></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="content-header-right text-md-right col-md-12 col-12 d-md-block d-none">
        <a href="addProduct.php"><button class="btn btn-primary btn-md"> Create <i data-feather='plus'></i></button></a>
    </div>

    <table class="table table table-striped border">
            <br />
            <thead>
                <tr>
                <th>ID</th>
                    <th>Title</th>
                    <!-- <th>URL</th>
                    <th>Image</th> -->
                    <th>Price</th>
                    <th>In Stock</th>
                    <th>Category</th>
                    <!-- <th>Status</th> -->
                    <th>Created At</th>
                    <th >View</th>
                    <th >Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($rows as $row) {
                ?>
                                
                <tr>
                    <td><?php echo $row['id']; ?> </td>
                    <td><?php echo $row['title']; ?></td>
                    <!-- <td><?php //echo $row['url']; ?> </td>
                    <td><?php //echo $row['image']; ?></td> -->
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['in_stock'] ? 'Yes' : 'No'; ?> </td>
                    <td><?php echo $row['category_name']; ?></td>
                    <!-- <td><?php echo $row['status'] ? 'Active' : ''; ?> </td> -->
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="productDetail.php?id=<?php echo $row['id']?>" target="_blank" class="btn btn-primary btn-sm"><i data-feather='eye'></i></a>
                        
                    </td>
                    
                    <td>
                        <a href="editProduct.php?id=<?php echo $row['id']?>" class="btn btn-primary btn-sm"><i data-feather='edit'></i></a>
                        <a class="btn btn-danger btn-sm delete-product" data-toggle="modal" data-target="#modals-delete-product" data-id="<?php echo $row['id']?>"><i data-feather='trash'></i></a>
                    </td>
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <nav aria-label="Page navigation example">
        <?php
            if ($paginate->rowCount() > 0) {
                $total_pages = ceil(count($total_record) / $limit);
                if($total_pages > 1){
                    echo '<ul class="pagination mt-3 justify-content-center">';

                    for($i=1; $i<=$total_pages; $i++) {
                        if ($i == $page) {
                            $active = "active";
                        } else {
                            $active = "";
                        }

                        echo '<li class="page-item '.$active.'"><a class="page-link" href="product.php?title='.$name.'&category_id='.$category_id.'&page='.$i.'">'.$i.'</a></li>';
                    }
                    echo '</ul>';
                }
            }
        ?>
        </nav>
          
        <?php include "footer.php" ?>

        <div class="modal fade" id="modals-delete-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation !</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/deleteProduct.php" method="post" >
                        <div class="modal-body">
                            <h4>Are you sure to delete ? </h4>
                            <input type="hidden" name="product_id" id="product_id" value="" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<script>
    $(document).on("click", ".delete-product", function() {
        var product_id = $(this).data('id');
        $(".modal-body #product_id").val(product_id);
    });
</script>