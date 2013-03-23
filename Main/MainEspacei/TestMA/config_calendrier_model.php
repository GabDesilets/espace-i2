<?php
/**
 * Created for espace-i2l.
 * User: Gabriel
 * Date: 23/03/13
 * Time: 4:49 PM
 */
$connection = mysql_connect('localhost','root','toor');
mysql_select_db('sitemeut_espace-i2',$connection);

/**
 * @return array|resource
 */
function get_cal_config(){

    $query = "SELECT minTime,maxTime,slotMinute from config_calendrier";
    $result =  mysql_query($query);

    return mysql_num_rows($result)>0
        ? $result
        : array();
}

/**
 * @return int
 */
function hasConfig(){

    $query = "SELECT minTime,maxTime,slotMinute from config_calendrier";
    $result =  mysql_query($query);

    return mysql_num_rows($result)>0
        ? 1
        : 0;

}

/**
 * @param array $data
 * @return string
 */
function addCalConfig($data = array()){
    $query = "insert into config_calendrier VALUES ({$data['minTime']},{$data['maxTime']},{$data['slotMinute']})";

    $result =  mysql_query($query);

    return mysql_error();
}

/**
 * @param $data
 * @return string
 */
function updateCalConfig($data){
    $query = "update config_calendrier set minTime=".$data['minTime'].",maxTime=".$data['maxTime'].",slotMinute=".$data['slotMinute']."";

    $result =  mysql_query($query);

    return mysql_error();
}