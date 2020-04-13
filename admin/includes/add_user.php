<?php 
if(!$_SESSION['id']){header("Location: ../../");}
if ($_SESSION['u_role'] !== 'admin') {
        header("Location: index.php");
    }
  if (isset($_POST['submit'])) {

    $u_username = $_POST['username'];
    $u_password = $_POST['password'];
    $u_f_name   = $_POST['u_f_name'];
    $u_l_name   = $_POST['u_l_name'];
    $u_email    = $_POST['email'];
    $u_role     = $_POST['u_role'];
    
    if (!empty($u_username) && !empty($u_email) && !empty($u_password)) {
    $u_password = password_hash($u_password, PASSWORD_BCRYPT, array('cost' => 12));

    $vars = [$u_username, $u_password, $u_f_name, $u_l_name, $u_email, $u_role];
    p_statement($query_string = "INSERT INTO tbl_users (u_username, u_password, u_f_name, u_l_name, u_email, u_role) VALUES (?, ?, ?, ?, ?, ?)", $type = "ssssss", $vars);
    echo "<h3>User Created</h3>";
  }
}
?>
<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label>Username</label>
    <input type="text" class="form-control" name="username">
  </div>

  <div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" name="password">
  </div>

  <div class="form-group">
    <label>User First Name</label>
    <input type="text" class="form-control" name="u_f_name">
  </div>

  <div class="form-group">
    <label>User Last Name</label>
    <input type="text" class="form-control" name="u_l_name">
  </div>

  <div class="form-group">
    <label>User Email</label>
    <input type="email" class="form-control" name="email">
  </div>

 <div class="form-group">
    <label>Role</label>
    <select name="u_role">
      <option value="subscriber">Select Role</option>
      <option value="admin">Admin</option>
      <option value="subscriber">Subscriber</option>
    </select>
  </div>

  <button name="submit" class="btn btn-primary">Submit</button>
</form>