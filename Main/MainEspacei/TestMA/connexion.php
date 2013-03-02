<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Gabriel Lamy
 * Date: 12-11-03
 * Time: 10:19
 * To change this template use File | Settings | File Templates.
 */
// include_once "modele/employe_model.php";

function connecter($login, $password)
{
    $employes = get_etudiant("upper(login) = '".strtoupper($login)."'");
    if($employes)
    {
        $employe = mysql_fetch_array($employes);
        if(strtoupper($employe['password']) == strtoupper($password))
        {
            if(session_id() == '')
            {
                session_start();
            }
            $_SESSION['uid'] = $employe['id'];
            $_SESSION['nom'] = $employe['nom'];
            $_SESSION['prenom'] = $employe['prenom'];
            $_SESSION['admin'] = $employe['admin'];

            return  true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

function get_etudiant( $where = null ) {
    $connection = mysql_connect('localhost','sitemeut_admin','4C51d21f9C');
    mysql_select_db('sitemeut_espace-i2',$connection);
    //die(var_dump($connection));
    $query = "select * from etudiant ";
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