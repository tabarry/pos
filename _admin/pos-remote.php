<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();

//Validation array
$validateAsArray = array('product__Category_validateas' => 'required', 'product__Picture_validateas' => 'image', 'product__Code_validateas' => 'required', 'product__Name_validateas' => 'required', 'product__Price_validateas' => 'float', 'product__Description_validateas' => 'required', 'product__Status_validateas' => 'enum',);
//---------
//Check to stop page opening outside iframe
//Deliberately disabled for list and delete conditions
$do = suSegment(1);
if ($do == 'print-invoice') {
    $sql = "SELECT order__ID,order__ID as order_id,order__Number,DATE_FORMAT(order__Date,'%d-%b-%y %h:%i %p') AS orderDate,order__Customer_Name,order__Mobile_Number,order__Total_Amount,order__Discount,order__Discount_Type,order__Cash_Recieved,order__Notes,order__Promo_Code FROM sulata_orders WHERE order__UID='" . suSegment(2) . "' AND order__Session='" . suSegment(3) . "' ";

    suInvoiceToPDF($sql, $outputFileName);
    exit;
}
if ($do == 'print-invoice-kitchen') {
    $sql = "SELECT order__ID,order__ID as order_id,order__Number,DATE_FORMAT(order__Date,'%d-%b-%y %h:%i %p') AS orderDate,order__Customer_Name,order__Mobile_Number,order__Total_Amount,order__Discount,order__Discount_Type,order__Cash_Recieved,order__Notes,order__Promo_Code FROM sulata_orders WHERE order__UID='" . suSegment(2) . "' AND order__Session='" . suSegment(3) . "' ";

    suKitchenInvoiceToPDF($sql, $outputFileName);
    exit;
}
if (($_GET["do"] != "check") && ($_GET["do"] != "autocomplete")) {
    suFrameBuster();
}
?>
<?php

