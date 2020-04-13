
<?php include "includes/header.php" ?>
<?php include "functions.php" ?>
<?php if (!isAdmin()) {
    header("Location: index.php");
} ?>
    <div id="wrapper">

<?php include "includes/nav.php" ?>

<div id="page-wrapper">

    <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                    Welcome to the admin page
                <small><?php echo getUserName(); ?></small>
            </h1>
        </div>
    </div>

    <div class="col-xs-6">
    <?php 

    if (isset($_POST['submit'])) {

    $c_title = $_POST['cat_title'];

    if ($c_title == "" || empty($c_title)) {
        echo "This field should not be empty";
    } else{
    p_statement($query_string = "INSERT INTO tbl_category (title) VALUES (?)", $type = "s", $vars = [$c_title]);
    }
                
} ?>
    <form action="categories.php" method="post">
        <h2>Create a category</h2>
        <input type="text" name="cat_title">
        <button class="btn btn-primary" name="submit">Create</button>
    </form>
    <?php if (isset($_GET['edit'])) {

        $cat_id = $_GET['edit'];
        include "includes/update_form.php";
} 
?>
    </div>
<div class="col-xs-6">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Category Title</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php                 
    $result_c_select = query("SELECT * FROM tbl_category");
    
    while($row = $result_c_select->fetch_assoc()) {
    $cat_id = $row['id'];
    $cat_title = $row['title'];
    echo "<tr>
    <td>$cat_id</td>
    <td>$cat_title</td>"; ?>
    <form action="" method="post">
        <input type="hidden" name="cat_id" value="<?php echo $cat_id ?>">
        <?php echo "<td><button class='btn btn-danger' name='delete'>Delete</button></td>"; ?>
    </form>
    <?php echo "<td><a href='categories.php?edit=$cat_id'>Edit</a></td>
    </tr>";

    } ?>
    <?php 
    if (isset($_POST['delete'])) {
        $delete_id = $_POST['cat_id'];

        query("DELETE FROM tbl_category WHERE id=$delete_id");
        header("Location: categories.php"); 
    } ?>
                </tbody>
            </table>
        </div>

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>

<?php include "includes/footer.php" ?>
