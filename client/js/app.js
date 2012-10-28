jQuery(document).ready(function ($) {

  var geocoder = new google.maps.Geocoder();

  /* Use this js doc for all application specific JS */

  /* TABS --------------------------------- */
  /* Remove if you don't need :) */

  $("#myLocationButton").click(function(e){
    getUserLocation(function(location){
      $("#mylocation").val(location);
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
                        callback(locName);
                        return;
                    }
                });
            }
          });
   } else {
    alert('no geo')
   }
  }

  function activateTab($tab) {
    
    var $activeTab = $tab.closest('dl').find('a.active'),
    contentLocation = $tab.attr("href") + 'Tab';

    // Strip off the current url that IE adds
    contentLocation = contentLocation.replace(/^.+#/, '#');

    //Make Tab Active
    $activeTab.removeClass('active').parent('dd').removeClass('active');
    $tab.addClass('active').parent('dd').addClass('active');

    //Show Tab Content
    $(contentLocation).closest('.tabs-content').children('li').hide();
    $(contentLocation).css('display', 'block');
    
  }

  $('dl.tabs dd a').live('click', function (event) {
    event.preventDefault();
    activateTab($(this));
  });

  /* ALERT BOXES ------------ */
  $(".alert-box").delegate("a.close", "click", function(event) {
    event.preventDefault();
    $(this).closest(".alert-box").fadeOut(function(event){
      $(this).remove();
    });
  });


  /* PLACEHOLDER FOR FORMS ------------- */
  /* Remove this and jquery.placeholder.min.js if you don't need :) */

  //$('input, textarea').placeholder();

  //* TOOLTIPS ------------ */
  //$(this).tooltips();



  /* UNCOMMENT THE LINE YOU WANT BELOW IF YOU WANT IE6/7/8 SUPPORT AND ARE USING .block-grids */
//  $('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'left'});
//  $('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'left'});
//  $('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'left'});
//  $('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'left'});



  /* DROPDOWN NAV ------------- */

  var lockNavBar = false;
  $('.nav-bar a.flyout-toggle').live('click', function(e) {
    e.preventDefault();
    var flyout = $(this).siblings('.flyout');
    if (lockNavBar === false) {
      $('.nav-bar .flyout').not(flyout).slideUp(500);
      flyout.slideToggle(500, function(){
        lockNavBar = false;
      });
    }
    lockNavBar = true;
  });
  if (Modernizr.touch) {
    $('.nav-bar>li.has-flyout>a.main').css({
      'padding-right' : '75px'
    });
    $('.nav-bar>li.has-flyout>a.flyout-toggle').css({
      'border-left' : '1px dashed #eee'
    });
  } else {
    $('.nav-bar>li.has-flyout').hover(function() {
      $(this).children('.flyout').show();
    }, function() {
      $(this).children('.flyout').hide();
    })
  }


  /* DISABLED BUTTONS ------------- */
  /* Gives elements with a class of 'disabled' a return: false; */

});