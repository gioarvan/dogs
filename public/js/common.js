/* Finds element type plugin */
(function( $ ) {
    $.fn.getType = function() { 
        return this[0].tagName == "INPUT" ? $(this[0]).attr("type").toLowerCase() : this[0].tagName.toLowerCase(); 
    }
})(jQuery)

$(document).ready(function(){
    
    //$.fn.tooltip.defaults.animation = false;
    
    //datePicker
    $( "#dog_date" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true, 
        yearRange: '1900:2020'
    });
   
    //tooltips and popovers
    $('input[name="dog_reward"]').popover();
   
    $('.tip').tooltip({
        html:false,
        delay: {
            show: 100, 
            hide: 100
        }
    });
    
    $('.tip-bottom').tooltip({
        placement : 'bottom',
        html:false,
         delay: {
            show: 100, 
            hide: 100
        }
    });
   
    $('.tip-left').tooltip({
        placement : 'left',
        html:false,
         delay: {
            show: 100, 
            hide: 100
        }
    });
    $('.tip-right').tooltip({
        placement : 'right',
        html:false,
         delay: {
            show: 100, 
            hide: 100
        }
    });
  
    //clear form button
    $('.frm-clear').bind('click',function(e){
        e.preventDefault();
        //clear map html
        $('#map_canvas').html('');
        var oform = $(this).closest('form');
        oform.find(':input').each(function($index){
            if($(this).getType() == 'text')
            {
                $(this).val('');
            }
            if($(this).getType() == 'select')
            {
                $(this).val(-1);
            }
            if($(this).getType() == 'textarea')
            {
                $(this).val('');
            }
        });
        if(oform.find('.formatted-addr')){
            $('.formatted-addr').text('');
        }
        if(oform.find('#map_canvas')){
            $('#map_canvas').css('height','0px');
        }
    });
   
    $('.s-acc').click(function(){
        $('.messages').hide();
    })
    //google map
    //$('input[name="dog_postal"]').bind('focusout',function(e){
    $('.s-map').click(function(e){
        e.preventDefault();
        var postal = $('input[name="dog_postal"]').val();
        //get static map image
        if(postal == ''){
            $('#map_canvas').html('').css('height','0px');
            $('.formatted-addr').html('');
            $('input[name="lat"]').val('');
            $('input[name="long"]').val('');
            $('input[name="area"]').val('');
            return false;
        }
        if(!parseInt(postal) || postal.length != 5)
        {
            alert('Συμπληρώστε έγκυρο ταχυδρομικό κωδικό.');
            return false;
        }
        //get map
        $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+postal+',GR&sensor=false', function(data) {
            //console.log(data);
            var coords = {
                'lati' : data.results[0].geometry.location.lat,
                'longi' : data.results[0].geometry.location.lng,
                'area' : data.results[0].formatted_address
            }
          
            var map = new GMap2(document.getElementById("map_canvas"),{
                size: new GSize(500,500)
                });
            map.setCenter(new GLatLng(coords.lati, coords.longi), 15);
            map.setUIToDefault();
            $('input[name="lat"]').val(coords.lati);
            $('input[name="long"]').val(coords.longi);
            $('input[name="area"]').val(coords.area);
            /*$('#map_canvas').css('width','500');*/
            $('#map_canvas').css('height','300');
            $('.formatted-addr').html(coords.area).css('font-weight','bold');
            //scroll to show map
            $('body,html').animate({
                scrollTop : 200
            }, 500);
        });
        
    });
    
    //google map - this is for lists - lost and found
    $('.gmap').bind('click',function(e){
        e.preventDefault();
        var postal = $(this).text();

        $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+postal+',GR&sensor=false', function(data) {
           
            var coords = {
                'lati' : data.results[0].geometry.location.lat,
                'longi' : data.results[0].geometry.location.lng,
                'area' : data.results[0].formatted_address
            }
          
            var map = new GMap2(document.getElementById("map_canvas"),{
                size: new GSize(500,300)
                });
            map.setCenter(new GLatLng(coords.lati, coords.longi), 15);
            map.setUIToDefault();
            $('.formatted-addr').html(coords.area).css('font-weight','bold');
        
        });
        
    });
    
    //breed dropdown
    $('#breed_id').change(function(){
        if($(this).val() == -2)
        {
            //other breed
            $('#o-breed').show();   
        } else {
            $('#o-breed').hide();  
        }
    });
    
    //hide all messages
    $('.msg-alert').hide();
   
    //signin form validation
    /*$('#btn-signin').click(function(e){
       
       //e.preventDefault();
       
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
       
       if(validateEmail($email) == false){
           $('.msg-alert').show().find('span').text('To email δεν είναι έγκυρο.');
           return false;
       }
       
       if(validatePassword($pwd) == false){
            $('.msg-alert').show().find('span').text('O κωδικός δεν είναι έγκυρος.');
           return false;  
       }
        
   });*/
   
    $('#editfound').submit(function(e){
        var postal = $('input[name="dog_postal"]').val();
        if(postal == ''){
            return false;
        }
        $.ajax({
            dataType: "json",
            async: false,
            url: 'http://maps.googleapis.com/maps/api/geocode/json?address='+postal+',GR&sensor=false',
            success: function(data){
                $('input[name="lat"]').val(data.results[0].geometry.location.lat);
                $('input[name="long"]').val(data.results[0].geometry.location.lng);
                $('input[name="area"]').val(data.results[0].formatted_address);      
            }
        }); 

    });
   
    $('#editlost').submit(function(e){
        var postal = $('input[name="dog_postal"]').val();
        if(postal == ''){
            return false;
        }
        $.ajax({
            dataType: "json",
            async: false,
            url: 'http://maps.googleapis.com/maps/api/geocode/json?address='+postal+',GR&sensor=false',
            success: function(data){
                if($('button[name="status"]').hasClass('active')){
                    $('input[name="status"]').val('F');
                }
                
                $('input[name="lat"]').val(data.results[0].geometry.location.lat);
                $('input[name="long"]').val(data.results[0].geometry.location.lng);
                $('input[name="area"]').val(data.results[0].formatted_address);
               
            }
        });
    });
   
    $('#addlost').submit(function(e){
        var postal = $('input[name="dog_postal"]').val();
        if(postal == ''){
            $('.alert-postal').show();
            return false;
        }
        $.ajax({
            dataType: "json",
            async: false,
            url: 'http://maps.googleapis.com/maps/api/geocode/json?address='+postal+',GR&sensor=false',
            success: function(data){
                $('input[name="lat"]').val(data.results[0].geometry.location.lat);
                $('input[name="long"]').val(data.results[0].geometry.location.lng);
                $('input[name="area"]').val(data.results[0].formatted_address);
               
            }
        }); 
    });
   
    $('#addfound').submit(function(e){
        var postal = $('input[name="dog_postal"]').val();
        if(postal == ''){
            return false;
        }
        $.ajax({
            dataType: "json",
            async: false,
            url: 'http://maps.googleapis.com/maps/api/geocode/json?address='+postal+',GR&sensor=false',
            success: function(data){
                $('input[name="lat"]').val(data.results[0].geometry.location.lat);
                $('input[name="long"]').val(data.results[0].geometry.location.lng);
                $('input[name="area"]').val(data.results[0].formatted_address);
               
            }
        }); 
    });
   
    $('button[name="status"]').bind('click',function(){
        var th = $(this);
        if(!th.hasClass('active')){
            th.removeClass('btn-primary');
            th.addClass('btn-success');
            $('<li/>',
            {
                id:'fmore',
                html: ' <li><span class="label label-info">Μπράβο!</span></li>'
            }).appendTo(th.parent()).show('slow');
        } else {
            th.removeClass('btn-success');
            th.addClass('btn-primary');
            $('#fmore').remove();
        }
    })
    
    
//listen to documents scroll - for sidebar
/*$(window).scroll(function(){
      //get sidebar position
      var sb = $('.sidebar-inner');
      var sb_pos = sb.position();
      sb.addClass('fixedSidebar'); 
   });*/
      
});
