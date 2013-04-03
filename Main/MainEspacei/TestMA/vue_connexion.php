<?php
    if(isset($_SESSION)) {
        session_destroy();
    }
    include("connexion.php");
    $logged = true;
    $connecting=false;
    $emptyUserPw=0;
    if(isset($_POST['btlogin']))
    {
        $connecting=true;
        if(isset($_POST['username']) && isset($_POST['password']))
        {
            if(trim($_POST['username'])=="")
                $emptyUserPw=1;
            if(trim($_POST['password'])=="")
                $emptyUserPw+=2;

            if($emptyUserPw==0){

                $logged = connecter($_POST['username'], $_POST['password']);
                if($logged)
                {
					header("Location: vue_calendrier.php");
                }
            }
            else {
                $logged=false;
            }
        }
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Connexion Espace-i</title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <!--[if IE]>
    <style type="text/css">
        .gradient {
            filter: none!important;
        }
        body{
            background-image: none;
            background-color: #ffffff;
        }
    </style>
    <![endif]-->

</head>

<body >
<div id="wrapper">
    <div id="bloc_connexion">
    <table id="centertable">
        <tr>
            <td width="50%" id="tdhide"></td>
            <td>
                <div id="mainwindow">
                    <form action="" method="post" id="loginform">
                        <table>
                            <tr>
								<br>
								<div id="logo_cegeptr">
									<img src="logo_top_cegeptr.jpg" alt="Logo cegeptr" />
								</div>
								<br>
                                <p class="text-info">Veuillez vous identifier avant d'entrer dans cette partie du site</p>

                                <td>
                                    <div id="erreurlogin">
                                        <?php
                                            if(!$logged)
                                            {
                                                switch($emptyUserPw){
                                                    case 1:{
                                                    echo "<span class='text-error'>Veuilez entrer votre nom d'utilisateur.</span>";
                                                    break;
                                                    }
                                                    case 2:{
                                                    echo "<span class='text-error'>Veuilez entrer votre mot de passe.</span>";
                                                    break;
                                                    }
                                                    case 3:{
                                                    echo "<span class='text-error'>Veuilez entrer un nom d'utilisateur et un mot de passe.</span>";
                                                    break;
                                                    }
                                                    default:{
                                                    echo "<span class='text-error'>Nom d'utilisateur ou mot de passe invalide.</span>";
                                                    }
                                                }

                                            }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="username">Nom d'utilisateur :</label></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="username" id="username" size="35" autofocus /></td>
                            </tr>
                            <tr>
                                <td><label for="password">Mot de passe :</label></td>
                            </tr>
                            <tr>
                                <td><input type="password" name="password" id="password" size="35"/></td>
                            </tr>
                            <tr align="right">
                                <td><input type="submit" value="Connexion" name="btlogin" class="btn"/></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
            <td width="50%"></td>
        </tr>
    </table>

    </div>
</div>
</body>

</html>