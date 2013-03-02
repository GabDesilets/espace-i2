<?php
if(file_exists("calendrier_model.php")){

    include_once "calendrier_model.php";
    //include_once "../modele/employe_model.php";
}
else
{

    include_once "calendrier_model.php";
   // include_once "modele/employe_model.php";
}
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
                 update($_POST);
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
            unset($evenement['id']);

            $data['employe'] = $evenement['empId'];
            $data['titre'] = $evenement['title'];
            $data['detail'] = $evenement['detail'];
            $data['datedebut'] = $evenement['start'];
            $data['datefin'] =  $evenement['end'];
            $data['allday'] =  $evenement['allDay'];
            $data['disponibilite'] = TRUE;
            $data['accepte'] =  $evenement['accepte'];
            $id = insert_dispo($data);
            add_event_reminder($id,$data['employe'],$data['datedebut'],$data['titre'], $data['detail']);
       }


    }
//          PARTIE A  ACTIVER QUAND NOUS AURONS UN SERVEUR ! NE PAS TOUCHER POUR L'INSTANT !
###########################################################################################################
/*
    $employe = get_employe("id = ".$calendriers['myEvents'][0]['empId']);
    $arr = array();

    while($row = mysql_fetch_assoc($employe))
    {
        $arr[] = $row;
    }
    @var $to= le desinataire
    @var $subject = notre sujet
    @var $message = notre message
    $to       = $_SESSION['email1'];
    $subject  = $arr['nom'].','.$arr['prenom'].'horaire de disponibilité.';
    $message  = $arr['prenom'].' '.$arr['nom'].' a rentré ses disponibilités.
                Vous pouvez maintenant aller les consulter et les accepter.'.
                'Ce message est envoyé automatiquement , veuillez de pas y repondre.';


  if(mail($to, $subject, $message))
        echo "Courriel envoyé";
    else
        echo "Erreur";
*/
###########################################################################################################
    $_SESSION['saveSuccess']=true;
}

function show_dispo($userId=NULL,$flForAccept=FALSE)
{
    $code ="";
    $data = get_dispo();
    $num_row = mysql_num_rows($data);
    $ctr=0;

    while ($row = mysql_fetch_array($data)) {
        $code.='{';
        $code.="id:".$row[0].',';
        $code.="title:'".str_replace("'","\'",$row[1])."',";
        $code.="detail:'".str_replace("\n","\\n",str_replace("'","\'",$row[4]))."',";
        $code.="start:'".$row[5]."',";
        $code.="end:'".$row[6]."',";
        $code.="allDay:".$row[8].",";

        //If event has been accepted
        if(!$row[7])
        {
            if($row[3]==0)
            {//indispo
                if(!$flForAccept)
                {
                    $code.="backgroundColor: '#E8353F',";
                    $code.="borderColor: '#D8000C',";
                }
                else
                {
                    $code.="backgroundColor: '#FFBABA',";
                    $code.="borderColor: '#D8000C',";
                    $code.="textColor: '#000000',";
                }
            }
            else
            {//dispo
                if(!$flForAccept)
                {
                    $code.="backgroundColor: '#4AB840',";
                    $code.="borderColor: '#008238',";
                }
                else
                {
                    $code.="backgroundColor: '#DFF2BF',";
                    $code.="borderColor: '#008238',";
                    $code.="textColor: '#000000',";
                }

            }
        }
        else
        {
            if($row[3]==0)
            {//indispo

                $code.="backgroundColor: '#E8353F',";
                $code.="borderColor: '#D8000C',";

            }
            else
            {//dispo

                $code.="backgroundColor: '#4AB840',";
                $code.="borderColor: '#008238',";

            }
        }

        $isAccepted = $row[7] ? $row[7] : 0;
        $code.="accepted:".$isAccepted.",";
        $code.="dispo:".$row[3]."}";
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
        delete_reminder($event_id);
    }
    else
    {
        return true;
    }

}


function update($data)
{
    update_dispo($data);
    update_reminder($data);
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