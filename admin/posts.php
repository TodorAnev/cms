<?php include "includes/header.php" ?>
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
                            <small><?php echo getUserName(); ?></small>
                        </h1>
                    <?php if(isset($_GET['source'])){
                        $source = $_GET['source'];    
                    } else{
                        $source = '';
                    }
                    switch ($source) {
                        case 'add_post':
                            include "includes/add_post.php";
                            break;
                            
                        case 'edit_post';
                            include "includes/edit_post.php";
                            break;

                        case 'my_posts';
                            include "includes/view_user_posts.php";
                                break;

                        case 'posts_comments';
                            include "includes/view_all_posts_comments.php";
                                break;

                        default:
                            include "includes/view_all_posts.php";
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
