<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Gabriel
 * Date: 02/03/13
 * Time: 6:33 PM
 * To change this template use File | Settings | File Templates.
 */

$connection = mysql_connect('localhost','root','');
mysql_select_db('sitemeut_espace-i2',$connection);


$query = "select * from horaire_etu ";

$result =  mysql_query($query);

$jsonArray = array();

//array (size=4)  'id' => string '55' (length=2)  'etu_id' => string '3' (length=1)  'heuredebut' => string 'Sat Mar 02 2013 09:20:00 GMT-0500 (Eastern Standard Tim' (length=55)

while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{

    $start = $row['heuredebut'];
    $end = $row['heurefin'];

    // Stores each database record to an array
    $buildjson = array('id' => $row['id'], 'start' => "$start",'end'=>"$end", 'allday' => false);

    // Adds each array into the container array
    array_push($jsonArray, $buildjson);
}
// Output the json formatted data so that the jQuery call can read it
echo json_encode($jsonArray);