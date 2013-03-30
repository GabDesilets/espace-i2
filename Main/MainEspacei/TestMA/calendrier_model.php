<?php
/**
 * Created by Gabriel Désilets.
 * User: Gabriel Désilets
 * Date: 12-12-31
 * Time: 16:33
 * Purpose :
 */
$connection = mysql_connect('localhost','root','toor');
mysql_select_db('sitemeut_espace-i2',$connection);

function insert_dispo($data)
{
    $query = "insert into horaire_etu (etu_id,heuredebut,heurefin)
    VALUES(".$data['etu_id'].","."'".$data['heuredebut']."'".",'".$data['heurefin']."'".")";

    $result =  mysql_query($query);
    if(!$result)
    {
        echo"Query failed: " . mysql_error() . " Actual query: " . $query;
        die();
    }
    else
    {
        return mysql_insert_id();
    }

}

function insert_event_reminder($data)
{
    $query =  $query = "insert into reminder_events (reminder_name,reminder_desc,reminder_date,reminder_author,reminder_event_id)
    VALUES('".mysql_real_escape_string($data['reminder_name'])."','".mysql_real_escape_string($data['reminder_desc'])."',".
        "STR_TO_DATE('".$data['reminder_date']."','%Y %m %d %H:%i')".",".$data['reminder_author'].",".$data['reminder_event_id'].")";

    $result =  mysql_query($query);
    if(!$result)
    {
        echo"Query failed: " . mysql_error() . " Actual query: " . $query;
        die();
    }
    else
    {
        return $result;
    }
}

function get_dispo($where = null)
{
    $query = "select * from horaire_etu ";
    if(isset($where))
    {
        $query .= "where ".$where;
    }

    $result =  mysql_query($query);
    if(!$result)
    {
        echo"Query failed: " . mysql_error() . " Actual query: " . $query;
        die();
    }
    else
    {
        return $result;
    }
}

function delete_dispo($event_id)
{
    $query = "DELETE FROM horaire_etu WHERE id=".$event_id;
    $result =  mysql_query($query);
    if(!$result)
    {
        echo"Query failed: " . mysql_error() . " Actual query: " . $query;
        die();
    }
    else
    {
        return $result;
    }
}

function delete_reminder($event_id)
{
    $query = "DELETE FROM reminder_events WHERE reminder_event_id=".$event_id;
    $result =  mysql_query($query);
    if(!$result)
    {
        echo"Query failed: " . mysql_error() . " Actual query: " . $query;
        die();
    }
    else
    {
        return $result;
    }
}

function update_dispo($data)
{
    $query ='UPDATE horaire_etu set  heuredebut="'.$data['start'].'",heurefin="'.$data['end'].'" WHERE id="'.$data['id'].'"';

    $result =  mysql_query($query);
    if(!$result)
    {
        echo"Query failed: " . mysql_error() . " Actual query: " . $query;
        die();
    }
    else
    {
        return $result;
    }
}

function Accept_conv_insert($aidant, $aide)
{
    $query =  $query = ("INSERT INTO Conversation(aidant,aide,timestamp)
    VALUES('$aidant', '$aide', '".time()."')");

    $result =  mysql_query($query);
    if(!$result)
    {
        echo"Query failed: " . mysql_error() . " Actual query: " . $query;
        die();
    }
    else
    {
        return $result;
    }
}