//Add record
if ($do == "add") {
//Check referrer
    suCheckRef();

//Check if order uid already exists
    $sql = "SELECT order__ID FROM sulata_orders WHERE order__UID = '" . suStrip($_POST['order__UID']) . "' AND order__dbState='Live' AND order__Session='" . session_id() . "'";

    $result = suQuery($sql);
    if (suNumRows($result) == 0) {
        //Insert data
        $orderNumber = suMakeOrderNumber();
        $sql2 = "INSERT INTO sulata_orders SET order__UID='" . suStrip($_POST['order__UID']) . "', order__Number='" . $orderNumber . "',order__Customer_Name='',order__Mobile_Number='', order__Status='Being Ordered',order__Session='" . session_id() . "', order__Last_Action_On ='" . date('Y-m-d H:i:s') . "',order__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', order__dbState='Live' ";
        suQuery($sql2);
        $orderId = suInsertId();
    } else {
        $row = suFetch($result);
        $orderId = $row['order__ID'];
    }
    suFree($result);

    //Check if same item already exists in order detail
    $sql3 = "SELECT orderdet__ID FROM sulata_order_details WHERE orderdet__Order='$orderId' AND orderdet__Product='" . suStrip($_POST['orderdet__Product']) . "' AND orderdet__dbState='Live'";
    $result3 = suQuery($sql3);
    if (suNumRows($result3) == 0) {
        //Insert into order details
        $sql = "INSERT INTO sulata_order_details SET orderdet__Order='" . $orderId . "',orderdet__Product='" . $_POST['orderdet__Product'] . "',orderdet__Code='" . suStrip($_POST['orderdet__Code']) . "',orderdet__Name='" . suStrip($_POST['orderdet__Name']) . "',orderdet__Price='" . suStrip($_POST['orderdet__Price']) . "', orderdet__Quantity='1',orderdet__Last_Action_On ='" . date('Y-m-d H:i:s') . "',orderdet__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', orderdet__dbState='Live' ";
        suQuery($sql);
    } else {
        $sql = "UPDATE sulata_order_details SET orderdet__Product='" . suStrip($_POST['orderdet__Product']) . "',orderdet__Code='" . suStrip($_POST['orderdet__Code']) . "',orderdet__Name='" . suStrip($_POST['orderdet__Name']) . "',orderdet__Price='" . suStrip($_POST['orderdet__Price']) . "', orderdet__Quantity=orderdet__Quantity+1,orderdet__Last_Action_On ='" . date('Y-m-d H:i:s') . "',orderdet__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', orderdet__dbState='Live' WHERE orderdet__Order='$orderId' AND orderdet__Product='" . suStrip($_POST['orderdet__Product']) . "' AND orderdet__dbState='Live'";
        suQuery($sql);
    }
    suFree($result3);
    //Get updated quantity
    //Check if same item already exists in order detail
    $sql = "SELECT orderdet__Quantity FROM sulata_order_details WHERE orderdet__Order='$orderId' AND orderdet__Product='" . suStrip($_POST['orderdet__Product']) . "' AND orderdet__dbState='Live'";
    $result = suQuery($sql);
    $row = suFetch($result);
    $productQuantity = $row['orderdet__Quantity'];
    suFree($result);
    suPrintJs("parent.$('#spanProductId" . suStrip($_POST['orderdet__Product']) . "').html('" . $productQuantity . "');");
    //Make cart
    $sql = "SELECT orderdet__ID,orderdet__Name,orderdet__Quantity, (orderdet__Price*orderdet__Quantity) AS orderdet__Amount FROM sulata_order_details WHERE orderdet__Order='$orderId' AND orderdet__dbState='Live'";
    $result = suQuery($sql);
    while ($row = suFetch($result)) {
        $cnt = $cnt + 1;
        $total = $total + $row['orderdet__Amount'];
        $tableContent .= "<tr>"
                . "<td width=\"10%\">" . $cnt . ". </td>"
                . "<td width=\"10%\"><a href=\"" . ADMIN_URL . "pos-remote.php/delete/" . $row['orderdet__ID'] . "/\" target=\"remote\"><i class=\"fa fa-trash color-Crimson\"></i></a></td>"
                . "<td width=\"20%\">"
                . " <form name=\"suForm_" . $row["orderdet__ID"] . "\" id=\"suForm_" . $row["orderdet__ID"] . "\" method=\"post\" target=\"remote\" action=\"" . ADMIN_URL . "pos-remote.php/update/\">"
                . "<input style=\"width:30px;\" type=\"hidden\" name=\"detailID\" value=\"" . $row['orderdet__ID'] . "\" />"
                . "<input style=\"width:30px;\" type=\"number\" name=\"changeQuantity\" value=\"" . $row['orderdet__Quantity'] . "\" onkeyup=\"document.suForm_" . $row['orderdet__ID'] . ".submit();\" onchange=\"document.suForm_" . $row['orderdet__ID'] . ".submit();\" />"
                . "</form>"
                . "</td>"
                . "<td width=\"10%\"> x</td>"
                . "<td  width=\"50%\">" . suUnstrip($row['orderdet__Name']) . "</td></tr>";
    }suFree($result);
    $tableContent .="<tr><td colspan=\"5\" class=\"right\">Total: " . $getSettings['site_currency'] . ' ' . number_format($total, 2) . " &nbsp;"
            . "<input type=\"hidden\" name=\"totalAmount\" id=\"totalAmount\" value=\"" . $total . "\"/></td></tr>";
    suPrintJs("parent.$('#tableContent').html('" . $tableContent . "');");
    suPrintJs("parent.$('#net_total').val('" . $total . "');");
    suPrintJs("parent.$('#total_balance').val('" . $total . "');");
}
if ($do == 'update') {
    $sql = "UPDATE sulata_order_details SET orderdet__Quantity='" . $_POST["changeQuantity"] . "' WHERE orderdet__ID='" . $_POST["detailID"] . "'";

    suQuery($sql);
    //get cart total
    $sql = "SELECT orderdet__Order,orderdet__Product FROM sulata_order_details WHERE orderdet__ID = '" . $_POST["detailID"] . "'";
    $result = suQuery($sql);
    $row = suFetch($result);
    $orderId = $row['orderdet__Order'];
    $productId = $row['orderdet__Product'];

    suFree($result);

    $sql = "SELECT orderdet__ID,orderdet__Name,orderdet__Quantity, (orderdet__Price*orderdet__Quantity) AS orderdet__Amount FROM sulata_order_details WHERE orderdet__Order='$orderId' AND orderdet__dbState='Live'";
    $result = suQuery($sql);
    while ($row = suFetch($result)) {
        $cnt = $cnt + 1;
        $total = $total + $row['orderdet__Amount'];
        $tableContent .= "<tr>"
                . "<td width=\"10%\">" . $cnt . ". </td>"
                . "<td width=\"10%\"><a href=\"" . ADMIN_URL . "pos-remote.php/delete/" . $row['orderdet__ID'] . "/\" target=\"remote\"><i class=\"fa fa-trash color-Crimson\"></i></a></td>"
                . "<td width=\"20%\">"
                . " <form name=\"suForm_" . $row["orderdet__ID"] . "\" id=\"suForm_" . $row["orderdet__ID"] . "\" method=\"post\" target=\"remote\" action=\"" . ADMIN_URL . "pos-remote.php/update/\">"
                . "<input style=\"width:30px;\" type=\"hidden\" name=\"detailID\" value=\"" . $row['orderdet__ID'] . "\" />"
                . "<input style=\"width:30px;\" type=\"number\" name=\"changeQuantity\" value=\"" . $row['orderdet__Quantity'] . "\" onkeyup=\"document.suForm_" . $row['orderdet__ID'] . ".submit();\" onchange=\"document.suForm_" . $row['orderdet__ID'] . ".submit();\" />"
                . "</form>"
                . "</td>"
                . "<td width=\"10%\"> x</td>"
                . "<td  width=\"50%\">" . suUnstrip($row['orderdet__Name']) . "</td></tr>";
    }suFree($result);
    $tableContent .="<tr><td colspan=\"5\" class=\"right\">Total: " . $getSettings['site_currency'] . ' ' . number_format($total, 2) . " &nbsp;"
            . "<input type=\"hidden\" name=\"totalAmount\" id=\"totalAmount\" value=\"" . $total . "\"/></td></tr>";
    $sql = "SELECT orderdet__Quantity FROM sulata_order_details WHERE orderdet__Order='$orderId' AND orderdet__Product='" . $productId . "' AND orderdet__dbState='Live'";
    $result = suQuery($sql);
    $row = suFetch($result);
    $productQuantity = $row['orderdet__Quantity'];
    suFree($result);
    suPrintJs("parent.$('#tableContent').html('" . $tableContent . "');parent.$('#spanProductId" . $productId . "').html('" . $productQuantity . "');");
    suPrintJs("parent.$('#net_total').val('" . $total . "');");
    suPrintJs("parent.$('#total_balance').val('" . $total . "');");
}
//Delete record
if ($do == "delete") {
//Check referrer
    suCheckRef();
    $id = suSegment(2);
//Get order if of the item to delete
    $sql = "SELECT orderdet__Order,orderdet__Product FROM sulata_order_details WHERE orderdet__ID = '" . $id . "'";
    $result = suQuery($sql);
    $row = suFetch($result);
    $orderId = $row['orderdet__Order'];
    $productId = $row['orderdet__Product'];
    ;
    suFree($result);
    //Delete record
    $sql = "DELETE FROM sulata_order_details WHERE orderdet__ID = '" . $id . "'";
    suQuery($sql);
    //Make cart
    $sql = "SELECT orderdet__ID,orderdet__Name,orderdet__Quantity, (orderdet__Price*orderdet__Quantity) AS orderdet__Amount FROM sulata_order_details WHERE orderdet__Order='$orderId' AND orderdet__dbState='Live'";
    $result = suQuery($sql);
    while ($row = suFetch($result)) {
        $cnt = $cnt + 1;
        $total = $total + $row['orderdet__Amount'];
        $tableContent .= "<tr>"
                . "<td width=\"10%\">" . $cnt . ". </td>"
                . "<td width=\"10%\"><a href=\"" . ADMIN_URL . "pos-remote.php/delete/" . $row['orderdet__ID'] . "/\" target=\"remote\"><i class=\"fa fa-trash color-Crimson\"></i></a></td>"
                . "<td width=\"20%\">"
                . " <form name=\"suForm_" . $row["orderdet__ID"] . "\" id=\"suForm_" . $row["orderdet__ID"] . "\" method=\"post\" target=\"remote\" action=\"" . ADMIN_URL . "pos-remote.php/update/\">"
                . "<input style=\"width:30px;\" type=\"hidden\" name=\"detailID\" value=\"" . $row['orderdet__ID'] . "\" />"
                . "<input style=\"width:30px;\" type=\"number\" name=\"changeQuantity\" value=\"" . $row['orderdet__Quantity'] . "\" onkeyup=\"document.suForm_" . $row['orderdet__ID'] . ".submit();\" onchange=\"document.suForm_" . $row['orderdet__ID'] . ".submit();\" />"
                . "</form>"
                . "</td>"
                . "<td width=\"10%\"> x</td>"
                . "<td  width=\"50%\">" . suUnstrip($row['orderdet__Name']) . "</td></tr>";
    }suFree($result);
    $tableContent .="<tr><td colspan=\"5\" class=\"right\">Total: " . $getSettings['site_currency'] . ' ' . number_format($total, 2) . " &nbsp;"
            . "<input type=\"hidden\" name=\"totalAmount\" id=\"totalAmount\" value=\"" . $total . "\"/></td></tr>";
    suPrintJs("parent.$('#tableContent').html('" . $tableContent . "');parent.$('#spanProductId" . $productId . "').html('0');");
    suPrintJs("parent.$('#net_total').val('" . $total . "');");
    suPrintJs("parent.$('#total_balance').val('" . $total . "');");
}

