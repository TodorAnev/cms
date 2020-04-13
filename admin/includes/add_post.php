<?php 
if(!$_SESSION['id']){header("Location: ../../");}
  if (isset($_POST['submit'])) {

  $p_author       = $_SESSION['username'];
  $p_title        = $_POST['title'];
  $p_category     = $_POST['categories'];
  $p_status       = $_POST['status'];
  $p_picture      = $_FILES['picture']['name'];
  $p_picture_temp = $_FILES['picture']['tmp_name'];
  $p_tags         = $_POST['tags'];
  $p_content      = $_POST['content'];
  $p_date         = date('d-m-y');
  move_uploaded_file($p_picture_temp, "../images/$p_picture");

  $vars = [$p_author, $p_title, $p_category, $p_status, $p_picture, $p_tags, $p_content];
  p_statement($query_string = "INSERT INTO tbl_posts (p_author, p_title, cat_id, p_active, p_picture, p_tags, p_content, p_date) VALUES (?, ?, ?, ?, ?, ?, ?, now())", $type = "sssisss", $vars);
  $p_id = mysqli_insert_id($conn);
  echo "<p>Post Created : <a href='../post/$p_id'>View Post</a> View all posts: <a href='posts.php'>View posts</a></p>";
    
  }
?>
<form action="" method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label>Post Title</label>
    <input type="text" class="form-control" name="title">
  </div>

 <div class="form-group">
    <label>Post Category</label>
    <select name="categories">
    <?php 
      $result = query("SELECT * FROM tbl_category");
      while($row = $result->fetch_assoc()) {
        
      $cat_id = $row['id'];
      $cat_title = $row['title']; 
      echo "<option value='$cat_id'>$cat_title</option>";
      
    }
      ?>

    </select>
  </div>

  <div class="form-group">
    <label>Choose Status</label>
    <select name="status">
      <option value="0">Choose Status</option>
      <option value="1">Active</option>
      <option value="0">Inactive</option>
    </select>
  </div>

  <div class="form-group">
    <label>Post Picture</label>
    <input type="file" name="picture">
  </div>

  <div class="form-group">
    <label>Post Tags</label>
    <input type="text" class="form-control" name="tags">
  </div>

  <div class="form-group">
    <label>Post Content</label>
      <textarea class="form-control" name="content" id="editor" cols="30" rows="10"></textarea>
  </div>

  <div class="form-group">
    <label>Post Date</label>
    <input type="date" class="form-control" name="date">
  </div>

  <button name="submit" class="btn btn-primary">Submit</button>
</form>

<script src="js/editor.js"></script>