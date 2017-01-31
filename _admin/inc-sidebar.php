<?php if ($_GET['overlay'] != 'yes') { ?>
    <div class="sidebar">

        <div class="sidey">

            <!-- Logo -->
            <!-- Sidebar navigation starts -->

            <!-- Responsive dropdown -->
            <div class="sidebar-dropdown"><a href="#" class="br-red"><i class="fa fa-bars"></i></a></div>

            <div class="side-nav">

                <div class="side-nav-block">
                    <?php
                    if ($includeCart == TRUE) {
                        include('inc-cart.php');
                    }
                    ?>
                    <!-- Sidebar heading -->
                    <!-- Sidebar links -->
                    <div class="clearfix"></div>
                    <?php if ($includeCart == TRUE) { ?>
                        <ul class="list-unstyled" style="margin-top:20px">

                            <li><a href="<?php echo ADMIN_URL; ?>" class="btn sideLink"><i class="fa fa-home"></i> Home</a></li>
                            <li><a href="<?php echo ADMIN_URL; ?>login.php/?do=logout" target="remote" class="btn sideLinkReverse"><i class="fa fa-power-off"></i> Log Out</a></li>

                        </ul>
                    <?php } else {
                        ?>

                        <ul class="list-unstyled" style="margin-top:20px">
                            <?php if ($_SESSION[SESSION_PREFIX . 'user__ID'] == '') { ?>
                                <li><a href="<?php echo ADMIN_URL; ?>login.php" class="btn sideLink"><i class="fa fa-key"></i> Log In</a></li>
                            <?php } ?>
                            <?php if ($_SESSION[SESSION_PREFIX . 'user__ID'] != '') { ?>
                                <li><a href="<?php echo ADMIN_URL; ?>" class="btn sideLink"><i class="fa fa-home"></i> Home</a></li>
                                <?php
                                $sqlDailyEarnings = "SELECT SUM(order__Total_Amount-order__Discount) AS totalAmount FROM sulata_orders WHERE order__dbState = 'Live' AND date(order__Date) = '" . date("Y-m-d") . "' ";
                                $rsDailyEarnings = suQuery($sqlDailyEarnings);
                                $rowDailyEarnings = suFetch($rsDailyEarnings);
                                ?>
                                <li><a href="<?php echo ADMIN_URL; ?>pos.php/" class="btn sideLinkReverse"><i class="fa fa-fax"></i> POS <?php if ($rowDailyEarnings['totalAmount'] != "") { ?>
                                            <sup><?php echo $getSettings['site_currency'] ?> <?php echo number_format($rowDailyEarnings['totalAmount'], 2) ?></sup>
                                        <?php } ?>
                                    </a></li>
                                <?php if ($_SESSION[SESSION_PREFIX . 'user__Type'] == 'Admin') {
                                    ?>
                                    <li><a href="<?php echo ADMIN_URL; ?>daily-sales-summary.php/" class="btn sideLinkReverse"><i class="fa fa-dollar"></i> Today's Sale</a></li>
                                    <li><a href="<?php echo ADMIN_URL; ?>date-wise-sales-report.php/" class="btn sideLinkReverse"><i class="fa fa-calendar"></i> Date-wise Sale</a></li>
                                <?php } ?>
                                <li><a href="<?php echo ADMIN_URL; ?>break-up-report.php/" class="btn sideLinkReverse"><i class="fa fa-cubes"></i> Sales Break-up</a></li>
                                <li><a href="<?php echo ADMIN_URL; ?>daily-inventory.php/" class="btn sideLinkReverse"><i class="fa fa-cubes"></i> Daily Inventory</a></li>
                                <li><a href="<?php echo ADMIN_URL; ?>open-orders<?php echo $tableCardLink; ?>.php/" class="btn sideLink"><i class="fa fa-folder-open"></i> Open Orders</a></li>
                                <li><a href="<?php echo ADMIN_URL; ?>orders-cards.php/" class="btn sideLink"><i class="fa fa-file-text-o"></i> Orders</a></li>
                                <li><a href="<?php echo ADMIN_URL; ?>assign-locations.php/" class="btn sideLink"><i class="fa fa-map-marker"></i> Assign Location</a></li>
                                <li><a href="<?php echo ADMIN_URL; ?>assign-menu.php/" class="btn sideLink"><i class="fa fa-list"></i> Assign Menu</a></li>
                                <?php if ($_SESSION[SESSION_PREFIX . 'user__Type'] == 'Admin') {
                                    ?>
                                    <li><a href="<?php echo ADMIN_URL; ?>graphs.php/" class="btn sideLink"><i class="fa fa-bar-chart"></i> Sales Graph</a></li>
                                <?php } ?>
                                <li><a href="<?php echo ADMIN_URL; ?>notes/" class="btn sideLink"><i class="fa fa-pencil"></i> Free Notes</a></li>
                                <li><a href="<?php echo ADMIN_URL; ?>sync-start/" class="btn sideLink"><i class="fa fa-arrow-up"></i> Sync</a></li>
                                <?php if ($_SESSION[SESSION_PREFIX . 'user__Type'] == 'Admin') {
                                    ?>

                                    <li><a href="<?php echo ADMIN_URL; ?>settings<?php echo $tableCardLink; ?>/" class="btn sideLink"><i class="fa fa-cogs"></i> Settings</a></li>

                                <?php } ?>
                                <li><a href="<?php echo ADMIN_URL; ?>themes.php/" class="btn sideLink"><i class="fa fa-photo"></i> Themes</a></li>
                                <li><a href="<?php echo ADMIN_URL; ?>users-update.php/" class="btn sideLink"><i class="fa fa-user"></i> Update Profile</a></li>
                                <li><a href="<?php echo ADMIN_URL; ?>login.php/?do=logout" target="remote" class="btn sideLinkReverse"><i class="fa fa-power-off"></i> Log Out</a></li>
                                <li class="divider"></li>
                            <?php } ?>
                            <?php
                            if ($getSettings['sidebar_links'] == 1) {
                                if ($_SESSION[SESSION_PREFIX . 'user__ID'] != '') {
                                    ?>

                                    <h4>&nbsp;</h4>

                                    <?php
                                    $dir = './';
                                    $dir = scandir($dir);
                                    $exclude = array(
                                        '.',
                                        '..',
                                        'index.html',
                                        'index.php',
                                        'login.php',
                                        'reload.php',
                                        'settings.php',
                                        'template.php',
                                        'logout.php',
                                        'message.php',
                                        'lost-password.php',
                                        'daily-sales-summary.php',
                                        'graphs.php',
                                        'notes.php',
                                        'themes.php',
                                        'modules.php',
                                        'css',
                                        'scss',
                                        'fonts',
                                        'img',
                                        'js',
                                        'less'
                                    );
                                    foreach ($dir as $file) {
                                        if ((!in_array($file, $exclude)) && ($file[0] != '.')) {
                                            if ((!stristr($file, '-add')) && (!stristr($file, '-remote')) && (!stristr($file, '-update')) && (!stristr($file, 'inc-')) && (!stristr($file, '-cards'))) {
                                                $fileNameActual = str_replace('.php', '', $file);
                                                $fileName = str_replace('-', ' ', $fileNameActual);

                                                $fileNameShow = str_replace('_', ' ', $fileName);
                                                if (stristr($fileNameShow, 'faqs')) {
                                                    $fileNameShow = 'FAQs';
                                                }
                                                $fileLink = str_replace('.php', $tableCardLink . '.php/', $file);
                                                ?>
                                                <li><a href="<?php echo ADMIN_URL . $fileLink; ?>" class="btn sideLink"><i class="fa fa-minus"></i> <?php echo ucwords($fileNameShow); ?></a></li>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>

                                    <?php
                                }
                            }
                            ?>
                            <?php
                            if ($getSettings['sidebar_links'] == 0) {
                                if ($_SESSION[SESSION_PREFIX . 'user__ID'] != '') {
                                    if ($_SESSION[SESSION_PREFIX . 'user__Type'] == 'Admin') {
                                        ?>

                                        <h4>&nbsp;</h4>


                                        <li><a href="<?php echo ADMIN_URL; ?>modules.php/" class="btn sideLink"><i class="fa fa-ellipsis-h pull-right"></i></a></li>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </ul>
                    <?php } ?>

                </div>

            </div>

            <!-- Sidebar navigation ends -->

        </div>
    </div>
<?php } else { ?>
    <style>
        .mainbar{
            margin-left:0px;
        }
    </style>
<?php } ?>
