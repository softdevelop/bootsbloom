$(document).ready(function() {

    if(!are_cookies_enabled()){
        noty({
            "text":function_please_enable_cookies,
            "theme":"noty_theme_default",
            "layout":"top",
            "type":"error",
            "animateOpen":{
                "height":"toggle"
            },
            "animateClose":{
                "height":"toggle"
            },
            "speed":500,
            "timeout":5000,
            "closeButton":true,
            "closeOnSelfClick":false,
            "closeOnSelfOver":false,
            "modal":true
        });    
    }
    
    //Default Action
    $(".tab_content").hide(); //Hide all content
    $("ul.tabs li:first").addClass("active").show(); //Activate first tab
    $(".tab_content:first").show(); //Show first tab content
	
    //On Click Event
    $("ul.tabs li").click(function() {
        $("ul.tabs li").removeClass("active"); //Remove any "active" class
        $(this).addClass("active"); //Add "active" class to selected tab
        $(".tab_content").hide(); //Hide all tab content
        var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
        $(activeTab).fadeIn(); //Fade in the active content
        return false;
    });

     $("#loadMoreContent").live('click', function(){
         $("#loadmore_loader").show();
         $("#loadMoreContent").hide();
            $.ajax({
                url:(this).href
            }).done(function(b){
                data   =   b.split("=================");
                data[1]    =   $.trim(data[1]);
                $("#loadMoreContent").show();
                if(data[1]!=''){
                    $("#loadMoreContent").attr('href',data[1]);
                   
                }else{
                    $("#loadMoreContent").hide();
                
                }
                $("#loading_content").append(data[0]);
                $("#loadmore_loader").hide();
                
            });
            return false;
        });

    $("#menu-sub > .dropdown > a").click(function(a){
        a.preventDefault();
        var b=$(this).closest(".dropdown");
        var parent_id = $(this).parent().attr('id');
        $(".dropdown-child",b);
        var c=!0;
        b.addClass("selected");
        b.find("span.count").remove();
        $(document).bind("click."+b.attr("id"),function(a){
            c?c=!1:$(a.target).parents(".dropdown-child").length||($(document).unbind("click."+b.attr("id")),b.removeClass("selected"))
            if(b.hasClass('selected')){
                if(parent_id=='menu-sub-me'){
                    $.ajax({
                        type: "POST",
                        url: WEBSITE_URL+'projects/get_user_created_projects'

                    }).done(function(data) { 
                        $("#menu-me-created").html(data);
                    });
                }
                if(parent_id=='menu-sub-message'){
                    $('#menu-messages-list').load(WEBSITE_URL+'latestmessages');
                }
                if(parent_id=='menu-sub-activity'){
                        $('#menu-activity-list').load(WEBSITE_URL+'notifications/getrecent_notifications');
                }
            }
        });
    });
    
    $("#accept_project_agreement").click(function(){
        if($("#accept_project_agreement").is(':checked')){
          
            $("#project_submit_button").addClass('button_blue');
            $("#project_submit_button").removeClass('button_grey');
        }else{
            $("#project_submit_button").removeClass('button_blue');
            $("#project_submit_button").addClass('button_grey');
        }
    });
    
    $("#project_submit_button").click(function(){
        if($("#accept_project_agreement").is(':checked')){
            $('#saving-layer').show();
            $("#ProjectCreateForm").submit(); 
        }
    });

    $("#logout_link").click(function(){
        $.ajax({
            type: "POST",
            url: HOST_URL+$("#logout_link").attr('href')
        }).done(function(data) { 
            data    =   $.trim(data);
            data    =   data.substring(1);
            FB.logout();
            $('#saving-layer').hide();
            window.location.href=WEBSITE_URL+data;
            return false;
        });
        return false;
    });    

    $("#disconnect_fb").click(function(){
        disconnect_facebook();
        return false;
    });
    
    $('textarea[maxlength]').live('keyup blur', function() {
		// Store the maxlength and value of the field.
		var maxlength = $(this).attr('maxlength');
		var val = $(this).val();
		// Trim the field if it has content over the maxlength.
		if (val.length > maxlength) {
			$(this).val(val.slice(0, maxlength));
		}
	});
	
	var reply_email	=	GetURLParameter();	
	if(reply_email=='email'){
		$("#reply-container").slideDown(400,"easeOutQuad",function(){$(this).find("#message_body").focus()});
	}
	
    $("#reply").live("click",function(a){a.preventDefault();a=$("#reply-container");a.is(":visible")?a.slideUp(400,"easeOutQuad"):a.slideDown(400,"easeOutQuad",function(){$(this).find("#message_body").focus()})});
	
	$("form#new_message").live("submit",function(a){a.preventDefault();var c=$(this);c.hasClass("disabled") || $.ajax({type:c.attr("method"),url:c.attr("action"),data:c.serialize(),success:function(d){d=$.trim(d);if(d=='error'){c.find("textarea").addClass("field_with_errors")}else{c.closest(".ajax-container").html(d)}},complete:function(){c.removeClass("disabled")}})});
	
	var $container 	= $('#am-container'),
		$imgs		= $container.find('img').hide(),
		totalImgs	= $imgs.length,
		cnt			= 0;
	if(totalImgs > 0){	
		$imgs.each(function(i) {
			var $img	= $(this);
			$(this).mouseover(function(){
				$(this).stop().animate( {opacity : '1.0'}, 300 );
			}).mouseleave(function(){
				$(this).stop().animate( {opacity : '0.7'}, 300 );
			})
			$('<img/>').load(function() {
				++cnt;
				if( cnt === totalImgs ) {
					$imgs.show().animate( {opacity : '0.7'}, 300 );
					$container.montage({
						fillLastRow	: true,
						alternateHeight	: true,
						alternateHeightRange : {
							min	: 108,
							max	: 108
						},
						margin : 3
					});
				}
			}).attr('src',$img.attr('src'));
		});	
	}
});

