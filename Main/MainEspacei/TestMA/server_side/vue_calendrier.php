<?php session_start(); ?>
<?php include_once 'calendrier.php'; ?>

<script type="text/javascript" xmlns="http://www.w3.org/1999/html">var ADMIN = <?php echo $_SESSION['admin'] ?>;</script>
<script src="js/jquery-1.9.0.js"></script>
<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
<script src="fullcalendar-1.5.4/fullcalendar/fullcalendar.js"></script>
<script src="fullcalendar-1.5.4/fullcalendar/gcal.js"></script>
<script src="js/jquery.loader-min.js"></script>
<script src="js/bootstrap.min.js"></script>

<link rel='stylesheet' type='text/css' href="css/jquery-ui-1.10.0.custom.min.css" />
<link rel='stylesheet' type='text/css' href="fullcalendar-1.5.4/fullcalendar/fullcalendar.css" />
<link rel='stylesheet' type='text/css' href="fullcalendar-1.5.4/fullcalendar/fullcalendar.print.css" media='print' />
<link rel='stylesheet' type="text/css" href="css/jquery.loader-min.css" />
<link rel='stylesheet' type='text/css' href="css/user.table.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<?php 
if ( !isset($_SESSION['admin'] ) ) {
    
    echo '<div><p>Une identification est nécessaire pour accéder au contenu de cette page.</p>
                <a href="vue_connexion.php">Connection</a></div>';
    die();
}
?>
<script>

    $(document).ready(function(){

        /* Ce code est temporaire.  Il sert à afficher l'onglet chat ou le cacher */
	    var hide = 0;
        $("#hide_chat").click(function(){
            if( hide == 0 ) {
                $("#onglet_chat").css("display", "none");
                hide = hide + 1;
            }
            else{
                $("#onglet_chat").css("display", "inline-block");
                hide = 0;
            }
        });

        /* Permet de savoir sur quel onglet on se trouve */
       /* var current_onglet = 1;
        if( current_onglet == 1 ) {
            $("#aidants").css("background", "rgb(212,212,212)");
        }*/

		/* Permet de changer d'onglet -> Aidants -> Chat */
		$(".onglets").click(function(){
			var current_onglet = $(this).attr('id');
			$.ajax({
                type:    'POST',
				dataType: 'html',
                url:     'change_chat_user.php',
                data:    {onglet: current_onglet},
                success: function(data)
                {
                    $("#liste_aidants").html(data);
                }
            });
		});

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
        // Active le dropdown pour les status
        $('.dropdown-toggle').dropdown()

        // Change le texte du status pour celui selectionner
        $(".status_btn").click(function(){
            var current_status = $(this).attr('id');
			
			$.ajax({
                type:    'POST',
				dataType: 'html',
                url:     'change_user_status.php',
                data:    {status: current_status},
                success: function(data)
                {
                    $("#status_text").html(data);
                }
            });
			
			/*
            if( current_status == "status_enligne" ) {
                $("#status_text").html("En ligne");
            }
            else if( current_status == "status_absent" ) {
                $("#status_text").html("Absent");
            }
            else {
                $("#status_text").html("Occupé");
            }*/
        });

    });

</script>

<div id="dialog-form" title="Ajout d'une disponibilité">
    <fieldset>
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" ><br>
        <label for="description">Description</label><br>
        <textarea rows="4" cols="30" name="description" id="description"></textarea>
    </fieldset>
</div>
<div id='message' class="success"></div>

<div id="page_complet">

    <div id="aidants">
        <h4>Aidants connectés</h4>
        <div id='main_users_table'>
            <div id="options_bar" style="height: 25px;">
                <div class="status input-prepend">
                    <div class="btn-group">
                        <button class="btn dropdown-toggle btn-mini" style="width: 60px; height: 25px;">
                            <span id="status_text">En ligne</span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="status_btn" id="status_enligne">En ligne</a></li>
                            <li><a href="#" class="status_btn" id="status_absent">Absent</a></li>
                            <li><a href="#" class="status_btn" id="status_occupe">Occupé</a></li>
                        </ul>
                    </div>
                </div>
                <div id="onglet_aidants" class="onglets btn btn-mini">
                    <p>Aidants</p>
                </div>
				
				<div id="onglet_chat" class="onglets btn btn-mini">
					<p>Chat</p>			
				</div>				
            </div>
            <div id="liste_aidants">
                <br>
				<ul class="unstyled">
					<li><p>Marc-Andre Trahan</p></li>
					<li><p>Alexandre Paquin</p></li>
					<li><p>Gabriel Desilets</p></li>
				</ul>
            </div>
        </div>
        <p><a href="#" id="hide_chat">Hide chat</a></p>
    </div>

    <div id='calendar' style="width : 1000px; float: right;"></div>
</div>