//place order
if ($do == "order") {
    $printKitchen = TRUE;
    suCheckRef();
    $phoneNumber = preg_replace("/[\s-]+/", " ", $_POST['order__Mobile_Number']);
    $taxValue = ($getSettings['sales_tax_rate'] / 100) * $_POST['totalAmount'];
    $sql = "UPDATE sulata_orders SET order__Customer_Name = '" . strtoupper(suStrip($_POST['order__Customer_Name'])) . "', order__Mobile_Number='" . strtoupper(suStrip($phoneNumber)) . "',order__Status='Received',order__Date='" . date('Y-m-d H:i:s') . "',order__Promo_Code = '" . $_POST['order__Promo_Code'] . "',order__Total_Amount='" . round($_POST['totalAmount'], 2) . "',order__Discount='" . ($_POST['order__Discount']) . "',order__Discount_Type='" . ($_POST['order__Discount_Type']) . "',order__Cash_Recieved='" . $_POST['order__Cash_Recieved'] . "',order__Tax='" . $getSettings['sales_tax_rate'] . "',order__Tax_Value='" . round($taxValue) . "',order__Notes = '" . suStrip($_POST['order__Notes']) . "',order__Location = '" . $getSettings['truck_location'] . "', order__Last_Action_On ='" . date('Y-m-d H:i:s') . "',order__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', order__dbState='Live' WHERE order__UID='" . suStrip($_POST['order__UID']) . "' AND order__Session='" . session_id() . "'";

    suQuery($sql);

    $sqlUID = "SELECT order__ID FROM sulata_orders WHERE order__UID='" . suStrip($_POST['order__UID']) . "' AND order__Session='" . session_id() . "'";
    $rsUID = suQuery($sqlUID);
    $rowUID = suFetch($rsUID);

    $sql2 = "UPDATE sulata_order_details SET orderdet__Order_UID = '" . suStrip($_POST['order__UID']) . "' WHERE orderdet__Order = '" . $rowUID['order__ID'] . "'";
    suQuery($sql2);

//    $sql = "SELECT order__ID,order__Number,DATE_FORMAT(order__Date,'%d-%b-%y %h:%i %p') AS orderDate,order__Customer_Name,order__Mobile_Number,order__Total_Amount,order__Discount,order__Discount_Type,order__Cash_Recieved,order__Notes,order__Promo_Code FROM sulata_orders WHERE order__UID='" . suStrip($_POST['order__UID']) . "' AND order__Session='" . session_id() . "' ";
//    $rs = suQuery($sql);
//    $row = suFetch($rs);
//
//    /* POST INSERT PLACE */
//    $print_invoice = '<html>
//    <head>
//        <title>Truck Cafe POS</title>
//        <meta charset="UTF-8">
//
//    </head>
//    <style>
//        body{
//            margin:0px;
//            font-family: Courier,Tahoma,Verdana;
//            font-size: 12px;
//            text-align:left;
//        }
//        html{
//        margin:0px;
//        }
//        @media all {
//	.page-break	{ display: none; }
//}
//
//@media print {
//	.page-break	{  page-break-before: always; }
//}
//    </style>
//    <body>
//    <div style="width:300px;">
//<center>
//<img src="' . ADMIN_URL . 'img/logo.png"/>
//
//</center>
//<p>
//<b>Order No.</b>: ' . $row['order__Number'] . '<br>
//Customer: ' . $row['order__Customer_Name'] . '<br>';
//    if($row['order__Mobile_Number']!=""){
//         $print_invoice.='Mobile: '.$row['order__Mobile_Number'].'<br>';
//    }
//    $print_invoice.='
//Date: ' . $row['orderDate'] . '<br>
//</p>
//<p style="text-align:left">
//
//
//
//
//        ';
//    $sql_invoice_details = "SELECT SUM(orderdet__Quantity) AS orderdet__Quantity,orderdet__Name,orderdet__Code,orderdet__Price FROM sulata_order_details  WHERE orderdet__Order = '" . $row['order__ID'] . "' GROUP BY orderdet__Product";
//    $rs_invoice_details = suQuery($sql_invoice_details);
//    while ($row_invoice_deatils = suFetch($rs_invoice_details)) {
//        $print_invoice.='
//            ' . $cnt = ($cnt + 1) . ') ' . $row_invoice_deatils['orderdet__Quantity'] . ' x ' . $row_invoice_deatils['orderdet__Name'] . ', @' . number_format($row_invoice_deatils['orderdet__Price'], 2) . ' = ' . number_format($row_invoice_deatils['orderdet__Quantity'] * $row_invoice_deatils['orderdet__Price'], 2) . '<br><br><br>
//
//
//
//';
//    }
//    $print_invoice.='
//</p>
//<p style="text-align:left">
//Total: ' . number_format($row['order__Total_Amount'], 2) . '<br>
//';
//    $balance = $row['order__Cash_Recieved'] - $row['order__Total_Amount'];
//
//    if ($row['order__Discount'] > 0) {
//        if($row['order__Promo_Code']!=""){
//             $print_invoice.='
//            Promo Code: ' . number_format($row['order__Promo_Code'], 2) . '<br>';
//        }
//        $print_invoice.='
//          
//Discount: ' . number_format($row['order__Discount'], 2) . '<br>
//Net: ' . number_format($row['order__Total_Amount'] - $row['order__Discount'], 2) . '<br>
//';
//        $balance = $row['order__Cash_Recieved'] - $row['order__Total_Amount'] - $row['order__Discount'];
//    }
//    
//    if ($row['order__Notes'] != "") {
//        $print_invoice.='
//Instructions: <br>
//' . nl2br($row['order__Notes']) . '
//';
//    }
//    $print_invoice .='
//        Cash Received: '.  number_format($row['order__Cash_Recieved'],2).'<br>
//            Balance: '.number_format($balance,2).'
//</p>
//<p  style="text-align:left">
//Prices in ' . $getSettings['site_currency'] . '<br>
//Invoice generated by: ' . $_SESSION[SESSION_PREFIX . 'user__Name'] . '<br>
//</p>
//<p style="text-align:center">
//Thank you for your visit.
//<br>
//' . $getSettings['site_url'] . '<br>
//' . $getSettings['site_email'] . '
//</p>
//</div>
//';
//
//
//
//
//
//
//    $print_invoice.='
//
//    </body>
//</html>
//
//
//';
    //echo $print_invoice_kitchen;
    $outputFileName = $row['order__Number'] . '.pdf';



    suPrintJS("parent.window.location.href='" . ADMIN_URL . "pos.php/print-invoice/" . suStrip($_POST['order__UID']) . "/" . session_id() . "/'");
}


