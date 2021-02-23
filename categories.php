<?php include "includes/connection.php" ?>
<?php include "includes/header.php" ?>
<?php include "includes/nav.php"  ?>


<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-md-8">

    <!-- First Blog Post -->
    <?php 

    if (isset($_GET['c_id'])) {
    $c_id = $_GET['c_id'];
     

    $per_page = 3;

    if(isset($_GET['page'])){

        
        $page = $_GET['page'];
    } else{
        $page = "";
    }

    if ($page == "" || $page == 1) {
        $page_1 = 0;
    } else {
        $page_1 = ($page * $per_page) - $per_page;
    }

    $result = p_statement($query_string = "SELECT * FROM tbl_posts WHERE p_active=1 AND cat_id=?", $type = "i", $vars = [$c_id]);
    $p_count = $result->num_rows;
    $p_count = ceil($p_count / $per_page);

    
    $stmt1 = p_statement($query_string = "SELECT id, p_title, p_date, p_author , p_content , p_picture , p_active FROM tbl_posts WHERE cat_id = ? AND p_active = 1 LIMIT $page_1,$per_page", $type = "i", $vars = [$c_id]);
    $rows = $stmt1->num_rows;


    if ($rows == 0) {
        echo "<h3 class='text-center'>There are no active posts in this category</h3>";
    } else {
         while($row = $stmt1->fetch_assoc()) :
        $p_title    = $row['p_title'];
        $p_author   = $row['p_author'];
        $p_date     = $row['p_date'];
        $p_image    = $row['p_picture'];
        $p_content  = $row['p_content'];
        $id         = $row['id'];
             ?>

    <!-- First Blog Post -->
    <h2>
        <a href="post/<?php echo $id ?>"><?php echo $p_title; ?></a>
    </h2>
    <p class="lead">
        by <a href="author_posts.php?p_author=<?php echo $p_author ?>&p_id=<?php echo $id ?>"><?php echo $p_author; ?></a>
    </p>
    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $p_date; ?></p>
    <hr>
    <img class="img-responsive" src="/cms/images/<?php echo "$p_image" ?>" alt="">
    <hr>
    <p><?php echo $p_content; ?></p>
    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
    <hr>
       
    <?php endwhile;  } ?>
    <?php } ?>

    </div>
    <?php include "includes/sidebar.php" ?>
    </div>

    <ul class="pager">
    <?php 
        for ($i=1; $i <= $p_count ; $i++) { 
            if ($i == $page) {
                echo "<li><a class='active_link' href='../categories.php?c_id=$c_id&page=$i'>$i</a></li>";
            } else{
                echo "<li><a href='categories.php?c_id=$c_id&page=$i'>$i</a></li>";
            }  
        } 
    ?>
    </ul>

    <hr>
    <?php include "includes/footer.php" ?>