function GetURLParameter(ref) {
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('?');
	for (var i = 0; i < sURLVariables.length; i++) 
	{
		var sParameterName = sURLVariables[i].split('?');
		if (sParameterName[0] == 'ref=email') 
		{
			var sParameterName = sURLVariables[i].split('=');
			return sParameterName[1];
			
		}
	}
}

function are_cookies_enabled() {
    var cookieEnabled = (navigator.cookieEnabled) ? true : false;

    if (typeof navigator.cookieEnabled == "undefined" && !cookieEnabled)
    { 
        document.cookie="testcookie";
        cookieEnabled = (document.cookie.indexOf("testcookie") != -1) ? true : false;
    }
    return (cookieEnabled);
}

function forgot_password() {
      $('#saving-layer').css({
        'display':'block'
    });
    $.get(WEBSITE_URL+'users/forgot-password',function(r){
        noty(
        {
            "text":r,
            'type':'alert',
            "layout":"center",
            "animateOpen":{
                "height":"toggle"
            },
            "animateClose":{
                "height":"toggle"
            },
            "speed":500,
            timeout: false,
            "closeButton":true,
            "closeOnSelfClick":false,
            "closeOnSelfOver":false,
            "modal":true,
            "buttons": [
            {
                "type": 'btn btn-primary', 
                "text": 'Submit', 
                click: function($noty) {
                    $.ajax({
                        type: "POST",
                        url: WEBSITE_URL+'users/forgot-password',
                        data: $('#UserForgotPasswordForm').serialize()
                    }).done(function(forgot_password) {
                        var password =   $.trim(forgot_password);
                        if(password!='success'){
			    $(".noty_text").empty();
                            $(".noty_text").html(password);
                            return false;
                        }else{
                            $noty.close();
                            noty({
                                "animateOpen":{
                                    "height":"toggle"
                                },
                                "animateClose":{
                                    "height":"toggle"
                                },
                                "force": true, 
                                "closeButton":true,
                                "layout" : "top", 
                                "text": function_instructions_reset_password, 
                                "type": 'information',
                                "model":true
                            });
                        }
                      
                    });	
                }
            },
            {
                "type": 'btn btn-danger', 
                "text": 'Cancel', 
                click: function($noty) {
                    $noty.close();        
                }
            }	   
            ]
        });    
    $('#saving-layer').hide();
    return false;
    });
    return false;
}

