(function( $ ) {
	'use strict';
	
	 $( window ).load(function() {

	   $("#data-storing").on("click", function() {
         if($(this).prop('checked') == true) { 
            $('#thstoring, #tdstoring').removeClass('wide');
            $('#thstoring, #tdstoring').addClass('first');          
	        $('.trstoring').removeClass('unseen'); 
			$('#storing-description').html(sform_submissions_object.disable); 
	     } 
	     else { $('.trstoring').addClass('unseen'); 
            $('#thstoring, #tdstoring').addClass('wide');
            $('#thstoring, #tdstoring').removeClass('first');          
		    $('#storing-description').html(sform_submissions_object.enable); 
		 }
       });
       
   
   	 });

})( jQuery );