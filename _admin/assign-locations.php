<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName='Assign Location';$pageTitle='Assign Location';

//Make select statement. The $SqlFrom is also used in $sqlP below.    
$sqlSelect = "SELECT location__ID,location__Location ";
$sqlFrom = " FROM sulata_locations WHERE location__dbState='Live'";
$sql = $sqlSelect . $sqlFrom;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('inc-head.php'); ?>
        <script type="text/javascript">
            $(document).ready(function() {
                //Keep session alive
                $(function() {
                    window.setInterval("suStayAlive('<?php echo PING_URL; ?>')", 300000);
                });
                //Disable submit button
                suToggleButton(1);
            });
        </script> 
    </head>

    <body>

        <div class="outer">

            <!-- Sidebar starts -->

            <?php include('inc-sidebar.php'); ?>
            <!-- Sidebar ends -->

            <!-- Mainbar starts -->
            <div class="mainbar">
                <?php include('inc-heading.php'); ?>
                <!-- Mainbar head starts -->
                <div class="main-head">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-4 col-xs-6">
                                <!-- Bread crumbs -->
                                <?php include('inc-breadcrumbs.php'); ?>
                            </div>

                            <div class="col-md-3 col-sm-4 col-xs-6">
                                <!-- Search block -->

                            </div>

                            <div class="col-md-3 col-sm-4 hidden-xs">
                                <!-- Notifications -->
                                <div class="head-noty text-center">

                                </div>
                                <div class="clearfix"></div>
                            </div>


                            <div class="col-md-3 hidden-sm hidden-xs">
                                <!-- Head user -->

                                <?php include('inc-header.php'); ?>
                                <div class="clearfix"></div>
                            </div>
                        </div>	
                    </div>

                </div>

                <!-- Mainbar head ends -->

                <div class="main-content">
                    <div class="container">

                        <div class="page-content">

                            <!-- Heading -->
                            <div class="single-head">
                                <!-- Heading -->
                                <h3 class="pull-left"><i class="fa fa-desktop purple"></i> <?php echo $pageTitle; ?></h3>
                               

                                <div class="clearfix"></div>
                            </div>

                            <div id="content-area">

                                <div id="error-area">
                                    <ul></ul>
                                </div>    
                                <div id="message-area">
                                    <p></p>
                                </div>
                                <!--SU STARTS-->
                                
                                
                               
                                
                    <div class="lineSpacer clear"></div>
                
                                    
<?php
if ($_GET['q'] != '') {
        $where .= " AND location__Location LIKE '%" . suStrip($_GET['q']) . "%' ";
    }
    
if (!$_GET['start']) {
    $_GET['start'] = 0;
}
if (!$_GET['sr']) {
    $sr = 0;
} else {
    $sr = $_GET['sr'];
}
if (!$_GET['sort']) {
    $sort = " ORDER BY location__Location";
} else {
    $sort = " ORDER BY " . $_GET['f'] . " " . $_GET['sort'];
} 
//Get records from database
    
    $sql = "$sql $where $sort LIMIT " . $_GET['start'] . "," . $getSettings['page_size'];

    $result = suQuery($sql);
    $numRows = suNumRows($result);
    ?>
                    <form name="suForm" id="suForm" action="<?php echo ADMIN_URL?>locations-remote.php/assign-location/" target="remote" method="post">
                    <?php
    while($row=  suFetch($result)){
    if($getSettings['truck_location']==$row['location__ID']){
        $checked = "checked='checked'";
    }else{
         $checked = "";
    }
?>
                                        <!-- CARDS START -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" id="card_<?php echo $row['location__ID']; ?>">
                                          
                                            <input type="radio" name="assign_location" id="assign_location" value="<?php echo $row['location__ID']?>"  <?php echo $checked?>> <?php  echo suSubstr(suUnstrip($row['location__Location']));?> 
                                           
       </div>
                                        <div class="clearfix"></div>
                                    <!-- CARDS END -->
    <?php }suFree($result) ?>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 " style="margin-top: 20px">
                                        <input type="submit" name="submit" value="Submit" id="submit" class="btn btn-primary" />
                                    </div>
                    </form>
<div class="clearfix"></div>
                                   
                  
                         
                    

                                <!--SU ENDS-->
                            </div>
                        </div>
                        <?php include('inc-site-footer.php'); ?>
                    </div>
                </div>

            </div>

            <!-- Mainbar ends -->

            <div class="clearfix"></div>
        </div>
        <?php include('inc-footer.php'); ?>
        <?php suIframe(); ?>  
    </body>
    <!--PRETTY PHOTO-->
    <?php include('inc-pretty-photo.php'); ?>    
</html>