<?php
/* 
	ACS status check page (called from the out of order page)
*/
session_start();
include_once('../config.php');
include_once('../includes/sip2.php');
include_once('../includes/json_encode.php');

$mysip = new sip2;

// Set host name
$mysip->hostname = $sip_hostname;
$mysip->port = $sip_port;

// Identify a patron
$mysip->patron = $_SESSION['patron_barcode'];

if($enable_patron_password == true){
			$mysip->patronpwd = $_SESSION['patron_password']; // password
}

// connect to SIP server
$connect=$mysip->connect();

if ($connect) {
	echo json_encode('online');
}
?>