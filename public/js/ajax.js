/* 
 * AJAX calls
 */

//var $v = new Validation();

$(document).ready(function() {
   
    $('#btn-contact').click(function(e) {
        e.preventDefault();
        var fname = $('input[name="modal_first_name"]').val();
        if(!Validation.isString(fname)){
            $('.modal_result_failure').show().find('span').text('Το όνομα σας δεν είναι έγκυρο.');
            return false; 
        }
        var lname = $('input[name="modal_last_name"]').val();
        if(!Validation.isString(lname)){
            $('.modal_result_failure').show().find('span').text('Το επίθετο σας δεν είναι έγκυρο.');
            return false; 
        }
        var email = $('input[name="modal_email"]').val();
        if(Validation.email(email) || email.length < 1) {
            $('.modal_result_failure').show().find('span').text('Το email δεν είναι έγκυρο ή δεν έχει συμπληρωθεί.');
            return false;
        }
        var message = $('input[name="modal_message"]').val();
        if(message.length < 1) {
            $('.modal_result_failure').show().find('span').text('Εισάγετε το μήνυμα σας.');
            return false;
        }
        $.ajax({
            url: BASE+'contact',
            type:'POST',
            dataType: 'text',
            data: {
                'fname' : fname,
                'lname' : lname,
                'email' : email.val(),
                'message':message
            },
            success: function(data){
                $('.modal_result_success').show().find('span').text('Το μήνυμα σας εστάλη με επιτυχία!');
            }
        });
    });
    
    $('#btn-signin').click(function(e) {
        e.preventDefault();
        
        var $email = $('input[name="username_login"]');
        var $pwd = $('input[name="password_login"]');
       
        if(!$email.val())
        {
            $('.msg-alert').show().find('span').text('Συμπληρώστε το email σας.');
            return false;  
        }
       
        if(!$pwd.val())
        {
            $('.msg-alert').show().find('span').text('Συμπληρώστε τoν κωδικό σας.');
            return false;  
        }
       
        if(!Validation.email($email.val()) == true){
            $('.msg-alert').show().find('span').text('To email δεν είναι έγκυρο.');
            return false;
        }
       
        if(!Validation.pwd($pwd.val(),4) == true){
            $('.msg-alert').show().find('span').text('O κωδικός δεν είναι έγκυρος.');
            return false;  
        }
        $.ajax({
            url: BASE+'signin',
            type:'POST',
            dataType: 'json',
            data: {
                'username_login' : $email.val(),
                'password_login':$pwd.val()
            },
            success: function(data){
                //close modal
                var signin_modal = $('#signin');
                var total_width = $('#header').width();
                signin_modal.modal('hide');
                $('.messages').css({
                    position: 'fixed',
                    height: '20px',
                    top: '0%'
                })
                if(data.status == 'ERROR')
                {
                    $('.messages').css('width',(total_width / 3)+'px').css('left','30%').text(data.message)
                    .addClass('alert alert-error').removeClass('alert-success').show('fast');
                } else {
                    $('.messages').css('width',(total_width / 4)+'px').css('left','35%').text(data.message)
                    .addClass('alert alert-success').removeClass('alert-error').show('fast',function(){
                        setTimeout(function(){
                            location.reload(); 
                        }, 100); 
                    });
                }
            }
        });
    });
})


