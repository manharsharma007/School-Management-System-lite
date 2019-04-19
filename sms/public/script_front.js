jQuery(document).ready(function ($){

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




  
  

	});