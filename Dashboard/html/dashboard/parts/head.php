<?php
#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);
session_start(); //gets session id from cookies, or prepa

if (session_id() == '' || !isset($_SESSION['login'])) { //if sid exists and login for sid exists
  
header("Location: /dashboard/login.php");

} else {

  #echo "Hi, " . $_SESSION['login'];

?>


<?php 

$namespaceArray = [
    
    "user" => 'ORG',
	"amsys" => 'ORG',
];

$GLOBALS["namespaceCompany"] = $namespaceArray[$_SESSION['login']];
#print_r($namespaceCompany);
#echo $namespaceCompany;


}

$server = 'http://'.$_SERVER['SERVER_NAME'];
?>
<!--
=========================================================
Material Dashboard - v2.1.2
=========================================================

Product Page: https://www.creative-tim.com/product/material-dashboard
Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by Creative Tim

=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
     Attack Surface Dashboard by AMSYS
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="./assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="./assets/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" href="sortable-theme-light.css" />
	<script src="sortable.min.js"></script>
	
	
	
	
	
	
</head>

<body class="" style="background-color: #000; color: #b32e2e;">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="./assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->