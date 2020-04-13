<?php include "includes/connection.php"; ?>
<?php include "admin/functions.php"; ?>
<?php session_start(); ?>
<?php 
    $select_cat = "SELECT * FROM tbl_category"; 
    $result_cat = $conn->query($select_cat);
 ?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms">Home Page</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav">
        
                    

                    <?php if (isAdmin()){ 
                        if (isset($_GET['p_id'])){
                        $p_id = $_GET['p_id']; ?>


                        <li><a href="/cms/admin/posts.php?source=edit_post&p_id=<?php echo $p_id ?>">Edit post</a></li>
                        <?php } ?>
                    <?php } ?>
                    <?php 
        while($row = $result_cat->fetch_assoc()) {
        $cat_title = $row['title'];
        $cat_id = $row['id'];

        $category_class = '';
        $registration_class = '';
        $contact_class = '';
        $login_class = '';

        $pageName = basename($_SERVER['PHP_SELF']); // selects the page we are on
        $registration = 'registration.php';
        $contact = 'contact.php';
        $login = 'login.php';

        if (isset($_GET['c_id']) && $_GET['c_id'] == $cat_id) {
            $category_class= 'active';
        } else if($pageName == $registration){
            $registration_class = 'active';
        } else if($pageName == $contact){
            $contact_class = 'active';
        }
          else if($pageName == $login){
            $login_class = 'active';
        }

        echo "<li class='$category_class'><a href='/cms/categories.php?c_id=$cat_id'>$cat_title</a></li>";
    } 

    ?>  

        <li class='<?php echo $registration_class ?>'><a href="/cms/registration">Registration page</a></li>
        

        <?php if(isLoggedIn()):  ?>
            <li class='<?php echo $contact_class ?>'><a href="/cms/contact">Contact page</a></li>
            <li class=''><a href="/cms/admin">Admin page</a></li>
            <li class=''><a href="/cms/includes/logout.php">Logout</a></li>
        <?php else: ?>
            <li class='<?php echo $login_class ?>'><a href="/cms/login">Login page</a></li>
        <?php endif; ?>
        
        
            
        
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