function contact_us() {
    $('#saving-layer').show();
    $.get(WEBSITE_URL+'pages/pages/contact_us',function(r){
        $('#saving-layer').hide();
        noty(
        {
            "text":r,
            'type':'alert',
            "layout":"topCenter",
            "animateOpen":{
                "height":"toggle"
            },
            "animateClose":{
                "height":"toggle"
            },
            "speed":500,
            "timeout":90000,
            "closeButton":true,
            "closeOnSelfClick":false,
            "closeOnSelfOver":false,
            "modal":true,
            "buttons": [
            {
                "type": 'btn btn-primary', 
                "text": 'Submit', 
                click: function($noty) {
                    $.ajax({
                        type: "POST",
                        url: WEBSITE_URL+'pages/pages/contact_us',
                        data: $('#PageContactUsForm').serialize()
                    }).done(function(data) { 
                        data    =   $.trim(data);
                        if(data!='success'){
                            $(".noty_text").empty();
                            $(".noty_text").html(data);
                        }else{
                            $noty.close();
                            noty({
                                "force": true, 
                                "closeButton":true,
                                "layout" : "top", 
                                "text": function_meaasge_send_team_contact_soon, 
                                "type": 'information',
                                "model":true
                            });
                        }
						
                                
                    })
                }
            },
            {
                "type": 'btn btn-danger', 
                "text": 'Cancel', 
                click: function($noty) {
                    $noty.close();         
                }
            } 
            ]
        });    
    });
}
		
function subscribe_newsletter(form_id) {
    $.ajax({
        type: "POST",
        url: WEBSITE_URL+'newsletters/subscribe_newsletter',
        data: $('#'+form_id).serialize(),
        success:function(result){
           result_splite=	result.split('||');
            result_splite[0]= $.trim(result_splite[0]);
            if(result_splite[0]=='error'){
                var type= 'error';
            }else{
                var type= 'success';
            }
            noty({
                "text":result_splite[1],
                "theme":"noty_theme_default",
                "layout":"top",
                "type":type,
                "animateOpen":{
                    "height":"toggle"
                },
                "animateClose":{
                    "height":"toggle"
                },
                "speed":500,
                "timeout":5000,
                "closeButton":true,
                "closeOnSelfClick":false,
                "closeOnSelfOver":false,
                "modal":true
            });    
        }
    })
    return false;
}

function addMore() { 
    var website = 	$("#website").val()
    if(website !=''){
        if(isValidURL(website)){
	 
            $('#addwebsite').append('<div id="web_'+count+'"  class=" fl pr112 pt10 grey13  ">&nbsp;<div  class="addmore fl ptb5 ml121 pl5"><input type="hidden" name="data[User][website][]"  id="web_'+count+'" value='+website+' />' + website+'<a href="javascript:void(0)" onClick="remove_webssite('+count+')" class="remove_lnk fr pr10 "> X</a></div></div>');
	
            count++;
            $("#counterweb").val(count);
            $("#website").val(''); 
	
        }else{
            noty({
                "text":function_invalid_url_check_again,
                "theme":"noty_theme_default",
                "layout":"top",
                "type":"error",
                "animateOpen":{
                    "height":"toggle"
                },
                "animateClose":{
                    "height":"toggle"
                },
                "speed":500,
                "timeout":5000,
                "closeButton":true,
                "closeOnSelfClick":false,
                "closeOnSelfOver":false,
                "modal":true
            });    
        }
	
    } else {
	
	
        noty({
            "text":function_please_enter_website_name,
            "theme":"noty_theme_default",
            "layout":"top",
            "type":"error",
            "animateOpen":{
                "height":"toggle"
            },
            "animateClose":{
                "height":"toggle"
            },
            "speed":500,
            "timeout":5000,
            "closeButton":true,
            "closeOnSelfClick":false,
            "closeOnSelfOver":false,
            "modal":true
        });    
		
    }
}

