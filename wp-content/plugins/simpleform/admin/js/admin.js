(function( $ ) {
	'use strict';
	
	 $( window ).load(function() {

       $("ul#submissions-data").hover(function () {
          $('#last-submission').addClass('unseen');
          $('#submissions-notice').removeClass('unseen');
          }, function () {
          $('#last-submission').removeClass('unseen');
          $('#submissions-notice').addClass('unseen');
       });
       
       $('.copy').click(function() {
         var tempInput = document.createElement('input');
         tempInput.style = "position: absolute; left: -1000px; top: -1000px";
         document.body.appendChild(tempInput);
         tempInput.value = $('#shortcode').text();
         tempInput.select();
         document.execCommand("copy");
         document.body.removeChild(tempInput);
         $('#shortcode-copy').val(ajax_sform_settings_options_object.copied);
         setTimeout(function(){ $('#shortcode-copy').val(ajax_sform_settings_options_object.copy); }, 30000); 
       });          

       $('#name-field').on('change', function () {
         var selectVal = $("#name-field option:selected").val();
         if ( selectVal == 'hidden' ) { $('.trname').addClass('unseen'); }
         else { $('.trname').removeClass('unseen'); 
	        if($('#namelabel').prop('checked') == true) { 
            $('tr.namelabel').addClass('unseen'); 
            } else { 
	        $('tr.namelabel').removeClass('unseen'); 
            }
	     }
       });          

       $('#lastname-field').on('change', function () {
         var selectVal = $("#lastname-field option:selected").val();
         if ( selectVal == 'hidden' ) { $('.trlastname').addClass('unseen'); }
         else { $('.trlastname').removeClass('unseen');
	        if($('#lastnamelabel').prop('checked') == true) { 
            $('tr.lastnamelabel').addClass('unseen'); 
            } else { 
	        $('tr.lastnamelabel').removeClass('unseen'); 
            }
	     }
       });          

       $('#email-field').on('change', function () {
         var selectVal = $("#email-field option:selected").val();
         if ( selectVal == 'hidden' ) { $('.tremail').addClass('unseen'); }
         else { $('.tremail').removeClass('unseen'); 
	        if($('#emaillabel').prop('checked') == true) { 
            $('tr.emaillabel').addClass('unseen'); 
            } else { 
	        $('tr.emaillabel').removeClass('unseen'); 
            }
         }
       });          

       $('#phone-field').on('change', function () {
         var selectVal = $("#phone-field option:selected").val();
         if ( selectVal == 'hidden' ) { $('.trphone').addClass('unseen'); }
         else { $('.trphone').removeClass('unseen'); 
	        if($('#phonelabel').prop('checked') == true) { 
            $('tr.phonelabel').addClass('unseen'); 
            } else { 
	        $('tr.phonelabel').removeClass('unseen'); 
            }
	     }
       });          

       $('#subject-field').on('change', function () {
         var selectVal = $("#subject-field option:selected").val();
         if ( selectVal == 'hidden' ) { $('.trsubject').addClass('unseen'); }
         else { $('.trsubject').removeClass('unseen'); 
	        if($('#subjectlabel').prop('checked') == true) { 
            $('tr.subjectlabel').addClass('unseen'); 
            } else { 
	        $('tr.subjectlabel').removeClass('unseen'); 
            }
         }
       });          

       $('#captcha-field').on('change', function () {
         var selectVal = $("#captcha-field option:selected").val();
         if ( selectVal == 'hidden' ) { $('.trcaptcha').addClass('unseen'); }
         else { $('.trcaptcha').removeClass('unseen'); }
       });          
       
       $('#preference-field').on('change', function () {
         var selectVal = $("#preference-field option:selected").val();
         if ( selectVal == 'hidden' ) { $('.trpreference').addClass('unseen'); }
         else { $('.trpreference').removeClass('unseen'); }
       }); 
       
       $('#consent-field').on('change', function () {
         var selectVal = $("#consent-field option:selected").val();
         if ( selectVal == 'hidden' ) { $('.trconsent').addClass('unseen'); }
         else { $('.trconsent').removeClass('unseen'); 
           if($('#privacy-link').prop('checked') == true) { 
           $('.trpage').removeClass('unseen'); 
           } 
           else { 
	       $('.trpage').addClass('unseen'); 
           }
         }
       });     
       
       $("#privacy-link").on("click", function() {
 	     var label = $('#consent-label').val();
         var string = ajax_sform_settings_options_object.privacy;
         if($(this).prop('checked') == true) { 
          $('.trpage').removeClass('unseen'); 
         } 
         else { 
	      $('.trpage').addClass('unseen'); 
          var pattern = new RegExp('<a [^>]*>' + string + '<\/a>', 'i');
          var nolink = label.replace(pattern, string);
          $('#consent-label').val(nolink);
          $('#privacy-page').val('');
          $('#set-page').addClass('unseen'); 
          $('#set-page').attr('page',0);
          $('#post-status').html('&nbsp;');
         }
       });
       
       $('#privacy-page').on('change', function () {
          var selectVal = $(this).val();
          var page = $('#set-page').attr('page');
          if ( selectVal != '' ) { 
	        $('#page-id').val(selectVal);       
	        if ( selectVal == page ) { $('#set-page').addClass('unseen'); } 
	        else { $('#set-page').removeClass('unseen'); } 
	      } 
          else { $('#set-page').addClass('unseen'); $('#privacy-link').click(); }
       });          
              
       $('#set-page').click(function(e){
          $('#label-error').html('');
          var string = $('textarea[name="consent-label"]').val();
          var id = $('input[name="page-id"]').val();
          var nonce = $('input[name="verification_nonce"]').val();
		  $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_sform_settings_options_object.ajaxurl,
            data: {
              action: "setting_privacy",
              'verification_nonce': nonce,
	          'page-id': id,
	          'consent-label': string,
            },    
            success: function(data){
	          if( data.error === true ){
                $('#label-error').html('Error occurred during creation of the link');
              }
	          if( data.error === false ){                
                $('#consent-label').val(data.label);
                $('#set-page').addClass('unseen');
                $('#set-page').attr('page',id);
              }
            },
 			error: function(data){
              $('#label-error').html('Error occurred during creation of the link');
	        } 	
		  });
		  e.preventDefault();
		  return false;
	   });
       
       $(".field-label").on("click", function() {
         var labelID = $(this).attr('id')
         if($(this).prop('checked') == true) { 
         $('tr.'+labelID).addClass('unseen'); 
         } 
         else { 
	     $('tr.'+labelID).removeClass('unseen'); 
         }
       });
       
       $("#required-sign").on("click", function() {
          if($(this).prop('checked') == true) { 
	      $('.trsign').addClass('unseen');
          } 
          else { 
          $('.trsign').removeClass('unseen'); 
          } 
       });
       
       $(".nav-tab").on("click", function() {
          var SettingsID = $(this).attr('id')
	      $( ".nav-tab-active" ).removeClass( "nav-tab-active" );
	      $( ".navtab" ).addClass('unseen');  
          $( '#tab-' + SettingsID ).removeClass('unseen');	   
	      $( this ).addClass( "nav-tab-active" );
	      if ( SettingsID == 'appearance' ) { $(".editorpage").text(ajax_sform_settings_options_object.appearance); }
	      else { $(".editorpage").text(ajax_sform_settings_options_object.builder); }
       });
       
       $('#form-template').on('change', function () {
         var selectVal = $("#form-template option:selected").val();
	         if ( selectVal == 'customized' ) { 
		         $("#template-notice").text(ajax_sform_settings_options_object.notes); 
		         $("#widget-template-notice").text(ajax_sform_settings_options_object.widgetnotes); }
             else { $("#template-notice").html('&nbsp;'); $("#widget-template-notice").html('&nbsp;'); }		
       });          
       
       $("#stylesheet").on("click", function() {
          if($(this).prop('checked') == true) { 
	      $('.trstylesheet').removeClass('unseen');
          } 
          else { 
          $('.trstylesheet').addClass('unseen'); 
          } 
       });
      
	   $("#stylesheet-file").on("click", function() {
         if($(this).prop('checked') == true) { 
			$('#stylesheet-description').html(ajax_sform_settings_options_object.cssenabled); 
			$('#widget-stylesheet-description').html(ajax_sform_settings_options_object.widgetcss); 
	     } 
	     else { 
		    $('#stylesheet-description').html(ajax_sform_settings_options_object.cssdisabled); 
			$('#widget-stylesheet-description').html(ajax_sform_settings_options_object.cssdisabled); 
		 }
       });
       
	   $("#javascript").on("click", function() {
         if($(this).prop('checked') == true) { 
			$('#javascript-description').html(ajax_sform_settings_options_object.jsenabled); 
			$('#widget-javascript-description').html(ajax_sform_settings_options_object.widgetjs); 
	     } 
	     else { 
		    $('#javascript-description').html(ajax_sform_settings_options_object.jsdisabled); 
		    $('#widget-javascript-description').html(ajax_sform_settings_options_object.jsdisabled); 
		 }
       });
       
       $('#outside-error').on('change', function () {
          var selectVal = $("#outside-error option:selected").val();
	      var text = $("label#focusout").html();
          if ( selectVal != 'none' ) {
			  $('.out').each(function(i, obj) {
              var elem = $( obj );
  	          if ( selectVal == 'top' ) { var placeholder = elem.attr("placeholder").replace(ajax_sform_settings_options_object.bottom, ajax_sform_settings_options_object.top); }
	          if ( selectVal == 'bottom' ) { var placeholder = elem.attr("placeholder").replace(ajax_sform_settings_options_object.top, ajax_sform_settings_options_object.bottom); }
    	      console.log(elem.attr("placeholder"));
	          elem.attr("placeholder", placeholder);
          });
          }
	      if ( selectVal == 'top' ) {
                 $("label#focusout").html(text.replace(ajax_sform_settings_options_object.nofocus, ajax_sform_settings_options_object.focusout));
		         $("#outside-notice").text(ajax_sform_settings_options_object.topnotes);
                 $('.troutside').removeClass('removed');
                 if ( $('#trcaptcha').hasClass('unseen') ) { 
    	           $('.messagecell').removeClass('last'); 
	             }
	             else { 
	               $('.captchacell').removeClass('last'); 
	             }
		  }
	      else if ( selectVal == 'bottom' ) {
                 $("label#focusout").html(text.replace(ajax_sform_settings_options_object.nofocus, ajax_sform_settings_options_object.focusout));
		         $("#outside-notice").text(ajax_sform_settings_options_object.bottomnotes);
	             $('.troutside').removeClass('removed');
                 if ( $('#trcaptcha').hasClass('unseen') ) { $('.messagecell').removeClass('last'); }
	             else { $('.captchacell').removeClass('last'); }
		  }
          else { 
                 $("label#focusout").html(text.replace(ajax_sform_settings_options_object.focusout, ajax_sform_settings_options_object.nofocus));
                 $("#outside-notice").html('&nbsp;');
	             $('.troutside').addClass('removed');
                 if ( $('#trcaptcha').hasClass('unseen') ) {  $('.messagecell').addClass('last'); }
	             else { $('.captchacell').addClass('last'); }
	      }		
       });      
       
	   $("#characters-length").on("click", function() {
         if($(this).prop('checked') == true) { 
			$('#characters-description').html(ajax_sform_settings_options_object.showcharacters); 
		    $('#incomplete-name').val(ajax_sform_settings_options_object.numnamer);
		    $('#incomplete-lastname').val(ajax_sform_settings_options_object.numlster);
		    $('#incomplete-subject').val(ajax_sform_settings_options_object.numsuber);
		    $('#incomplete-message').val(ajax_sform_settings_options_object.nummsger);
	     } 
	     else { 
		    $('#characters-description').html(ajax_sform_settings_options_object.hidecharacters); 
		    $('#incomplete-name').val(ajax_sform_settings_options_object.gennamer);
		    $('#incomplete-lastname').val(ajax_sform_settings_options_object.genlster);
		    $('#incomplete-subject').val(ajax_sform_settings_options_object.gensuber);
		    $('#incomplete-message').val(ajax_sform_settings_options_object.genmsger);
		 }
       });
       
       $("#ajax-submission").on("click", function() {
          if($(this).prop('checked') == true) { 
	       $('.trajax').removeClass('unseen');
           $('#thserver, #tdserver').removeClass('last');          
         } 
          else { 
           $('.trajax').addClass('unseen'); 
           $('#thserver, #tdserver').addClass('last');
        } 
       });

       $("#confirmation-message").on("click", function() {
         if($(this).prop('checked') == true) { 
         $('.trsuccessmessage').removeClass('unseen'); 
         $('.trsuccessredirect').addClass('unseen'); 
         $('#confirmation-page').val('');
         $('#post-status').html('&nbsp;');
         } 
       });

       $("#success-redirect").on("click", function() {
         if($(this).prop('checked') == true) { 
         $('.trsuccessmessage').addClass('unseen'); 
         $('.trsuccessredirect').removeClass('unseen'); 
         } 
       });

       $('#confirmation-page, #privacy-page').on('change', function () {
	     var element = $(this).find('option:selected'); 
         var value = element.attr("value"); 
         var Tag = element.attr("Tag"); 
         if ( Tag == 'draft' ) { 
             $("#post-status").html(ajax_sform_settings_options_object.status + ' - <strong><a href="'+ ajax_sform_settings_options_object.adminurl +'post.php?post=' + value + '&action=edit" target="_blank" style="text-decoration: none; color: #9ccc79;">' + ajax_sform_settings_options_object.publish + '</a></strong>');
	     }
         else { 
	       if ( value != '' ) {
             var editlink = '<strong><a href="'+ ajax_sform_settings_options_object.adminurl +'post.php?post=' + value + '&action=edit" target="_blank" style="text-decoration: none;">' + ajax_sform_settings_options_object.edit + '</a></strong>';
             var viewlink = '<strong><a href="'+ ajax_sform_settings_options_object.pageurl +'/?page_id=' + value + '" target="_blank" style="text-decoration: none;">' + ajax_sform_settings_options_object.view + '</a></strong>';
             var link = ajax_sform_settings_options_object.pagelinks.replace(ajax_sform_settings_options_object.edit, editlink);
             var links = link.replace(ajax_sform_settings_options_object.view, viewlink);
             $("#post-status").html(links);
           }
           else {
             $("#post-status").html('&nbsp;');
           }
	     }		         
       });          

       $("#smpt-warnings").on("click", function() {
         if( $('.smpt-warnings').hasClass('unseen') ) { $(this).text(ajax_sform_settings_options_object.hide); $('.smpt-settings').addClass('unseen'); $('.smpt-warnings').removeClass('unseen'); } 
         else { 
	       $(this).text(ajax_sform_settings_options_object.show); 
	       $('#trsmtpon').removeClass('unseen'); 
	       $('.smpt-warnings').addClass('unseen'); 
	       if( $('#server-smtp').prop('checked') == true ){ 
		       $('.trsmtp').removeClass('unseen'); 
		       if( $('#smtp-authentication').prop('checked') == true ){ $('.trauthentication').removeClass('unseen'); } 
		       else { $('.trauthentication').addClass('unseen'); } 
		   } 
		   else { $('.trsmtp').addClass('unseen'); } 
         }
       });

       $("#server-smtp").on("click", function() {
         if($(this).prop('checked') == true) { 
           $('.trsmtp').removeClass('unseen'); 
           $('#thsmtp, #tdsmtp').addClass('first');
           $('#thsmtp, #tdsmtp').removeClass('wide');
           $('#smtp-notice').removeClass('invisible');
           if ($('#smtp-authentication').prop('checked') == true) { $('.trauthentication').removeClass('unseen'); } 
           else { $('.trauthentication').addClass('unseen'); } 
         } 
         else { 
           $('.trsmtp').addClass('unseen'); 
           $('#thsmtp, #tdsmtp').addClass('wide');
           $('#thsmtp, #tdsmtp').removeClass('first');          
           $('#smtp-notice').addClass('invisible');
         }
       });

       $("#smtp-authentication").on("click", function() {
          if($(this).prop('checked') == true) { 
	      $('#thauthentication, #tdauthentication').removeClass('last'); 
	      $('.trauthentication').removeClass('unseen'); 
          } 
          else { 
	      $('#thauthentication, #tdauthentication').addClass('last'); 
	      $('.trauthentication').addClass('unseen'); 
          }  
       });
       
       $("#notification").on("click", function() {
          if($(this).prop('checked') == true) { 
          $('.trnotification').removeClass('unseen'); 
          $('#thnotification, #tdnotification').addClass('first');
          $('#thnotification, #tdnotification').removeClass('wide');
            if ($('#custom-name').prop('checked') == true) { $('.trcustomname').removeClass('unseen'); } 
            else { $('.trcustomname').addClass('unseen'); } 
            if( $('#default-subject').prop('checked') == true){ $('.trcustomsubject').removeClass('unseen'); } 
            else { $('.trcustomsubject').addClass('unseen'); } 
          } 
          else { 
          $('.trnotification').addClass('unseen'); 
          $('#thnotification, #tdnotification').addClass('wide');
          $('#thnotification, #tdnotification').removeClass('first');
          }
       });

       $("#requester-name").on("click", function() {
         if($(this).prop('checked') == true) { $('.trcustomname').addClass('unseen'); } 
         else { $('.trcustomname').removeClass('unseen'); }
       });
       
       $("#form-name").on("click", function() {
         if($(this).prop('checked') == true) { $('.trcustomname').addClass('unseen'); } 
         else { $('.trcustomname').removeClass('unseen'); }
       });
       
       $("#custom-name").on("click", function() {
         if($(this).prop('checked') == true) { $('.trcustomname').removeClass('unseen'); } 
         else { $('.trcustomname').addClass('unseen'); }
       });

       $("#request-subject").on("click", function() {
         if($(this).prop('checked') == true) { $('.trcustomsubject').addClass('unseen'); } 
         else { $('.trcustomsubject').removeClass('unseen'); }
       });
       
       $("#default-subject").on("click", function() {
         if($(this).prop('checked') == true) { $('.trcustomsubject').removeClass('unseen'); } 
         else { $('.trcustomsubject').addClass('unseen'); }
       });

       $("#autoresponder").on("click", function() {
         if($(this).prop('checked') == true) { 
           $('.trconfirmation').removeClass('unseen'); 
           $('#thconfirmation, #tdconfirmation').addClass('first');
           $('#thconfirmation, #tdconfirmation').removeClass('wide');
         } 
         else { 
	       $('.trconfirmation').addClass('unseen'); 
           $('#thconfirmation, #tdconfirmation').addClass('wide');
           $('#thconfirmation, #tdconfirmation').removeClass('first');
         }
       });
       
	   $('#save-settings').click(function(e){
	      $('.message').removeClass('error success unchanged');
	      $('.message').addClass('seen');
          $('.message').html(ajax_sform_settings_options_object.loading);
          var formData = $('form#settings').serialize();
		  $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_sform_settings_options_object.ajaxurl,
            data: formData + '&action=sform_edit_options', 
            success: function(data){
	          var error = data['error'];
	          var message = data['message'];
	          var update = data['update'];
	          if( error === true ){
	            $('.message').addClass('error');
                $('.message').html(data.message);
              }
	          if( error === false ){
                $('.message').html(data.message);
	            if( update === false ) { 
		            $('.message').addClass('unchanged');
		        }
	            if( update === true ) { 
		            $('.message').addClass('success');
		        }
              }
            },
 			error: function(data){
              $('.message').html('AJAX call failed');
	        } 	
		  });	
		  e.preventDefault(); 
		  return false;
	   });

       $(document).on('change', 'input[type=checkbox], input[type=radio], select', function() {
	      $('.message').removeClass('seen error success unchanged');
       });

       $(document).on('input', 'input[type=text], input[type=email], textarea', function() {
	      $('.message').removeClass('seen error success unchanged');
       });

       $('#save-attributes').click(function(e){
	      $('.message').removeClass('error success unchanged');
	      $('.message').addClass('seen');
          $('.message').text(ajax_sform_settings_options_object.saving);
          var formData = $('form#attributes').serialize();
		  $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_sform_settings_options_object.ajaxurl,
            data: formData + '&action=shortcode_costruction', 
            success: function(data){
	          var error = data['error'];
	          var message = data['message'];
	          var update = data['update'];
	          if( error === true ){
	            $('.message').addClass('error');
                $('.message').html(data.message);
              }
	          if( error === false ){
                $('.message').html(data.message);
	            if( update === false ){
	              $('.message').addClass('unchanged');
                }
	            if( update === true ){
	              $('.message').addClass('success');
                }
              }
            },
 			error: function(data){
              $('.message').html('AJAX call failed');
	        } 	
		  });
		  e.preventDefault();
		  return false;
	   });
	   	   
	   $(document).on('change','.sfwidget',function(){
 	     var box = $(this).attr('box');
         var selectVal = $(this).val();
         if ( selectVal === 'all' ) { 
	         $('div#sform-widget-hidden-pages.'+box).addClass('unseen');
 	         $('div#sform-widget-visible-pages.'+box).addClass('unseen');
 	         $('p#visibility-notes').removeClass('unseen');
 	         $('p#visibility').addClass('visibility');
 	     }
         else {
	         $('p#visibility-notes').addClass('unseen'); 
 	         $('p#visibility').removeClass('visibility');
 
	         if ( selectVal === 'hidden' ) {
	         $('div#sform-widget-hidden-pages.'+box).removeClass('unseen'); 
	         $('div#sform-widget-visible-pages.'+box ).addClass('unseen');
	         }
	         else {
	         $('div#sform-widget-hidden-pages.'+box).addClass('unseen'); 
	         $('div#sform-widget-visible-pages.'+box ).removeClass('unseen');
	         }
	     }
       });       
       
	   $(document).on('click','.sform-widgetbox',function(){    
	     var box = $(this).attr('box');
         if($(this).prop('checked') == true) { 
           $('.'+box).removeClass('unseen'); 
         } 
         else { 
	       $('.'+box).addClass('unseen'); 
         }
       });

	   $('#form').change(function(){
         var id = $(this).val();
         var url = $(location).attr('href');
         const urlParams = new URLSearchParams(url);
         const currentid = urlParams.get('form');
         if (url.indexOf('form=') > -1) {
           var redirect_url = url.replace('&form=' + currentid, '&form=' + id);
         } else {
           var redirect_url = url + '&form=' + id;
         }
         document.location.href = redirect_url;
        });

	   $('#widget').change(function(){
         var id = $(this).val();
         var url = $(location).attr('href');
         const urlParams = new URLSearchParams(url);
         const currentid = urlParams.get('id');
         if (url.indexOf('id=') > -1) {
           var redirect_url = url.replace('&id=' + currentid, '&id=' + id);
         } else {
           var redirect_url = url + '&id=' + id;
         }
         document.location.href = redirect_url;
        });
        
       $( "#edit-widget" ).hover( function() { 
           $('#widget-notes').removeClass('invisible'); 
	     }, function() { 
           $('#widget-notes').addClass('invisible'); 
	   });             

       $(".widgetfield").on("click", function() {
	     var field = $(this).attr('field');
         if($(this).prop('checked') == true) { 
         $('.tr'+field).addClass('secret'); 
         } 
         else { $('.tr'+field).removeClass('secret'); 
	        if($('#'+field+'label').prop('checked') == true) { 
            $('tr.'+field+'label').addClass('unseen'); 
            } else { 
	        $('tr.'+field+'label').removeClass('unseen'); 
            }
	     }
       });

	   $("#admin-notices").on("click", function() {
         if($(this).prop('checked') == true) { 
			$('.admin-notices').addClass('invisible'); 
	     } 
	     else { 
		    $('.admin-notices').removeClass('invisible'); 
		 }
       });

   	 });

})( jQuery );