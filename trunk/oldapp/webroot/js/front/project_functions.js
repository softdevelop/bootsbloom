$.extend({
    projectaction: function() {
		
		$('.remove_lnk').live('click',function() {
                handleFormChanged();
        });
		
        $("#navigation a").bind('click',function(){
            if($("#preview_section").hasClass('preview_class')){
                $("#preview_section").slideToggle().removeClass('preview_class');
            }
        });
        
        $("#next_but,#back_but").click(function(){
             if($("#preview_section").hasClass('preview_class')){
                $("#preview_section").slideToggle().removeClass('preview_class');
            }
        });
        
        $('#ProjectEditForm input[type=text], #ProjectEditForm textarea,#ProjectEditForm input[type=radio],#ProjectEditForm input[type=hidden],#ProjectEditForm select').each(function (i) {
            $(this).data('initial_value', $(this).val());
        });

        $('#ProjectEditForm input[type=text], #ProjectEditForm textarea').keyup(function() {
            if ($(this).val() != $(this).data('initial_value')) {
                handleFormChanged();
            }
        });
        $('#ProjectEditForm input[type=radio]').change(function() {
            if ($(this).val() != $(this).data('initial_value')) {
                handleFormChanged();
            }
        });
        $('#ProjectEditForm select').change(function() {
            if ($(this).val() != $(this).data('initial_value')) {
                handleFormChanged();
            }
        });
        $('#ProjectEditForm input[type=hidden]').change(function() { 
            if ($(this).val() != $(this).data('initial_value')) {
                handleFormChanged();
            }
        });
        $('#ProjectEditForm').bind('keyup', function() { 
            handleFormChanged();
        });
        $('.navigation_link').bind("click", function () {
            return confirmNavigation();
        });
        $("#discard_changes").click(function(){
            formChanged=false;
            discard_changes();
        });
		
		if(window.location.hash=="#review"){
			$("#next_but").hide();
            $("#submit_but").show();
        }
		
        $("#project_save_but").unbind('click');
        $("#submit_but").unbind('click');
        $("#project_save_but").click(function(){
            
            if(window.location.hash=="#basics"){
                var save_url =   WEBSITE_URL+"projects/basics/"+project_id;
                var panel_id    =   'basics-panel';
            } 
            if(window.location.hash=="#rewards"){
                var save_url =   WEBSITE_URL+"projects/rewards/"+project_id;
                var panel_id    =   'rewards-panel';
            } 
            if(window.location.hash=="#story"){
                
                var save_url =   WEBSITE_URL+"projects/story/"+project_id;
                var panel_id    =   'story-panel';
				$("#ProjectDescription").val( tinymce.get('ProjectDescription').getContent() );
            } 
            if(window.location.hash=="#about_you"){
                
                var save_url =   WEBSITE_URL+"projects/about_you/"+project_id;
                var panel_id    =   'about_you-panel';
            } 
            
            if(window.location.hash=="#account"){
                
                var save_url =   WEBSITE_URL+"projects/account/"+project_id;
                var panel_id    =   'account-panel';
            } 
            
            $("#saving-layer").show();
            
            $.ajax({
                type: "POST",
                url: save_url,
                data: $('#ProjectEditForm').serialize()
            }).done(function(res_data){
                var splite_content =   res_data.split('###');
                if(($.trim(splite_content[0]))=='success'){
                    $("#project_save_but").hide();
                    $("#discard_changes").hide();
                    $("#next_but").show();
					$("#preview_but").show();
					$("#submit_bit").show();
                    $("#back_but").show();
                    formChanged=false;
                }
                $("#"+panel_id).html("");
                $("#"+panel_id).html(splite_content[1]);
                $.projectaction();
                if(window.location.hash=="#basics"){
                    $.project_basics();
                }
                if(window.location.hash=="#story"){
                    $.project_story();
                }
                if(window.location.hash=="#rewards"){
                    $.project_rewards();
                }
                $("#saving-layer").hide();			
                return false;
            });
        });               
                        
       $("#submit_but").click(function(){
			if($("#preview_section").hasClass('preview_class')){
                $("#preview_section").slideToggle().removeClass('preview_class');
            }
            $("#saving-layer").show();
            
            $.ajax({
                type: "POST",
                url:  WEBSITE_URL+"projects/save_project/"+project_id,
                data: $('#ProjectEditForm').serialize()
            }).done(function(result_data){
                result_data    =   $.trim(result_data);
                if(result_data=='success'){
                    if($("#ProjectActive").val()!=1){ // if project is not active
                        window.location.href=WEBSITE_URL+'projects/final_review/'+user_slug+'/'+project_id;
                    }else{
                        window.location.href=WEBSITE_URL+'users/profile/'+user_slug;
                    }
                    return false;
                }else{
                    var jsondata= $.parseJSON(result_data);
                    if(jsondata.basics!=undefined){
                        show_errors(project_id,'basics');
                        $('#sections').trigger('goto',$('ul.target > li.target_panel').index($('#basics-panel')));
                        window.location.hash = '#basics';
                    }else if(jsondata.rewards!=undefined){
                        show_errors(project_id,'rewards');
                        $('#sections').trigger('goto',$('ul.target > li.target_panel').index($('#rewards-panel')));
                        window.location.hash = '#rewards';
                    }else if(jsondata.story!=undefined){
                        show_errors(project_id,'story');
                        $('#sections').trigger('goto',$('ul.target > li.target_panel').index($('#story-panel')));
                        window.location.hash = '#story';
                    
                    }else if(jsondata.about_you!=undefined){
                        show_errors(project_id,'about_you');
                        $('#sections').trigger('goto',$('ul.target > li.target_panel').index($('#about_you-panel')));
                        window.location.hash = '#about_you';
                    }
                
                    $("#saving-layer").hide();
                }
            });
            return false
       })                 
    },
    
	project_basics:function(){
        $("#ProjectTitle").charCount({
            allowed: 60,		
            warning: '',
            counterText: ''	
        });
        $("#ProjectShortDescription").charCount({
            allowed:300,		
            warning: '',
            counterText: ''	
        });
      
        $("#ProjectTitle").bind('keyup blur change paste',function(){
            $('#changed_project_title').html($("#ProjectTitle").val());
            $('#review_changed_project_title').html($("#ProjectTitle").val());
        });
        $("#ProjectShortDescription").bind('keyup blur change paste',function(){
            $('#changed_project_blurb').html($("#ProjectShortDescription").val());
        });
        if(window.location.hash=='#basics')
			$('#sections').height($('#sections').height()+$('#calendar_container').height());
		else
			$('#sections').height($('#sections').height());	
			
		$('textarea[maxlength]').live('keyup blur', function() {
        // Store the maxlength and value of the field.
        var maxlength = $(this).attr('maxlength');
        var val = $(this).val();
        // Trim the field if it has content over the maxlength.
        if (val.length > maxlength) {
            $(this).val(val.slice(0, maxlength));
        }
    });
},
    
	project_story:function(){
       
		
    },
    
    project_about_you:function(){
          $("#UserBiography").charCount({
            allowed:300,		
            warning: '',
            counterText: ''	
        });
    },
    
	project_rewards:function(){
        
    }
});

