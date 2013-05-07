<?php
session_start();
header("Content-Type: text/html; charset=iso-8859-1");
$connection = mysql_connect('localhost','root','');
mysql_select_db('sitemeut_espace-i2',$connection);

$aide = $_POST['uid'];
$aidant = $_POST['aidant'];
$time = time();
$id_conversation = 0;

mysql_query("INSERT INTO conversation(id,aidant,aide,timestamp) VALUES('', '$aidant', '$aide', '$time')");

$requete_id = mysql_query("SELECT `id` FROM conversation WHERE aidant='$aidant' AND aide ='$aide'  and timestamp = '$time'");
while($val = mysql_fetch_array($requete_id))
{
	$id_conversation = $val['id'];
	$_SESSION['Conv_id'] = $val['id'];
}


$message = 'Bienvenue dans le chat:';

mysql_query("INSERT INTO minichat(id_conv,pseudo,message,timestamp) VALUES('$id_conversation','$aidant', '$message', '$time')");

mysql_close();


echo $id_conversation;