<?php include "includes/connection.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?> 

<?php require "vendor/autoload.php"; ?>
<?php 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load(); ?>

<?php $options = array(
    'cluster' => 'eu',
    'useTLS' => true
  ); ?>
<?php $pusher = new Pusher\Pusher(getenv('APP_KEY'),getenv('APP_SECRET'),getenv('APP_ID'), $options) 

?>

<?php 
    
if($_SERVER['REQUEST_METHOD'] == "POST") {

$u_username = trim($_POST['username']);
$u_email    = trim($_POST['email']);
$u_password = trim($_POST['password']);

$error = [
    'u_username'=>'',
    'u_email'=>'',
    'u_password'=>''
];

// it can be (strlen($u_username)) ? $error['u_username'] = 'Username needs to be longer' : '' ; this way id doesn't rewrite
if(strlen($u_username) < 4){
    $error['u_username'] = 'Username needs to be longer';
}
if($u_username == ''){
    $error['u_username'] = 'Username cannot be empty';
}
if(usernameExists($u_username)){
    $error['u_username'] = 'Username already exists';
}
if($u_username == ''){
    $error['u_username'] = 'Username cannot be empty';
}
if(emailExists($u_email)){
    $error['u_email'] = 'Email already exists, <a href="index.php">Please login</a>';
}
if($u_email == ''){
    $error['u_email'] = 'Email cannot be empty';
}
if($u_password == ''){
    $error['u_password'] = 'Password cannot be empty';
}
foreach ($error as $key => $value) {
    if(empty($value)){

        unset($error[$key]);// cleaning empty fields, so they are empty, and the if(empty($error)) can detect it
   }

}

    if(empty($error)){
        registerUser($u_username,$u_email,$u_password);
        $data['message'] = $u_username;
        $pusher->trigger('notifications', 'new_user' , $data);
        loginUser($u_username, $u_password);
    }

} 
?>
    <!-- Page Content -->
    <div class="container">
<section id="login">
<div class="container">
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="form-wrap">
            <h1>Register</h1>

                <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                    <div class="form-group">
                        <label for="username" class="sr-only">username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($u_username) ? $u_username : '' ?>">
                        <p><?php echo isset($error['u_username']) ? $error['u_username'] : '' ?></p>
                    </div>
                     <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($u_email) ? $u_email : '' ?>">
                        <p><?php echo isset($error['u_email']) ? $error['u_email'] : '' ?></p>
                    </div>
                     <div class="form-group">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        <p><?php echo isset($error['u_password']) ? $error['u_password'] : '' ?></p>
                    </div>
                    <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                </form>

            </div>
        </div> <!-- /.col-xs-12 -->
    </div> <!-- /.row -->
</div> <!-- /.container -->
</section>
<hr>

<?php include "includes/footer.php";?>