function handleFormChanged() {
    formChanged = true;
    $("#project_save_but").show();
    $("#discard_changes").show();
    $("#next_but").hide();
	$("#preview_but").hide();
    $("#back_but").hide();
	$("#submit_bit").hide();
}

function confirmNavigation() {
    if (formChanged) {
        var result = confirm(project_function_are_you_soure_it_will_lost_change);
        if(result){
            formChanged = false;
            discard_changes();
            return true;
        }else{
            return false;
        }
        
        
    } else {
        return true;
    }
}

function discard_changes(){
    $('#ProjectEditForm').get(0).reset();
    $("#project_save_but").hide();
    $("#discard_changes").hide();
    $("#changed_project_blurb").html($("#ProjectOldShortDescription").val());
    $('#changed_project_title').html($("#ProjectOldTitle").val());
    $('#review_changed_project_title').html($("#ProjectOldTitle").val());
    $("#next_but").show();
	$("#preview_but").show();
	$("#submit_bit").show();
    $("#back_but").show();
            
    $( "#datepicker" ).datetimepicker("destroy").datetimepicker({
        defaultDate: new Date(yr,mnth,dy),  
        hour: hr, 
        minute: mnt
    });
           
    if(window.location.hash=="#story"){
        $('#ProjectDescription').setData( $("#ProjectOldDescription").val());
        $('#ProjectDescription').updateElement();
     }
      if(window.location.hash=="#rewards"){
       $("#saving-layer").show();
        var save_url =   WEBSITE_URL+"projects/rewards/"+project_id;
        var panel_id    =   'rewards-panel';
        $.ajax({
            type: "POST",
            url: save_url,
            data:false
        }).done(function(res_data){
            var splite_content =   res_data.split('###');
            if(($.trim(splite_content[0]))=='success'){
                $("#project_save_but").hide();
                $("#discard_changes").hide();
                $("#next_but").show();
				$("#preview_but").show();
				$("#submit_bit").show();
                $("#back_but").show();
                formChanged=false;
            }
            $("#"+panel_id).html("");
            $("#"+panel_id).html(splite_content[1]);
         
          
            if(window.location.hash=="#rewards"){
                $.project_rewards();
            }
            $("#saving-layer").hide();			
            return false;
        });
                
                
    } 
        
        
     
}
        
$(function() {
    $.projectaction();
});

function remove_reward(reward_div_id,remove_id) {
    $("#reward_append_to_div_"+reward_div_id).remove();
    reward_counter--;
    if(remove_id>0){
        if($("#remove_ids").val()==""){
            $("#remove_ids").val(remove_id);
        }else{
            $("#remove_ids").val($("#remove_ids").val()+","+remove_id);
        }
        
        
    }
    handleFormChanged();
    return false;
}
    
function check_limit_value(reward_id) {
    if($("#RewardLimit_"+reward_id).attr('checked')){
        $("#limit_value_div_"+reward_id).show();
    }else{
        $("#limit_value_div_"+reward_id).hide();
    }
    handleFormChanged();
}

function show_errors(project_id,tab) {
       $.ajax({
                type: "POST",
                url:  WEBSITE_URL+"projects/show_validation_errors/"+project_id+'/'+tab
            }).done(function(res_data){
                $("#"+tab+"_errors").html(res_data);
            });
             
}
