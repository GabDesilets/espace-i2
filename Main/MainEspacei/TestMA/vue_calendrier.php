<?php session_start(); ?>
<?php include_once 'calendrier.php'; ?>
<?php include 'user_status.php'; ?>

<script type="text/javascript" xmlns="http://www.w3.org/1999/html">var ADMIN = <?php echo $_SESSION['admin'] ?>;</script>
<script src="js/jquery-1.9.0.js"></script>
<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
<script src="fullcalendar-1.5.4/fullcalendar/fullcalendar.js"></script>
<script src="fullcalendar-1.5.4/fullcalendar/gcal.js"></script>
<script src="js/jquery.loader-min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/design_vue_calendrier.js"></script>
<script src="js/change_status.js" ></script>

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
        // Active le dropdown pour les status
        $('.dropdown-toggle').dropdown()

        // Change le texte du status pour celui selectionner
        $(".status_btn").click(function(){
            var current_status = $(this).html();
			
			$.ajax({
                type:    'POST',
				dataType: 'html',
                url:     'change_user_status.php',
                data:    {status: current_status},
                success: function(data)
                {
                    data = data.substr(569);
					if(data != 'Deconnexion') {
						$("#status_text").html(data);
					}
                    else{
						window.location.href = "vue_connexion.php";
					}
                }
            }); // fin ajax
        }); // fin event click
    }); // fin document.ready

</script>

<div id="dialog-form" title="Ajout d'une disponibilité">
    <fieldset>
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" ><br>
        <label for="description">Description</label><br>
        <textarea rows="4" cols="30" name="description" id="description"></textarea>
    </fieldset>
</div>

<div id="condition_utilisation" title="Conditions d'utilisation">
	<h3 class="text-center">Conditions d'utilisation</h3>
	<ol style="font-size: 12px;">
		<li>Le service de dépannage en informatique s’adresse seulement aux étudiants inscrits au Cégep de Trois-Rivières.</li>
		<li>Le centre n’offre aucun service relatif aux aspects matériels.</li>
		<li>Une autorisation de prise de contrôle du poste client, si nécessaire, vous sera demandé.</li>
		<li>Aucune responsabilité ne peut être attribuée de part et d’autre lors de l’exécution des travaux et services offerts par le Centre de dépannage en informatique.</li>
		<li>Vous devez protéger toute information à caractère personnelle et/ou confidentielle.</li>
		<li>Les séances de dépannage peuvent être enregistrées.</li>
		<li>Vous ne pouvez pas faire appel au centre d'aide si vous êtes en examen ou en classe.</li>
	</ol>
	<div id="form_condition_utilisation">
		<div id="bleh1" style="display: inline-block; width: 45%;">
			<fieldset>
				<legend><h5>Vous êtes connecté sur</h5></legend>
				<form method="post" action="">
					<ul class="unstyled" style="font-size: 12px;">
						<li><input type="radio" name="connecter_sur" value="Portable">Portable</li>
						<li><input type="radio" name="connecter_sur" value="Ordinateur de bureau">Ordinateur de bureau</li><br>
					<ul>
				</form>
			</fieldset>
		</div>
		<div id="bleh2" style="display: inline-block; width: 45%;">
			<fieldset>
				<legend><h5>Où vous trouvez-vous</h5></legend>
				<form method="post" action="">
					<ul class="unstyled" style="font-size: 12px;">
						<li><input type="radio" name="localisation" value="Domicile">Domicile</li>
						<li><input type="radio" name="localisation" value="Cégep">Cégep</li>
						<li><input type="radio" name="localisation" value="Autre">Autre</li>
					</ul>
				</form>
			</fieldset>
		</div>
		
		<div style="display: block;" id="Acceptation_cond_utilsation">
			<input type="checkbox" name="accept_cond_util" value="accept" required><span style="font-size : 12px;">  J’accepte avoir lu et compris les termes et conditions d’utilisation des services du Centre de dépannage en informatique,<br>je comprends que le Centre de dépannage en informatique ne peut être tenu responsable des erreurs et perturbations occasionnées par ses interventions.<br>Je confirme que la demande d’aide ne contrevient aucunement aux règlements du collège tel que le règlement relatif au plagiat et à la fraude.</span>
		</div>
	</div>
	
</div>


