<?php include "includes/connection.php" ?>
<?php include "includes/header.php" ?>
<?php include "includes/nav.php"  ?>


<!-- Page Content -->
<div class="container">

<div class="row">
    <div class="col-md-8">

    <!-- First Blog Post -->
    <?php 

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

    $result = query("SELECT * FROM tbl_posts WHERE p_active = 1");
    $p_count = mysqli_num_rows($result);
    $p_count = ceil($p_count / $per_page);


    $result = query("SELECT * FROM tbl_posts WHERE p_active = 1 LIMIT $page_1,$per_page");
    $returns = mysqli_num_rows($result);
    if($returns == 0){
        echo "<h3 class='text-center'>There are no active posts</h3>";
    } else {
    while($row = $result->fetch_assoc()) {
        $p_id = $row['id'];
        $p_title = $row['p_title'];
        $p_date = $row['p_date'];
        $p_author = $row['p_author'];
        $p_content = substr($row['p_content'], 0,100);
        $p_image = $row['p_picture'];
        $p_active = $row['p_active'];


        ?>
        <h2>
            <a href="post/<?php echo $p_id ?>"><?php echo $p_title; ?></a>
        </h2>
        <p class="lead">
            by <a href="author_posts.php?p_author=<?php echo $p_author ?>&p_id=<?php echo $p_id ?>"><?php echo $p_author; ?></a>
        </p>
        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $p_date; ?></p>
        <hr>
        <img class="img-responsive" src="images/<?php echo imagePlaceholder($p_image)?>" alt="">

        <hr>
        <p><?php echo $p_content; ?></p>
        <a class="btn btn-primary" href="post.php?p_id=<?php echo $p_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

        <hr>
<?php } ?>
<?php } ?>
</div>

    <?php include "includes/sidebar.php" ?>
    </div>
        
    <ul class="pager">
        <?php 
        for ($i=1; $i <= $p_count ; $i++) { 

            if ($i == $page) {
                echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
            } else{
                echo "<li><a href='index.php?page=$i'>$i</a></li>";
            }
        } 
    ?>
    </ul>
    <hr>
    <?php include "includes/footer.php" ?>

