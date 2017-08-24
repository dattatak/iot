<?php
session_start();
mysql_connect("","","");
mysql_select_db("iot");
/* DB
-user
	username
	password
	sessionid
-iots
	id
	username
	status
*/
class iot_control{//暂时采用用户控制方式，api控制会引入一个secure ID。弃坑ing。
	function user_open($id){
		$username=$_SESSION["username"];
		$sessionid=$_SESSION["sessionid"];
		$query=mysql_query("SELECT * FROM `user` WHERE `username`='$username'");
		if (!$query){
			return "denied";
		}
		$row=mysql_fetch_array($query);
		if ($row["sessionid"]==$sessionid){
			$query=mysql_query("SELECT * FROM `iots` WHERE `id`='$id'");
			$row=mysql_fetch_array($query);
			if ($row["username"]==$username){
				$query=mysql_query("UPDATE `iots` SET `status`='open' WHERE `id`='$id'");
				return "open_ok";
			}else{return "denied";}
		}else{return "denied";}
	}
	function user_close($id){
		$username=$_SESSION["username"];
		$sessionid=$_SESSION["sessionid"];
		$query=mysql_query("SELECT * FROM `user` WHERE `username`='$username'");
		if (!$query){
			return "denied";
		}
		$row=mysql_fetch_array($query);
		if ($row["sessionid"]==$sessionid){
			$query=mysql_query("SELECT * FROM `iots` WHERE `id`='$id'");
			$row=mysql_fetch_array($query);
			if ($row["username"]==$username){
				$query=mysql_query("UPDATE `iots` SET `status`='close' WHERE `id`='$id'");
				return "close_ok";
			}else{return "denied";}
		}else{return "denied";}
	}
	function status($id){
		$query=mysql_query("SELECT * FROM `iots` WHERE `id`='$id'");
		if (!$query){
			return "not_exist";
		}else{
			$row=mysql_fetch_array($query);
			return "status:".$row["status"];
		}
	}
}
class user{
	function login($username,$password){
		$password_md5=md5($password);
		$query=mysql_query("SELECT * FROM `user` WHERE `username`='$username'");
		if (!$query){
			return "user_not_exist";
		}
		$row=mysql_fetch_array($query);
		if ($row["password"]==$password_md5){
			$_SESSION["username"]=$username;
			$sessionid=rand(10000,99999).rand(10000,99999).rand(10000,99999);//坑，重复暂时不管.
			mysql_query("UPDATE `user` SET sessionid='$sessionid' WHERE `username`='$username'");
			$_SESSION["sessionid"]=$sesionid;
			return "login_success";
		}else{return "password_error";}
	}
	function register($username,$password){
		$password_md5=$md5($password);
		$query=mysql_query("SELECT * FROM `user` WHERE `username`='$username'");
		if (!$query){
			return "user_exist";
		}
		$default_sessionid=rand(10000,99999).rand(10000,99999).rand(10000,99999);
		$query=mysql_query("INSERT INTO user(username,password,sessionid) VALUES('$username','$password_md5','$default_sessionid')");
		if ($query){
			return "register_successful";
		}
	}
	function verify(){
		$username=$_SESSION["username"];
		$sessionid=$_SESSION["sessionid"];
		$query=mysql_query("SELECT * FROM `user` WHERE `username`='$username'");
		if (!$query){
			return "denied";
		}
		$row=mysql_fetch_array($query);
		if ($row["sessionid"]==$sessionid){
			return "ok";
		}else{return "denied";}
	}
	function get_iots_info(){
		$username=$_SESSION["username"];
		$query=mysql_query("SELECT * FROM `iots` WHERE `username`='$username'");
		$rows=mysql_fetch_array($query);
		return $rows;
	}
	function add_iot($iot_name){
		$username=$_SESSION["username"];
		$query=mysql_query("SELECT * FROM `iots` WHERE `id`='$iot_name'");
		if ($query){
			return "exist";
		}
		$query=mysql_query("INSERT INTO iots(id,username,status) VALUES('$iot_name','$username','close')");
		if ($query){
			return "success";
		}else{
			return "error";
		}
	}
	function edit_iot($previous_iot_name,$new_iot_name){
	}
	function del_iot($iot_name){
	}
	function change_password(){
	}
	function get_api(){
	}
}
class admin{
	function login($username,$password){
	}
}
?>