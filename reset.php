<?php include "includes/connection.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?> 
<?php 

    if(!isset($_GET['email']) && !isset($_GET['token'])){
        redirect('index');
    }

    if(p_statement($query_string = "SELECT u_username, u_email, u_token FROM tbl_users WHERE u_token = ?", $type = "s", $vars = [$_GET['token']])){
        
    if(isset($_POST['password']) && isset($_POST['confirmPassword'])){

        $u_password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirmPassword']);

        $error = [
            'u_password'=>'',
            'confirm_password'=>''
        ];

        if($confirm_password == ''){
            $error['u_password'] = 'Please enter both fields';
        }

        if($u_password == ''){
            $error['u_password'] = 'Please enter both fields';
        }

        if(strlen($u_password) < 6 && strlen($confirm_password) < 6){
            $error['u_password'] = 'Password must be longer than 6 characters';
        }

        if($u_password !== $confirm_password){
            $error['confirm_password'] = 'Passwords must be the same';
        }

        foreach ($error as $key => $value) {
            if(empty($value)){
                unset($error[$key]);// cleaning empty fields, so they are empty, and the if(empty($error)) can detect it
           }
    }
    if(empty($error)){

        $u_password = $_POST['password'];
        $hashedPassword = password_hash($u_password , PASSWORD_BCRYPT, array('cost'=>12));


        $stmt = p_statement($query_string = "UPDATE tbl_users SET u_token='', u_password='$hashedPassword' WHERE u_email = ?", $type = "s", $vars = [$_GET['email']]);
     
            if($stmt >= 1){ 
                redirect('/cms/login.php');
            }
        }
    }
} ?>

<!-- Page Content -->
<div class="container">

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">

                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center">Reset Password</h2>
                        <p>You can reset your password here.</p>
                        <div class="panel-body">

                            <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                        <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                    </div>
                                    <p><?php echo isset($error['u_password']) ? $error['u_password'] : '' ?></p>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-check color-blue"></i></span>
                                        <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                    </div>
                                </div>
                                <?php echo isset($error['confirm_password']) ? $error['confirm_password'] : '' ?>
                                <div class="form-group">
                                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                </div>

                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>

                        </div><!-- Body-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->