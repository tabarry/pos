<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$sql = "SELECT menu__ID,menu__Title,menu__Status FROM sulata_menus WHERE menu__dbState='Live' AND menu__ID='" . suSegment(1) . "'";
$result = suQuery($sql);
$rowMenu = suFetch($result);
$pageName = 'Add Menus Details';
$pageTitle = 'Add Menus Details';
?>
<!DOCTYPE html>
<html>
    <head>
<?php include('inc-head.php'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                //Keep session alive
                $(function () {
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
                                <div class="pull-right">
                                    <a href="<?php echo ADMIN_URL; ?>menus-cards/"><i class="fa fa-th-large"></i></a>
                                    <a href="<?php echo ADMIN_URL; ?>menus/"><i class="fa fa-table"></i></a>
                                </div>

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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>menus-remote/menu-details/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" >

                                    <div class="gallery clearfix">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">  
                                                <input type="hidden" name="menu__ID" id="menu__ID" value="<?php echo suSegment(1)?>" />
                                                <label><?php echo $dbs_sulata_menus['menu__Title_req']; ?>Title:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_menus['menu__Title_html5_type'], 'name' => 'menu__Title', 'id' => 'menu__Title', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_menus['menu__Title_max'], 'value' => '', $dbs_sulata_menus['menu__Title_html5_req'] => $dbs_sulata_menus['menu__Title_html5_req'], 'class' => 'form-control','readonly'=>'readonly','value'=>  suUnstrip($rowMenu['menu__Title']));
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">        
                                                <label><?php echo $dbs_sulata_menus['menu__Status_req']; ?>Status:</label>
                                                <?php
                                                $options = $dbs_sulata_menus['menu__Status_array'];
                                                $js = "class='form-control'";
                                                $js .= "readonly='readonly'";
                                                echo suDropdown('menu__Status', $options,  suUnstrip($rowMenu['menu__Status']), $js)
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                <div class="single-head">
                                                    <!-- Heading -->
                                                    <h3 class="pull-left"><i class="fa fa-list purple"></i> Add Products Prices</h3> 
                                                    <div class="clearfix"></div>
                                                </div>
                                                
                                               
                                                <p class="clearfix">&nbsp;</p>
                                                <div class="clearfix"></div>
                                                   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                                       <table width="100%" class="table table-hover table-bordered tbl">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">
                                                Sr.
                                            </th>
                                          
                                           <th style="width:65%">Product</th>
<th style="width:20%">Price</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                                <?php
                                                $sqlMenuItems = "SELECT product__Name,menudetail__Product,menudetail__Product_Price FROM sulata_menu_details INNER JOIN sulata_products ON product__ID = menudetail__Product WHERE product__dbState = 'Live' AND menudetail__dbState = 'Live' AND menudetail__Menu = '".  suSegment(1)."'";
                                                $rsMenuItems = suQuery($sqlMenuItems);
                                                $i = 1;
                                                while ($rowMenuItems = suFetch($rsMenuItems)) {
                                                    
                                                    ?>
                                        <tr>
                                            <td><?php echo $i?></td>
                                            <td>
                                                <?php echo suUnstrip($rowMenuItems['product__Name'])?>
                                                <input type="hidden" name="menudetail__Product[]" id="menudetail__Product" value="<?php echo $rowMenuItems['menudetail__Product']?>" />
                                            </td>
                                            <td><input type="text" name="menudetail__Product_Price[]" id="menudetail__Product_Price" class="form-control" autocomplete="off" value="<?php echo suUnstrip($rowMenuItems['menudetail__Product_Price'])?>" /></td>
                                        </tr>
                                             
                                                           
                                                 
                                               
                                               
                                         
                                                <?php
                                                $i++;
                                            }suFree($rsCategories);
                                            ?>
                                    </tbody>
                                                       </table>
                                                     </div>
                                            <div class="clearfix"></div>


                                        </div>      
                                    </div>


                            </div>
                            <div class="lineSpacer clear"></div>
                            <p>
                                <?php
                                $arg = array('type' => 'submit', 'name' => 'Submit', 'id' => 'Submit', 'value' => 'Submit', 'class' => 'btn btn-primary pull-right');
                                echo suInput('input', $arg);
                                ?>                              
                            </p>
                            <p>&nbsp;</p>
                            </form>

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