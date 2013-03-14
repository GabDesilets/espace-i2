<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Marc-André
 * Date: 13-03-14
 * Time: 11:44
 * To change this template use File | Settings | File Templates.
 */
session_start();
$choix_connexion = $_POST['choix_connexion'];
$choix_localisation = $_POST['choix_localisation'];

mysql_connect("localhost", "root", "");
mysql_select_db("sitemeut_espace-i2");

echo mysql_query("INSERT INTO `connexion_aidant` VALUES('', '" . $_SESSION['uid'] . "', '" . $choix_connexion . "' , '" . $choix_localisation . "')") or die(mysql_error());