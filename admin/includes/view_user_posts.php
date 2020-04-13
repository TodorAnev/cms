<?php 

if(!$_SESSION['id']){header("Location: ../../");}
// include("delete_modal.php");

if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $checkboxValue) {
     $bulk_option = $_POST['bulk'];
     switch ($bulk_option) {
        case '0':
            query("UPDATE tbl_posts SET p_active = 0 WHERE id LIKE '$checkboxValue'");
             break;

        case '1':
            query("UPDATE tbl_posts SET p_active = 1 WHERE id LIKE '$checkboxValue'");
             break;

        case 'clone':
            $result = query("SELECT * FROM tbl_posts WHERE id = '$checkboxValue'");

            while($row = $result->fetch_assoc()) {
            $p_category = $row['cat_id'];
            $p_title    = $row['p_title'];
            $p_author   = $row['p_author'];
            $p_tags     = $row['p_tags'];
            $p_date     = $row['p_date'];
            $p_picture  = $row['p_picture'];
            $p_content  = $row['p_content'];
            }

            $vars = [$p_author, $p_title, $p_category, $p_picture, $p_tags, $p_content];
            p_statement($query_string = "INSERT INTO tbl_posts (p_author, p_title, cat_id, p_picture, p_tags, p_content, p_date) VALUES (?, ?, ?, ?, ?, ?, now())", $type = "ssssss", $vars);

            break;

        case 'delete':
            query("DELETE FROM tbl_posts WHERE id LIKE '$checkboxValue'");
             break;
         
         default:
             echo "Please select an option";
             break;
        }
    }

} 

    $result = query(
    "SELECT tp.id as 'tpid', tp.p_author, tp.p_title, tp.cat_id, tp.p_active, tp.p_picture, tp.p_tags, tp.p_comments, tp.p_date, tp.p_content, tp.p_views_count, tc.id as 'tcid', tc.title 
    FROM tbl_posts tp
    LEFT JOIN tbl_category tc 
    ON tp.cat_id = tc.id
    WHERE tp.p_author = '".$_SESSION['username']."'
    ORDER by tpid DESC");

    $returns = mysqli_num_rows($result);
    if($returns == 0){
        echo "<h3 class='text-center'>You haven't made any posts</h3>";
    } else { ?>

            <form action="" method="post">
    <table class="table table-bordered table-hover">
<div class="form-group">
        <div id="bulkOptionContainer" class="col-xs-4">
            <select name="bulk" id="" class="form-control">
                <option value="nothing">Select Option</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
                <option value="clone">Clone</option>
                <option value="delete">Delete</option>
            </select>
        </div>
</div>
    <div class="col-xs-4">
        <button name="submit" class="btn btn-success">Apply</button>
        <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
    </div>
    <div class="col-xs-4"></div>
     <thead>
        <tr>
            <th>All: <input name="selectAll" id="selectAllBoxes" type="checkbox"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Content</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Post Views</th>
            <th>Date</th>
            <th>Comments</th>
            <th>Delete</th>
            <th>Edit</th>
            <th>View Post</th>
        </tr>
    </thead>
    <tbody>

    <?php while($row = $result->fetch_assoc()) {
    $p_id          = $row['tpid'];
    $p_author      = $row['p_author'];
    $p_title       = $row['p_title'];
    $p_category    = $row['cat_id'];
    $p_active      = $row['p_active'];
    $p_picture     = $row['p_picture'];
    $p_tags        = $row['p_tags'];
    $p_comments    = $row['p_comments'];
    $p_date        = $row['p_date'];
    $p_content     = $row['p_content'];
    $p_views_count = $row['p_views_count'];
    $cat_title     = $row['title'];
    ($p_active == 1) ? $p_draft = 'Active' : $p_draft = 'Inactive';
    if ($_SESSION['username'] !== $p_author) {header("Location: posts.php");}


    echo "<tr>"; ?>
    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $p_id ?>'></td>
    <?php
    echo "<td>$p_id</td>
    <td>$p_author</td>
    <td>$p_title</td>
    <td>$cat_title</td>
    <td>$p_draft</td>
    <td>$p_content</td>
    <td><img class='img-responsive' src='../images/$p_picture' alt='image' width='250' height='150'></img></td>
    <td>$p_tags</td>
    <td>$p_views_count</td>
    <td>$p_date</td>";

    $result_com_count = query("SELECT * FROM tbl_comments WHERE com_p_id=$p_id");
    $com_count = mysqli_num_rows($result_com_count);

    echo "<td><a href='comments.php?source=view_post_comments&p_id=$p_id'>$com_count</a></td>";?>

   <form action="" method="post">
            <input type="hidden" name="p_id" value="<?php echo $p_id ?>">
            <?php echo "<td><button class='btn btn-danger' name='delete'>Delete</button></td>";?>
    </form>

    <?php  
    echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id=$p_id'>Edit</a></td>
    <td><a class='btn btn-primary' href='../post/$p_id'>View Post</a></td>
    </tr>"; 
        } 
    }

    if (isset($_POST['delete'])) {
            $p_delete = $_POST['p_id'];
            query("DELETE FROM tbl_posts WHERE id=$p_delete");
            header("Location: posts.php?source=my_posts");
    }
?>

<!-- <script>
    $(document).ready(function(){
        $(".delete_link").on('click', function(){
            var id = $(this).attr("rel"); //this=the link we are clicking at the moment

            var delete_url = "posts.php?delete="+ id +" ";

            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal('show');
            

        });
    });
</script>  -->           

                            </tbody>
                        </table>
                    </form>