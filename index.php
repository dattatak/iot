<?php
require("functions.php");
$user = new user();
if ($user -> verify()=="denied"){
	include "index.php?action=login";
}else{
	include "index.php?action=main";
}
$action=$_GET["action"];
switch $action
{
	case "login":
		include "templates/login.htm";
		break;
	case "main":
		include "templates/main.htm";
		break;
	case "register":
		include "templates/register.htm";
		break;
	case "add_iot":
		include "templates/add_iot.htm";
		break;
	case "edit_iot":
		include "templates/edit_iot.htm";
		break;
	case "del_iot":
		include "templates/del_iot.htm";
		break;
	case "control_iot":
		include "templates/control_iot.htm";
		break;
}