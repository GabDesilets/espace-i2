<?php
if(isset($_POST['helper_id'])) {
    echo get_status_aidant($_POST['helper_id']);
}

if(isset($_POST['status']) && isset($_POST['helper_id'])) {
    echo set_status_occupe($_POST['status'], $_POST['helper_id']);
}

function get_user_status()
{
    $connection = mysql_connect('localhost','root','');
    mysql_select_db('sitemeut_espace-i2',$connection);
	//Requ�te
	$query_status = "SELECT * FROM etudiant, user_status WHERE user_status.uid = etudiant.id";
	$result_status = mysql_query($query_status);
    $count = 0;
    $count_aidant = 0;

	//Boucle pour afficher tout les users
	while($value = mysql_fetch_array($result_status))
	{
        if( $value['status'] == 'Aider' ) {
            $count++;
        }
        else {
            echo '<br><p><a class="nom_aidants" href="#" onclick="javascript:get_infos('.$value['id'].');" title="Entrer en communication avec ' . $value['prenom'] . ' ' . $value['nom'] . '"><strong>'.$value['prenom'].'</a>  : </strong>'. $value['status'] .'</p><br>';
            $count_aidant++;
        }
	}
    if( $count_aidant == 0 ) {
        echo "Il n'y a aucun aidant présentement connecté<br>";
    }
    if( $count > 0 ) {
        if( $count == 1 ) {
            echo '<br><p>Il y a ' . $count . ' utilisateur présentement connecté</p>';
        }
        else {
            echo '<br><p>Il y a ' . $count . ' utilisateurs présentements connectés</p>';
        }
    }
}

function get_status() {

    $connection = mysql_connect('localhost','root','');
    mysql_select_db('sitemeut_espace-i2',$connection);

    $query_status = "SELECT `status` FROM user_status WHERE uid = " . $_SESSION['uid'];
    $result_status = mysql_query($query_status);

    while($donnees = mysql_fetch_array($result_status)) {
        echo $donnees['status'];
    }

}

function get_status_aidant($helper_id) {
    session_start();
    $connection = mysql_connect('localhost','root','');
    mysql_select_db('sitemeut_espace-i2',$connection);

    $query_status = "SELECT `status` FROM user_status WHERE uid = " . $helper_id;
    $result_status = mysql_query($query_status);

    while($donnees = mysql_fetch_array($result_status)) {
       echo $donnees['status'];
    }
}

function set_status_occupe($status, $helper_id) {
    $connection = mysql_connect('localhost','root','');
    mysql_select_db('sitemeut_espace-i2',$connection);

    $query = mysql_query("UPDATE user_status SET status = '".$status."' WHERE uid = ".$helper_id) or die(mysql_error());
    echo 'sucess';
}