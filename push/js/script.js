//
// script.js
//
// @author Vikeer Jaichand
//
// Main script file for push project
//

$(document).ready(function(){
                
});
function SendPushNotification(id){
    var data = $('form#'+id).serialize();
    $('form#'+id).unbind('submit');                
    $.ajax({
        url: "lib/sendmessage.class.php",
        type: 'GET',
        data: data,
        beforeSend: function() {
             
        },
        success: function(data, textStatus, xhr) {
              $('.txt_message').val("");
        },
        error: function(xhr, textStatus, errorThrown) {
             
        }
    });
    return false;
}