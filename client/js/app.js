
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
      
   var from = $("#from").val() != undefined ? $("#from").val() : "Sibiu";
   var to = $("#to").val() != undefined ? $("#to").val() : "Sibiu";
   
   $.getJSON(gateway_url + "?f="+from+"&t="+to+"&type=train&callback=?", function(data){
      $("#lista-rute").html("");
	  $.each(data.results,function(i,item){
        renderItem(i,item);
      })
   });
    //alert(ajx);
}

function renderItem(z,item){
	
	var lista = $("#lista-rute");
	var theClone = $("#train-template").clone();
	var tName = "";
	
	theClone.attr('style',"");
	theClone.attr("id",'train' + z);
	
	lista.append(theClone);

	$.each(item.data.Tren,function(i,train){
		
		var tinfo = train;
				
		tName += tName;
		
		if(tinfo.Itren){
			if(tinfo.Itren.tip) tName += tinfo.Itren.tip;
			if(tinfo.Itren.nr) tName += tinfo.Itren.nr;
		}
		
		theClone.find('.title').append("<b>" + tName + "</b> - ");
		
		if(tinfo.Plecare && tinfo.Plecare.ora && tinfo.Plecare.sta)theClone.find('.body').append('<div class="tag">').html('Pleaca la ' + tinfo.Plecare.ora + " din " + tinfo.Plecare.sta);
		
		if(i == item.data.Tren.length - 1) theClone.find('.body').append('<div class="tag">').html('Soseste la ' + tinfo.Sosire.ora + " din " + tinfo.Sosire.sta);
		
	})
	
	theClone.find('.title').addClass(item.type);
	
	
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