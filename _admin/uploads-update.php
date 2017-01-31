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
$sql = "SELECT upload__ID,upload__Title,upload__Picture FROM sulata_uploads WHERE upload__dbState='Live' AND upload__ID='" . $id . "'";
$result = suQuery($sql);
if (suNumRows($result) == 0) {
    suExit(INVALID_RECORD);
}
$row = suFetch($result);
suFree($result);

$pageName = 'Update Uploads';
$pageTitle = 'Update Uploads';
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
                                    <a href="<?php echo ADMIN_URL; ?>uploads-cards.php/"><i class="fa fa-th-large"></i></a>
                                    <a href="<?php echo ADMIN_URL; ?>uploads.php/"><i class="fa fa-table"></i></a>
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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>uploads-remote.php/update/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" enctype="multipart/form-data">
                                    <div class="gallery clearfix">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                
                                                <label><?php echo $dbs_sulata_uploads['upload__Title_req']; ?>Title:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_uploads['upload__Title_html5_type'], 'name' => 'upload__Title', 'id' => 'upload__Title', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_uploads['upload__Title_max'], 'value' => suUnstrip($row['upload__Title']), $dbs_sulata_uploads['upload__Title_html5_req'] => $dbs_sulata_uploads['upload__Title_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  

                                                <label><?php echo $dbs_sulata_uploads['upload__Picture_req']; ?>Picture:</label>
                                                <?php
                                                if ((isset($row['upload__Picture']) && $row['upload__Picture'] != '') && (file_exists(ADMIN_UPLOAD_PATH . $row['upload__Picture']))) {
                                                    $defaultImage = BASE_URL . 'files/' . $row['upload__Picture'];
                                                } else {
                                                    $defaultImage = BASE_URL . 'files/default-image.png';
                                                }
                                                ?>

                                                <div class="imgThumb" style="background-image:url(<?php echo $defaultImage; ?>);"></div>    
                                                <?php
                                                $arg = array('type' => $dbs_sulata_uploads['upload__Picture_html5_type'], 'name' => 'upload__Picture', 'id' => 'upload__Picture');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>
                                        </div>


                                        <?php if ((file_exists(ADMIN_UPLOAD_PATH . $row['upload__Picture'])) && ($row['upload__Picture'] != '')) { ?>
                                            <a class="underline" href="<?php echo BASE_URL . 'files/' . $row['upload__Picture']; ?>" target="_blank"><?php echo VIEW_FILE; ?></a>
                                        <?php } ?>    

                                        <div><?php echo $getSettings['allowed_image_formats']; ?></div>


                                        <?php
                                        $arg = array('type' => 'hidden', 'name' => 'previous_upload__Picture', 'id' => 'previous_upload__Picture', 'value' => $row['upload__Picture']);
                                        echo suInput('input', $arg);
                                        ?>   


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
                                        $arg = array('type' => 'hidden', 'name' => 'upload__ID', 'id' => 'upload__ID', 'value' => $id);
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