            <?php include "includes/connection.php" ?> 
            <?php   
                if(ifItIsMethod('post')){

                if(isset($_POST['login'])){
                    if(isset($_POST['username']) && isset($_POST['password'])){
                    loginUser($_POST['username'], $_POST['password']);
                    } else{
                        redirect('index');
                    }
                }
            } ?>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                        <div class="input-group">
                            <input name="search" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default" name="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>


                    <!-- /.input-group -->
                </div>
    <?php if (isset($_SESSION['u_role'])) { 

?>

        <div class="well">
                    <h3>Logged in as <?php echo $_SESSION['username']; ?></h3>
                    <input type="button" value="Logout" class="btn btn-default" id="btnHome" onClick="document.location.href='/cms/includes/logout.php'" />
                </div>



                     <?php } else { ?>
                <div class="well">
                    <form action="" method="post">
                        <div class="form-group">
                            <input name="username" type="text" class="form-control" placeholder="Enter Username">
                        </div>
                        <div class="form-group">
                            <input name="password" type="password" class="form-control" placeholder="Enter Password">
                        </div>
                    <button name="login" type="submit" class="btn btn-default">Login</button>
                    </form>
                </div>
<?php } ?>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <?php   
                                $sql = "SELECT * FROM tbl_category"; // LIMIT 1 // displays only 1 category
                                $result = $conn->query($sql); 
                                if (mysqli_num_rows($result)!==0){
                                while($row = $result->fetch_assoc()) {
                                    $cat_id = $row['id'];
                                    $cat_title = $row['title'];
                                    echo "<li><a href='/cms/categories.php?c_id=$cat_id'>$cat_title</a></li>";
                                }
                            } else{
                                echo "No categories";
                            }

                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <?php // include "widget.php" ?>
            </div>
