$(document).ready(function(){
    var $postal = parseInt($('.postal').text());
    $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+$postal+',GR&sensor=false', function(data) {
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
        $('#map_canvas').css('width','500px');
        $('#map_canvas').css('height','500px');
        $('.formatted-addr').html(coords.area).css('font-weight','bold');
           
    });
     
})
 