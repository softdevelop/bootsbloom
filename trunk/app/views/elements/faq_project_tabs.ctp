<script type="text/javascript">
    var project_slug    =   '<?php echo $project_detail['Project']['slug']; ?>';
    var user_slug    =   '<?php echo $project_detail['User']['slug']; ?>';
    var is_user_login   =   '<?php echo $is_user_login; ?>';
    var open_ask_question   =   '<?php echo $open_ask_question; ?>';
    var open_report_project   =   '<?php echo $open_report_project; ?>';
    var project_stared_id    =   '<?php echo $alrady_stared['StaredProject']['id']; ?>';
	
		
<?php if (isset($stared_project_session)) { ?>

        var msg_text = '<?php echo $stared_project_msg; ?>';
        var stared_project_session = '<?php echo $stared_project_session; ?>';
        var msg_category = $.trim(stared_project_session);
        if(msg_category =='error'){
            var msg_type = 'error';
        }else{
            var msg_type = 'success';
        }
            			
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
            "text": msg_text, 
            "type": msg_type,
            "model":true,
            'closeButton' : true
        });
<?php } ?>

    $(function(){
    
        $("#already_stared").live('click',function(){
            $('#saving-layer').show();
            $.get(WEBSITE_URL+'projects/stared_project/'+project_slug,function(r){ alert('alrady ');
                if(r=='already_exists'){
                    noty({
                        "animateOpen":{
                            "height":"toggle"
                        },
                        "animateClose":{
                            "height":"toggle"
                        },
                        "force": true, 
                        "layout" : "top", 
                        "text": project_removed_from_reminder_list, 
                        "type": 'error',
                        "model":true,
                        'closeButton' : true
                    });
                    
                    $("#replace_star").html('<a href="'+WEBSITE_URL+'projects/stared_project/'+project_slug+'" class="tabstyle_star" id="make_stared">Remind Me</a>');
                    $('#saving-layer').hide();
                    return false; 
                }
                show_makestar_popup(r);
                $('#saving-layer').hide();
            });
            return false;
        });
        
        $("#make_stared").live('click',function(){
            $('#saving-layer').show();
    
            $.get(WEBSITE_URL+'projects/stared_project/'+project_slug,function(r){
        
                if(r=='success'){
                    noty({
                        "animateOpen":{
                            "height":"toggle"
                        },
                        "animateClose":{
                            "height":"toggle"
                        },
                        "force": true, 
                        "layout" : "top", 
                        "text": project_tnks_inform_by_email, 
                        "type": 'information',
                        "model":true,
                        'closeButton' : true
                    });
            
                    $("#replace_star").html('<a href="'+WEBSITE_URL+'projects/stared_project/'+project_slug+'" class="tabstyle_stared" id="already_stared">Remind Me</a>');
                    $('#saving-layer').hide();
                    return false;
                }
                show_makestar_popup(r)
                $('#saving-layer').hide();
        
        
        
            });
            return false;
        });

   
    });

    function show_makestar_popup(r){
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
                        $.ajax({
                            type: "POST",
                            url: WEBSITE_URL+'projects/stared_project/'+project_slug,
                            data: $('#ProjectStaredProjectForm').serialize()
                        }).done(function(stared_responce) { alert('from faq project tab');
                            var stared_data =   $.trim(stared_responce);
                            stared_data=	stared_data.split('||');
                            if(stared_data[0]=='already_exists'){
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
                                    "text": project_removed_from_reminder_list, 
                                    "type": 'error',
                                    "model":true,
                                    'closeButton' : true
                                });
                                $("#replace_star").html('<a href="'+WEBSITE_URL+'projects/stared_project/'+project_slug+'" class="tabstyle_star" id="make_stared">Remind Me</a>');
                            }else
                                if(stared_data[0] =='success'){
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
                                    "text": project_tnks_inform_by_email, 
                                    "type": 'information',
                                    "model":true,
                                    'closeButton' : true
                                });
                                $("#replace_star").html('<a href="'+WEBSITE_URL+'projects/stared_project/'+project_slug+'" class="tabstyle_stared" id="already_stared">Remind Me</a>'); 
                                
                            }else{
                                $(".noty_text").empty();
                                $(".noty_text").html(stared_data[0]);
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
    }
    /**comments of backer on project**/
	
    function project_backer_comment(){

        $('#saving-layer').css({
            'display':'block'
        });

        $.get(WEBSITE_URL+'projects/project_backer_comment/'+project_slug,function(r){
	
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
                            $.ajax({
                                type: "POST",
                                url: WEBSITE_URL+'projects/project_backer_comment/'+project_slug,
                                data: $('#ProjectProjectBackerCommentForm').serialize()
                            }).done(function(backer_comment) {

                                var comments =   $.trim(backer_comment);
                                if(comments!='success'){
						
                                    $(".noty_text").empty();
                                    $(".noty_text").html(comments);
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
                                        "text": project_comment_posted_successfully, 
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
	
	
	
</script>   

<?php
echo $this->Html->script(array(
    'front/project_detail.js'
));
$total_pledge_amount = $project_detail['Project']['total_pledge'];
?>
<div class="grey_gradient">
    <div id="pop_up_info" style="display: none; width: 100px;"></div>
    <div class="pt24">
        <div class="wrapper">
            <h2>
                <?php echo $project_detail['Project']['title']; ?>

                <span>A <?php echo $this->Html->link($project_detail['Category']['category_name'], "#"); ?> <?php __('projt_dtl_project_in'); ?> <?php echo $this->Html->link($project_detail['Project']['project_country'], "#"); ?> <?php __('frnt_By'); ?> <?php echo $this->Html->link($project_detail['User']['name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $project_detail['User']['slug'])); ?> &bull; <?php echo $this->Html->link(__('projt_dtl_send_msg', true), 'javascript:void(0)', array('id' => 'send_message')); ?></span> 
            </h2>
            <?php if ($this->Session->check('Message.flash')) { ?> <div class="error"> <?php echo $this->Session->flash(); ?></div> 
                <div class="clr"><br /></div>
            <?php } ?>
            <span class="project_short_desc"> <?php echo $project_detail['Project']['short_description']; ?></span>
            <div class="mt29">
                <div class="fl">
                    <ul class="user_tabs">
                        <li<?php if ($this->params['action'] == "detail") {
                echo 'class="selected"';
            } ?>>
<?php echo $this->Html->link(__('projt_dtl_project_home', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project_detail['User']['slug'], $project_detail['Project']['slug'])); ?>
                        </li>
                        <li <?php if ($this->params['action'] == "project_update") {
    echo 'class="selected"';
} ?>>
                            <?php echo $this->Html->link(__('projt_dtl_project_update', true) . ' <span>' . $count_comment . '</span>', array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update', $project_detail['User']['slug'], $project_detail['Project']['slug']), array('escape' => false)); ?> 
                        </li>
                        <li <?php if ($this->params['action'] == "project_backers") {
                                echo 'class="selected"';
                            } ?>>
                            <?php echo $this->Html->link(__('projt_dtl_project_backers', true) . ' <span>' . count($project_detail['Backer']) . '</span>', array('plugin' => false, 'controller' => 'projects', 'action' => 'project_backers', $project_detail['User']['slug'], $project_detail['Project']['slug']), array('escape' => false)); ?>
                        </li>
                        <li <?php if ($this->params['action'] == "backer_comment") {
                                echo 'class="selected"';
                            } ?>>
                            <?php echo $this->Html->link(__('projt_dtl_project_comment', true) . ' <span>' . count($backer_comments) . '</span>', array('plugin' => false, 'controller' => 'projects', 'action' => 'backer_comment', $project_detail['User']['slug'], $project_detail['Project']['slug']), array('escape' => false)); ?>
                        </li>
                        <li <?php if ($this->params['action'] == "project_faq") {
                                echo 'class="selected"';
                            } ?>>
							<?php echo $this->Html->link(__('faq', true) . ' <span>' . count($project_faqs) . '</span>', array('plugin' => false, 'controller' => 'projects', 'action' => 'project_faq', $project_detail['User']['slug'], $project_detail['Project']['slug']), array('escape' => false)); ?>
                        </li>
                        <?php
							$user_info = $this->Session->read('Auth.User');
							if (isset($user_info) && ($project_detail['User']['slug'] == $user_info['slug']) && $project_detail['Project']['project_end_date'] < time() && $total_pledge_amount >= $project_detail['Project']['funding_goal']) {
						?>
						<li
                        <?php
                        if ($this->params['action'] == "project_reward_survey") {
                            echo 'class="selected"';
                        }
                        ?>>
							<?php echo $this->Html->link(__('reward_survey', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_reward_survey', $project_detail['User']['slug'], $project_detail['Project']['slug']), array('escape' => false)); ?>
                        </li>
						<?php	
							}	
                        ?>
                    </ul>
                </div>
                        <?php
                        if (!$this->Session->check('Auth.admin.id')) {
                            if ($project_detail[$model]['user_id'] != $this->Session->read('Auth.User.id')) {
                                ?>
                        <div class="fr tabstyle">
                            <span id="replace_star">
                                <?php
                                if ($alrady_stared) {

                                    echo $this->Html->link(__('projt_dtl_remind_me', true), array('controller' => 'projects', 'action' => 'stared_project', $project_detail['Project']['slug']), array('class' => 'tabstyle_stared', 'id' => 'already_stared'));
                                } else {
                                    echo $this->Html->link(__('projt_dtl_remind_me', true), array('controller' => 'projects', 'action' => 'stared_project', $project_detail['Project']['slug']), array('class' => 'tabstyle_star', 'id' => 'make_stared'));
                                }
                                ?>
                            </span>
                        </div>
    <?php } } ?>
                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>