function addMoreWebsite() { 
    var website = 	$("#website").val()
    if(website !=''){
        if(isValidURL(website)){
            $('#addwebsite').append('<div id="web_'+count+'"  class=" pt10 grey13 ">&nbsp;<div  class="addmore fl ptb5 pl5"><input type="hidden" name="data[User][website][]"  id="web_'+count+'" value='+website+' />' + website+'<a href="javascript:void(0)" onClick="remove_webssite('+count+')" class="remove_lnk fr pr10 "> X</a></div></div>');
	    count++;
            $("#counterweb").val(count);
            $("#website").val(''); 
	
        }else{
            noty({
                "text":function_invalid_url_check_again,
                "theme":"noty_theme_default",
                "layout":"top",
                "type":"error",
                "animateOpen":{
                    "height":"toggle"
                },
                "animateClose":{
                    "height":"toggle"
                },
                "speed":500,
                "timeout":5000,
                "closeButton":true,
                "closeOnSelfClick":false,
                "closeOnSelfOver":false,
                "modal":true
            });    
        }
	
    } else {
	
	
        noty({
            "text":function_please_enter_website_name,
            "theme":"noty_theme_default",
            "layout":"top",
            "type":"error",
            "animateOpen":{
                "height":"toggle"
            },
            "animateClose":{
                "height":"toggle"
            },
            "speed":500,
            "timeout":5000,
            "closeButton":true,
            "closeOnSelfClick":false,
            "closeOnSelfOver":false,
            "modal":true
        });    	
    }
}

function remove_webssite(count) {	
    $("#web_"+count+"").remove();
    $("#counterweb").val(count);
}

function isValidURL(url) {
    var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;
    if(RegExp.test(url)){
        return true;
    }else{
        return false;
    }
}

function remove_image() {
    $.ajax({
        type: "POST",
        url: WEBSITE_URL+'users/remove-image',
    }).done(function(data) { 
				
        $('#new_image').children().fadeOut(500, function() {
            $('#new_image').empty();
            $('#image_hide').hide();
        });
    })
}
	
function hide_name() {
    $('#image_hide').hide();
    $('#image_display').hide();

}
		
function show_password() {

    $('#change_password').slideToggle(1000);
	
}

function check_password() {
    $('#saving-layer').css({
        'display':'block'
    });
   
   $.get(WEBSITE_URL+'users/check-password',function(r){
        $('#saving-layer').css({
            'display':'none'
        });
        noty(
        {
            "text":r,
            'type':'alert',
            "layout":"center",
            "animateOpen":{
                "height":"toggle"
            },
            "animateClose":{
                "height":"toggle"
            },
            "speed":500,
            "timeout":90000,
            "closeButton":true,
            "closeOnSelfClick":false,
            "closeOnSelfOver":false,
            "modal":true,
            "buttons": [
            {
                "type": 'btn btn-primary', 
                "text": 'Submit', 
                click: function($noty) {
				
                    check_password_authentication($noty);
                }
				
            },
            {
                "type": 'btn btn-danger', 
                "text": 'Cancel', 
                click: function($noty) {
                    $noty.close();              
                }
            }		   
            ]
        });    
    }); 
}

function verification_email() {      
    $('#saving-layer').show();
    $.ajax({
        type: "POST",
        url: WEBSITE_URL+'users/users/email_verification',
        success:function(verification_email_result){
            var email_result =   $.trim(verification_email_result);
            if(email_result!='success'){
                $('#saving-layer').hide();		
                noty({
                    "text":function_there_some_error_check_again,
                    "theme":"noty_theme_default",
                    "layout":"top",
                    "type":'error',
                    "animateOpen":{
                        "height":"toggle"
                    },
                    "animateClose":{
                        "height":"toggle"
                    },
                    "speed":500,
                    "timeout":5000,
                    "closeButton":true,
                    "closeOnSelfClick":false,
                    "closeOnSelfOver":false,
                    "modal":true
                }); 
				
				
            }else{
                $('#saving-layer').hide();
                noty({
                    "text":function_email_verification_send_to_email,
                    "theme":"noty_theme_default",
                    "layout":"top",
                    "type":'success',
                    "animateOpen":{
                        "height":"toggle"
                    },
                    "animateClose":{
                        "height":"toggle"
                    },
                    "speed":500,
                    "timeout":5000,
                    "closeButton":true,
                    "closeOnSelfClick":false,
                    "closeOnSelfOver":false,
                    "modal":true
                }); 
            }	
        }
    })
    return false;
}

