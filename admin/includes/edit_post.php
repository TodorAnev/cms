<?php 
if(!$_SESSION['id']){header("Location: ../../");}
  if(isset($_POST['submit'])){

    $p_id           = $_GET['p_id']; 
    $p_title        = $_POST['title'];
    $p_category     = $_POST['categories'];
    $p_status       = $_POST['status'];
    $p_picture      = $_FILES['picture']['name'];
    $p_picture_temp = $_FILES['picture']['tmp_name']; 
    $p_tags         = $_POST['tags'];
    $p_content      = $_POST['content'];
    $p_date         = $_POST['date'];
    move_uploaded_file($p_picture, "../images/$p_picture");

    if (empty($p_picture)) {
      $result = p_statement($query_string = "SELECT * FROM tbl_posts WHERE id=?", $type = "i", $vars = [$p_id]);
      while($row = $result->fetch_assoc()){
        $p_picture = $row['p_picture'];
      }
    }

    $vars = [$p_title, $p_status, $p_tags, $p_content, $p_date, $p_category, $p_picture, $p_id];
    p_statement($query_string = "UPDATE tbl_posts SET p_title = ?, p_active = ?, p_tags = ?, p_content = ?, p_date = ?, cat_id = ?, p_picture = ? WHERE id=?", $type = "sisssssi", $vars);
    echo "<p>Post Updated : <a href='../post/$p_id'>View Post</a> "; if(isAdmin()){echo "Edit other posts: <a href='posts.php'>Edit</a></p>";}

    }

    if(isset($_GET['p_id'])){
      $p_id = $_GET['p_id'];

      $result = p_statement($query_string = "SELECT * FROM tbl_posts WHERE id=?", $type = "i", $vars = [$p_id]);
      while($row = $result->fetch_assoc()) {
            $p_id       = $row['id'];
            $p_author   = $row['p_author'];
            $p_title    = $row['p_title'];
            $p_category = $row['cat_id'];
            $p_active   = $row['p_active'];
            $p_picture  = $row['p_picture'];
            $p_tags     = $row['p_tags'];
            $p_comments = $row['p_comments'];
            $p_date     = $row['p_date'];
            $p_content  = $row['p_content'];
          }

        if($_SESSION['username'] !== $p_author && $_SESSION['u_role'] !== 'admin'){
            header("Location: index.php");
      }
?>
<form action="" method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label>Post Title</label>
    <input value="<?php echo $p_title; ?>" type="text" class="form-control" name="title">
  </div>

  <div class="form-group">
    <label>Post Category</label>
    <select name="categories">
    <?php 
      $result = query("SELECT * FROM tbl_category");
      while($row = $result->fetch_assoc()) {
      $cat_id = $row['id'];
      $cat_title = $row['title'];
      if($cat_id == $p_category){
      echo "<option selected name='category' value='$cat_id'>$cat_title</option>";
    } else{
      echo "<option name='category' value='$cat_id'>$cat_title</option>";
    }
  }
      ?>

    </select>
  </div>
  <div class="form-group">
    <label>Change Status</label>
     <select name="status">
      <?php if($p_active == 1){ ?>
      <option value="1">Active</option>
      <option value="0">Inactive</option>
      <?php } else { ?>
      <option value="0">Inactive</option>
      <option value="1">Active</option>
    <?php } ?>
    </select>
  <div class="form-group">
    <label>Image</label>
    <input type="file" name="picture">
    <img width="300" src="../images/<?php echo $p_picture; ?>" alt="picture">
  </div>

  <div class="form-group">
    <label>Post Tags</label>
    <input value="<?php echo $p_tags; ?>" type="text" class="form-control" name="tags">
  </div>

  <div class="form-group">
    <label>Post Content</label>
      <textarea class="form-control" name="content" id="editor" cols="30" rows="10"><?php echo $p_content;?></textarea>
  </div>

  <div class="form-group">
    <label>Post Date</label>
    <input value="<?php echo $p_date; ?>" type="date" class="form-control" name="date">
  </div>

  <button name="submit" class="btn btn-primary">Update Post</button>
</form>

<?php } else {redirect('index.php');} ?>

<script src="js/editor.js"></script>