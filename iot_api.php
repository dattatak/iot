<?php
/*
	control_mode
	1)user_control
	2)api_control
	via a GET value(mode)
*/
require("functions.php");
$user=new user;
$control=new iot_control;
$mode=$_GET["mode"];
$action=$_GET["action"];
if ($mode=="user"){
		$user -> verify();
		if ($user -> verify()=="denied"){
		include "index.php?action=login";
	}else{
		
	}
}