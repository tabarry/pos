<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
$pageName = 'Sales Graph';
$pageTitle = 'Sales Graph';
checkLogin();
/* rapidSql */
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('inc-head.php'); ?>
        <script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
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
                                <h3 class="pull-left"><i class="fa fa-home purple"></i> <?php echo $pageTitle; ?></h3>

                                <div class="clearfix"></div>
                            </div>
                            <form name="suAdvancedForm" id="suAdvancedForm" method="get" action="">
                                <fieldset style="border: 1px solid #eee;padding: 20px;">
                                    <div class="form-group" style="margin-top: 10px;">
                                        <div class="clearfix"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label ><i class="fa fa-calendar blue"></i> Start Date</label>
                                            <input type="text" name="startDate" id="startDate" autocomplete="off" class="form-control dateBox" maxlength="" value="<?php echo $_GET['startDate'] ?>" /></div>


                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label><i class="fa fa-calendar blue"></i> End Date </label>
                                            <input type="text" name="endDate" id="endDate" autocomplete="off" class="form-control dateBox" maxlength="" value="<?php echo $_GET['endDate'] ?>"/>
                                        </div>
                                    </div>

                                    <script>
                                        $(function () {
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
                                        $(function () {
                                            $('#endDate').datepicker({
                                                changeMonth: true,
                                                changeYear: true
                                            });
                                            $('#endDate').datepicker('option', 'yearRange', 'c-100:c+10');
                                            $('#endDate').datepicker('option', 'dateFormat', '<?php echo DATE_FORMAT; ?>');
<?php if ($_GET['endDate'] != '') { ?>
                                                $('#endDate').datepicker('setDate', '<?php echo $_GET['endDate'] ?>');
<?php } ?>
                                        });

                                    </script>
                                    <div class="clearfix"></div>
                                    <div class="form-group" style="margin-top: 10px;">
                                        <div class="col-xs-5 col-sm-2 col-md-8 col-lg-8">
                                            <input id="Submit_advance" type="submit" value="Search" name="Submit_advance" class="btn btn-primary pull-right">
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </fieldset>
                                <div class="clearfix"></div>
                            </form>
                            <a class="underline pull-right" href="<?php echo ADMIN_URL ?>graphs/">Clear Search</a>
                            <div class="clearfix"></div>



                            <div id="chartContainer" style=" height: 350px;width: 100%;">
                                <div class="clearfix"></div>
                            </div>
                            <div id="chartContainer2" style=" height: 350px;width: 100%;">
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>


                            <div id="error-area">
                                <ul></ul>
                            </div>    
                            <div id="message-area">
                                <p></p>
                            </div>
                            <!--SU STARTS-->
                            <div class="clearfix"></div>
                            <!--SU ENDS-->

                        </div>
                        <?php include('inc-site-footer.php'); ?>
                    </div>
                </div>

            </div>

            <!-- Mainbar ends -->

            <div class="clearfix"></div>
        </div>
        <?php include('inc-footer.php'); ?>
        <?php
        if ($_GET['startDate'] != "" && $_GET['endDate'] != "") {
            $where .= " AND date(order__Date) >= '" . suDate2Db($_GET['startDate']) . "' AND date(order__Date) <= '" . suDate2Db($_GET['endDate']) . "'";
        } else {
            $where .=" AND DATE_FORMAT(order__Date,'%b') = '" . date('M') . "'";
        }
        $sqlOrders = "SELECT COUNT(order__UID) AS totalOrders,SUM(order__Total_Amount-order__Discount) AS totalAmount,DATE_FORMAT(order__Date,'%d %b') AS orderDate,DATE_FORMAT(order__Date,'%b') AS Month FROM sulata_orders WHERE order__dbState = 'Live' AND ((order__Status='Received') OR (order__Status='Delivered'))  " . $where . " GROUP BY orderDate ORDER BY order__Date ASC";
        $rsOrders = suQuery($sqlOrders);
        while ($rowOrders = suFetch($rsOrders)) {
            //$dataPoint .= "  { x: new Date(".$rowOrders['orderMonth']."), y: ".$rowOrders['totalOrders']." }".",";
            $dataPoint .= "  {y: " . $rowOrders['totalOrders'] . ", label: '" . $rowOrders['orderDate'] . "'}" . ",";
            $dataPoint2 .= "  {y: " . $rowOrders['totalAmount'] . ", label: '" . $rowOrders['orderDate'] . "'}" . ",";
        }
        $dataPoint = substr($dataPoint, 0, -1);
        $dataPoint2 = substr($dataPoint2, 0, -1);
        ?>
        <script type="text/javascript">
            window.onload = function () {
                var myNewChart = new CanvasJS.Chart("chartContainer",
                        {
                            title: {
                                text: "Sales Truck Cafe (Order Based)"
                            },
                            animationEnabled: true,
                            theme: "theme3",
                            axisY: {
                                valueFormatString: "#,##0.##" // move comma to change formatting

                            },
                            data: [
                                {
                                    type: "column",
                                    dataPoints: [
<?php echo $dataPoint ?>
                                    ]
                                }
                            ]
                        });

                myNewChart.render();
                myNewChart = {};
                var myNewChart2 = new CanvasJS.Chart("chartContainer2",
                        {
                            title: {
                                text: "Sales Truck Cafe (Value Based)"
                            },
                            animationEnabled: true,
                            theme: "theme3",
                            axisY: {
                                valueFormatString: "#,##0.##" // move comma to change formatting

                            },
                            data: [
                                {
                                    type: "column",
                                    dataPoints: [
<?php echo $dataPoint2 ?>
                                    ]
                                }
                            ]
                        });

                myNewChart2.render();
                myNewChart2 = {};
            }
        </script>

        <?php suIframe(); ?>  
    </body>
    <!--PRETTY PHOTO-->
    <?php include('inc-pretty-photo.php'); ?>    

</html>