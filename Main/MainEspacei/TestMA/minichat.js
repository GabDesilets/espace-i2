var current_onglet;
$(document).ready(function(){
	$('#message_chat').keypress(function(e){
		var key = window.event ? e.keyCode : e.which;

        if (e.which == 13) 
		{
			if($('#message_chat').val() != "")
			{
				submitChat();
			}
        }
	});
    $(".onglets").click(function(){
        current_onglet = $(this).attr('id');
    });
});


function getXMLHttpRequest() {
	var xhr = null;
	
	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest(); 
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}
	
	return xhr;
}


function refreshChat()
{
    if (current_onglet == 'onglet_chat') {
        var xhr = getXMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                document.getElementById('minichat').innerHTML = xhr.responseText; // Donn�es textuelles r�cup�r�es
            }
        };

        xhr.open("GET", "minichat.php", true);
        xhr.send(null);

        //On baisse le scroll quand il y a des nouevau message
        var objDiv = document.getElementById("Message");
        objDiv.scrollTop = objDiv.scrollHeight;

    }
}

function submitChat()
{
var xhr = getXMLHttpRequest();
var pseudo = encodeURIComponent(document.getElementById('pseudo').value);
var message = encodeURIComponent(document.getElementById('message_chat').value);
document.getElementById('message_chat').value = ""; // on vide le message sur la page
if($('#minichat').innerHTML != '')
{
	xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                document.getElementById('minichat').innerHTML = xhr.responseText; // Donn�es textuelles r�cup�r�es
				
				//On baisse le scroll quand on poste un message
				var objDiv = document.getElementById("Message");
				objDiv.scrollTop = objDiv.scrollHeight;
        }
	};
	
	xhr.open("POST", "minichat.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("pseudo="+pseudo+"&message="+message);
}

document.getElementById('message_chat').value = ""; // on vide le message sur la page
}
var timer=setInterval("refreshChat()", 2000); // r�p�te toutes les 5s