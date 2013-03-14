<?php
session_start();
$current_status = $_POST['status'];

mysql_connect("localhost", "root", "");
mysql_select_db("sitemeut_espace-i2");

$uid = $_SESSION['uid'];

//Requ�te
$query = "SELECT * FROM user_status WHERE  uid = ".$uid;

$result = mysql_query($query);

if( $current_status == 'En ligne' || utf8_decode($current_status == 'Occupe') || $current_status == 'Absent' || utf8_decode($current_status == 'Deconnexion'))
{
	if(mysql_num_rows($result) > 0)
	{
		if($current_status == 'Deconnexion') {
			mysql_query("DELETE FROM user_status WHERE uid = " .$uid) or die(mysql_error());
		}
		else{
			mysql_query("UPDATE user_status SET status = '".$current_status."' WHERE uid = ".$uid) or die(mysql_error());	
		}		
	}
	else
	{
		mysql_query("insert into `user_status` VALUES(".$uid.", '".$current_status."')") or die(mysql_error());
	}
}

echo $current_status;