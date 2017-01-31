<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Daily Inventory Report';
$pageTitle = 'Daily Inventory Report';
$downloadAccess = TRUE;


if ($_GET['startDate'] != "") {
    $date = suDate2Db($_GET['startDate']);
} else {
    $date = date("Y-m-d");
}

$sql = "SELECT DT.rawmaterial__Material,DT.rawmaterial__Material, DT.rawmaterial__Unit, SUM(DT.tot ) as total from( SELECT RM.rawmaterial__Material, RM.rawmaterial__Unit, ( PM.promaterial__Quantity * OD.orderdet__Quantity) as tot FROM sulata_product_material PM INNER JOIN sulata_raw_materials RM ON PM.promaterial__Material = RM.rawmaterial__ID INNER JOIN sulata_products P ON P.product__ID = PM.promaterial__Product INNER JOIN sulata_order_details OD ON P.product__ID = OD.orderdet__Product INNER JOIN sulata_orders O ON O.order__UID = OD.orderdet__Order_UID WHERE ((O.order__Status = 'Received') OR (O.order__Status = 'Delivered')) AND date(order__Date)='" . $date . "' group by P.product__ID,rawmaterial__Material, rawmaterial__Unit, tot ) as DT group by DT.rawmaterial__Material, DT.rawmaterial__Unit  ";

$sql2 = "SELECT  product__ID,product__Name,SUM(orderdet__Quantity) AS totalQuantity,DATE_FORMAT(order__Date, '%b %d, %y') AS order__Date2  FROM sulata_order_details INNER JOIN sulata_products ON product__ID = orderdet__Product INNER JOIN sulata_orders ON order__ID = orderdet__Order WHERE ((order__Status = 'Received') OR (order__Status = 'Delivered')) GROUP BY product__ID";
//Download CSV
if (suSegment(1) == 'stream-csv' && $downloadAccess == TRUE) {
    $outputFileName = 'daily-inventory-' . date('Y-m-d') . '.csv';
    $headerArray = array('Material', 'Unit', 'Quantity');
    suSqlToCSV($sql, $headerArray, $outputFileName);
    exit;
}
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
                                <form name="suAdvancedForm" id="suAdvancedForm" method="get" action="">
                                    <fieldset style="border: 1px solid #eee;padding: 20px;">
                                        <div class="form-group" style="margin-top: 10px;">

                                            <div class="clearfix"></div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <label ><i class="fa fa-calendar blue"></i> Search by Date</label>
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
                                                <input id="Submit_advance" type="submit" value="Search" name="Submit_advance" class="btn btn-primary pull-right">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </fieldset>
                                </form>
                                <?php if ($_GET['startDate']) { ?>

                                    <div class="pull-right"><a style="text-decoration:underline !important;" href="<?php echo ADMIN_URL; ?>daily-inventory.php/">Clear search.</a></div>
                                </div>
                            <?php } ?>
                            <div class="clearfix"></div>
                        </div>


                        <!-- TABLE -->

                        <table width="100%" class="table table-hover table-bordered tbl">
                            <thead>
                                <tr>
                                    <th style="width:5%">
                                        Sr.
                                    </th>

                                    <th style="width:23%">Material</th>
                                    <th style="width:23%">Unit</th>
                                    <th style="width:23%">Quantity</th>



                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($_GET['startDate'] != "" && $_GET['endDate'] != "") {
                                    $where .= " AND date(order__Date) >= '" . suDate2Db($_GET['startDate']) . "' AND date(order__Date) <= '" . suDate2Db($_GET['endDate']) . "'";
                                } else {
                                    $where .= " AND date(O.order__Date)='" . date("Y-m-d") . "'";
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
                                    $sort = "";
                                } else {
                                    //$sort = "GROUP BY orderdet__Product ORDER BY totalQuantity DESC" . $_GET['f'] . " " . $_GET['sort'];
                                }
//Get records from database

                                $sql = "$sql $sort LIMIT " . $_GET['start'] . "," . $getSettings['page_size'];

                                $result = suQuery($sql);
                                $numRows = suNumRows($result);

                                while ($row = suFetch($result)) {
                                    ?>


                                    <tr>
                                        <td>
                                            <?php echo $sr = $sr + 1; ?>.
                                        </td>
                                        <td><?php echo suUnstrip($row['rawmaterial__Material']); ?></td>
                                        <td><?php echo suUnstrip($row['rawmaterial__Unit']); ?></td>
                                        <td><?php echo $row['total']; ?></td>






                                    </tr>
                                    <?php
                                }suFree($result);
                                ?>


                            </tbody>
                        </table>

                        <!-- /TABLE -->
                        <?php
//                                $sqlP = "SELECT COUNT(order__ID) AS totalRecs FROM FROM sulata_order_details INNER JOIN sulata_products ON product__ID = orderdet__Product INNER JOIN sulata_orders ON order__ID = orderdet__Order WHERE order__Status = 'Received' $where";
//                                suPaginate($sqlP);
                        ?>
                        <?php if ($downloadAccess == TRUE) { ?>
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