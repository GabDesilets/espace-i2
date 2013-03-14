<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Gabriel
 * Date: 02/03/13
 * Time: 6:33 PM
 * To change this template use File | Settings | File Templates.
 */
$connection = mysql_connect('localhost','root','toor');
mysql_select_db('sitemeut_espace-i2',$connection);


$query = "select * from horaire_etu ";

$result =  mysql_query($query);

$jsonArray = array();

while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{

    $start = $row['heuredebut'];
    $end = $row['heurefin'];

    // Stores each database record to an array
    $buildjson = array(
        'id' => intval($row['id']),
        'title' => 'derptest',
        'start' => "$start",
        'end'=>"$end",
        'allDay' => false
    );

    // Adds each array into the container array
    array_push($jsonArray, $buildjson);
}
// Output the json formatted data so that the jQuery call can read it
echo json_encode($jsonArray);