//reload
if ($do == "reload") {
//Check referrer
    suCheckRef();
    $id = suSegment(2);
    //Make cart
    $sql = "SELECT orderdet__ID,orderdet__Name,orderdet__Quantity, (orderdet__Price*orderdet__Quantity) AS orderdet__Amount FROM sulata_orders,sulata_order_details WHERE orderdet__Order=order__ID AND order__dbState='Live' AND order__UID='$id' AND orderdet__dbState='Live'";
    $result = suQuery($sql);
    while ($row = suFetch($result)) {
        $cnt = $cnt + 1;
        $total = $total + $row['orderdet__Amount'];
        $tableContent .= "<tr>"
                . "<td width=\"10%\">" . $cnt . ". </td>"
                . "<td width=\"10%\"><a href=\"" . ADMIN_URL . "pos-remote.php/delete/" . $row['orderdet__ID'] . "/\" target=\"remote\"><i class=\"fa fa-trash color-Crimson\"></i></a></td>"
                . "<td width=\"20%\">"
                . " <form name=\"suForm_" . $row["orderdet__ID"] . "\" id=\"suForm_" . $row["orderdet__ID"] . "\" method=\"post\" target=\"remote\" action=\"" . ADMIN_URL . "pos-remote.php/update/\">"
                . "<input style=\"width:30px;\" type=\"hidden\" name=\"detailID\" value=\"" . $row['orderdet__ID'] . "\" />"
                . "<input style=\"width:30px;\" type=\"number\" name=\"changeQuantity\" value=\"" . $row['orderdet__Quantity'] . "\" onkeyup=\"document.suForm_" . $row['orderdet__ID'] . ".submit();\" onchange=\"document.suForm_" . $row['orderdet__ID'] . ".submit();\" />"
                . "</form>"
                . "</td>"
                . "<td width=\"10%\"> x</td>"
                . "<td  width=\"50%\">" . suUnstrip($row['orderdet__Name']) . "</td></tr>";
    }suFree($result);
    $tableContent .="<tr><td colspan=\"5\" class=\"right\">Total: " . $getSettings['site_currency'] . ' ' . number_format($total, 2) . " &nbsp;"
            . "<input type=\"hidden\" name=\"totalAmount\" id=\"totalAmount\" value=\"" . $total . "\"/></td></tr>";
    suPrintJs("parent.$('#tableContent').html('" . $tableContent . "');parent.$('#spanProductId" . $productId . "').html('0');");
    suPrintJs("parent.$('#net_total').val('" . $total . "');");
    suPrintJs("parent.$('#total_balance').val('" . $total . "');");
}

