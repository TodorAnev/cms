    <?php 
        if ($_SESSION['u_role'] !== 'admin') {
            header("Location: index.php");
        }
    ?>
            <?php
        $result = query("SELECT * FROM tbl_comments");
        $returns = mysqli_num_rows($result);
        if($returns == 0){
            echo "<h3 class='text-center'>There aren't any comments made</h3>";
        } else { ?>
            
        <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>In response to Post:</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Author</th>
                <th>Status</th>
                <th>Delete</th>
                <th>Approve</th>
                <th>Unapprove</th>
            </tr>
        </thead>
        <tbody>

        <?php while($row = $result->fetch_assoc()) {
        $com_id      = $row['id'];
        $com_p_id    = $row['com_p_id'];
        $com_content = $row['com_content'];
        $com_date    = $row['com_date'];
        $com_author  = $row['com_author'];
        $com_status  = $row['com_status'];
        ($com_status == 1) ? $status = 'Approved' : $status = 'Unapproved';

        echo "<tr>
        <td>$com_id</td>";

        $result_p_select_id = p_statement($query_string = "SELECT * FROM tbl_posts WHERE id=?", $type = "i", $vars = [$com_p_id]);

        while($row = $result_p_select_id->fetch_assoc()) {
        $p_id = $row['id'];
        $p_title = $row['p_title'];
        
        echo "<td><a href='../post/$p_id'>$p_title</a></td>";
        }
        echo "<td>$com_content</td>
        <td>$com_date</td>
        <td>$com_author</td>
        <td>$status</td>";?>

        <form action="" method="post">
        <input type="hidden" name="com_id" value="<?php echo $com_id ?>">
        <input type="hidden" name="com_status" value="<?php echo $com_status ?>">
        <?php echo "<td><button class='btn btn-danger' name='delete'>Delete</button></td>";?>
        </form>

        <form action="" method="post">
        <input type="hidden" name="com_id" value="<?php echo $com_id ?>">
        <input type="hidden" name="com_status" value="<?php echo $com_status ?>">
        <?php echo "<td><button class='btn btn-primary' name='approve'>Approve</button></td>";?>
        </form>

        <form action="" method="post">
        <input type="hidden" name="com_id" value="<?php echo $com_id ?>">
        <input type="hidden" name="com_status" value="<?php echo $com_status ?>">
        <?php echo "<td><button class='btn btn-primary' name='unapprove'>Unapprove</button></td>";?>
        </form>

    <?php } 
    }

        if (isset($_POST['delete'])) {
            $delete_com_id = $_POST['com_id'];
            $com_status = $_POST['com_status'];

            query("DELETE FROM tbl_comments WHERE id=$delete_com_id");
            $result = query("SELECT * FROM tbl_comments WHERE id = $delete_com_id");
            
            while($row = $result->fetch_assoc()) {
            $com_p_id = $row['com_p_id'];
            }

            if($com_status == 1){
            query("UPDATE tbl_posts SET p_comments = p_comments-1 WHERE id = $com_p_id");
            } 
            header("Location: comments.php"); 
        }

        if (isset($_POST['approve'])) {

            $com_id = $_POST['com_id'];
            $com_status = $_POST['com_status'];

            query("UPDATE tbl_comments SET com_status = 1 WHERE id=$com_id");
            $result = query("SELECT * FROM tbl_comments WHERE id = $com_id");
    
            while($row = $result->fetch_assoc()) {
            $com_p_id = $row['com_p_id'];
            }

            if($com_status == 0){
            query("UPDATE tbl_posts SET p_comments = p_comments+1 WHERE id = $com_p_id");
            } 
            header("Location: comments.php");
        }
    
        if (isset($_POST['unapprove'])) {
            $com_id = $_POST['com_id'];
            $com_status = $_POST['com_status'];

            query("UPDATE tbl_comments SET com_status = 0 WHERE id=$com_id");
            header("Location: comments.php");
            query("SELECT * FROM tbl_comments WHERE id = $com_id");

            while($row = $result->fetch_assoc()) {
            $com_p_id = $row['com_p_id'];
            }

            if($com_status == 1){
            query("UPDATE tbl_posts SET p_comments = p_comments-1 WHERE id = $com_p_id");
            } 
            header("Location: comments.php"); 
        }

    ?>
                    </tbody>
                </table>