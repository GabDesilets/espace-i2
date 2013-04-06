<?php
    include_once "calendrier_model.php";

dispatchCalendar();

function dispatchCalendar()
{

    if(array_key_exists('action',$_POST)||(array_key_exists('action',$_GET)))
    {
        $action = isset($_POST['action'])
            ? $_POST['action']
            : $_GET['action'];

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
        }
    }
}


function add($calendriers)
{
    if(!session_id())
    {
        session_start();
    }

    $data = Array();

    foreach ($calendriers['myEvents'] as $evenement)
    {
        if($evenement['empId'] == $_SESSION['uid']){

            if(is_numeric($evenement['id']))
            {
                update($evenement);
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

    }
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
    if(!session_id())
    {
        session_start();
    }
    if($data['empId'] == $_SESSION['uid']){
        update_dispo($data);
    }

}


