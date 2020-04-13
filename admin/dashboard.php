<?php include "includes/header.php"; ?>
<?php include "functions.php"; ?>
    <div id="wrapper">

<?php include "includes/nav.php"; ?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                                Welcome to the dashboard
                            <small><?php echo currentUser(); ?></small>
                        </h1>
                    </div>
                </div>    
                <!-- /.row -->
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo $p_count = recordCountStatement('tbl_posts', 'p_author', $_SESSION['username']); ?></div>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php?source=my_posts">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'><?php echo $c_count = allPostsUserComments(); ?></div>
                      <div>Comments made</div>
                    </div>
                </div>
            </div>
            <a href="comments.php?source=view_user_comments">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'><?php
                     $com_recieved  = query("SELECT * FROM tbl_posts WHERE p_author = '".$_SESSION['username']."' ");
                                $counter = 0;
                                    while($row = $com_recieved->fetch_assoc()) {

                                      $p_comments = $row['p_comments'];
                                      $counter = $counter + $p_comments;

                                } echo $counter; ?>
                            </div>
                        <div>Comments approved on my posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php?source=posts_comments">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>             
        <?php   $p_active      = recordCountStatementAnd('tbl_posts', 'p_active', '1', 'p_author'); 
                $p_inactive    = recordCountStatementAnd('tbl_posts', 'p_active', '0', 'p_author');
                $c_count       = recordCountStatementAnd('tbl_comments', 'com_status', '1', 'com_author');
                $com_inactive  = recordCountStatementAnd('tbl_comments', 'com_status', '0', 'com_author'); ?>
                <!-- /.row -->
                <div class="row">
                    <script type="text/javascript">
                          google.charts.load('current', {'packages':['bar']});
                          google.charts.setOnLoadCallback(drawChart);

                          function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                              ['Data', 'Count'],

                              <?php 
                              $elements_text = ['All posts','Active Posts', 'Inactive Posts', 'Comments made' , 'Pending Comments', 'Comments recieved on posts'];
                              $elements_count = [$p_count ,$p_active ,$p_inactive, $c_count ,$com_inactive  ,$counter];

                              for ($i = 0; $i < 6; $i++) {
                                  echo "['$elements_text[$i]'" .  "," . "$elements_count[$i]],";
                              }
                               ?>
                            ]);

                            var options = {
                              chart: {

                              }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                          }
                    </script>                
                </div>
                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
<?php include "includes/footer.php" ?>

