<link href="<?php echo ADMIN_URL; ?>css/cart.css" rel="stylesheet" type="text/css"/>
<div id="cart">
    <?php
    $sqlLocation = "SELECT location__Location FROM sulata_locations WHERE location__dbState = 'Live' AND location__ID = '" . $getSettings['truck_location'] . "'";
    $rsLocation = suQuery($sqlLocation);
    $rowLocation = suFetch($rsLocation);
    ?>

    <form name="orderForm" id="orderForm" action="<?php echo ADMIN_URL; ?>pos-remote.php/order/" method="post" target="remote">
        <h4>THIS ORDER</h4>
        <h4>Location: <?php echo $rowLocation['location__Location'] ?></h4>
        <input type="hidden" name="order__UID" value="<?php echo $uid; ?>"/>
        <input type="text" name="order__Customer_Name" id="order__Customer_Name" placeholder="Name" class="form-control caps" required="required" autocomplete="off"/>
        <input type="number" name="order__Mobile_Number" id="order__Mobile_Number" placeholder="Mobile" class="form-control caps" autocomplete="off"/>
        <table id="tableContent">



            <tr>
                <td colspan="3" class="right" style="font-size: 12px">Total: Rs. 00.00 &nbsp;</td>

            </tr>
        </table>
        <table>
            <tr>
                <td  colspan="3" style="font-size: 12px">Promotional Code:</td>
            </tr>
            <tr>
                <td   colspan="3">
                    <input type="text" style="width: 120px" name="order__Promo_Code" id="order__Promo_Code" value="" autocomplete="off" onkeypress="return searchCode(event, this)" >


                </td>

            <tr>
                <td  colspan="3" style="font-size: 12px">Discount:</td>
            </tr>
            <tr>
                <td  align="center">
                    <input type="text" style="width: 50px" name="net_discount" id="net_discount" value="0" autocomplete="off" onkeyup="checkDiscount();" onkeypress="return floatOnly(event)">
                    <input type="hidden" name="order__Discount" id="order__Discount"  autocomplete="off"  value="0"  />

                </td>
                <td align="center">
                    <input type="radio" name="order__Discount_Type" id="order__Discount_Type1" value="percentage" onclick="return checkDiscount()" /> %
                    <input type="radio" name="order__Discount_Type" id="order__Discount_Type2" value="flat"  checked="checked" onclick="return checkDiscount()"/> <span style="font-size: 12px"><?php echo $getSettings['site_currency'] ?></span>
                </td>
            </tr>
