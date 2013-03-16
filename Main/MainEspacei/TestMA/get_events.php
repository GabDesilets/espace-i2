<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Gabriel
 * Date: 02/03/13
 * Time: 6:33 PM
 */
$connection = mysql_connect('localhost','root','toor');
mysql_select_db('sitemeut_espace-i2',$connection);


$query = "select he.*, CONCAT_WS(' ',e.prenom,e.nom) as nom
          from horaire_etu he
          JOIN etudiant e on e.id = he.etu_id";

$result =  mysql_query($query);

$jsonArray = array();

while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{

    $start = $row['heuredebut'];
    $end = $row['heurefin'];

    // Stores each database record to an array
    $buildjson = array(
        'id' => intval($row['id']),
        'title' =>$row['nom'],
        'start' => "$start",
        'end'=>"$end",
        'allDay' => false
    );

    // Adds each array into the container array
    array_push($jsonArray, $buildjson);
}
// Output the json formatted data so that the jQuery call can read it
echo json_encode($jsonArray);

