<?php include "includes/header.php" ?>
<?php include "functions.php" ?>
<?php if(!isLoggedIn()){header("Location: dashboard.php");}?>

<?php   if (isset($_POST['submit'])) {

    $u_id       = $_SESSION['id'];
    $u_username = $_POST['username'];
    $u_password = $_POST['password'];
    $u_f_name   = $_POST['u_f_name'];
    $u_l_name   = $_POST['u_l_name'];
    $u_email    = $_POST['email'];

 if (!empty($u_username) && !empty($u_email) && !empty($u_password)) {

    $u_username = mysqli_real_escape_string($conn, $u_username);
    $u_email = mysqli_real_escape_string($conn, $u_email);
    $u_password = mysqli_real_escape_string($conn, $u_password);

    $u_password = password_hash($u_password, PASSWORD_BCRYPT, array('cost' => 12));

    $vars = [$u_username, $u_password, $u_f_name, $u_l_name, $u_email, $u_id];
    p_statement($query_string = "UPDATE tbl_users SET u_username = ?, u_password = ?, u_f_name = ?, u_l_name = ?, u_email = ? WHERE id=?", $type = "sssssi", $vars);

  } 

}

?>

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
    <?php 
    $id = $_SESSION['id'];

    $result = query("SELECT * FROM tbl_users WHERE id='$id'");
    while($row = $result->fetch_assoc()) {

      $u_username = $row['u_username'];
      $u_f_name = $row['u_f_name'];
      $u_l_name = $row['u_l_name'];
      $u_email = $row['u_email'];
      $u_role = $row['u_role'];

    } ?>

          <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Username</label>
              <input value="<?php echo $u_username; ?>"type="text" class="form-control" name="username">
            </div>

            <div class="form-group">
              <label>Password</label>
              <input autocomplete="off" type="password" class="form-control" name="password">
            </div>

            <div class="form-group">
              <label>First Name</label>
              <input value="<?php echo $u_f_name; ?>" type="text" class="form-control" name="u_f_name">
            </div>

            <div class="form-group">
              <label>Last Name</label>
              <input value="<?php echo $u_l_name; ?>" type="text" class="form-control" name="u_l_name">
            </div>

            <div class="form-group">
              <label>User Email</label>
              <input value="<?php echo $u_email; ?>" type="email" class="form-control" name="email">
            </div>
             <div class="form-group">
              <label>Current Role:</label>
              <h3><?php echo ucfirst($u_role); ?></h3>
            </div>
            <button name="submit" class="btn btn-primary">Update</button>
          </form>

        </div>
      </div>

        <!-- /.row -->

    </div>
      <!-- /.container-fluid -->

  </div>
    <!-- /#page-wrapper -->

</div>

<?php include "includes/footer.php" ?>
