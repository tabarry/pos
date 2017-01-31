<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Daily Sales Summary';
$pageTitle = 'Daily Sales Summary';
$downloadAccess = TRUE;
$sql = "SELECT order__ID, order__UID,order__Number,DATE_FORMAT(order__Date, '%b %d, %y %h:%i %p') AS order__Date2,CONCAT(order__Customer_Name,' - ',order__Mobile_Number) as Customer,(order__Total_Amount-order__Discount) AS Total,SUM(product__Cost_Price * orderdet__Quantity) AS costPrice,order__Tax,order__Tax_Value,order__Location FROM sulata_orders INNER JOIN sulata_order_details ON order__UID = orderdet__Order_UID INNER JOIN sulata_products ON product__ID = orderdet__Product  WHERE order__dbState='Live' AND ((order__Status = 'Received') OR (order__Status = 'Delivered')) AND date(order__Date)='" . date("Y-m-d") . "' ";
$sql2 = "SELECT order__ID, order__UID,order__Number,DATE_FORMAT(order__Date, '%b %d, %y %h:%i %p') AS order__Date2,CONCAT(order__Customer_Name,' - ',order__Mobile_Number) as Customer,(order__Total_Amount-order__Discount) AS Total,SUM(product__Cost_Price * orderdet__Quantity) AS costPrice,order__Tax,order__Tax_Value FROM sulata_orders INNER JOIN sulata_order_details ON order__UID = orderdet__Order_UID INNER JOIN sulata_products ON product__ID = orderdet__Product  WHERE order__dbState='Live' AND ((order__Status = 'Received') OR (order__Status = 'Delivered')) AND date(order__Date)='" . date("Y-m-d") . "' GROUP BY order__ID";
//Download CSV
if (suSegment(1) == 'stream-csv' && $downloadAccess == TRUE) {
    $outputFileName = date('Y-m-d') . '.csv';
    $headerArray = array('UID', 'Order No', 'Date', 'Customer', 'Total', 'Total Cost', 'Tax Rate', 'Tax Value');
    suSqlToCSV($sql2, $headerArray, $outputFileName);
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
                                <h3 class="pull-left"><i class="fa fa-dollar green"></i> <?php echo $pageTitle; ?></h3>
                                <p>&nbsp;</p>
                                <form name="suForm" id="suForm" action="" method="get">
                                    <div class="col-lg-4">
                                        <label>Search by Location:</label>
                                        <select name="location" id="location" class="form-control">
                                            <option value="">Select...</option>
                                            <?php
                                            $sqlLocations = "SELECT location__ID,location__Location FROM sulata_locations WHERE location__dbState = 'Live'";
                                            $rsLocations = suQuery($sqlLocations);
                                            while ($rowLocations = suFetch($rsLocations)) {
                                                if ($_GET['location'] == $rowLocations['location__ID']) {
                                                    $selected = "selected='selected'";
                                                } else {
                                                    $selected = "";
                                                }
                                                ?>
                                                <option value="<?php echo $rowLocations['location__ID'] ?>" <?php echo $selected ?>><?php echo suUnstrip($rowLocations['location__Location']) ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="clearfix"></div>
                                        <input type="submit" name="submit" value="Search" class="btn btn-primary " style="float: right"/>
                                        <div class="clearfix"></div>
                                        <?php if ($_GET['location'] != '') { ?>
                                            <div class="pull-right"><a style="text-decoration:underline !important;" href="<?php echo ADMIN_URL; ?>daily-sales-summary.php/">Clear search.</a></div>
                                        <?php } ?>
                                    </div>
                                </form>
                                <div class="clearfix"></div>

                            </div>

                            <!-- TABLE -->

                            <table width="100%" class="table table-hover table-bordered tbl">
                                <thead>
                                    <tr>
                                        <th style="width:5%">
                                            Sr.
                                        </th>

                                        <th style="width:7%">UID</th>
                                        <th style="width:7%">No.</th>
                                        <th style="width:10%">Date</th>
                                        <th style="width:15%">Customer</th>
                                        <th style="width:10%">Location</th>

                                        <th style="width:7%;text-align: right" >Tax Rate</th>
                                        <th style="width:10%;text-align: right" >Total</th>
                                        <th style="width:10%;text-align: right" >Cost Price</th>
                                        <th style="width:10%;text-align: right" >Earnings</th>

                                        <th style="width:10%;text-align: right" >Tax Value</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($_GET['location'] != "") {
                                        $where .=" AND order__Location='" . $_GET['location'] . "'";
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
                                        $sort = "GROUP BY order__UID ORDER BY order__UID DESC";
                                    } else {
                                        $sort = "GROUP BY order__UID ORDER BY order__UID DESC" . $_GET['f'] . " " . $_GET['sort'];
                                    }
//Get records from database

                                    $sql = "$sql $where $sort LIMIT " . $_GET['start'] . "," . $getSettings['page_size'];

                                    $result = suQuery($sql);
                                    $numRows = suNumRows($result);

                                    while ($row = suFetch($result)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $sr = $sr + 1; ?>.
                                            </td>
                                            <td><?php echo suUnstrip($row['order__UID']); ?></td>
                                            <td><?php echo suUnstrip($row['order__Number']); ?></td>
                                            <td><?php echo suUnstrip($row['order__Date2']); ?></td>
                                            <td><?php echo suUnstrip($row['Customer']); ?></td>
                                            <?php
                                            $sqlLocation = "SELECT location__Location FROM sulata_locations WHERE location__dbState='Live' AND location__ID = '" . $row['order__Location'] . "'";
                                            $rsLocation = suQuery($sqlLocation);
                                            $rowLocation = suFetch($rsLocation);
                                            ?>
                                            <td><?php echo suUnstrip($rowLocation['location__Location']); ?></td>

                                            <td align="right"><?php echo ($row['order__Tax']); ?>  </td>
                                            <td align="right"><?php echo number_format($row['Total'], 2); ?>  <sup><?php echo $getSettings['site_currency'] ?></sup></td>
                                            <td align="right"><?php echo number_format($row['costPrice'], 2); ?>  <sup><?php echo $getSettings['site_currency'] ?></sup></td>
                                            <td align="right"><?php echo $earnings = number_format($row['Total'] - $row['costPrice'], 2); ?>  <sup><?php echo $getSettings['site_currency'] ?></sup></td>

                                            <td align="right"><?php echo number_format($row['order__Tax_Value'], 2); ?>  <sup><?php echo $getSettings['site_currency'] ?></sup></td>
                                            <?php $total = $total + $row['Total']; ?>
                                            <?php $totalTax = $totalTax + $row['order__Tax_Value']; ?>
                                            <?php $totalcost = $totalcost + $row['costPrice']; ?>
                                            <?php $totalEarnings = $totalEarnings + $earnings; ?>




                                        </tr>
                                    <?php }suFree($result) ?>
                                    <tr>
                                        <td colspan="7">

                                        </td>


                                        <td align="right">Total  <sup><?php echo $getSettings['site_currency'] ?></sup>: <?php echo $totalValue = number_format($total, 2);
                                    ?></td>
                                        <td align="right">Total Cost <sup><?php echo $getSettings['site_currency'] ?></sup>: <?php echo $totalCostValue = number_format($totalcost, 2);
                                    ?></td>
                                        <td align="right">Total Earning <sup><?php echo $getSettings['site_currency'] ?></sup>: <?php echo $totalEarningsValue = number_format($totalEarnings, 2);
                                    ?></td>

                                        <td align="right"> Total Tax  <sup><?php echo $getSettings['site_currency'] ?></sup>:  <?php echo $totalTaxValue = number_format($totalTax, 2);
                                    ?></td>




                                    </tr>

                                </tbody>
                            </table>

                            <!-- /TABLE -->
                            <?php
                            $sqlP = "SELECT COUNT(order__ID) AS totalRecs FROM sulata_orders  WHERE order__dbState='Live' AND order__Status = 'Received' AND date(order__Date)='" . date("Y-m-d") . "' $where";
                            suPaginate($sqlP);
                            ?>
                            <?php if ($downloadAccess == TRUE && $numRows > 0) { ?>
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