if ($do == "print-kitchen") {

    $sql = "SELECT order__ID,order__Number,DATE_FORMAT(order__Date,'%d-%b-%y %h:%i %p') AS orderDate,order__Customer_Name,order__Total_Amount,order__Discount,order__Discount_Type,order__Cash_Recieved,order__Notes FROM sulata_orders WHERE order__UID='" . suSegment(2) . "' AND order__Session='" . suSegment(3) . "' ";
    $rs = suQuery($sql);
    $row = suFetch($rs);

    $print_invoice_kitchen = '<html>
<head>
    <title>Truck Cafe POS</title>
    <meta charset="UTF-8">

</head>
<style>
    body{
        margin:0px;
        font-family: Courier,Tahoma,Verdana;
        font-size: 12px;
        text-align:left;
    }
    html{
    margin:0px;
    }
    @media all {
.page-break	{ display: none; }
}

@media print {
.page-break	{  page-break-before: always; }
}
</style>
<body>
<div style="width:300px;">
<h1 style="text-align:left">' . $getSettings['site_tagline'] . '</h1>
<p>
<b>Order No.</b>: ' . $row['order__Number'] . '<br>
Customer: ' . $row['order__Customer_Name'] . '<br>
Date: ' . $row['orderDate'] . '<br>
</p>
<p style="text-align:left">




    ';
    $sql_invoice_details = "SELECT SUM(orderdet__Quantity) AS orderdet__Quantity,orderdet__Name,orderdet__Code,orderdet__Price FROM sulata_order_details  WHERE orderdet__Order = '" . $row['order__ID'] . "' GROUP BY orderdet__Product";
    $rs_invoice_details = suQuery($sql_invoice_details);
    while ($row_invoice_deatils = suFetch($rs_invoice_details)) {
        $print_invoice_kitchen.='
        ' . $cnt2 = ($cnt2 + 1) . ') ' . $row_invoice_deatils['orderdet__Quantity'] . ' x ' . $row_invoice_deatils['orderdet__Name'] . '<br><br>



';
    }
    if ($row['order__Notes'] != "") {
        $print_invoice_kitchen.='
Instructions: <br>
' . nl2br($row['order__Notes']) . '
';
    }
    $print_invoice_kitchen.='
