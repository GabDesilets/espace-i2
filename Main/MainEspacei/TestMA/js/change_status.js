/**
 * Created with JetBrains PhpStorm.
 * User: Marc-André
 * Date: 13-03-03
 * Time: 16:37
 * To change this template use File | Settings | File Templates.
 */

function refresh_status_js() {

        $.ajax({
            type:    'POST',
            dataType: 'html',
            url:     'refresh_status.php',
            success: function(data)
            {
                $("#liste_aidants").html(data);
            }
        }); // fin ajax

} // fin function

var timer=setInterval("refresh_status_js()", 5000); // r�p�te toutes les 5s
