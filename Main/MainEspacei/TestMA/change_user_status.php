<?php

$current_status = $_POST['status'];

if( $current_status == 'status_enligne' ) {
	echo 'En ligne';
}
else if( $current_status == 'status_absent' ) {
	echo 'Absent';
}
else if( $current_status == 'status_occupe' ) {
	echo 'Occupe';
}

/*if($current_onglet == 'onglet_aidants') {
	?>
	<br><ul class="unstyled"><li><p>Marc-Andre Trahan</p></li><li><p>Alexandre Paquin</p></li><li><p>Gabriel Desilets</p></li></ul>
	<?php
}
else if($current_onglet == 'onglet_chat') {
	?>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="minichat.js"></script>
<body onload="refreshChat();">
<div id="Message" style="width:100%;height:200px;overflow:auto">
<!-- Affichage du minichat ici -->
<div id="minichat"></div>
<!-- Fin Affichage du minichat -->
</div>
<div id="Chat" style="width:100%;height:100%;overflow:auto">
<p>
Pseudo : <br/><input type="text" name="pseudo" id="pseudo" /><br />
Message : <br/><textarea name="message" rows="4" cols="30" id="message_chat" style="width: 375px;" ></textarea><br />
<input type="button" class="btn" value="Envoyer" onclick="submitChat();" />
</p>
</div>
</body>
	<?php
}
*/
