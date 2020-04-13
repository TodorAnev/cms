<?php if(!$_SESSION['id']){header("Location: ../../");} ?>
<form action="" method="post"> 
        <h2>Update a category</h2>
                            <?php 
        if (isset($_GET['edit'])) {
            $cat_id = $_GET['edit'];

            $result = p_statement($query_string = "SELECT * FROM tbl_category WHERE id=?", $type = "i", $vars = [$cat_id]);


            while($row = $result->fetch_assoc()) {
            $cat_id    = $row['id'];
            $cat_title = $row['title'];
     ?>
    <input value="<?php if(isset($cat_title)){echo $cat_title;} ?>"type="text" name="cat_update">
    <?php } ?>
<?php }          
         if (isset($_POST['update'])) { 
            $cat_title = $_POST['cat_update'];

            $vars = [$cat_title , $cat_id];
            p_statement($query_string = "UPDATE tbl_category SET title = ? WHERE id = ?", $type = "si", $vars);

            redirect("categories.php");
        }
         ?>

        <button class="btn btn-primary" type="submit" name="update">Update</button>
</form>

