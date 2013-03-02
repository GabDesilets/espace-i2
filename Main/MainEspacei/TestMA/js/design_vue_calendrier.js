 $(document).ready(function(){
	
    /* Permet de modifier l'interface si l'on clique sur l'onglet de chat */
	$("#onglet_chat").click(function(){			
		$("#main_users_table").css("width", "400px");
		$("#aidants").css("width", "400px");
		$("#calendar").css("width", "800px");
        $("#onglet_chat").css("width", "161px");
        $("#onglet_chat").css("margin-left", "225px");
        $("#onglet_aidants").css("width", "161px");

	});

    /* Permet de modifier l'interface si l'on clique sur l'onglet des aidants */
	$("#onglet_aidants").click(function(){			
		$("#main_users_table").css("width", "200px");
		$("#aidants").css("width", "200px");
		$("#calendar").css("width", "1000px");
        $("#onglet_chat").css("width", "56px");
        $("#onglet_chat").css("margin-left", "130px");
        $("#onglet_aidants").css("width", "57px");
	});
		
});