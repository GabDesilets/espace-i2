<?php
function get_user_status()
{
	mysql_connect("localhost", "root", "");
	mysql_select_db("sitemeut_espace-i2");

	//Requ�te
	$query_status = "SELECT * FROM etudiant, user_status WHERE user_status.uid = etudiant.id";
	$result_status = mysql_query($query_status);

	//Boucle pour afficher tout les users
	while($value = mysql_fetch_array($result_status))
	{
		echo '<p><a class="nom_aidants" href="#" title="Entrer en communication avec ' . $value['prenom'] . ' ' . $value['nom'] . '"><strong>'.$value['prenom'].'</a>  : </strong>'. $value['status'] .'</p>';
	}
}

