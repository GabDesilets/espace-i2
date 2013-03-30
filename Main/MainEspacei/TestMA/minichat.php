<?php
session_start();
header("Content-Type: text/html; charset=iso-8859-1");
$connection = mysql_connect('localhost','root','toor');
mysql_select_db('sitemeut_espace-i2',$connection);

$uid = $_SESSION['uid'];

$requete_id = mysql_query("SELECT `conv_id` FROM etudiant WHERE id='$uid'");
while($val = mysql_fetch_array($requete_id))
{
	$ConvID = $val['conv_id'];
}

$requete_prenom = mysql_query("SELECT `prenom` FROM etudiant WHERE id = '$uid'");
while($val = mysql_fetch_array($requete_prenom))
{
	$pseudo = $val['prenom'];
}

if (isset($_POST['message'])) 
{
    if (!empty($_POST['message'])) 
    {
		$message = mysql_real_escape_string(utf8_decode(trim($_POST['message'])));
		//$pseudo = mysql_real_escape_string(utf8_decode($_POST['pseudo']));  Saisie champ pseudo
		mysql_query("INSERT INTO minichat(id_conv,pseudo,message,timestamp) VALUES('$ConvID','$pseudo', '$message', '".time()."')");
	}
}

$reponse = mysql_query("SELECT * FROM minichat WHERE id_conv = '$ConvID' ORDER BY id ASC");

while($val = mysql_fetch_array($reponse))
{
	echo '<strong>'.htmlentities(stripslashes($val['pseudo'])).' à '.date('H\:i\:s',$val['timestamp']).' : </strong>'. htmlentities(stripslashes($val['message'])) .'<br/>';
}
mysql_close();