</p>

<p  style="text-align:left">

Invoice generated by: ' . $_SESSION[SESSION_PREFIX . 'user__Name'] . '<br>
</p></div>
';






    $print_invoice_kitchen.='

</body>
</html>
<script>
window.print();
</script>

';

    echo $print_invoice_kitchen;



    suPrintJs("
        parent.window.location.href='" . ADMIN_URL . "pos.php/';
    ");
}

if ($do == 'customer-copy') {
    $sql = "SELECT order__ID,order__Number,DATE_FORMAT(order__Date,'%d-%b-%y %h:%i %p') AS orderDate,order__Customer_Name,order__Mobile_Number,order__Total_Amount,order__Discount,order__Discount_Type,order__Cash_Recieved,order__Notes,order__Promo_Code FROM sulata_orders WHERE order__ID='" . suSegment(2) . "' ";

    $rs = suQuery($sql);
    $row = suFetch($rs);

    /* POST INSERT PLACE */
    $print_invoice = '<html>
    <head>
        <title>Truck Cafe POS</title>
        <meta charset="UTF-8">

    </head>
    <style>
        body{
            margin:0px;
            font-family: Courier,Tahoma,Verdana;
            font-size: 12px;
            text-align:left;
        }
        html{
        margin:0px;
        }
        @media all {
	.page-break	{ display: none; }
}

@media print {
	.page-break	{  page-break-before: always; }
}
    </style>
    <body>
    <div style="width:300px;">
<center>
<img src="' . ADMIN_URL . 'img/logo.png"/>

</center>
<p>
<b>Order No.</b>: ' . $row['order__Number'] . '<br>
Customer: ' . $row['order__Customer_Name'] . '<br>';
    if ($row['order__Mobile_Number'] != "") {
        $print_invoice.='Mobile: ' . $row['order__Mobile_Number'] . '<br>';
    }
    $print_invoice .='Date: ' . $row['orderDate'] . '<br>
</p>
<p style="text-align:left">




        ';
    $sql_invoice_details = "SELECT SUM(orderdet__Quantity) AS orderdet__Quantity,orderdet__Name,orderdet__Code,orderdet__Price FROM sulata_order_details  WHERE orderdet__Order = '" . $row['order__ID'] . "' GROUP BY orderdet__Product";
    $rs_invoice_details = suQuery($sql_invoice_details);
    while ($row_invoice_deatils = suFetch($rs_invoice_details)) {
        $print_invoice.='
            ' . $cnt = ($cnt + 1) . ') ' . $row_invoice_deatils['orderdet__Quantity'] . ' x ' . $row_invoice_deatils['orderdet__Name'] . ', @' . number_format($row_invoice_deatils['orderdet__Price'], 2) . ' = ' . number_format($row_invoice_deatils['orderdet__Quantity'] * $row_invoice_deatils['orderdet__Price'], 2) . '<br><br><br>



';
    }
    $print_invoice.='
