<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
if ($_SESSION[SESSION_PREFIX . 'user__Type'] != 'Admin') {
    suExit(INVALID_ACCESS);
}
$id = suSegment(1);
if (!is_numeric($id)) {
    suExit(INVALID_RECORD);
}
$sql = "SELECT promotionalcode__ID,promotionalcode__Code,promotionalcode__Validity,promotionalcode__Type,promotionalcode__Value,promotionalcode__Active FROM sulata_promotional_codes WHERE promotionalcode__dbState='Live' AND promotionalcode__ID='" . $id . "'";
$result = suQuery($sql);
if (suNumRows($result) == 0) {
    suExit(INVALID_RECORD);
}
$row = suFetch($result);
suFree($result);

$pageName = 'Update Promotional Codes';
$pageTitle = 'Update Promotional Codes';
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
                                <div class="pull-right">
                                    <a href="<?php echo ADMIN_URL; ?>promotional-codes-cards.php/"><i class="fa fa-th-large"></i></a>
                                    <a href="<?php echo ADMIN_URL; ?>promotional-codes.php/"><i class="fa fa-table"></i></a>
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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>promotional-codes-remote.php/update/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" >
                                    <div class="gallery clearfix">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                
                                                <label><?php echo $dbs_sulata_promotional_codes['promotionalcode__Code_req']; ?>Code:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_promotional_codes['promotionalcode__Code_html5_type'], 'name' => 'promotionalcode__Code', 'id' => 'promotionalcode__Code', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_promotional_codes['promotionalcode__Code_max'], 'value' => suUnstrip($row['promotionalcode__Code']), $dbs_sulata_promotional_codes['promotionalcode__Code_html5_req'] => $dbs_sulata_promotional_codes['promotionalcode__Code_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">    
                                                <label><?php echo $dbs_sulata_promotional_codes['promotionalcode__Validity_req']; ?>Validity:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_promotional_codes['promotionalcode__Validity_html5_type'], 'name' => 'promotionalcode__Validity', 'id' => 'promotionalcode__Validity', 'autocomplete' => 'off', 'class' => 'form-control dateBox', 'maxlength' => $dbs_sulata_promotional_codes['promotionalcode__Validity_max'], $dbs_sulata_promotional_codes['promotionalcode__Validity_html5_req'] => $dbs_sulata_promotional_codes['promotionalcode__Validity_html5_req']);
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>
                                        </div>
                                        <script>
                                            $(function() {
                                                $('#promotionalcode__Validity').datepicker({
                                                    changeMonth: true,
                                                    changeYear: true
                                                });
                                                $('#promotionalcode__Validity').datepicker('option', 'yearRange', 'c-100:c+10');
                                                $('#promotionalcode__Validity').datepicker('option', 'dateFormat', '<?php echo DATE_FORMAT; ?>');
                                                $('#promotionalcode__Validity').datepicker('setDate', '<?php echo suDateFromDb($row['promotionalcode__Validity']) ?>');
                                            });

                                        </script>                                  


                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">        
                                                <label><?php echo $dbs_sulata_promotional_codes['promotionalcode__Type_req']; ?>Type:</label>
                                                <?php
                                                $options = $dbs_sulata_promotional_codes['promotionalcode__Type_array'];
                                                $js = "class='form-control'";
                                                echo suDropdown('promotionalcode__Type', $options, suUnstrip($row['promotionalcode__Type']), $js)
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">            
                                                <label><?php echo $dbs_sulata_promotional_codes['promotionalcode__Value_req']; ?>Value:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_promotional_codes['promotionalcode__Value_html5_type'], 'name' => 'promotionalcode__Value', 'id' => 'promotionalcode__Value', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_promotional_codes['promotionalcode__Value_max'], 'value' => suUnstrip($row['promotionalcode__Value']), $dbs_sulata_promotional_codes['promotionalcode__Value_html5_req'] => $dbs_sulata_promotional_codes['promotionalcode__Value_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>    
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">        
                                                <label><?php echo $dbs_sulata_promotional_codes['promotionalcode__Active_req']; ?>Active:</label>
                                                <?php
                                                $options = $dbs_sulata_promotional_codes['promotionalcode__Active_array'];
                                                $js = "class='form-control'";
                                                echo suDropdown('promotionalcode__Active', $options, suUnstrip($row['promotionalcode__Active']), $js)
                                                ?>
                                            </div>
                                        </div>


                                        <p>
                                            <?php
                                            $arg = array('type' => 'submit', 'name' => 'Submit', 'id' => 'Submit', 'value' => 'Submit', 'class' => 'btn btn-primary pull-right');
                                            echo suInput('input', $arg);
                                            ?>                              
                                        </p>
                                        <?php
                                        //Referrer field
                                        $arg = array('type' => 'hidden', 'name' => 'referrer', 'id' => 'referrer', 'value' => $_SERVER['HTTP_REFERER']);
                                        echo suInput('input', $arg);
                                        //Id field
                                        $arg = array('type' => 'hidden', 'name' => 'promotionalcode__ID', 'id' => 'promotionalcode__ID', 'value' => $id);
                                        echo suInput('input', $arg);
                                        ?>
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