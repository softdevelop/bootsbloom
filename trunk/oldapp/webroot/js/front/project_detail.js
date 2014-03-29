$(function() {
    
    $("#see_full_bio").click(function(){
        $('#bio_info').modal({
            minHeight:500,
            minWidth:800
        })
                     
    });
        
    if(open_ask_question==1){
	
        open_ask_question_fun(requestId);
        
    }

    if(open_report_project==1){
        report_project();
    }    
    $("#ask_question, #send_message").click(function(){
        open_ask_question_fun($(this).attr('id'));
    });
    
    $("#report_project").click(function(){
        report_project();
    });
    $("#get_embed_code").click(function(){
        $("#widget_div").modal({
            minHeight:530,
            minWidth:850
        });
      
    });
    
});
/* Open Ask Question start*/
function open_ask_question_fun(requestId){
    $('#saving-layer').css({
        'display':'block'
    });
    $.get(WEBSITE_URL+'sendmessage/'+user_slug+'/'+project_slug+'?ref='+requestId,function(r){
        $('#saving-layer').css({
            'display':'none'
        });
            
        if(is_user_login==1){ // open form if user login
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
                        var ask_question_value=$.trim($("#ProjectAskedQuestionQuestion").val());
                        if(ask_question_value==""){
                            $("#ProjectAskedQuestionQuestion_error").addClass('red_text').html(function_please_enter_question_ask);
                            return false;
                        }else{
                            $.ajax({
                                type: "POST",
                                url: $('#ProjectAskedQuestionForm').attr('action'),
                                data: $('#ProjectAskedQuestionForm').serialize()
                            }).done(function(data) { 
                                data=$.trim(data);
                                if(data=='success'){
                                    $noty.close();
                                    noty({
                                        "animateOpen":{
                                            "height":"toggle"
                                        },
                                        "animateClose":{
                                            "height":"toggle"
                                        },
                                        "force": true, 
                                        "layout" : "top", 
                                        "text": detail_your_message_send_to_project_poster, 
                                        "type": 'success',
                                        "model":true
                                    });
                                }
                            });
                                    
                            return false;
                        }
                    /* end ELSE**/
                    }
                }]
            });    
        }else{  // opens login form if user is not logedin
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
                "buttons": false
            });    
        }
    });
}
/* Ask Question function end*/  
   
/*Report Project Function start*/
function report_project(){
    $('#saving-layer').css({
        'display':'block'
    });
    $.get(WEBSITE_URL+'project_reports/report_project/'+user_slug+'/'+project_slug+'?ref=report_project',function(r){
        $('#saving-layer').css({
            'display':'none'
        });
        if(is_user_login==1){ // open form if user login
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
                "timeout":false,
                "closeButton":true,
                "closeOnSelfClick":false,
                "closeOnSelfOver":false,
                "modal":true,
                    
                "buttons": [
                {
                    "type": 'btn btn-primary', 
                    "text": 'Submit',
                    click: function($noty) {
                                
                        if($("input[type=radio][id^=report_type_]:checked").val()==5){
                            if($("#ProjectReportCategoryId").val()==""){
                                $("#ProjectReportCategoryId_error").addClass('red_text').html(detail_please_select_category);
                                return false;
                            }
                        }else{
                            if($.trim($("#ProjectReportSuggestion").val())==""){ 
                                $("#ProjectReportSuggestion_error").addClass('red_text').html(function_please_enter_resion);
                                return false;
                            }
                        }
                        $.ajax({
                            type: "POST",
                            url: $('#ProjectReportForm').attr('action'),
                            data: $('#ProjectReportForm').serialize()
                        }).done(function(data) { 
                            data =$.trim(data);
                            
                            if(data=='success'){
                                $noty.close();
                                noty({
                                    "animateOpen":{
                                        "height":"toggle"
                                    },
                                    "animateClose":{
                                        "height":"toggle"
                                    },
                                    "force": true, 
                                    "layout" : "top", 
                                    "text": detail_your_report_send_to_site_admin, 
                                    "type": 'success',
                                    "model":true,
                                    "closeButton":true
                                });
                            }
                        });
                                
                        return false;
                                
                                
                    /* end ELSE**/
                    }
                }]
                    
            });   
        }else{
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
                "buttons": false
                    
            });   
        }
            
    });
}