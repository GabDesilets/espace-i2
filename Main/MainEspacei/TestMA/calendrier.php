<?php
    include_once "calendrier_model.php";

dispatchCalendar();

function dispatchCalendar()
{

    if(array_key_exists('action',$_POST))
    {
        $action = $_POST['action'];
        switch ($action)
        {
            case "add":
                unset($_POST['action']);
                add($_POST);
            break;

            case "delete":
                delete($_POST['event_id']);
            break;

            case "update":
                 unset($_POST['action']);
                 update($_POST['event']);
             break;

            case "acceptedDispo":
                unset($_POST['action']);
                getNotAcceptedDispo($_POST['empId']);
            break;

            case "acceptEvent":
                unset($_POST['action']);
                if(!$_POST['myEventIds'])
                {
                    echo 0;
                }
                ajax_update_event_state($_POST['myEventIds'],$_POST['isAccepted'],$_POST['eventArrayIds'],$_POST['emp_id']);
            break;
        }
    }
}


function add($calendriers)
{
    $data = Array();

    foreach ($calendriers['myEvents'] as $evenement)
    {
       $isFromEdit = FALSE;

       if(is_numeric($evenement['id']))
       {
           update($evenement);
           $isFromEdit = TRUE;
       }
       else
       {
           if(preg_match('/^fake_id/', $evenement['id']))
           {
               unset($evenement['id']);

               $data['etu_id'] = $evenement['empId'];
               $data['heuredebut'] = $evenement['start'];
               $data['heurefin'] =  $evenement['end'];

               $id = insert_dispo($data);
           }


       }


    }

###########################################################################################################
    $_SESSION['saveSuccess']=true;
}

function show_dispo($userId=NULL,$flForAccept=FALSE)
{
    $code ="";
    $data = get_dispo();
    $num_row = mysql_num_rows($data);
    $ctr=0;
//Sat Feb 23 2013 16:00:00 GMT-0500 (Est)
    while ($row = mysql_fetch_assoc($data)) {
        $code.='{';
        $code.="id:".$row['id'].',';
        $code.="title:'".str_replace("'","\'",$row['etu_id'])."',";
        $code.="detail:'".str_replace("\n","\\n",str_replace("'","\'",$row['etu_id']))."',";
        $code.="start:'".$row['heuredebut']."',";
        $code.="end:'".$row['heurefin']."',";
        $code.="allDay: false,";
        $code.="backgroundColor: '#4AB840',";
        $code.="borderColor: '#008238',";
        $code.="textColor: '#000000'}";
        $ctr++;
        if($ctr != $num_row)
        {
            $code.=',';
        }

    }
    if (!$code)
    {
        $code = Array();
    }

    return $code;
}

function delete($event_id)
{
    session_start();

    if(is_numeric($event_id))
    {
        delete_dispo($event_id);
    }
    else
    {
        echo "error";
    }

}


function update($data)
{
    update_dispo($data);
}

function getNotAcceptedDispo($uid)
{
    $data = get_not_accepted_dispo($uid);

    if(mysql_num_rows($data))
    {
       echo json_encode(mysql_num_rows($data));
    }

    else
    {
        echo json_encode(0);
    }
}
//myEventIds : myIds, action : 'acceptEvent',isAccepted: flAccepted,eventArrayIds:ids,emp_id:<?php echo $_SESSION['uid']
function ajax_update_event_state($dataIds,$isAccepted,$arrayIds,$emp_id)
{
    $answer = Array();

    foreach($arrayIds as $id)
    {
        //check if this emp already accepted this event
        $event = get_event_state_from_emp($emp_id,$id);

        if(mysql_num_rows($event)==0)
        {

            $answer['event_id'] = $id;
            $answer['emp_id'] = $emp_id;

            if($isAccepted==1)
            {
                $answer['is_accepted'] = 1;
                $answer['is_denied'] = 0;
            }
            else
            {
                $answer['is_accepted'] = 0;
                $answer['is_denied'] = 1;
            }
            insert_emp_answ_events($answer);
        }
        else
        {
            update_event_emp_state($event,$isAccepted);
        }

    }


}

function sending_reminders()
{
    $today = date( "Y-m-d H:i:s" );
    $trigger_date =  date("Y-m-d H:i:s",strtotime("+1 day"));


    $result = get_reminder_events($trigger_date,$today);
    $data = Array();

    while ($row = mysql_fetch_assoc($result))
    {
       array_push($data,$row);
    }

    return $data;

}

function add_event_reminder($event_id,$user,$start_date,$event_name,$event_desc=NULL)
{

    $data = Array();
    $data['reminder_event_id']  = $event_id;
    $data['reminder_author']    = $user;
    $data['reminder_date']      = $start_date;
    $data['reminder_name']      = $event_name;
    $data['reminder_desc']      = $event_desc;

    insert_event_reminder($data);
}

function update_reminder($event)
{
    $data = Array();
    $data['reminder_event_id']  = $event['id'];
    $data['reminder_date']      = $event['start'];
    $data['reminder_name']      = $event['title'];
    $data['reminder_desc']      = $event['detail'];

    update_event_reminder($data);
}

function update_event_emp_state($event,$new_state)
{
    $data = Array();
    while ($row = mysql_fetch_assoc($event))
    {
        array_push($data,$row);
    }
    if($new_state==1)
    {
        $data[0]['is_accepted'] = 1;
        $data[0]['is_denied'] = 0;
    }
    else
    {
        $data[0]['is_accepted'] = 0;
        $data[0]['is_denied'] = 1;
    }

    update_event_from_emp($data[0]);
}