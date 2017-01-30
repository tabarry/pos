<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$do = suSegment(1);
if($do=='print-invoice'){
     suPrintJS("window.open('" . ADMIN_URL . "pos-remote/print-invoice/" . suSegment(2) . "/" . suSegment(3) . "/', 'remote');");
//     suPrintJS("remote.window.location.href='" . ADMIN_URL . "pos-remote/print-invoice/" . suStrip($_POST['order__UID']) . "/" . session_id() . "/'");
}
$pageName = 'POS';
$pageTitle = 'Point of Sale';
//include cart in side bar
$includeCart = TRUE;
if ($_GET['u'] == '') {
    $uid = uniqid();
} else {
    $uid = suDecrypt($_GET['u']);
    $oldProduct = array();
    $oldQuantity = array();
    $old = array();
    $sql = "SELECT orderdet__Product,orderdet__Quantity FROM sulata_orders,sulata_order_details WHERE orderdet__dbState='Live' AND order__dbState='Live' AND orderdet__Order=order__ID AND order__UID='$uid' AND order__Session='" . session_id() . "'";
    $result = suQuery($sql);
    while ($row = suFetch($result)) {
        array_push($oldProduct, $row['orderdet__Product']);
        array_push($oldQuantity, $row['orderdet__Quantity']);
    }suFree($result);
}
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
        <style>
            .card{
                text-align: center;
            }
            .card h1{
                font-size: 120%;
            }
            .category{
                padding-top:10px;
                padding-bottom: 10px;
                background-color: #EEE;
                color: #000;
                margin-top:10px;
                margin-bottom: 10px;
                border-radius: 3px;
                text-align: center;
            }
            .spanProductId{
                font-size: 120%;
                color: #F39C12;
            }
            /** Highlight **/
            .highlight {
                background-color: #fff34d;
                -moz-border-radius: 5px; /* FF1+ */
                -webkit-border-radius: 5px; /* Saf3-4 */
                border-radius: 5px; /* Opera 10.5, IE 9, Saf5, Chrome */
                -moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.7); /* FF3.5+ */
                -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.7); /* Saf3.0+, Chrome */
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.7); /* Opera 10.5+, IE 9.0 */
            }

            .highlight {
                padding:1px 4px;
                margin:0 -4px;
            }
        </style>
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


                                <fieldset id="search-area1">
                                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><i class="fa fa-search blue"></i> Search</label>
                                    <div class="col-xs-7 col-sm-10 col-md-10 col-lg-10">
                                        <input id="q" type="text" value="" name="q" class="form-control" autocomplete="off">
                                    </div>

                                    <div id="searchDiv" style="display:none;"><a style="text-decoration:underline !important;" href="javascript:;" onclick="clearSearch();">Clear search.</a></div>
                            </div>
                            </fieldset>



                            <div class="lineSpacer clear"></div>




                            <!-- CARDS START -->
                            <?php
                            $sql1 = "SELECT category__ID,category__Category FROM sulata_menu_details INNER JOIN sulata_products ON product__ID = menudetail__Product INNER JOIN sulata_categories ON category__ID = product__Category WHERE category__dbState='Live' AND product__dbState = 'Live' AND menudetail__dbState = 'Live' AND menudetail__Menu = '".$getSettings['truck_menu']."' GROUP BY category__ID ORDER BY category__Category";
                            $result1 = suQuery($sql1);
                            while ($row1 = suFetch($result1)) {
                                ?>
                                <h3 class="col-xs-12 col-sm-12 col-md-12 col-lg-12 category">
                                    <?php echo suUnstrip($row1['category__Category']); ?>
                                </h3>
                                <?php
                                if ($_GET['q'] != '') {
                                    $where .= " AND (product__Name LIKE '%" . suStrip($_GET['q']) . "%' OR product__Code LIKE '%" . suStrip($_GET['q']) . "%' )";
                                }

                                $sql = "SELECT product__ID,product__Category,product__Picture,product__Code,product__Name,menudetail__Product_Price,product__Status FROM sulata_menu_details INNER JOIN sulata_products ON product__ID = menudetail__Product WHERE product__dbState='Live' AND product__Category='" . $row1['category__ID'] . "' AND menudetail__dbState = 'Live' AND menudetail__Menu = '".$getSettings['truck_menu']."' $where";
                                $result = suQuery($sql);
                                while ($row = suFetch($result)) {
                                    ?>


                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" id="card_<?php echo $row['product__ID']; ?>">
                                        <form name="suForm<?php echo $row['product__ID']; ?>" id="suForm<?php echo $row['product__ID']; ?>" target="remote" action="<?php echo ADMIN_URL; ?>pos-remote/add/" method="post">
                                            <div class="card">

                                                <h1>
                                                    <?php
                                                    if (!isset($row['product__Name']) || ($row['product__Name'] == '')) {
                                                        echo "-";
                                                    } else {
                                                        echo suSubstr(suUnstrip($row['product__Name']),100);
                                                    }
                                                    ?>

                                                </h1>
                                                <label>
                                                    <?php
                                                    if (!isset($row['product__Code']) || ($row['product__Code'] == '')) {
                                                        echo "-";
                                                    } else {
                                                        echo suSubstr(suUnstrip($row['product__Code']),100);
                                                    }
                                                    ?>
                                                </label>
                                                <?php
                                                if ((isset($row['product__Picture']) && $row['product__Picture'] != '') && (file_exists(ADMIN_UPLOAD_PATH . $row['product__Picture']))) {
                                                    $defaultImage = BASE_URL . 'files/' . $row['product__Picture'];
                                                } else {
                                                    $defaultImage = BASE_URL . 'files/default-image.png';
                                                }
                                                ?>
                                                <center>
                                                    <?php if ($row['product__Status'] == 'Available') { ?>
                                                        <div class="imgThumb" style="display:none;background-image:url(<?php echo $defaultImage; ?>);cursor:pointer;" onclick="$('#suForm<?php echo $row['product__ID']; ?>').submit();"></div>
                                                    <?php } else { ?>
                                                        <div class="imgThumb grayScale" style="display:none;background-image:url(<?php echo $defaultImage; ?>);"></div>
                                                    <?php } ?>
                                                </center>


                                                <p>
                                                    <?php
                                                    if (!isset($row['menudetail__Product_Price']) || ($row['menudetail__Product_Price'] == '')) {
                                                        $price = '-';
                                                    } else {
                                                        $price = $getSettings['site_currency'] . ' ' . suSubstr(number_format($row['menudetail__Product_Price'], 2));
                                                    }
                                                    ?>
                                                </p>

                                                <label style="padding-bottom:5px;">

                                                    <?php
                                                    if (!isset($row['product__Status']) || ($row['product__Status'] == '')) {
                                                        echo "-";
                                                    } else {
                                                        echo suSubstr(suUnstrip($row['product__Status']));
                                                    }
                                                    ?>
                                                </label>
                                                <!-- product info -->
                                                <input type="hidden" name="order__UID" value="<?php echo $uid; ?>"/>
                                                <input type="hidden" name="orderdet__Product" value="<?php echo $row['product__ID']; ?>"/>
                                                <input type="hidden" name="orderdet__Code" value="<?php echo suUnstrip($row['product__Code']); ?>"/>
                                                <input type="hidden" name="orderdet__Name" value="<?php echo suUnstrip($row['product__Name']); ?>"/>
                                                <input type="hidden" name="orderdet__Price" value="<?php echo suUnstrip($row['menudetail__Product_Price']); ?>"/>

                                                <!-- // -->
                                                <?php if ($row['product__Status'] == 'Available') { ?>
                                                    <input type="submit" value="<?php echo $price; ?>" class="btn btn-primary"/>

                                                <?php } else { ?>
                                                    <input type="submit" value="<?php echo $price; ?>" class="btn btn-danger" disabled="disabled"/>

                                                <?php } ?>
                                                <span class="spanProductId" id="spanProductId<?php echo $row['product__ID']; ?>">
                                                    <?php
                                                    if (in_array($row['product__ID'], $oldProduct)) {
                                                        echo $oldQuantity[suGetArrayIndex($row['product__ID'], $oldProduct)];
                                                    } else {
                                                        echo '0';
                                                    }
                                                    ?>
                                                </span>
                                                <div class="right"><label><?php echo $sr = $sr + 1; ?></label></div>

                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                }suFree($result);
                            } suFree($result1);
                            ?>
                            <!-- CARDS END -->
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
    <!-- Search -->
    <script src="<?php echo BASE_URL; ?>/sulata/js/highlight.js" type="text/javascript"></script>
    <script type="text/javascript">

                                                            $(function () {
                                                                $('#q').bind('keyup change', function (ev) {
                                                                    // pull in the new value
                                                                    var searchTerm = $(this).val();
                                                                    //Show clear search link
                                                                    $('#searchDiv').show();
                                                                    // remove any old highlighted terms
                                                                    $('body').removeHighlight();

                                                                    // disable highlighting if empty
                                                                    if (searchTerm) {
                                                                        // highlight the new term
                                                                        $('body').highlight(searchTerm);
                                                                    }
                                                                });
                                                            });

                                                            function clearSearch() {
                                                                $('#q').val('');
                                                                // remove any old highlighted terms
                                                                $('body').removeHighlight();
                                                                //hide clear search link
                                                                $('#searchDiv').hide();

                                                            }
    </script>
    <?php suIframe(); ?>
    <?php
    if ($_GET['u'] != '') {
        suPrintJs("remote.location.href='" . ADMIN_URL . "pos-remote/reload/" . $uid . "/'");
    }
    ?>
</body>
<!--PRETTY PHOTO-->
<?php include('inc-pretty-photo.php'); ?>
</html>
