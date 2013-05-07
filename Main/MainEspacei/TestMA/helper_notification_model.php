<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Gabriel
 * Date: 15/03/13
 * Time: 4:38 PM
 */
$connection = mysql_connect('localhost','root','');
mysql_select_db('sitemeut_espace-i2',$connection);

const IS_ACCEPTED = 'is_accepted';
const IS_REFUSED  = 'is_refused';

function insert_notice($helper_id){
    $query = "insert into notification_to_helper (helper_id) values({$helper_id});";
    $result =  mysql_query($query);
    if(!$result)
    {
        echo"Query failed: " . mysql_error() ;
        die();
    }
}

function get_notice($helper_id){
    $query = "select id from notification_to_helper where helper_id={$helper_id} and is_seen = 0";

    $result =  mysql_query($query);
    if(mysql_num_rows($result)>0){
        return TRUE;
    }
    else{
        return FALSE;
    }
}

function set_notice_status($helper_id,$respond, $conv_id){

    $time = time();
    $query = "";
    $query2 = "";
    switch (TRUE) {
        case $respond==IS_ACCEPTED:
           $query = "update notification_to_helper SET is_accepted = 1,is_refused = 0 , is_seen = 1 where helper_id = {$helper_id}";
            break;
        case $respond==IS_REFUSED:
            $query = "update notification_to_helper SET is_accepted = 0,is_refused = '$conv_id' , is_seen = 1 where helper_id = {$helper_id}";
            $query2 = "INSERT INTO minichat VALUES('$conv_id', '', 'Système', 'Cette personne a refuser la conversation', '$time' )";
            break;
        default:
            //Here we crash on purpose because we shouldn't be in the default case
            $query = "update notification_to_helper SET is_accepted = 0,is_refused = 0 , is_seen = 1 where 1=0";
    }

    if($query2 != "") {
        $result2 = mysql_query($query2);
    }
    $result =  mysql_query($query);
    return $result;
}