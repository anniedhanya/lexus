$(document).ready(function() {


  var temlat = "";
   var temlong = "";


    var gustaddress =  localStorage.getItem('guest-addres');

      if(gustaddress != null)
      {
         var obj = JSON.parse(gustaddress);
        var count = Object.keys(obj).length
        if(count > 0)
        {
              //obj['address'].push({"locationaddress":locationaddress,"locationtitle":locationtitle,"completeAddress":coompleteaddress,"cordinates":cordinates});
            var locationcord = obj.cordinates.split(",");
             temlat =  locationcord[0];
             temlong =  locationcord[1];


             $("#servicelocation").val(obj.locationaddress);
             $("#address_title").val(obj.locationtitle);
             $("#request_address").val(obj.completeAddress);
             $("#coordinates").val(obj.cordinates);
              $("#locationautocomplete").val(obj.locationaddress);

        }
      }

        var markers = [];
        var map;
        var latitu=document.getElementById("lat").value;
        var lngitu=document.getElementById("lng").value;
        if(latitu!=""){

            var lati =  latitu;
            var longi = lngitu;
        }else{
            var lati =  20.593684;
            var longi = 78.96288;
        }
      
        function myMap(lat,long) {
            var mapCanvas = document.getElementById("map");


            var latitude = lat;
            var longitude = long;

             //latlng = new google.maps.LatLng(lat, long);
            // placeMarker(map,latlng);
            var myCenter = new google.maps.LatLng(latitude, longitude);

           
            var mapOptions = { center: myCenter, zoom: 16 };
            map = new google.maps.Map(mapCanvas, mapOptions);
            
            google.maps.event.addListener(map, 'click', function (event) {
                  deleteMarkers();
            
               
                placeMarker(map, event.latLng);
                //return;
            });

            if(temlat != "" && temlong != "" )
            {
                var uluru = {lat:temlat, lng:temlong};
             
                var marker = new google.maps.Marker({position: uluru, map: map});
            }
        }

        function placeMarker(map, location) {
            deleteMarkers();
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                animation: google.maps.Animation.DROP,
                icon: '/images/common/default.png'
            });
            
            markers.push(marker);
/*-----------------------------------------------------*/
var lat=location.lat();
var lng=location.lng();

          var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();

  geocoder.geocode({ 'latLng': latlng }, function (results, status) {
 
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {

                        console.log(lat);
                        document.getElementById("locationautocomplete").value=results[1].formatted_address;
                       document.getElementById("latitude").value=lat;
                       document.getElementById("longitude").value=lng;
                    

                        var marker = new google.maps.Marker({
                                          map: map,
                                          position: results[0].geometry.location
                                        });
                         markers.push(marker);
                          var infowindow = new google.maps.InfoWindow({
                content: '<strong>Location Details</strong> <br> '+results[1].formatted_address 
            });

                    }
                    
                }
            });

        }

        // Sets the map on all markers in the array.
        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
            setMapOnAll(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
            setMapOnAll(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }

        ///*---------------------------------------------*/

function initMap(lat,long) {
       var latitu=document.getElementById("lat").value;
        var lngitu=document.getElementById("lng").value;
        if(latitu!=""){
    
            var latitude =  latitu;
            var longitude = lngitu;
        }else{
            var latitude = lat;
            var longitude = long;
          }

        var card = document.getElementById('location-map');
         var input = document.getElementById('locationautocomplete');

     var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: latitude, lng: longitude},
          zoom: 15
        });
     if(latitu!=""){
       myMap(latitude,longitude);
     }else{
      myMap(lat,long);
     }
         
        
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
     
        var autocomplete = new google.maps.places.Autocomplete(input);
        
   
google.maps.event.addListener(autocomplete, 'place_changed', function () {



            var places = autocomplete.getPlace();

            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({"address":places.formatted_address }, function(results, status) {
                   
                if (status == google.maps.GeocoderStatus.OK) {
                    var lat = results[0].geometry.location.lat(),
                        lng = results[0].geometry.location.lng(),
                        placeName = results[0].address_components[0].long_name,
                        latlng = new google.maps.LatLng(lat, lng);
                         //placeMarker(map,latlng);

                        initMap(lat,lng);


                }
            });

});

        }

  /*$('#myModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
  
    initMap(lati,longi);
    $("#location-map").css("width", "100%");
    $("#map").css("width", "100%");
  });*/
  $('#myModal_').on('show.bs.modal', function(event) {

       
          
 // $("#error_servicelocation").text("");
    var button = $(event.relatedTarget);
  
    initMap(lati,longi);
    $("#location-map").css("width", "100%");
    $("#map").css("width", "100%");
  });

});