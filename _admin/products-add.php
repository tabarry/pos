<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Add Products';
$pageTitle = 'Add Products';
if ($_SESSION[SESSION_PREFIX . 'user__Type'] != 'Admin') {
    suExit(INVALID_ACCESS);
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
        <script type="text/javascript">
            function doAutocomplete(arg) {

                $(arg).autocomplete({
                    source: availableTags
                });
            }
            ;


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
                                    <a href="<?php echo ADMIN_URL; ?>products-cards.php/"><i class="fa fa-th-large"></i></a>
                                    <a href="<?php echo ADMIN_URL; ?>products.php/"><i class="fa fa-table"></i></a>
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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>products-remote.php/add/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" enctype="multipart/form-data">

                                    <div class="gallery clearfix">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">        
                                                <label><?php echo $dbs_sulata_products['product__Category_req']; ?>Category:
                                                    <?php if ($addAccess == 'true') { ?>    
                                                        <a title="Add new record.." rel="prettyPhoto[iframes]" href="<?php echo ADMIN_URL; ?>categories-add.php/?overlay=yes&iframe=true&width=50%&height=100%"><img border='0' src='<?php echo BASE_URL; ?>sulata/images/add-icon.png'/></a>

                                                        <a onclick="suReload('product__Category', '<?php echo ADMIN_URL; ?>', '<?php echo suCrypt('sulata_categories'); ?>', '<?php echo suCrypt('category__ID'); ?>', '<?php echo suCrypt('category__Category'); ?>');" href="javascript:;"><img border='0' src='<?php echo BASE_URL; ?>sulata/images/reload-icon.png'/></a>    
                                                    <?php } ?>    
                                                </label>
                                                <?php
                                                $sql = "SELECT category__ID AS f1, category__Category AS f2 FROM sulata_categories where category__dbState='Live' ORDER BY f2";
                                                $options = suFillDropdown($sql);
                                                $js = "class='form-control'";
                                                echo suDropdown('product__Category', $options, '', $js)
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <label><?php echo $dbs_sulata_products['product__Picture_req']; ?>Picture:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_products['product__Picture_html5_type'], 'name' => 'product__Picture', 'id' => 'product__Picture', $dbs_sulata_products['product__Picture_html5_req'] => $dbs_sulata_products['product__Picture_html5_req']);
                                                echo suInput('input', $arg);
                                                ?>
                                                <div><?php echo $getSettings['allowed_image_formats']; ?></div>
                                            </div>
                                        </div>




                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_products['product__Code_req']; ?>Code:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_products['product__Code_html5_type'], 'name' => 'product__Code', 'id' => 'product__Code', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_products['product__Code_max'], 'value' => '', $dbs_sulata_products['product__Code_html5_req'] => $dbs_sulata_products['product__Code_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_products['product__Name_req']; ?>Name:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_products['product__Name_html5_type'], 'name' => 'product__Name', 'id' => 'product__Name', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_products['product__Name_max'], 'value' => '', $dbs_sulata_products['product__Name_html5_req'] => $dbs_sulata_products['product__Name_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">            
                                                <label><?php echo $dbs_sulata_products['product__Cost_Price_req']; ?>Cost Price<sup><?php echo $getSettings['site_currency']; ?></sup>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_products['product__Cost_Price_html5_type'], 'name' => 'product__Cost_Price', 'id' => 'product__Cost_Price', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_products['product__Cost_Price_max'], 'value' => '', $dbs_sulata_products['product__Cost_Price_html5_req'] => $dbs_sulata_products['product__Cost_Price_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>    

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">            
                                                <label><?php echo $dbs_sulata_products['product__Price_req']; ?>Price<sup><?php echo $getSettings['site_currency']; ?></sup>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_products['product__Price_html5_type'], 'name' => 'product__Price', 'id' => 'product__Price', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_products['product__Price_max'], 'value' => '', $dbs_sulata_products['product__Price_html5_req'] => $dbs_sulata_products['product__Price_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>    
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                
                                                <label><?php echo $dbs_sulata_products['product__Description_req']; ?>Description:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_products['product__Description_html5_type'], 'name' => 'product__Description', 'id' => 'product__Description', $dbs_sulata_products['product__Description_html5_req'] => $dbs_sulata_products['product__Description_html5_req'], 'class' => 'form-control');
                                                echo suInput('textarea', $arg, '', TRUE);
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">        
                                                <label><?php echo $dbs_sulata_products['product__Status_req']; ?>Status:</label>
                                                <?php
                                                $options = $dbs_sulata_products['product__Status_array'];
                                                $js = "class='form-control'";
                                                echo suDropdown('product__Status', $options, 'Available', $js)
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">        
                                                <label>Add Raw Material:</label>
                                                <table border="1" class="table table-hover table-bordered tbl" style="padding-bottom:0px;margin-bottom:0px;">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                Material
                                                            </th>
                                                            <th>
                                                                Unit
                                                            </th>

                                                            <th>
                                                                Quantity
                                                            </th>

                                                            <th>
                                                                &nbsp;
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td width="20%">
                                                                <input type="hidden" name="material__ID[]"  id="material__ID[]"  value="" />
                                                                <input type="text" autocomplete="off" name="material[]" id="material" onkeypress="return searchCode(event, this)" onkeyup="doAutocomplete(this)"  class="form-control"/>

                                                            </td>
                                                            <td width="20%">
                                                                <input type="text" autocomplete="off" name="unit[]" id="unit[]" readonly="readonly" class="form-control"/>
                                                            </td>

                                                            <td width="10%">
                                                                <input type="text" autocomplete="off" name="qty[]"  value="1"   class="form-control "/>
                                                            </td >

                                                            <td width="10%" align="center">
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div id="insertBefore"></div>


                                                <div class="clearfix"></div>
                                                <p>&nbsp;</p>
                                                <a href="javascript:;" onclick="addRow()" class="btn btn-primary">Add row</a>
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
                                <form name="suForm3" id="suForm3" style="display: none">
                                    <table border="1" class="table table-hover table-bordered tbl" style="border-top:0px;padding-bottom:0px;margin-bottom:0px;">
                                        <tbody>
                                            <tr>
                                                <td width="20%">
                                                    <input type="hidden" name="material__ID[]"  id="material__ID[]"  value="" />
                                                    <input type="text" autocomplete="off" name="material[]" id="material" onkeypress="return searchCode(event, this)" onkeyup="doAutocomplete(this)"  class="form-control"/>
                                                </td>
                                                <td width="20%">
                                                    <input type="text" autocomplete="off" name="unit[]" id="unit[]" readonly="readonly" class="form-control"/>
                                                </td>

                                                <td width="10%">
                                                    <input type="text" autocomplete="off" name="qty[]"  value="1"  class="form-control"   />
                                                </td >
                                                <td width="10%" align="center">
                                                    <a href="javascript:;" onclick="delRow(this);"><i class="fa fa-close red"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </form>
                                <?php
                                $sql_product = "SELECT rawmaterial__Unit,rawmaterial__Material,rawmaterial__ID FROM sulata_raw_materials WHERE rawmaterial__dbState = 'Live' ";
                                $rs_product = suQuery($sql_product);
                                while ($row_product = suFetch($rs_product)) {
                                    $obj .= '{' . '"item"' . ':' . ' ' . '"' . suUnstrip($row_product['rawmaterial__Material']) . '"' . ', ' . '"unit"' . ':' . '"' . suUnstrip($row_product['rawmaterial__Unit']) . '"' . ', ' . '"id"' . ':' . ' ' . '"' . $row_product['rawmaterial__ID'] . '"' . ',' . '"serial"' . ':' . ' ' . '"' . $row_product['rawmaterial__Material'] . '"' . '}' . ',';

                                    //$serialNo.=$row_product['product__Serial_No'].',';
                                    $serialNo.='"' . $row_product['rawmaterial__Material'] . '"' . ',';
                                }
                                ?>
                                <script>
                                    var availableTags = [<?php echo substr($serialNo, 0, -1) ?>];
                                    //Json object
                                    var obj = [
<?php echo substr($obj, 0, -1) ?>

                                    ];


                                    function addRow() {

                                        $($('#suForm3').html()).insertBefore("#insertBefore");


                                    }
                                    function delRow(arg) {
                                        $(arg).parent().parent().parent().parent().remove();


                                    }
                                    function findNext(arg, whichNext) {
                                        n = $(':input:eq(' + ($(':input').index(arg) + whichNext) + ')');
                                        //alert(n.val());
                                        return n;
                                    }
                                    function findPrev(arg, whichPrev) {
                                        n = $(':input:eq(' + ($(':input').index(arg) - whichPrev) + ')');
                                        //alert(n.val());
                                        return n;
                                    }



                                    function stopSubmit(e) {

                                        if (e.keyCode == 13) { //Stop submitting on enter
                                            return false;
                                        }

                                    }

                                    function searchCode(e, str) {
                                        if (e.keyCode == 13) {

                                            for (var i = 0; i < obj.length; i++) {
                                                // look for the entry with a matching `code` value
                                                if (obj[i].serial.toLowerCase() == str.value.toLowerCase()) {


                                                    //alert(x);
                                                    //Get and set item
                                                    id = findPrev(str, 1);
                                                    id.val(obj[i].id);
                                                    var y = id.val();
                                                    //alert(y);
                                                    //alert(y);
                                                    var myarr = document.getElementsByName('material__ID[]');
                                                    var numberofElements = myarr.length - 3;
                                                    //alert(numberofElements);
                                                    for (var j = 0; j <= numberofElements; j++) {
                                                        var x = document.getElementsByName("material__ID[]")[j].value;

                                                        //alert(x);
                                                        //alert(z);
                                                        if (x == y) {
                                                            alert('Raw Material already exists.');
                                                            code = findNext(str, 1);
                                                            code.val('');
                                                            id = findPrev(str, 1);
                                                            id.val('');
                                                            qty = findNext(str, 2);
                                                            qty.val('0');
                                                            return false;
                                                        }
                                                    }



                                                    //Get and set item
                                                    code = findNext(str, 1);
                                                    code.val(obj[i].unit);

                                                    qty = findNext(str, 2);
                                                    qty.val('1');


                                                    return false;
                                                } else {
                                                    code = findNext(str, 1);
                                                    code.val('');

                                                    qty = findNext(str, 2);
                                                    qty.val('0');


                                                    //                                            return false;
                                                }

                                            }
                                            alert('Invalid Raw Material.');
                                            return false;
                                        }

                                    }

                                </script>
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