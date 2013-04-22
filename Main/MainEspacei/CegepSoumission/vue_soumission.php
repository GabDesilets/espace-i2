<?php include_once('soumission.php');
if(!session_id())
{
    session_start();
}
set_empty_session();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Le styles -->
    <link href="docs/assets/css/bootstrap.css" rel="stylesheet">
    <link href="docs/assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="docs/assets/css/docs.css" rel="stylesheet">
    <link href="docs/assets/js/google-code-prettify/prettify.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="docs/assets/js/html5shiv.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="docs/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="docs/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="docs/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="docs/assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="favicon.png">
    <script src="docs/assets/js/jquery.js"></script>

    <title>Espace-i Soumission de projet</title>
</head>
<body>
    <form enctype="multipart/form-data"  method="POST" action="soumission.php" class="form-inline form-horizontal" accept-charset='UTF-8'>
      <div class="img-circle input-large">
          <img src="img/Espace_i_Developp_RGB.jpg">
      </div>

            <legend class="text-center">
                Espace-i
                <br> Département d'informatique
                <br>Soumission de projet
            </legend>
        <?php if(isset($_SESSION['err_send_osbl_mail'])): ?>
            <div class="alert alert-error" style="width: 1000px">
                <?php echo $_SESSION['err_send_osbl_mail'] ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['success_send_submission'])): ?>
            <div class="alert alert-success" style="width: 1000px">
                <?php echo $_SESSION['success_send_submission'] ?>
            </div>
        <?php endif; ?>
        <div class="control-group">
            <div class="alert alert-info controls" style="width: 1000px">
               Les champs munis d'un astérisque (*) sont obligatoire.
            </div>
        </div>
            <div class="control-group">
            <label class="control-label" for="osbl_nom">Nom de l'organisme</label>
            <div class="controls">
                <input type="text" id="osbl_nom"  name="osbl_nom" placeholder="Votre nom ici..."
                       value="<?php echo isset($_SESSION['var']['osbl_nom']) ? $_SESSION['var']['osbl_nom'] : '' ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="osbl_adresse">Adresse:</label>
            <div class="controls">
                <input type="text" id="osbl_adresse" name="osbl_adresse" placeholder="Votre adresse..."
                       value="<?php echo isset($_SESSION['var']['osbl_adresse']) ? $_SESSION['var']['osbl_adresse'] : '' ?>">
            </div>
        </div>
        <div class="control-group">
        <label class="control-label" for="osbl_ville">Ville:</label>
        <div class="controls">
                <select id="osbl_ville" name="osbl_ville">
                    <?php foreach ( get_villes() as $ville): ?>
                    <?php $selected = $_SESSION['var']['osbl_ville']== $ville ? 'selected' : ''?>
                        <option <?php echo $selected ?>><?php echo $ville; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="osbl_code_p">Code postal:</label>
            <div class="controls">
                <input type="text" id="osbl_code_p" name="osbl_code_p" placeholder="Votre code postal..."
                       value="<?php echo isset($_SESSION['var']['osbl_code_p']) ? $_SESSION['var']['osbl_code_p'] : '' ?>">
                <?php if(isset($_SESSION['err_osbl_code_p'])): ?>
                <div class="alert alert-error" style="width: 1000px">
                    <?php echo $_SESSION['err_osbl_code_p'] ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="osbl_email">*Courriel:</label>
            <div class="controls">
                <input id="osbl_email"  name="osbl_email" class="span3" type="email" required
                       value="<?php echo isset($_SESSION['var']['osbl_email']) ? $_SESSION['var']['osbl_email'] : '' ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="osbl_phone">*Téléphone:</label>
            <div class="controls">
                <input id="osbl_phone" name="osbl_phone" class="number input-medium" type="tel" required
                       value="<?php echo isset($_SESSION['var']['osbl_phone']) ? $_SESSION['var']['osbl_phone'] : '' ?>">
                <label  for="osbl_phone_post">Poste:</label>
                <input id="osbl_phone_post" name="osbl_phone_post" class="input-small number" type="text"
                       value="<?php echo isset($_SESSION['var']['osbl_phone_post']) ? $_SESSION['var']['osbl_phone_post'] : '' ?>">
                <?php if(isset($_SESSION['err_osbl_phone'])): ?>
                    <div class="alert alert-error" style="width: 1000px">
                        <?php echo $_SESSION['err_osbl_phone'] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="contact_source">Personne contact:</label>
            <div class="controls">
                <input type="text" id="contact_source"  name="contact_source" placeholder="Votre nom ici..."
                       value="<?php echo isset($_SESSION['var']['contact_source']) ? $_SESSION['var']['contact_source'] : '' ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="osbl_phone">Téléphone:</label>
            <div class="controls">
                <input id="private_phone" name="private_phone" class="number input-medium" type="tel"
                       value="<?php echo isset($_SESSION['var']['private_phone']) ? $_SESSION['var']['private_phone'] : '' ?>">
                <label  for="private_phone_poste">Poste:</label>
                <input id="private_phone_poste" name="private_phone_poste" class="input-small number" type="text"
                       value="<?php echo isset($_SESSION['var']['private_poste']) ? $_SESSION['var']['private_poste'] : '' ?>">
                <?php if(isset($_SESSION['err_private_phone'])): ?>
                    <div class="alert alert-error" style="width: 1000px">
                        <?php echo $_SESSION['err_private_phone'] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="private_email">Courriel:</label>
            <div class="controls">
                <input id="private_email" name="private_email" class="span3" type="email"
                       value="<?php echo isset($_SESSION['var']['private_email']) ? $_SESSION['var']['private_email'] : '' ?>">
                <?php if(isset($_SESSION['err_private_email'])): ?>
                    <div class="alert alert-error" style="width: 1000px">
                        <?php echo $_SESSION['err_private_email'] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="control-group">
            <div class="alert alert-info controls" style="width: 1000px">
                Description de vos besoins(Joindre toutes les informations qui peuvent nous permettre d'avoir une bonne idée
                de vos besoins et de votre organisation)
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="osbl_project_type">Type de projet :</label>
            <div class="controls">
                <select id="osbl_project_type" name="osbl_project_type">
                    <?php foreach ( get_type_projets() as $projet): ?>
                    <?php $selected = $_SESSION['var']['osbl_project_type']== $projet ? 'selected' : ''?>
                    <option <?php echo $selected ?>><?php echo $projet; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" id="other_choice"  name="other_choice"
                       value="<?php echo isset($_SESSION['var']['other_choice']) ? $_SESSION['var']['other_choice'] : '' ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="description_demande">Description:</label>
            <div class="controls">
                <textarea id="description_demande" name="description_demande" rows="15" style="width: 650px">
                    <?php if(isset($_SESSION['var']['message'])):  ?>
                        <?php echo $_SESSION['var']['message'] ?>
                    <?php endif; ?>
                </textarea>
            </div>
        </div>
        <div class="alert alert-info controls" style="width: 825px">
            Pour sélectionner plusieurs documents , vous devez tenir la touche contrôle(ctrl) enfoncé et cliquer sur les documents désiré.
        </div>
        <div class="control-group">
            <label class="control-label" for="files">Pièces jointes:</label>
            <div class="controls">
                <input type="file"  name="file[]" multiple  id="files"
                       value="<?php echo $_FILES ?>"/>
            </div>
        </div>
        <br>
        <div class="control-group">
            <div class="controls">
                <input type="submit" class="btn" value="Soumettre">
            </div>
        </div>
        <div class="alert alert-info controls" style="width: 1000px">
            Pour plus d'information : <br>
            Coordonnée espace I  Téléphone :819-376-1721 poste : 2494 ou 2496
        </div>
        <input type="hidden"  name="action" value="sendRequest" />
    </form>
</body>
</html>
<script>
    window.onunload = function() {
        <?php session_destroy();  ?>
    };
    $(document).ready(function(){

        $(':input').bind("cut copy paste",function(e) {
            e.preventDefault();
        });
        if($('#osbl_project_type').val()=="Autre")
        {
            $('#other_choice').show("slow");
        }
        else
        {
            $('#other_choice').hide("fast");
            $('#other_choice').val('');
        }
    });

    $('#other_choice').hide();
    $('.number').keypress(function(event){
        var key = window.event ? event.keyCode : event.which;

        if (event.keyCode == 8 || event.keyCode == 45) {
            return true;
        }
        else if ( key < 48 || key > 57 ) {
            return false;
        }
        else return true;
    });

    $('#osbl_project_type').change(function(){
       if($(this).val()=="Autre")
       {
           $('#other_choice').show("slow");
           $('#other_choice').focus();
       }
        else
       {
           $('#other_choice').val('');
           $('#other_choice').hide("fast");
       }
    });

    $('#osbl_code_p').keyup(function(){
        this.value = this.value.toUpperCase();
    });
</script>
