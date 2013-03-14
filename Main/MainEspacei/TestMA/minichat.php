<?php
header("Content-Type: text/html; charset=iso-8859-1");
$connection = mysql_connect('localhost','root','toor');
mysql_select_db('sitemeut_espace-i2',$connection);

$_POST['pseudo'] = trim($_POST['pseudo']);
$_POST['message'] = trim($_POST['message']);

if (isset($_POST['pseudo']) && isset($_POST['message'])) 
{
    if (!empty($_POST['pseudo']) && !empty($_POST['message'])) 
    {	
		if( $_POST['pseudo'] == 'Admin' ) {
			$_POST['pseudo'] = 'Marc';
			$message = mysql_real_escape_string(utf8_decode(trim($_POST['message'])));
			$pseudo = mysql_real_escape_string(utf8_decode($_POST['pseudo']));
			mysql_query("INSERT INTO minichat(pseudo,message,timestamp) VALUES('$pseudo', '$message', '".time()."')");
		}
	}
}
$reponse = mysql_query("SELECT * FROM minichat ORDER BY id ASC");
while($val = mysql_fetch_array($reponse))
{
	echo '<strong>'.htmlentities(stripslashes($val['pseudo'])).' � '.date('H\:i\:s',$val['timestamp']).' : </strong>'. htmlentities(stripslashes($val['message'])) .'<br/>';
}
mysql_close();
?>
