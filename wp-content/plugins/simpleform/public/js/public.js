(function( $ ) {
	'use strict';
	
	 $( window ).load(function() {

      $("#sform").on("submit", function (e) { 
       
	   if( ! $(this).hasClass("needs-validation") && ! $(this).hasClass("block-validation") ) { 
	   
	      if( $( "#spinner" ).length ) {
	        $('#submission').addClass('d-none');
            $('#spinner').removeClass('d-none');
          }
          
	      if ( ajax_sform_processing.outside !== true  ) {                                            
          $('.message').addClass("invisible");
          }
	   
	      $('.form-control, #sform-consent, #captcha-question-wrap, .control-label').removeClass('is-invalid');
          $('#sform-error span').removeClass('visible');   
          var postdata = $('form#sform').serialize();
		  $.ajax({
            type: 'POST',
            dataType: 'json',
            url:ajax_sform_processing.ajaxurl, 
            data: postdata + '&action=formdata_ajax_processing',
            success: function(data){
              $('#spinner').addClass('d-none');
              $('#submission').removeClass('d-none');	            
	          var error = data['error'];
	          var showerror = data['showerror'];
	          var notice = data['notice'];
	          var label = data['label'];
	          var field = data['field'];
	          var redirect = data['redirect'];
	          var redirect_url = data['redirect_url'];
              if( error === true ){
	            $.each(data, function(field, label) {
	            $('#sform-' + field).addClass('is-invalid');
                $('label[for="sform-' + field + '"].control-label').addClass('is-invalid');              
                $('div#' + field + '-question-wrap').addClass('is-invalid');
                $('#' + field + '-error span').text(label);
	            if( $('#sform').hasClass("needs-focus") ) { $('input.is-invalid, textarea.is-invalid').first().focus(); }
	            else { $('#sform-error').focus(); }
                });
	            $('#sform-error span').addClass('visible');  
	            
	         if ( ajax_sform_processing.outside === true || ( ajax_sform_processing.outside !== true  && showerror === true ) ) {                                            
               $('.message').removeClass("invisible");
               $('.message').html(data.notice);
                }
                
              }
              if( error === false ){
                if( redirect === false ){
                  $("#sform, #sform-introduction, #sform-bottom").addClass('d-none');
                  $('#sform-confirmation').html(data.notice);
                  $('#sform-confirmation').focus();
                }
                else {
	              document.location.href = redirect_url;
                  $('#sform-error span').removeClass('visible');                                                
                }
              }
            },
 			error: function(data){
              $('#spinner').addClass('d-none');
              $('#submission').removeClass('d-none');	            
              $('.message').removeClass("invisible");
              $('#sform-error span').addClass('visible');                                                
              $('.message').html(ajax_sform_processing.ajax_error);
              $('#sform-error').focus();
	        } 	
		  });
		  e.preventDefault();
		  return false;
	   }	  
		  
	  });
   
   	 });

})( jQuery );