<!--            <tr>
                <td colspan="3" >Promotion Code: </td>

            </tr>
            <tr>
                <td colspan="3" >   <input type="text" name="promotion" id="promotion" autocomplete="off"   style="width: 100px" onkeypress="return searchCode(event, this)" /></td>

            </tr>-->
            <tr>
                <td colspan="3" style="font-size: 12px">Net Total: </td>

            </tr>
            <tr>
                <td colspan="3" >   <input type="text" name="net_total" id="net_total" readonly="readonly" autocomplete="off"  value="0" style="width: 100px" onchange="return checkDiscount()" /></td>

            </tr>
            <tr>
                <td colspan="3" style="font-size: 12px">Cash Received: </td>

            </tr>
            <tr>
                <td colspan="3" >   <input type="number" name="order__Cash_Recieved" id="order__Cash_Recieved"  autocomplete="off" required="required" value="" style="width: 100px" onkeyup="return cashReceived()" onkeypress="return floatOnly(event)" placeholder="0"  step="0.01" /></td>

            </tr>
            <tr>
                <td colspan="3" style="font-size: 12px">Balance: </td>

            </tr>
            <tr>
                <td colspan="3" >   <input type="text" name="total_balance" id="total_balance" readonly="readonly" autocomplete="off"  value="0" style="width: 100px" /></td>

            </tr>
            <tr>
                <td colspan="3" style="font-size: 12px">Intructions: </td>

            </tr>
            <tr>
                <td colspan="3" >
                    <textarea name="order__Notes" id="order__Notes" rows="5"></textarea>
                </td>

            </tr>

        </table>

        <p class="pull-right topSpacer5"><input type="submit" value="Confirm" class="btn btn-primary"/></p>

        <p class="pull-right topSpacer5"><input type="button" value="Clear" onclick="location.href = '<?php echo ADMIN_URL ?>pos.php/';" class="btn btn-primary"/></p>
    </form>
    <?php
    $sql_product = "SELECT promotionalcode__Code,promotionalcode__Type,promotionalcode__Value FROM sulata_promotional_codes WHERE promotionalcode__Validity >= '" . date("Y-m-d") . "' AND promotionalcode__Active = 'Active'";
    $rs_product = suQuery($sql_product);
    while ($row_product = suFetch($rs_product)) {
        $obj .= '{' . '"code"' . ':' . ' ' . '"' . suUnstrip($row_product['promotionalcode__Code']) . '"' . ', ' . '"type"' . ':' . '"' . suUnstrip($row_product['promotionalcode__Type']) . '"' . ', ' . '"value"' . ':' . ' ' . '"' . $row_product['promotionalcode__Value'] . '"' . '}' . ',';
    }
    ?>
    <script>
        var obj = [
<?php echo substr($obj, 0, -1) ?>

        ];
        function floatOnly(e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return stopSubmit(e);
        }
        function cashReceived() {

            document.getElementById("total_balance").value = document.getElementById("order__Cash_Recieved").value - document.getElementById("net_total").value;
            return stopSubmit(e);

        }
        function checkDiscount() {

            if ($('input[name=order__Discount_Type]:checked', '#orderForm').val() == "percentage") {

                t = $("#totalAmount").val();
                d = $("#net_discount").val();

                nt = parseFloat(t * (d / 100));


                //Number(findNext(arg,1).val((r-net).toFixed(2)));
                //Number($("#discount_calculation").val((nt).toFixed(2)));

                nt2 = nt.toFixed(2);
                $("#order__Discount").val(nt2);
                dc = $("#order__Discount").val();
                nt3 = $("#net_total").val(t - dc);
                //document.getElementById("total_balance").value = nt3;
                nt4 = $("#total_balance").val(t - dc);



            } else {
                var d = parseFloat($("#net_discount").val());
                t = $("#totalAmount").val();

                var d2 = d.toFixed(2);
                $("#order__Discount").val(d2);
                nt3 = $("#net_total").val(t - d2);
                nt4 = $("#total_balance").val(t - d2);
                //document.getElementById("total_balance").value = nt3;



            }

            return floatOnly(event);
            return cashReceived();

        }

        function stopSubmit(e) {

            if (e.keyCode == 13) { //Stop submitting on enter
                return false;

            }

            return stopSubmit(e);
        }
        function searchCode(e, str) {
            if (e.keyCode == 13) {

                for (var i = 0; i < obj.length; i++) {
                    // look for the entry with a matching `code` value
                    if (obj[i].code.toLowerCase() == str.value.toLowerCase()) {

                        if (obj[i].type == 'percentage') {
                            radiobtn = document.getElementById("order__Discount_Type1");
                            radiobtn.checked = true;
                            document.getElementById("net_discount").value = obj[i].value;

                            return checkDiscount();



                        } else {
                            radiobtn = document.getElementById("order__Discount_Type2");
                            radiobtn.checked = true;
                            document.getElementById("net_discount").value = obj[i].value;
                            return checkDiscount();



                        }




                    } else {
                        alert('Invalid code.');
                        document.getElementById("net_discount").value = "0";
                        return checkDiscount();


                    }

                }

                return false;

            }

        }
        function giveDiscount(e) {
            return stopSubmit(e);

        }

    </script>

</div>