</p>
<p style="text-align:left">
Total: ' . number_format($row['order__Total_Amount'], 2) . '<br>
';
    $balance = $row['order__Cash_Recieved'] - $row['order__Total_Amount'];

    if ($row['order__Discount'] > 0) {
        if ($row['order__Promo_Code'] != "") {
            $print_invoice.='
            Promo Code: ' . number_format($row['order__Promo_Code'], 2) . '<br>';
        }
        $print_invoice.='
          
Discount: ' . number_format($row['order__Discount'], 2) . '<br>
Net: ' . number_format($row['order__Total_Amount'] - $row['order__Discount'], 2) . '<br>
';
        $balance = $row['order__Cash_Recieved'] - $row['order__Total_Amount'] - $row['order__Discount'];
    }

    if ($row['order__Notes'] != "") {
        $print_invoice.='
Instructions: <br>
' . nl2br($row['order__Notes']) . '
';
    }
    $print_invoice .='
        Cash Received: ' . number_format($row['order__Cash_Recieved'], 2) . '<br>
            Balance: ' . number_format($balance, 2) . '
</p>
<p  style="text-align:left">
Prices in ' . $getSettings['site_currency'] . '<br>
Invoice generated by: ' . $_SESSION[SESSION_PREFIX . 'user__Name'] . '<br>
</p>
<p style="text-align:center">
Thank you for your visit.
<br>
' . $getSettings['site_url'] . '<br>
' . $getSettings['site_email'] . '
</p>
</div>
';







    $print_invoice.='

    </body>
