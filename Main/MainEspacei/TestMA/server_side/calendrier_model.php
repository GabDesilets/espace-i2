<?php
/**
 * Created by Gabriel Désilets.
 * User: Gabriel Désilets
 * Date: 12-12-31
 * Time: 16:33
 * Purpose :
 */
$connection = mysql_connect('localhost','sitemeut_admin','4C51d21f9C');
mysql_select_db('sitemeut_espace-i2',$connection);

function insert_dispo($data)
{

    $query = "insert into events (titre,employe,disponibilite,detail,datedebut,datefin,accepte,allday)VALUES('".
        mysql_real_escape_string($data['titre'])."',".$data['employe'].",".$data['disponibilite'].",'".mysql_real_escape_string($data['detail'])."',".
        "STR_TO_DATE('".$data['datedebut']."','%Y %m %d %H:%i')".
        ",STR_TO_DATE('".$data['datefin']."', '%Y %m %d %H:%i')".",".$data['accepte'].",".$data['allday'].")";

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
    $query = "select * from events ";
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
    $query = "DELETE FROM events WHERE id=".$event_id;
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
    $query = "UPDATE events SET  titre='".mysql_real_escape_string($data['title'])."', detail='".mysql_real_escape_string($data['detail']).
        "', datedebut="."STR_TO_DATE('".$data['start']."','%Y %m %d %H:%i')".
        ", datefin="."STR_TO_DATE('".$data['end']."', '%Y %m %d %H:%i')".
        ", disponibilite =1, allday=".$data['allDay']." where id=".$data['id'];

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

function update_event_reminder($data)
{

    $query = "update reminder_events set reminder_name= '".mysql_real_escape_string($data['reminder_name'])."', reminder_desc= '".mysql_real_escape_string($data['reminder_desc']).
        "',reminder_date="."STR_TO_DATE('".$data['reminder_date']."','%Y %m %d %H:%i')"." where reminder_event_id = ".$data['reminder_event_id']."";

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


function get_not_accepted_dispo($id)
{
    $query = "select * from events
    join employe on employe.id = events.employe
     WHERE events.employe =".$id."
     AND events.accepte IS FALSE";
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

function get_event_state_from_emp($emp_id,$event_id)
{
    $query = "SELECT * FROM  events_accepted WHERE event_id = ".$event_id." and emp_id = ".$emp_id;

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


function insert_emp_answ_events($answer)
{
    $query = "insert into events_accepted values(".$answer['event_id'].",".$answer['emp_id'].",".$answer['is_accepted'].",".$answer['is_denied'].")";

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


function update_event_from_emp($new_event)
{
    $query = "UPDATE events_accepted set is_accepted = ".$new_event['is_accepted'].", is_denied=".$new_event['is_denied'].
        " WHERE event_id = ".$new_event['event_id']." and emp_id=".$new_event['emp_id'];
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

function get_reminder_events($trigger_date,$today)
{

    $query = "SELECT * FROM reminder_events WHERE reminder_date BETWEEN '".$today."' and '".$trigger_date."' ORDER BY reminder_date ASC" ;

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