function check_password_authentication($noty) {
    
    $('#saving-layer').css({
        'display':'block'
    });
    $.ajax({
        type: "POST",
        url: WEBSITE_URL+'users/check-password',
        data: $('#UserCheckPasswordForm').serialize()
    }).done(function(check_password_responce_r) {
						
        $('#saving-layer').css({
            'display':'none'
        });				
        var check_password_responce= $.trim(check_password_responce_r);				 
        if(check_password_responce!='success'){
            $(".noty_text").empty();
            $(".noty_text").html(check_password_responce);
     
        }else{
            $.ajax({
                type: "POST",
                url: WEBSITE_URL+'users/account-setting',
                data: $('#UserAccountSettingForm').serialize()
            }).done(function(account_setting_responce) { 
                var res =   $.trim(account_setting_responce);
                var blank='';
                $('#UserConPassword').val(blank);
                $('#UserNewPassword').val(blank);
                if(res!='success' && res!='new_password'){
                    $noty.close();
                    noty({
                        "animateOpen":{
                            "height":"toggle"
                        },
                        "animateClose":{
                            "height":"toggle"
                        },
                        "force": true, 
                        "closeButton":true,
                        "layout" :"top", 
                        "text": function_password_or_email_error, 
                        "type": 'error',
                        "model":true
                    });
                }else
                if(res!='new_password'){
                    $noty.close();
                    noty({
                        "animateOpen":{
                            "height":"toggle"
                        },
                        "animateClose":{
                            "height":"toggle"
                        },
                        "force": true, 
                        "closeButton":true,
                        "layout" :"top", 
                        "text": function_your_change_has_saved, 
                        "type": 'information',
                        "model":true
                    });
                } 
                else{
                    $noty.close();
                    noty({
                        "animateOpen":{
                            "height":"toggle"
                        },
                        "animateClose":{
                            "height":"toggle"
                        },
                        "force": true, 
                        "closeButton":true,
                        "layout" :"top", 
                        "text": function_current_password_not_accepted, 
                        "type": 'error',
                        "model":true
                    });
									    

                }		
            })  
        }
    });
                   
    return false;
}
  				
function change_country() {
    $('#country_name').css({
        'display':'none'
    });
   
    var input='<div id="country_search" class="aligncenter"><input type="text" id="ProjectCountry" class="input-text"  name ="data[Project][country]" onChange="new_country()" /> </div>';
    $('#country_search').html(input);
	
    $("#ProjectCountry").tokenInput(WEBSITE_URL+"projects/get_countries",{
        animateDropdown: false,
        tokenLimit: 1,
        hintText:false,
        minText:2,
        searchText:false
    });
  				
    $('.token-input-list').css('padding','0px');			
    $('#token-input-ProjectCountry').attr('style','');
    $('#token-input-ProjectCountry').attr('style','height:23px; width:210px; font-size:13px;padding-left:6px; border-radius: 3px 3px 3px 3px; -moz-transition-duration:0.4s; -moz-transition-property:all; background-color:#fff !important; background-image:-moz-linear-gradient(center top , #FFFFFF, #FFFFFF); border-color:#2583a7; box-shadow:0 0 5px #9fcada; height:26px; outline:medium none; ');
	
    $('#country_search').css({
        'display':'block'
    });
				
    $("#token-input-ProjectCountry").blur(function() {
        $("#country_search").css({
            'display':'none'
        });
        $('#country_name').css({
            'display':'block'
        });		
    });
}

function new_country() {
               
    $('#country_search').css({
        'display':'none'
    });
    $('#saving-layer').css({
        'display':'block'
    });
    $('#country_name').css({
        'display':'block'
    });
    var country = $('p').html();
    var country_array=country.split(',');					 
    if(country_array[1] !=null){
							
        $.ajax({
            type: "POST",
            url: WEBSITE_URL+'home/change_country',
            data: {
                "country":country_array[1]
            }
        }).done(function(project_country) { 
										
            $('#saving-layer').css({
                'display':'none'
            });		
            $('#project_slide').html(project_country);	
            $('#country').html(country_array[0]);		
        })
    }
}
  				
