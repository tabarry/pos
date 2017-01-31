<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Manage Menus';
$pageTitle = 'Manage Menus';

//Make select statement. The $SqlFrom is also used in $sqlP below.    
$sqlSelect = "SELECT menu__ID,menu__Title,menu__Status ";
$sqlFrom = " FROM sulata_menus WHERE menu__dbState='Live'";
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
                                <div class="pull-right">
                                    <a href="<?php echo ADMIN_URL; ?>menus.php/"><i class="fa fa-table"></i></a>
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

                                <form class="form-horizontal" name="searchForm" id="searchForm" method="get" action="">
                                    <fieldset id="search-area1">
                                        <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><i class="fa fa-search blue"></i> Search by Title</label>
                                        <div class="col-xs-7 col-sm-10 col-md-10 col-lg-10">
                                            <input id="q" type="text" value="" name="q" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-xs-5 col-sm-2 col-md-2 col-lg-2">
                                            <input id="Submit" type="submit" value="Search" name="Submit" class="btn btn-primary pull-right">
                                        </div>
                                        <?php if ($_GET['q']) { ?>
                                            <div class="lineSpacer clear"></div>
                                            <div class="pull-right"><a style="text-decoration:underline !important;" href="<?php echo ADMIN_URL; ?>menus-cards.php/">Clear search.</a></div>
                                            </div>
                                        <?php } ?>
                                    </fieldset>
                                </form>


                                <div class="lineSpacer clear"></div>
                                <?php if ($addAccess == 'true') { ?>
                                    <div id="table-area"><a href="<?php echo ADMIN_URL; ?>menus-add.php/" class="btn btn-black">Add new..</a></div>
                                <?php } ?>
                                <?php
                                $fieldsArray = array('menu__Title', 'menu__Status');
                                suSort($fieldsArray);
                                ?>

                                <?php
                                if ($_GET['q'] != '') {
                                    $where .= " AND menu__Title LIKE '%" . suStrip($_GET['q']) . "%' ";
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
                                    $sort = " ORDER BY menu__Title";
                                } else {
                                    $sort = " ORDER BY " . $_GET['f'] . " " . $_GET['sort'];
                                }
//Get records from database

                                $sql = "$sql $where $sort LIMIT " . $_GET['start'] . "," . $getSettings['page_size'];

                                $result = suQuery($sql);
                                $numRows = suNumRows($result);

                                while ($row = suFetch($result)) {
                                    ?>
                                    <!-- CARDS START -->
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" id="card_<?php echo $row['menu__ID']; ?>">
                                        <div class="card">

                                            <?php if (($editAccess == TRUE) || ($deleteAccess == TRUE)) { ?>

                                                <header>
                                                    <a href="<?php echo ADMIN_URL; ?>menu-details.php/<?php echo $row['menu__ID']; ?>/"><i class="fa fa-dollar"> Update Menu Price</i></a> - 
                                                    <?php if ($editAccess == TRUE) { ?>

                                                        <a href="<?php echo ADMIN_URL; ?>menus-update.php/<?php echo $row['menu__ID']; ?>/"><i class="fa fa-edit"></i></a> - 
                                                    <?php } ?>

                                                    <?php if ($deleteAccess == TRUE) { ?>

                                                        <a onclick="return delById('card_<?php echo $row['menu__ID']; ?>', '<?php echo CONFIRM_DELETE; ?>')" href="<?php echo ADMIN_URL; ?>menus-remote.php/delete/<?php echo $row['menu__ID']; ?>/" target="remote"><i class="fa fa-trash"></i></a>
                                                    <?php } ?>

                                                </header>
                                            <?php } ?>
                                            <label>Title</label>

                                            <h1>
                                                <?php
                                                if (!isset($row['menu__Title']) || ($row['menu__Title'] == '')) {
                                                    echo "-";
                                                } else {
                                                    echo suSubstr(suUnstrip($row['menu__Title']));
                                                }
                                                ?>
                                            </h1>
                                            <label>Status</label>

                                            <p>
                                                <?php
                                                if (!isset($row['menu__Status']) || ($row['menu__Status'] == '')) {
                                                    echo "-";
                                                } else {
                                                    echo suSubstr(suUnstrip($row['menu__Status']));
                                                }
                                                ?>
                                            </p>
                                            <?php if (($editAccess == TRUE) || ($deleteAccess == TRUE)) { ?>
                                                <th style="width:10%">&nbsp;</th>
                                            <?php } ?>

                                            <div class="right"><label><?php echo $sr = $sr + 1; ?></label></div>

                                        </div>

                                    </div>
                                    <!-- CARDS END -->
                                <?php }suFree($result) ?>
                                <div class="clearfix"></div>

                                <?php
                                $sqlP = "SELECT COUNT(menu__ID) AS totalRecs $sqlFrom $where";


                                suPaginate($sqlP);
                                ?>
                                <?php if ($downloadAccessCSV == TRUE && $numRows > 0) { ?>
                                    <p>&nbsp;</p>
                                    <p><a target="remote" href="<?php echo ADMIN_URL; ?>menus.php/stream-csv/" class="btn btn-black pull-right"><i class="fa fa-download"></i> Download CSV</a></p>
                                    <p>&nbsp;</p>
                                    <div class="clearfix"></div>
                                <?php } ?>
                                <?php if ($downloadAccessPDF == TRUE && $numRows > 0) { ?>
                                    <p>&nbsp;</p>
                                    <p><a target="remote" href="<?php echo ADMIN_URL; ?>menus.php/stream-pdf/" class="btn btn-black pull-right"><i class="fa fa-download"></i> Download PDF</a></p>
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