<script type="text/javascript">
var ids = new Array();
    $(function(){
        var startDiag;
        var endDiag;
        var alldayDiag;
        var descDiag;
        var titleDiag;
        var eventIDDiag;
    });
    $(document).ready(function() {

        $(function() {
            $( document ).tooltip();
        });

        var saving = <?php if(isset($_SESSION['saveSuccess'])){
            echo ($_SESSION['saveSuccess'])?"true":"false";
        }
        else
        {
            echo "false";
        }
        $_SESSION['saveSuccess']=false;
        ?>;

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        var calendar = $('#calendar').fullCalendar({
            header: {
                left: '',
                center: 'title',
                right: ''
            },
            selectable: true,
            selectHelper: true,
            default: 'agendaDay',
            timeFormat:{
                month:'h:mm{ - h:mm}'
            },
            monthNames: [
            "Janvier", "Février", "Mars",
            "Avril", "Mai", "Juin",
            "Juillet", "Août", "Septembre",
            "Octobre", "Novembre", "Décembre"],
            monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Juin','Juil','Août','Sep','Oct','Nov','Dec'],
            dayNames: [ 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
            allDaySlot: false,
            buttonText: {
                prev:     '&nbsp;&#9668;&nbsp;',  // left triangle
                next:     '&nbsp;&#9658;&nbsp;',  // right triangle
                prevYear: '&nbsp;&lt;&lt;&nbsp;', // <<
                nextYear: '&nbsp;&gt;&gt;&nbsp;', // >>
                today:    "Aujourd'hui",
                month:    'Mois',
                week:     'Semaine',
                day:      'Jour'
            },
            eventMouseover: function(event, jsEvent, view) {
                if (view.name !== 'agendaDay')
                {
                    $(jsEvent.target).attr('title', event.detail);
                }
            },
            eventRender: function(event, element) {
                element.find('.fc-event-title').append("<br/>" + event.detail);
            },
            select: function(start, end, allDay) {

                if(ADMIN == 1)
                {
                    startDiag=start;
                    endDiag=end;
                    alldayDiag=allDay;
                    eventIDDiag=null;
                    $("#description").val("");
                    $("#title").val("");
                    $('.ui-button:contains(Suprimmer)').hide();
                    $( "#dialog-form" ).dialog( "open" );
                    $('#title').focus();
                }


            },
           editable: ADMIN ==1 ? true:false,
            events: [
				
                <?php // echo show_dispo($_SESSION['uid']); ?>
            ],
            eventTextColor: '#000000',
            eventClick: function(event)
            {
                if(ADMIN ==1)
                {
                    $("#description").val(event.detail);
                    $("#title").val(event.title);
                    eventIDDiag=event.id;
                    $('.ui-button:contains(Suprimmer)').show();
                    $( "#dialog-form" ).dialog( "open" );
                }
                else
                {


                    if(event.backgroundColor == '#4b95e5')
                    {
                        event.backgroundColor =  '#4AB840';
                        var index = ids.indexOf(event.id);
                        ids.splice(index, 1);

                    }
                    else
                    {
                        event.backgroundColor = '#4b95e5';
                        ids.push(event.id);
                    }
                    $('#calendar').fullCalendar( 'render' );
                }

            }
        });
        $('#calendar').fullCalendar( 'changeView', 'agendaDay' )
        if(saving)
        {
            $('#message').show('slow');
            $('#message').html('Modifications enregistrées avec succès <span class="closeDiv"  onclick="closeDiv()"  style="float: right; cursor: pointer;">X</span>');
            if(<?php echo(isset($_GET['lastView']))?"true":"false";?>){
                calendar.fullCalendar( 'changeView', <?php echo (isset($_GET['lastView']))?"'".$_GET['lastView']."'":"''";?> );
            }
        }
    });
	
    $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 350,
        width: 500,
        modal: true,
        buttons: {
            "Accepter": function() {
                descDiag=$("#description").val();
                titleDiag = $('#title').val();

                var calendar = $('#calendar');
                var backCol,borderCol;

                backCol="#4AB840";
                borderCol="#008238";

                if(eventIDDiag==null){
                    calendar.fullCalendar('renderEvent',
                        {
                            id      : 'fake_id'+randomString(10),
                            title   : titleDiag,
                            detail  : descDiag,
                            start   : startDiag,
                            end     : endDiag,
                            allDay  : alldayDiag,
                            backgroundColor:backCol,
                            borderColor:borderCol
                        },
                        true // make the event "stick"
                    );
                    calendar.fullCalendar('unselect');
                }
                else
                {
                    calendar.fullCalendar( 'clientEvents' ,eventIDDiag)[0].detail=descDiag;
                    calendar.fullCalendar( 'clientEvents' ,eventIDDiag)[0].title=titleDiag;
                    calendar.fullCalendar( 'clientEvents' ,eventIDDiag)[0].backgroundColor=backCol;
                    calendar.fullCalendar( 'clientEvents' ,eventIDDiag)[0].borderColor=borderCol;
                    $('#calendar').fullCalendar("rerenderEvents");
                }


                $( this ).dialog( "close" );
            },
            "Annuler": function() {
                $( this ).dialog( "close" );
            },
            "Suprimmer":function() {
                $.ajax({
                    type:    'POST',
                    url:     'controlleur/calendrier.php',
                    data:    {event_id: eventIDDiag, action : 'delete'},
                    success: function(data)
                    {
                        $('#calendar').fullCalendar("removeEvents",  (eventIDDiag));
                        $('#calendar').fullCalendar("rerenderEvents");
                        $('#message').show('slow')
                        $('#message').html('Disponibilité suprimmée avec succès <span class="closeDiv" onclick="closeDiv()"  style="float: right; cursor: pointer;">X</span>');
                    }
                });
                $( this ).dialog( "close" );
            }
        }
    });

    $('#updateBtn').click(function() {
        save_ajax();
    });


    $('#accetpBtn').click(function() {
        update_dispo_ajax(false,1);
    });

    $('#accetAllpBtn').click(function() {
        update_dispo_ajax(true,1);
    });

    $('#deniedBtn').click(function() {
        update_dispo_ajax(false,0);
    });

    $('#deniedAllBtn').click(function() {
        update_dispo_ajax(true,0);
    });
    function randomString(length) {
        var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz'.split('');

        if (! length) {
            length = Math.floor(Math.random() * chars.length);
        }

        var str = '';
        for (var i = 0; i < length; i++) {
            str += chars[Math.floor(Math.random() * chars.length)];
        }
        return str;
    }

    function closeDiv()
    {
        $('#message').hide('slow');
    }

    function save_ajax()
    {
        var connecter = <?php echo session_id()? 'true':'false' ; ?>;
        if(!connecter)
        {
            alert('Veuillez-vous connecter !');
            window.location='index.php';
        }
        var calendar_info = $('#calendar').fullCalendar( 'clientEvents');

        var evenements = new Array();

        Date.prototype.monthNames = [
            "Janvier", "Février", "Mars",
            "Avril", "Mai", "Juin",
            "Juillet", "Août", "Septembre",
            "Octobre", "Novembre", "Décembre"
        ];

        Date.prototype.getMonthName = function() {
            return this.monthNames[this.getMonth()];
        };

        var today = new Date();

        for(var i=0;i<calendar_info.length;i++)
        {

            var data = {
                'empId' : <?php echo $_SESSION['uid'] ?>,
            'title' :calendar_info[i].title,
                'detail': calendar_info[i].detail,
                'start' : $.fullCalendar.formatDate( calendar_info[i].start,'yyyy MM dd HH:mm'),
                'id'    : calendar_info[i]._id,
                'allDay': calendar_info[i].allDay,
                'end'   :  $.fullCalendar.formatDate( calendar_info[i].end,'yyyy MM dd HH:mm'),
                'accepte':false
        }
            evenements.push(data);
        }
        $.ajax({
            type:    'POST',
            url:     'controlleur/calendrier.php',
            data:    {myEvents : evenements, action : 'add'},
            success: function(data)
            {
                var view = $('#calendar').fullCalendar('getView');
                window.location.href = "principal.php?pageid=0&lastView="+view.name;
            }

        });
    }

    function update_dispo_ajax(flAllEvent,flAccepted)
    {

        var connecter = <?php echo session_id()? 'true':'false' ; ?>;
        if(!connecter)
        {
            alert('Veuillez-vous connecter !');
            window.location='index.php';
        }

        var calendar_info = $('#calendar').fullCalendar( 'clientEvents');
        var myIds ="";
        var ctr1 = 1;
        if(!flAllEvent)//Flag if the event have been selected
        {
            for(var i=0; i<ids.length; i++)
            {
                myIds+=ids[i];
                if(ctr1 < ids.length)
                {
                    myIds+=',';
                }
                ctr1++;
            }

        }

        var ctr2 = 1;
        var numRow = calendar_info.length;
        if(flAllEvent)
        {
            for(var i=0;i<numRow;i++)
            {
                myIds+=calendar_info[i]._id;
                ids.push(calendar_info[i]._id);
                if(ctr2 < numRow)
                {
                    myIds+=',';
                }
                ctr2++;
            }
        }


        $.ajax({
            type:    'POST',
            url:     'controlleur/calendrier.php',
            data:    {myEventIds : myIds, action : 'acceptEvent',isAccepted: flAccepted,eventArrayIds:ids,emp_id:<?php echo $_SESSION['uid'] ?>},
            success: function(data)
            {
                ids.splice(0, ids.length);

                for(var i=0;i<calendar_info.length;i++)
                {
                    calendar_info[i].backgroundColor = '#4AB840'
                }
                $('#calendar').fullCalendar( 'render' );
                $('#dialog_calendar' ).dialog( "close" );
                $('#message').show('slow');
                $('#message').html('Disponibilité acceptées avec succès <span class="closeDiv" onclick="closeDiv()"  style="float: right; cursor: pointer;">X</span>');
            }

        });
    }

</script>