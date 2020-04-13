<?php  include "includes/connection.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/nav.php"; ?> 
<?php 
require 'classes/config.php';
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

if (!isset($_SESSION['u_role'])) {
        header("Location: /cms");
}
    if(ifItIsMethod('post')){
    if(isset($_POST['body'])){
        $body = $_POST['body'];
        $subject = $_POST['subject'];
        $username = $_SESSION['username'];
        $email = 'toshkoanev@abv.bg';

        // configure phpmailer

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

        $mail->Subject = "$subject";

        $mail->Body = "$body";

        if($mail->send()){
            $emailSent = true;
        } else {
            echo "Not sent";
        }
        
    }
}
?>


    <!-- Navigation -->
    
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
                        </div>
                        <div class="form-group">  
                        <textarea class="form-control" name="body" id="body" placeholder="Enter your message" cols="50" rows="10"></textarea>
                        </div>
                         
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block btn-primary" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
