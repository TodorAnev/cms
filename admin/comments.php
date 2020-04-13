
<?php ob_start(); ?>
<?php include "includes/header.php" ?>
<?php include "../includes/connection.php" ?>
<?php include "functions.php" ?>

    <div id="wrapper">

<?php include "includes/nav.php" ?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                                Welcome to the admin page
                            <small><?php echo currentUser(); ?></small>
                        </h1>
                    <?php if(isset($_GET['source'])){
                        $source = $_GET['source'];    
                    } else{
                        $source = '';
                    }
                    switch ($source) {
                        case 'view_user_comments':
                            include "includes/view_user_comments.php";
                            break;
                            
                        case 'view_post_comments';
                            include "includes/view_post_comments.php";
                            break;
                        
                        default:
                            include "includes/view_all_comments.php";
                            break;
                    }
                    ?>
                    </div>
                </div>

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>

<?php include "includes/footer.php" ?>
