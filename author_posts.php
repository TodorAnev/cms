<?php include "includes/connection.php" ?>
<?php include "includes/header.php" ?>
<?php include "includes/nav.php"  ?>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-md-8">
            <!-- First Blog Post -->
        <?php 

    if (isset($_GET['p_author']) && isLoggedIn()){
        $p_author = $_GET['p_author'];
        $p_id = $_GET['p_id'];

    $s_result = p_statement($query_string = "SELECT * FROM tbl_posts WHERE p_author=?", $type = "s", $vars = [$p_author]);
    $q_r_count = mysqli_num_rows($s_result); 
    if ($q_r_count == 0) {
        echo "<h2>This author doesn't have any posts</h2>";
    }else{
        while($row = $s_result->fetch_assoc()) {  
        $p_title   = $row['p_title'];
        $p_date    = $row['p_date'];
        $p_author  = $row['p_author'];
        $p_content = $row['p_content'];
        $p_image   = $row['p_picture'];
        ?>

        <h2>
            <a href="post/<?php echo $p_id ?>"><?php echo $p_title; ?></a>
        </h2>
        <p class="lead">
            by <a href="author_posts.php?p_author=<?php echo $p_author ?>&p_id=<?php echo $p_id ?>"><?php echo $p_author; ?></a>
        </p>
        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $p_date; ?></p>
        <hr>
        <img class="img-responsive" src="/cms/images/<?php echo "$p_image"?>" alt="">
        <hr>
        <p><?php echo $p_content; ?></p>
        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

        <hr>
        <?php
        }   
    } 
} else {redirect("/cms");}
    
    ?> 

    </div>

    <?php include "includes/sidebar.php" ?>

    <?php include "includes/footer.php" ?>