function change_city() {
    $('#country_name').css({
        'display':'none'
    });
    var input='<div id="country_search_1" class="aligncenter"><input type="text" id="ProjectCity" class="input-text"  name ="data[Project][city]"  /> </div>';
    $('#country_search').html(input);
    $("#ProjectCity").tokenInput(WEBSITE_URL+"projects/get_city",{
        animateDropdown: false,
        tokenLimit: 1,
        hintText:false,
        minText:2,
        searchText:'searching..',
        minChars: 3,
        onAdd:function(item){
            new_city(item.id)
        }
    });
    $('.token-input-list').css('padding','0px');			
    $('#token-input-ProjectCountry').attr('style','');
    $('#token-input-ProjectCountry').attr('style','height:23px; width:210px; font-size:13px;padding-left:6px; border-radius: 3px 3px 3px 3px; -moz-transition-duration:0.4s; -moz-transition-property:all; background-color:#fff !important; background-image:-moz-linear-gradient(center top , #FFFFFF, #FFFFFF); border-color:#2583a7; box-shadow:0 0 5px #9fcada; height:26px; outline:medium none; ');
	
    $('#country_search').css({
        'display':'block'
    });
    $("#token-input-ProjectCity").blur(function() {
        $("#country_search").css({
            'display':'none'
        });
        $('#country_name').css({
            'display':'block'
        });		
    });
}
						
function new_city(item) {
    $('#country_search').css({
        'display':'none'
    });
    $('#saving-layer').css({
        'display':'block'
    });
    $('#country_name').css({
        'display':'block'
    });
    var country_array=item.split('##');					 
    if(country_array[0] !=null){
        $.ajax({
            type: "POST",
            url: WEBSITE_URL+'home/change_country',
            data: {
                "city":country_array[0]
            }
        }).done(function(project_country) { 
										
            $('#saving-layer').css({
                'display':'none'
            });		
            $('#project_slide').html(project_country);	
            $('#country').html(country_array[1]);		
        })
    }
}

function disconnect_facebook() {
    $('#saving-layer').show();
    $.ajax({
        type: "POST",
        url: HOST_URL+$("#disconnect_fb").attr('href')
                               
    }).done(function(data) {
        data=$.trim(data);
        $('#fb_not_loged_in').show();
        $('#fb_loged_in').hide();
        $('#saving-layer').hide();
        FB.logout();
    });
}

function report_spam(message_id) {
    $('#saving-layer').show();
    $.get(WEBSITE_URL+'report_spam/'+message_id,function(r){
        $('#saving-layer').hide();
        noty(
        {
            "text":r,
            'type':'alert',
            "layout":"topCenter",
            "animateOpen":{
                "height":"toggle"
            },
            "animateClose":{
                "height":"toggle"
            },
            "speed":500,
            "timeout":90000,
            "closeButton":true,
            "closeOnSelfClick":false,
            "closeOnSelfOver":false,
            "modal":true,
            "buttons": [
            {
                "type": 'btn btn-primary', 
                "text": 'Report as spam', 
                click: function($noty) {
                    $.ajax({
                        type: "POST",
                        url: WEBSITE_URL+'set_as_spam/'+message_id,
                        data: $('#MessageReportSpamForm').serialize()
                    }).done(function(data) { 
                        data    =   $.trim(data);
                        if(data!='success'){
                            $(".noty_text").empty();
                            $(".noty_text").html(data);
                            
                        }else{
							$("#reportspam_"+message_id).hide();
                            $noty.close();
                            noty({
                                "force": true, 
                                "closeButton":true,
                                "layout" : "top", 
                                "text": function_meaasge_report_spam, 
                                "type": 'information',
                                "model":true
                            });
							
                        }
						
                                
                    })
                }
            },
            {
                "type": 'btn btn-danger', 
                "text": 'Cancel', 
                click: function($noty) {
                    $noty.close();         
                }
            } 
            ]
        });  
			$(".reportspam").hide();
    });
}
