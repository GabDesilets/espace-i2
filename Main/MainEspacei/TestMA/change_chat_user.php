<?php
session_start();
$current_onglet = $_POST['onglet'];
include_once 'user_status.php';
if ($current_onglet == 'onglet_deconnexion') {
    deconnexion($_SESSION['uid']);
}
if($current_onglet == 'onglet_aidants' || $current_onglet == 'onglet_aidants_etu')
{
	echo get_user_status($_SESSION['uid']);
}
else if($current_onglet == 'onglet_chat' || $current_onglet == 'onglet_chat_etu') {
?>
<script src="js/jquery-1.9.0.js"></script>
<script type="text/javascript" src="minichat.js"></script>
<body onload="refreshChat();">
<div id="Message" style="width:100%;height:200px;overflow:auto">
<!-- Affichage du minichat ici -->
<div id="minichat"></div>
<!-- Fin Affichage du minichat -->
</div>
<div id="Chat" style="width:100%;height:100%;overflow:auto">
<p>
<div style="visibility:hidden;">Pseudo : <br/><input type="text" name="pseudo" id="pseudo" /><br /></div>
Message : <br/><textarea name="message" rows="4" cols="30" id="message_chat" style="width: 375px;" ></textarea><br />
<input type="button" class="btn" value="Envoyer" onclick="submitChat();" />
</p>
</div>
</body>
	<?php
}
else {
    die("Un problème est survenu. Veuillez réessayer plus tard.");
}

