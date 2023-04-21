<?php
include "php/connect.php";
include "php/auth.php";

$name = isset($_GET['name']) ? $_GET['name'] : null;
$sql = 'SELECT * FROM categories where status=1';
if ($name) {
    $sql .= " and name like '%".$name."%'";
}

$pagninationSql = $sql;

if(isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$limit = 10;
$offset = ($page-1) * $limit;

$sql .= ' order by id desc LIMIT '.$offset.','.$limit;

$categoriesSql = $conn->query($sql);
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
                            <input type="text" id="fp-default" class="form-control" value="<?php echo $name?>" placeholder="Search By Name" name="name" />
                        </div>
                        
                        <div class="col-md-2 text-left">
                            <button class="btn btn-primary"><i data-feather='search'></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <div class="content-header-right text-md-right col-md-12 col-12 d-md-block d-none">
        <a href="addCategory.php"><button class="btn btn-primary btn-md"> Create <i data-feather='plus'></i></button></a>
    </div>

    <table class="table table table-striped border">
            <br />
            <thead>
                <tr>
                <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($categories as $row) {
                ?>
                                
                <tr>
                    <td><?php echo $row['id']; ?> </td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?> </td>
                    <td><?php echo $row['status']; ?> </td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="editCategory.php?id=<?php echo $row['id']?>" class="btn btn-primary btn-sm"><i data-feather='edit'></i></a>
                        <a class="btn btn-danger btn-sm delete-category" data-toggle="modal" data-target="#modals-delete-category" data-id="<?php echo $row['id']?>"><i data-feather='trash'></i></a>
                    </td>
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">
        <?php
            if ($paginate->rowCount() > 0) {
                $total_pages = ceil(count($total_record) / $limit);
                if($total_pages > 1) {
                    echo '<ul class="pagination mt-3 justify-content-center">';

                    for($i=1; $i<=$total_pages; $i++) {
                        if ($i == $page) {
                            $active = "active";
                        } else {
                            $active = "";
                        }

                        echo '<li class="page-item '.$active.'"><a class="page-link" href="category.php?name='.$name.'&page='.$i.'">'.$i.'</a></li>';
                    }
                    echo '</ul>';
                }
                
            }
        ?>
        </nav>
       

<?php include "footer.php" ?>

<div class="modal fade" id="modals-delete-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation !</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/deleteCategory.php" method="post" >
                        <div class="modal-body">
                            <h4>Are you sure to delete ? </h4>
                            <input type="hidden" name="category_id" id="category_id" value="" />
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
    $(document).on("click", ".delete-category", function() {
        var category_id = $(this).data('id');
        $(".modal-body #category_id").val(category_id);
    });
</script>
