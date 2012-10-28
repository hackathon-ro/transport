
var fromLocation = null;
var geocoder = new google.maps.Geocoder();

var gateway_url = "http://t.zeweb.ro/api.php";
  
jQuery(document).ready(function ($) {

  $("#myLocationButton").click(function(e){
    getUserLocation(function(location,latlng){
      initGeoMap('googleMapElement',latlng);
      $("#mapModal").reveal();
      fromLocation = location;
    });
    e.preventDefault();
  });
  
  function getUserLocation(callback){
   if(navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position){
            var mylocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            if(geocoder) {
                geocoder.geocode({'latLng': mylocation}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var locParts = results[0].formatted_address.split(", ");
                        var locName = locParts[locParts.length - 2] + ", " + locParts[locParts.length - 1];
                        callback(locName,mylocation);
                        return;
                    }
                });
            }
          });
   } else {
    alert('no geolocation')
   }
  }
  
  function renderResults(){
    
  }

  /* ALERT BOXES ------------ */
  $(".alert-box").delegate("a.close", "click", function(event) {
    event.preventDefault();
    $(this).closest(".alert-box").fadeOut(function(event){
      $(this).remove();
    });
  });

});

function getTrasee(){
   gotoPanelByID(2);
   $.getJSON(gateway_url + "?from=Bucuresti&to=Sibiu&type=tren&callback=?", function(data){
      $.each(data,function(i,item){
        console.log(item);
      })
   });
    //alert(ajx);
}

function initGeoMap(elementID,latlng){
  var msrc = 'http://maps.googleapis.com/maps/api/staticmap?center='+ latlng.Ya +',' + latlng.Za +'&zoom=8&size=400x150&sensor=false'
  $("#" + elementID).attr("src",msrc);
}
  
function closeGeoMap(){
  $("#from").val(fromLocation);
  $('#mapModal').trigger('reveal:close');
  return false;
}