</html>
<script>
window.print();
</script>

';
    echo $print_invoice;
}
if ($do == "kitchen-copy") {
    $sql = "SELECT order__ID,order__Number,DATE_FORMAT(order__Date,'%d-%b-%y %h:%i %p') AS orderDate,order__Customer_Name,order__Total_Amount,order__Discount,order__Discount_Type,order__Cash_Recieved,order__Notes FROM sulata_orders WHERE order__ID='" . suSegment(2) . "'";
    $rs = suQuery($sql);
    $row = suFetch($rs);

    $print_invoice_kitchen = '<html>
<head>
    <title>Truck Cafe POS</title>
    <meta charset="UTF-8">

</head>
<style>
    body{
        margin:0px;
        font-family: Courier,Tahoma,Verdana;
        font-size: 12px;
        text-align:left;
    }
    html{
    margin:0px;
    }
    @media all {
.page-break	{ display: none; }
}

@media print {
.page-break	{  page-break-before: always; }
}
</style>
<body>
<div style="width:300px;">
<h1 style="text-align:left">' . $getSettings['site_tagline'] . '</h1>
<p>
<b>Order No.</b>: ' . $row['order__Number'] . '<br>
Customer: ' . $row['order__Customer_Name'] . '<br>
Date: ' . $row['orderDate'] . '<br>
</p>
<p style="text-align:left">




    ';
    $sql_invoice_details = "SELECT SUM(orderdet__Quantity) AS orderdet__Quantity,orderdet__Name,orderdet__Code,orderdet__Price FROM sulata_order_details  WHERE orderdet__Order = '" . $row['order__ID'] . "' GROUP BY orderdet__Product";
    $rs_invoice_details = suQuery($sql_invoice_details);
    while ($row_invoice_deatils = suFetch($rs_invoice_details)) {
        $print_invoice_kitchen.='
        ' . $cnt2 = ($cnt2 + 1) . ') ' . $row_invoice_deatils['orderdet__Quantity'] . ' x ' . $row_invoice_deatils['orderdet__Name'] . '<br><br>



';
    }
    if ($row['order__Notes'] != "") {
        $print_invoice_kitchen.='
Instructions: <br>
' . nl2br($row['order__Notes']) . '
';
    }
    $print_invoice_kitchen.='
</p>

<p  style="text-align:left">

Invoice generated by: ' . $_SESSION[SESSION_PREFIX . 'user__Name'] . '<br>
</p></div>
';






    $print_invoice_kitchen.='

</body>
</html>
<script>
window.print();
</script>

';

    echo $print_invoice_kitchen;
}
?>
