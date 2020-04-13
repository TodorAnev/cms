<?php 
if ($_SESSION['u_role'] !== 'admin') {
        header("Location: index.php");
    }
  if (isset($_GET['u_id'])) {
    $u_id = $_GET['u_id'];

    $result = p_statement($query_string = "SELECT * FROM tbl_users WHERE id=?", $type = "i", $vars = [$u_id]);
    while($row = $result->fetch_assoc()) {
        $username = $row['u_username'];
        $f_name   = $row['u_f_name'];
        $l_name   = $row['u_l_name'];
        $email    = $row['u_email'];
        $role     = $row['u_role'];
    }

    if (isset($_POST['submit'])) {

      $u_username = $_POST['username'];
      $u_password = $_POST['password'];
      $u_f_name   = $_POST['u_f_name'];
      $u_l_name   = $_POST['u_l_name'];
      $u_email    = $_POST['email'];
      $u_role     = $_POST['u_role'];

      if (!empty($u_password)) {
      $hashed_password = password_hash($u_password, PASSWORD_BCRYPT, array('cost' => 12));

      $vars = [$u_username, $hashed_password, $u_f_name, $u_l_name, $u_email, $u_role, $u_id];
      p_statement($query_string = "UPDATE tbl_users SET u_username = ?, u_password = ?, u_f_name = ?, u_l_name = ?, u_email = ?, u_role = ? WHERE id=?", $type = "ssssssi", $vars);

      header("Location: users.php?source=edit_user&u_id=$u_id");
    } else {
      echo "Enter your password";
    }

  } 

} else{
  header("Location: ../");
}

?>
<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label>Username</label>
    <input value="<?php echo $username; ?>"type="text" class="form-control" name="username">
  </div>

  <div class="form-group">
    <label>Password</label>
    <input autocomplete="off" type="password" class="form-control" name="password"> <!-- i removed <?php //echo $password; ?> from value -->
  </div>

  <div class="form-group">
    <label>User First Name</label>
    <input value="<?php echo $f_name; ?>" type="text" class="form-control" name="u_f_name">
  </div>

  <div class="form-group">
    <label>User Last Name</label>
    <input value="<?php echo $l_name; ?>" type="text" class="form-control" name="u_l_name">
  </div>

  <div class="form-group">
    <label>User Email</label>
    <input value="<?php echo $email; ?>" type="email" class="form-control" name="email">
  </div>

 <div class="form-group">
    <label>Current Role: </label>
    <h4><?php echo ucfirst($role); ?></h6>
  </div>
  <div class="form-group">
    <label>Change Role</label>
    <select name="u_role">
      <option value="<?php echo $role; ?>">Change Role</option>
      <option value="admin">Admin</option>
      <option value="subscriber">Subscriber</option>
    </select>
  </div>

  <button name="submit" class="btn btn-primary">Update</button>
</form>
