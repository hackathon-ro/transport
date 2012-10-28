$(function($) {
  
  $.switchIndex = 0;
  var lastElement = 0;
  
  // Set the negative margin on the top menu for slide-menu pages
  var $selector1 = $('#topMenu'),
  events = 'click.fndtn touchstart.fndtn';
  if ($selector1.length > 0) $selector1.css("margin-top", $selector1.height() * -1);

  // Watch for clicks to show the menu for slide-menu pages
  var $selector3 = $('#menuButton');
  if ($selector3.length > 0)  {
    $('#menuButton').on(events, function(e) {
      e.preventDefault();
      $('body').toggleClass('active-menu');
    });
  }

  // Switch panels for the paneled nav on mobile
  var $selector5 = $('#switchPanels');
  if ($selector5.length > 0)  {
    $('#switchPanels dd').on(events, function(e) {
      e.preventDefault();
      var switchToPanel = $(this).children('a').attr('href');
      $.switchIndex = $(switchToPanel).index();
      lastElement = $(this);
      $(this).toggleClass('active').siblings().removeClass('active');
      $(switchToPanel).parent().css("left", ($.switchIndex * (-100) + '%'));
    });
  }

  $(".nextPanel").on("click",function(e){
    e.preventDefault();
    nextPanel();
  })
  
  $('div.page-panel').live("swipeleft", function(){
      alert('asd');
  });
  
  $('div.page-panel').live("swiperight", function(){
		alert('asd');
        var prevpage = $(this).prev('div[data-role="page"]');
		// swipe using id of next page if exists
		if (prevpage.length > 0) {
			nexPanel()
		}
  });
  
  function nextPanel(){
    
    $.switchIndex = $.switchIndex + 1;
    
    var buttonEl = $("#button_panel_" + $.switchIndex);
    var panelEl = $("#panel-" + $.switchIndex);

    $(buttonEl.next()).addClass('active').siblings().removeClass('active');
    $(panelEl).parent().css("left", ($.switchIndex * (-100) + '%'));
    
  }
  
  function prevPanel(){
    
    $.switchIndex = $.switchIndex - 1;
    
    var buttonEl = $("#button_panel_" + $.switchIndex);
    var panelEl = $("#panel-" + $.switchIndex);

    $(buttonEl.prev()).addClass('active').siblings().removeClass('active');
    $(panelEl).parent().css("left", ($.switchIndex * (-100) + '%'));
    
  }

  
});
