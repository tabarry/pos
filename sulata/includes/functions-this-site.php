<?php

/*
 * SULATA FRAMEWORK
 * This file contains the functions related to this particular web site.
 */

if (!function_exists('suMakeOrderNumber')) {

    function suMakeOrderNumber() {
        global $getSettings;
        $sql = "SELECT order_count FROM sulata_order_counter WHERE order_count_date='".date('Y-m-d')."'";
        $result = suQuery($sql);
        if (suNumRows($result) == 0) {
           echo $sql2 = "INSERT INTO sulata_order_counter SET order_count='" . $getSettings['order_counter_start'] . "' , order_count_date = '".  date('Y-m-d')."'";
         
            $result2 = suQuery($sql2);
            $row2 = suFetch($result2);
            $orderNumber = $getSettings['order_counter_start'];
        } else {
            $row = suFetch($result);
            $orderCount = $row['order_count'];
         
            if ($orderCount == $getSettings['order_counter_reset']) {
                $orderNumber = $getSettings['order_counter_start'];
                $sql2 = "UPDATE sulata_order_counter SET order_count='" . $orderNumber . "'  AND order_count_date = '".  date('Y-m-d')."'";
                suQuery($sql2);
            } else {
                $orderNumber = ($orderCount + 1);
             
                $sql2 = "UPDATE sulata_order_counter SET order_count='" . $orderNumber . "' , order_count_date = '".  date('Y-m-d')."'";
               suQuery($sql2);
            }
        }
        return $orderNumber;
    }

}
if (!function_exists('suGetArrayIndex')) {

    function suGetArrayIndex($str, $arr) {
        //echo $str;
        for ($i = 0; $i <= sizeof($arr); $i++) {
            
            if ($arr[$i] == $str) {
                return $i;
                break;
            }
        }
    }

}