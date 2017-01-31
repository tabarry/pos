<?php

/*
 * SULATA FRAMEWORK
 * This file contains the database connection.
 */

$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if(suConnectErrorNo()>0){
  if(suConnectErrorNo()==1045){
    $cn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD2, DB_NAME);
  }else{
    suExit(suConnectError());
  }
}

mysqli_query($cn, "SET NAMES utf8");
mysqli_select_db($cn, DB_NAME) or suDie();
