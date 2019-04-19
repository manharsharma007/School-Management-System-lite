jQuery(document).ready(function ($){
        (function() {

  "use strict";

  var toggles = document.querySelectorAll(".__nav-icon");

  for (var i = toggles.length - 1; i >= 0; i--) {
    var toggle = toggles[i];
    toggleHandler(toggle);
  };

  function toggleHandler(toggle) {
    toggle.addEventListener( "click", function(e) {
      e.preventDefault();
      if(this.classList.contains("is-active") === true)
      {
        this.classList.remove("is-active");
        $('.secondary-menu').removeClass('active');
      }
      else
      {
        this.classList.add("is-active");
        $('.secondary-menu').addClass('active');
      }
    });
  }

})();

	$('.popup-link').on('click', function(e)
	{
		e.preventDefault();
		var data_window = $(this).attr('data-href');

		$('#'+data_window).fadeIn(); 
	});

	$('.popup-close').on('click', function(e)
	{
		e.preventDefault();
		var data_window = $(this).attr('data-href');

		$('#'+data_window).fadeOut();
        window.location.reload();
	});




	$('.file-upload').change(function(e){
        var fileName = e.target.files[0].name;
        $('.file-display').html('<span>'+fileName+'</span>');
    });

    $(".form_ajax").submit(function(e){
        e.preventDefault(); //prevent default action
          $('.send').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
          $('.send').attr('disabled', 'true');
            var post_url = $(this).attr("data-action"); //get form action url
            var id = $(this).attr("id");
            var request_method = $(this).attr("method"); //get form GET/POST method
            var form_data = new FormData(this); //constructs key/value pairs representing fields and values
            
            $.ajax({ //ajax form submit
                url : post_url,
                type: request_method,
                data : form_data,
                dataType : "json",
                contentType: false,
                cache: false,
                processData:false
            }).done(function(res){
                    $(".ajax_response").html( res.text );
                      if( res.code == 1) $('#'+id)[0].reset();
                    $('.send').html('Submit');
                    $('.send').removeAttr('disabled');
                    var scrollPos =  $(".ajax_response").offset().top;
 		             $(window).scrollTop(scrollPos);
            });
        });




  // Drop Down Menu
  jQuery('ul#main-menu').superfish({ 
        delay:       600,
        animation:   {opacity:'show',height:'show'},
        speed:       'fast',
        autoArrows:  true,
        dropShadows: false
    });

  
  // Mobile Menu

  // Create the dropdown base
  jQuery("<select />").appendTo("#main-menu-wrapper");
      
  // Create default option "Go to..."
  jQuery("<option />", {
    "selected": "selected",
    "value"   : "",
    "text"    : 'Go to....'
  }).appendTo("#main-menu-wrapper select");
      
  // Populate dropdown with menu items
  jQuery("#main-menu a").each(function() {
    var el = jQuery(this);
    jQuery("<option />", {
      "value"   : el.attr("href"),
      "text"    : el.text()
    }).appendTo("#main-menu-wrapper select");
  });
  
  // To make dropdown actually work
  jQuery("#main-menu-wrapper select").change(function() {
    window.location = jQuery(this).find("option:selected").val();
  });
  

});

$('.datepicker').appendDtpicker({
    "dateFormat": "YYYY-MM-DD",
    "dateOnly": true,
    "closeOnSelected": true,
    "autodateOnStart": false
    });

$('.datetimepicker').appendDtpicker({
    "dateFormat": "YYYY-MM-DD hh:mm",
    "closeOnSelected": true,
    "autodateOnStart": false
    });