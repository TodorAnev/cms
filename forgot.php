<?php include "includes/connection.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?> 
<?php 
require 'classes/config.php';
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
 ?>

<?php if(!isset($_GET['forgot'])){
    redirect('index');
} 
if(ifItIsMethod('post')){
    if(isset($_POST['email'])){
        $email = 'toshkoanev@abv.bg';
        $lenght = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($lenght));

        if(emailExists($email)){

            if(p_statement($query_string = "UPDATE tbl_users SET u_token='$token' WHERE u_email = ?", $type = "s", $vars = [$email])){

            $mail = new PHPMailer();
            
            $mail->isSMTP();                                          // Send using SMTP
            $mail->Host       = Config::SMTP_HOST;                    // Set the SMTP server to send through
            $mail->Username   = Config::SMTP_USER;                    // SMTP username
            $mail->Password   = Config::SMTP_PASSWORD;                // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption; 
            $mail->Port       = Config::SMTP_PORT;
            $mail->SMTPAuth   = true;                                 // Enable SMTP authentication  
            $mail->CharSet    = 'UTF-8';
            $mail->isHTML(true);

            $mail->setFrom('toshkoanev@abv.bg' , 'Todor Anev');
            $mail->addAddress($email);

            $mail->Subject = 'This is a test email';

            $mail->Body = "<p>Please click to reset your password<p>
            <a href='http://localhost/cms/reset.php?email=$email&token=$token'>http://localhost/cms/reset.php?email=$email&token=$token</a>




            ";

            if($mail->send()){
                $emailSent = true;
            } else {
                echo "Not sent";
            }
               
            } else {
                echo mysqli_error($conn);
            }
        }
    }
}
?>

<!-- Page Content -->
<div class="container">

<div class="form-gap"></div>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <?php if(!isset($emailSent)): ?>
                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center">Forgot Password?</h2>
                        <p>You can reset your password here.</p>
                        <div class="panel-body">

                            <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                        <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                </div>
                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>

                        </div>
                        <?php else: ?>
                            <h2>Please check you email</h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->