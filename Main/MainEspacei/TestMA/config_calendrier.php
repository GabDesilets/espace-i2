<?php
/**
 * Created for espace-i2l.
 * User: Gabriel
 * Date: 23/03/13
 * Time: 4:48 PM
 */
include_once "config_calendrier_model.php";

$config = $_POST;
saveCalConfig($config);
/**
 * @param $config
 */
function saveCalConfig($config){
    $calConfig = hasConfig();

    if($calConfig==0){
        addCalConfig($config);
    }
    else{
        updateCalConfig($config);
    }
}