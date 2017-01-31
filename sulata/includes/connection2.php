<?php

/*
 * SULATA FRAMEWORK
 * This file contains the onlin database connection for sync purbose.
 */

$cn = mysqli_connect(DB2_HOST, DB2_USER, DB2_PASSWORD, DB2_NAME);
if(suConnectErrorNo()>0){
  if(suConnectErrorNo()==1045){
    $cn = mysqli_connect(DB2_HOST, DB2_USER, DB2_PASSWORD2, DB2_NAME);
  }else{
    suExit(suConnectError());
  }
}
mysqli_query($cn, "SET NAMES utf8");
mysqli_select_db($cn, DB2_NAME) or suDie();
