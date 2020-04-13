<?php include "includes/connection.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/nav.php";  ?>

<?php if (isset($_POST['liked'])) {
    $p_id = $_POST['p_id'];
    $u_id = $_POST['u_id'];

    // 1. FETCHING POST  
    $result = p_statement($query_string = "SELECT * FROM tbl_posts WHERE id = ?", $type = "i", $vars = [$p_id]);
    $post = $result->fetch_assoc();
    $likes = $post['p_likes'];
    // 2.UPDATE POST WITH LIKES
    p_statement($query_string = "UPDATE tbl_posts SET p_likes=$likes+1 WHERE id=?", $type = "i", $vars= [$p_id]);
    // 3.CREATE LIKES FOR POSTS
    p_statement($query_string = "INSERT INTO tbl_likes(u_id, p_id) VALUES(?, ?)", $type = "ii" , $vars = [$u_id, $p_id]);
} 

if (isset($_POST['unliked'])) {
    $p_id = $_POST['p_id'];
    $u_id = $_POST['u_id'];

    // 1. FETCHING POST  
    $result = p_statement($query_string = "SELECT * FROM tbl_posts WHERE id = ?", $type = "i", $vars = [$p_id]);
    $post = $result->fetch_assoc();
    $likes = $post['p_likes'];
    // 2.UPDATE POST WITH DISLIKE
    p_statement($query_string = "UPDATE tbl_posts SET p_likes=$likes-1 WHERE id=?", $type = "i", $vars= [$p_id]);
    // 3.DELETE LIKE FOR CURRENT USER
    p_statement($query_string = "DELETE FROM tbl_likes WHERE p_id = ? AND u_id = ?", $type = "ii" , $vars = [$p_id, $u_id]);
} 

?>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-md-8">

    <!-- First Blog Post -->
    <?php 

    if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];

    p_statement($query_string = "UPDATE tbl_posts SET p_views_count = p_views_count + 1 WHERE id = ?", $type = "i", $vars= [$p_id]);

    $result = p_statement($query_string = "SELECT * FROM tbl_posts WHERE id=?", $type = "i", $vars = [$p_id]);
    while($row = $result->fetch_assoc()) {
        $p_title = $row['p_title'];
        $p_date = $row['p_date'];
        $p_author = $row['p_author'];
        $p_content = $row['p_content'];
        $p_image = $row['p_picture'];
        ?>

        <!-- First Blog Post -->
        <h2>
            <a href="#"><?php echo $p_title; ?></a>
        </h2>
        <p class="lead">
            by <a href="../author_posts.php?p_author=<?php echo $p_author ?>&p_id=<?php echo $p_id ?>"><?php echo $p_author; ?></a>
        </p>
        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $p_date; ?></p>
        <hr>
        <img class="img-responsive" src="../images/<?php echo imagePlaceholder($p_image)?>" alt="">
        <hr>
        <p><?php echo $p_content; ?></p>
        <hr>
        <?php if(isLoggedIn()){ ?>
         <div class="row">
        <p class="pull-right"><a class='<?php echo userLikedPost($p_id) ? 'unlike' : 'like'?>' href=""><span class="glyphicon glyphicon-thumbs-up"></span><?php echo userLikedPost($p_id) ? ' Unlike' : ' Like'?></a></p> <!-- It changes the class with each click, that is why the like is removed and added at the bottom of the page in the javascript -->
        </div>
        <?php } else { ?>
        <div class="row">
            <p class="pull-right">You need to <a href="/cms/login.php">Login</a> to like</p>
        </div>
       <?php } ?>    
        <div class="row">
            <p class="pull-right text-primary">Likes : <?php echo getPostlikes($p_id); ?></p>
        </div>

        <div class="clearfix"></div>
    <?php  } ?>  

         <!-- Blog Comments -->

    <?php 
if (isset($_POST['submit'])) {
    $com_content = $_POST['comment'];
    $com_author = $_SESSION['username'];
    $com_p_id = $p_id;
    $com_date = date('d-m-y');

    if (!empty($com_content)) {
    $vars = [$com_p_id, $com_content, $com_author];
    p_statement($query_string = "INSERT INTO tbl_comments (com_p_id, com_content, com_date, com_author ) VALUES ( ? , ? , now(), ?)", $type = "iss", $vars);
    } 

    echo "<h3 style='color:#337ab7'>Your comment needs to be approved</h3>";

} ?>

<!-- Comments Form -->
<?php if(isLoggedIn()){ ?>
<div class="well">
    <h4>Leave a Comment:</h4>
    <form action="" method="post">
      <div class="form-group">
        <label>Comment:</label>
        <textarea name="comment" class="form-control" rows="3"></textarea>
      </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php } else { ?>
    <div class="row">
        <p class="pull-right">You need to <a href="/cms/login.php">Login</a> to comment</p>
    </div>
   <?php } ?>   

<hr>
      <?php  } else{
header("Location: ../");

}

?> 
    <!-- Comment -->
    <?php 
        $result_com_select = p_statement($query_string = "SELECT * FROM tbl_comments WHERE com_status = 1 AND com_p_id = ? ORDER BY com_p_id DESC", $type = "i", $vars = [$p_id]);

        while($row = $result_com_select->fetch_assoc()) {
        $com_content = $row['com_content'];
        $com_date = $row['com_date'];
        $com_author = $row['com_author'];
     ?>

    <div class="media">
    <a class="pull-left" href="#">
        <img class="media-object" src="http://placehold.it/64x64" alt="">
    </a>
        <div class="media-body">
            <h4 class="media-heading"><?php echo $com_author ?>
                <small><?php echo $com_date ?></small>
            </h4>
            <?php echo $com_content ?>
        </div>
    </div>
<?php } ?>

</div>
    
<?php include "includes/sidebar.php" ?>

<?php include "includes/footer.php" ?>
<script>
    $(document).ready(function(){
        var p_id = <?php echo $p_id; ?>;
        var u_id = <?php echo loggedInUserId(); ?>;
        $('.like').click(function(){
            // LIKE
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $p_id ?>",
                type: 'post',
                data: {
                    'liked' : 1,
                    'p_id' : p_id,
                    'u_id' : u_id

                }
            });

        });
        $('.unlike').click(function(){

            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $p_id ?>",
                type: 'post',
                data: {
                    'unliked' : 1,
                    'p_id' : p_id,
                    'u_id' : u_id

                }
            });

        });
    });
</script>
