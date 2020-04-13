<?php //if(!$_SESSION['id']){header("Location: ../../");} ?>
<?php if ($_SESSION['u_role'] !== 'admin') {
        header("Location: index.php");
    } ?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Role</th>
                <th>Subscriber</th>
                <th>Admin</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = query("SELECT * FROM tbl_users");
           
        while($row = $result->fetch_assoc()) {
        $u_id = $row['id'];
        $u_username = $row['u_username'];
        $u_f_name   = $row['u_f_name'];
        $u_l_name   = $row['u_l_name'];
        $u_email    = $row['u_email'];
        $u_role     = $row['u_role'];


        echo "<tr>
        <td>$u_id</td>";
        echo "<td>$u_username</td>";
        echo "<td>$u_f_name</td>
        <td>$u_l_name</td>
        <td>$u_email</td>
        <td>$u_role</td>"; ?>

        <form action="" method="post">
                <input type="hidden" name="u_id" value="<?php echo $u_id ?>">
                <?php echo "<td><button class='btn btn-primary' name='subscriber'>Subscriber</button></td>"; ?>
        </form>

        <form action="" method="post">
                <input type="hidden" name="u_id" value="<?php echo $u_id ?>">
                <?php echo "<td><button class='btn btn-primary' name='admin'>Admin</button></td>"; ?>
        </form>

        <form action="" method="post">
                <input type="hidden" name="u_id" value="<?php echo $u_id ?>">
                <?php echo "<td><button class='btn btn-danger' name='delete'>Delete</button></td>"; ?>
        </form>

        <?php 
        echo "<td><a href='users.php?source=edit_user&u_id=$u_id'>Edit</a></td>
        </tr>";
                
} 
    if (isset($_POST['delete'])) {
        $u_id = $_POST['u_id'];
        query("DELETE FROM tbl_users WHERE id=$u_id");
        header("Location: users.php"); 
    }

    if (isset($_POST['subscriber'])) {
        $u_id = $_POST['u_id'];
        query("UPDATE tbl_users SET u_role = 'subscriber' WHERE id=$u_id");
        header("Location: users.php");
    }

    if (isset($_POST['admin'])) {
        $u_id = $_POST['u_id'];
        query("UPDATE tbl_users SET u_role = 'admin' WHERE id=$u_id");
        header("Location: users.php");
    }

    ?>
                            </tbody>
                        </table>