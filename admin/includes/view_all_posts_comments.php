<?php 

    if(!$_SESSION['id']){header("Location: ../../");}
    include("delete_modal.php");
                   
        $result = query("SELECT id FROM tbl_posts ORDER by id DESC");
        $returns = mysqli_num_rows($result);

        if($returns == 0){
            echo "<h3 class='text-center'>You haven't recieved any comments on yours posts</h3>";
        } else { ?>

            <form action="" method="post">
    <table class="table table-bordered table-hover">
         <thead>
            <tr>
                <th>Id</th>
                <th>In response to post:</th>
                <th>Comment</th>
                <th>Author</th>
                <th>Date</th>
                <th>Status</th>
                <th>Approve</th>
                <th>Unapprove</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>

        <?php while($row = $result->fetch_assoc()) {
        $p_id = $row['id'];

        $result_com_count = query("SELECT * FROM tbl_comments WHERE com_p_id=$p_id"); // com_p_id has the same value as $p_id;
        // logic = when we make a comment we addres the current post, so in this query we compare if the com_p_id = p_id and when they are the same this means there is a comment
        while($row   = $result_com_count->fetch_assoc()) {
        $com_content = $row['com_content'];
        $com_id      = $row['id'];
        $com_date    = $row['com_date'];
        $com_author  = $row['com_author'];
        $com_p_id    = $row['com_p_id'];
        $com_status  = $row['com_status'];
        ($com_status == 1) ? $status = 'Approved' : $status = 'Unapproved';

        echo "<tr>
        <td>$com_id</td>";

        $result_p_select_id = query("SELECT * FROM tbl_posts WHERE id=$com_p_id");

        while($row = $result_p_select_id->fetch_assoc()) {
        $p_id = $row['id'];
        $p_title = $row['p_title'];
        
        echo "<td><a href='../post/$p_id'>$p_title</a></td>";
        }
        echo "<td>$com_content</td>
        <td>$com_author</td>
        <td>$com_date</td>
        <td>$status</td>"?>

        <form action="" method="post">
        <input type="hidden" name="com_id" value="<?php echo $com_id ?>">
        <input type="hidden" name="com_status" value="<?php echo $com_status ?>">
        <?php echo "<td><button class='btn btn-primary' name='approve'>Approve</button></td>";?>
        </form>

        <form action="" method="post">
        <input type="hidden" name="com_id" value="<?php echo $com_id ?>">
        <input type="hidden" name="com_status" value="<?php echo $com_status ?>">
        <?php echo "<td><button class='btn btn-primary' name='unapprove'>Unapprove</button></td>";?>
        </form>

        <form action="" method="post">
        <input type="hidden" name="p_id" value="<?php echo $com_id ?>"><?php 
        echo "<td><button class='btn btn-danger' name='delete'>Delete</button></td>";?> 
        </form>

        <?php  

        }

    }   
     
     
}
if (isset($_POST['delete'])) {
    $delete_com_id = $_POST['p_id'];

    query("DELETE FROM tbl_comments WHERE id=$delete_com_id");
    $result = query("SELECT * FROM tbl_comments WHERE id = $delete_com_id");

    while($row = $result->fetch_assoc()) {
    $com_p_id = $row['com_p_id'];
    }

    if($com_status == 1){
    query("UPDATE tbl_posts SET p_comments = p_comments-1 WHERE id = $com_p_id");
    } 

    header("Location: posts.php?source=posts_comments");
}


if (isset($_POST['approve'])) {
    $com_id = $_POST['com_id'];
    $com_status = $_POST['com_status'];

    query("UPDATE tbl_comments SET com_status = 1 WHERE id=$com_id");

    $result = query("SELECT * FROM tbl_comments WHERE id = $com_id");
    
    while($row = $result->fetch_assoc()) {
    $com_p_id = $row['com_p_id'];
    }

    if($com_status == 0){
    query("UPDATE tbl_posts SET p_comments = p_comments+1 WHERE id = $com_p_id");
    } 

    header("Location: posts.php?source=posts_comments");
}

if (isset($_POST['unapprove'])) {
    $com_id = $_POST['com_id'];
    $com_status = $_POST['com_status'];

    query("UPDATE tbl_comments SET com_status = 0 WHERE id=$com_id");
    header("Location: comments.php");
    $result = query("SELECT * FROM tbl_comments WHERE id = $com_id");

    while($row = $result->fetch_assoc()) {
    $com_p_id = $row['com_p_id'];
    }

    if($com_status == 1){
    query("UPDATE tbl_posts SET p_comments = p_comments-1 WHERE id = $com_p_id");
    } 

      header("Location: posts.php?source=posts_comments");

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
</script>    -->         

                            </tbody>
                        </table>
                    </form>