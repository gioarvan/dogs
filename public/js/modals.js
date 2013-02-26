/* 
 * Application modals 
 * 
 */

$(document).ready(function(){
    $('.s-acc').bind('click',function(e){
        e.preventDefault();
        $('#modal_signin').modal();
    });
    $('.telinfo').bind('click',function(e){
        e.preventDefault();
        $('#modal_telinfo').modal();
    });
   
})


