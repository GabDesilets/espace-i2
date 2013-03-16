<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Gabriel
 * Date: 15/03/13
 * Time: 4:38 PM
 */
include_once "helper_notification_model.php";

dispatchHelpNotice();

/**
 * Dispatch by action what the user want to do.
 */
function dispatchHelpNotice(){
    if(array_key_exists('action',$_POST)||(array_key_exists('action',$_GET)))
    {
        $action = isset($_POST['action'])
            ? $_POST['action']
            : $_GET['action'];

        switch ($action)
        {
            case "add":
                unset($_POST['action']);
                addNotice($_POST);
                break;

            case "getNotice":
                getNotice($_GET);
                break;

            case "setRespond":
                setRespond($_POST);
                break;
        }
    }

}

/**
 * @param $data
 * add a notice to a specific connected helper
 */
function addNotice($data){
    $helper_id = CheckIsset($data,'helper_id');
    if($helper_id===NULL){
        die("Une erreur est survenue desoler :( ");
    }
    insert_notice($helper_id);
    echo json_encode(array('success'=>true));
}

function getNotice($data){
    $helper_id = CheckIsset($data,'helper_id');

    if($helper_id===NULL){
        die("Une erreur est survenue desoler :( ");
    }
    $haveNotice = get_notice($helper_id);
    echo json_encode(array('haveNotice'=>$haveNotice));
}

/**
 * @param $data
 * save the respond of the helper
 */
function setRespond($data){
    $helper_id  =  CheckIsset($data,'helper_id');
    $respond    =  CheckIsset($data,'respond');

    if($helper_id===NULL || $respond===NULL){
        die("Une erreur est survenue desoler :( ");
    }

    if(set_notice_status($helper_id,$respond)){
        echo json_encode(array('success'=>TRUE));
    }
}

/**
 * @param array $d
 * @param string $k
 * @return null or the set value
 */
function CheckIsset($d = array(),$k = ""){
    $r = isset($d[$k])
        ? $d[$k]
        : NULL;
    return $r;
}