<div id='message' class="success"></div>
<div id="page_complet">
<?php if ( $_SESSION['admin'] == 1 ) : ?>
    <div id="aidants">
        <h4>Aidants connectés</h4>
        <div id='main_users_table'>
            <div id="options_bar" style="height: 25px;">
                <div class="status input-prepend">
                    <div class="btn-group">
                        <button class="btn dropdown-toggle btn-mini" style="width: 60px; height: 25px;">
                            <span id="status_text">
							<?php get_status(); ?>
							</span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="status_btn" id="status_enligne">En ligne</a></li>
                            <li><a href="#" class="status_btn" id="status_absent">Absent</a></li>
                            <li><a href="#" class="status_btn" id="status_occupe">Occupe</a></li>
							<li class="divider"></li>
							<li><a href="#" class="status_btn" id="status_deconnexion">Deconnexion</a></li>
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
				<ul class="unstyled">
					<?php echo get_user_status() ?>
				</ul>
            </div>
        </div>
    </div>

    <?php else: ?>

    <div id="aidants">
        <h4>Aidants connectés</h4>
        <div id='main_users_table_etu'>
            <div id="options_bar_etu" style="height: 25px;">
                <div id="onglet_aidants_etu" class="onglets btn btn-mini">
                    <p>Aidants</p>
                </div>

                <div id="onglet_chat_etu" class="onglets btn btn-mini">
                    <p>Chat</p>
                </div>
            </div>
            <div id="liste_aidants_etu">
                <br>
                <ul class="unstyled">
                    <?php echo get_user_status() ?>
                </ul>
            </div>
        </div>
    </div>

    <?php endif;?>

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
                left: 'prev,next today',
                center: 'title',
                right: 'agendaDay, agendaWeek'
            },
            selectable: true,
            selectHelper: true,
            default: 'agendaDay',
			axisFormat: 'H:mm',
            timeFormat:{
                agenda: 'H'
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
			slotMinutes: 5,
			minTime: 8,
			maxTime: 20,
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
                <?php echo show_dispo();   ?>
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

            },
            eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {

                update_dispo_ajax(event);

            },
            eventResize: function(event,dayDelta,minuteDelta,allDay,revertFunc) {

                update_dispo_ajax(event);

            }

        });
       $('#calendar').fullCalendar( 'changeView', 'agendaDay' );
        $('#calendar').fullCalendar( 'render' );

        var calendar_info = $('#calendar').fullCalendar( 'clientEvents');
        if(saving)
        {
            $('#message').show('slow');
            $('#message').html('Modifications enregistrées avec succès <span class="closeDiv"  onclick="closeDiv()"  style="float: right; cursor: pointer;">X</span>');
        }
    });
	
    $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 350,
        width: 500,
        modal: true,
        buttons: {
            "Accepter": function()
            {
                descDiag=$("#description").val();
                titleDiag = $('#title').val();

                var calendar = $('#calendar');
                var backCol,borderCol;

                backCol="#4AB840";
                borderCol="#008238";

                if(eventIDDiag==null)
                {
                    calendar.fullCalendar('renderEvent',
                        {
                            id      : 'fake_id'+randomString(10),
                            title   : titleDiag,
                            detail  : descDiag,
                            start   : startDiag,
                            end     : endDiag,
                            backgroundColor:backCol,
                            borderColor:borderCol,
                            allDay : false
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
                    calendar.fullCalendar("rerenderEvents");
                }

               save_ajax();
                $( this ).dialog( "close" );
            },
            "Annuler": function() {
                $( this ).dialog( "close" );
            },
            "Suprimmer":function() {
                $.ajax({
                    type:    'POST',
                    url:     'calendrier.php',
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
	
	
	// Permet de faire afficher les conditions d'utilisation si l'on clique sur un aidants
	$(".nom_aidants").click(function(){
		$( "#condition_utilisation" ).dialog( "open" );
	});
	// Paramètres pour l'affichage des conditions d'utilisation
	$( "#condition_utilisation" ).dialog({
        autoOpen: false,
        height: 625,
        width: 850,
        modal: true,
        buttons: {
            "Accepter": function()
            {
                var connection_choice =  $("input[name='connecter_sur']:checked").val();
                var localisation_choice =  $("input[name='localisation']:checked").val();
                var accept_cond_util =  $("input[name='accept_cond_util']").val();
				if(connection_choice && accept_cond_util && localisation_choice)
                {
                    $( this ).dialog( "close" );
                    alert('La session commencera sous peu');
                }
                else
                {
                    alert("Vous devez ");
                }

            },
            "Refuser": function() {
                $( this ).dialog( "close" );
            }
        }
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
                'start' : calendar_info[i].start,
                'id'    : calendar_info[i]._id,
                'allDay': calendar_info[i].allDay,
                'end'   : calendar_info[i].end,
                'accepte':false
            };
            evenements.push(data);
        }

        $.ajax({
            type:    'POST',
            url:     'calendrier.php',
            data:    {myEvents : evenements, action : 'add'},
            success: function(data)
            {

            }

        });
    }

    function update_dispo_ajax(event)
    {
        var data = {
            'empId' : <?php echo $_SESSION['uid'] ?>,
            'start' : event.start,
            'id'    : event.id,
            'end'   : event.end
        };
        $.ajax({
            type:    'POST',
            url:     'calendrier.php',
            data:    {event : data, action : 'update',emp_id:<?php echo $_SESSION['uid'] ?>},
            success: function(data)
            {
                $('#calendar').fullCalendar( 'render' );

            }

        });
    }

    function fetchCalendar()
    {
        $.ajax({
            type:    'GET',
            url:     'get_events.php',
            success: function(data)
            {
                console.log(data);
                $('#fullcalendar').fullCalendar({
                   events:[
                       data
                   ]
                });
//oui jai commit
            }

        });
    }
var timer=setInterval("fetchCalendar()", 20000);

</script>