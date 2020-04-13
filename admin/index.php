<?php include "includes/header.php"; ?>
<?php include "functions.php"; ?>
<?php if(!isAdmin()){header("Location: dashboard.php");}?>
    <div id="wrapper">

<?php include "includes/nav.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                                Welcome to the admin page
                            <small><?php echo getUserName(); ?></small>
                        </h1>
                    </div>
                </div>    
                <!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo $p_count = recordCount('tbl_posts'); ?></div>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'><?php echo $c_count = recordCount('tbl_comments'); ?></div>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'><?php echo $u_count = recordCount('tbl_users'); ?></div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'><?php echo $cat_count = recordCount('tbl_category'); ?></div>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>             
        <?php   $p_active      = recordCountStatement('tbl_posts', 'p_active', '1'); 
                $p_inactive    = recordCountStatement('tbl_posts', 'p_active', '0');
                $c_count       = recordCountStatement('tbl_comments', 'com_status', '1');
                $com_inactive  = recordCountStatement('tbl_comments', 'com_status', '0');
                $u_subscribers = recordCountStatement('tbl_users', 'u_role', 'subscriber'); ?>
                <!-- /.row -->
                <div class="row">
                    <script type="text/javascript">
                          google.charts.load('current', {'packages':['bar']});
                          google.charts.setOnLoadCallback(drawChart);

                          function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                              ['Data', 'Count'],

                              <?php 
                              $elements_text = ['All posts','Active Posts', 'Inactive Posts', 'Comments' , 'Pending Comments', 'Users' , 'Subscribed Users', 'Categories'];
                              $elements_count = [$p_count ,$p_active ,$p_inactive, $c_count ,$com_inactive , $u_count ,$u_subscribers, $cat_count];

                              for ($i = 0; $i < 7; $i++) {
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
<!-- this is the toaster, i can put it in footer(js) and header(css) -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha256-ENFZrbVzylNbgnXx0n3I1g//2WeO47XxoPe0vkp3NC8=" crossorigin="anonymous" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha256-3blsJd4Hli/7wCQ+bmgXfOdK7p/ZUMtPXY08jmxSSgk=" crossorigin="anonymous"></script>
 <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
 <script>
     $(document).ready(function(){

        var pusher = new Pusher('526c26dd356d9c992c96', {

            cluster: 'eu',
            encrypted: true
        });
        var notificationChannel = pusher.subscribe('notifications');
        notificationChannel.bind('new_user', function(notification){
            var message = notification.message;
            toastr.success(`${message} just registered`);
            console.log(message);
        });
     });
 </script>
