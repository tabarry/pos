<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
set_time_limit(0);
checkLogin();
$pageName = 'Start your synchronisation';
$pageTitle = 'Start your synchronisation';
$downloadAccess = TRUE;

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
                                <h3 class="pull-left"><i class="fa fa-desktop green"></i> <?php echo $pageTitle; ?></h3>
                                <p>&nbsp;</p>
                                <form name="suAdvancedForm" id="suAdvancedForm" method="post" action="<?php echo ADMIN_URL?>sync.php">
                                <fieldset style="border: 1px solid #eee;padding: 20px;">
                                    <div class="form-group" style="margin-top: 10px;">

                                        <div class="clearfix"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label ><i class="fa fa-calendar blue"></i> Select date</label>
                                            <input type="text" name="startDate" id="startDate" autocomplete="off" class="form-control dateBox" maxlength="" value="<?php echo $_GET['startDate'] ?>" /></div>



                                    </div>

                                    <script>
                                        $(function() {
                                            $('#startDate').datepicker({
                                                changeMonth: true,
                                                changeYear: true
                                            });
                                            $('#startDate').datepicker('option', 'yearRange', 'c-100:c+10');
                                            $('#startDate').datepicker('option', 'dateFormat', '<?php echo DATE_FORMAT; ?>');
<?php if ($_GET['startDate'] != '') { ?>
                                                $('#startDate').datepicker('setDate', '<?php echo $_GET['startDate'] ?>');
<?php } ?>
                                        });


                                    </script>
                                    <div class="clearfix"></div>
                                    <div class="form-group" style="margin-top: 10px;">
                                        <div class="col-xs-5 col-sm-2 col-md-4 col-lg-4">
                                            <input id="Submit_advance" type="submit" value="Start" name="Submit_advance" class="btn btn-primary pull-right">
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </fieldset>
                            </form>

                                <div class="clearfix"></div>
                            </div>


                        <!-- TABLE -->



                        <!-- /TABLE -->
<?php
//                                $sqlP = "SELECT COUNT(order__ID) AS totalRecs FROM FROM sulata_order_details INNER JOIN sulata_products ON product__ID = orderdet__Product INNER JOIN sulata_orders ON order__ID = orderdet__Order WHERE order__Status = 'Received' $where";
//                                suPaginate($sqlP);
?>
                        <?php if ($downloadAccess2 == TRUE && $numRows > 0) { ?>
                            <p>&nbsp;</p>
                            <p><a target="remote" href="<?php echo $_SERVER['PHP_SELF']; ?>/stream-csv/" class="btn btn-black pull-right"><i class="fa fa-download"></i> Download</a></p>
                            <p>&nbsp;</p>
                            <div class="clearfix"></div>
<?php } ?>


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
