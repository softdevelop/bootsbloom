<script type="text/javascript">
    $('.set_opt_out').live('click',function(){
         var link = this;
        $.get(WEBSITE_URL+'home/optout_feature',function(r){
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
                        "text": 'Yes, opt me out', 
                        click: function($noty) {
                            $.ajax({
                                type: "POST",
                                url: link.href

                            }).done(function(url) { 
                               url  =   $.trim(url);
                               window.location.href = url;
                               return false;
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
             return false;
	 
        });
         return false;
    });

</script>
<div class="mt17">
    <div class="blue18 mb8">
        <span class="fl pl5"><?php __('get_social_right_pannel'); ?></span>
        <div class="clr"></div>
    </div>
    <ul class="sidenav ie_radius">
        <?php
        $find_frnd_act = '';
        $browse_project_act = '';
        $following_act = '';
        $follower_act = '';
        $blocked_act = '';
        if ($this->params['action'] == 'find_friends') {
            $find_frnd_act = 'act';
        }
        if ($this->params['action'] == 'friend_projects') {
            $browse_project_act = 'act';
        }
        if ($this->params['action'] == 'following') {
            $following_act = 'act';
        }
        if ($this->params['action'] == 'followers') {
            $follower_act = 'act';
        }
        if ($this->params['action'] == 'blocked') {
            $blocked_act = 'act';
        }
        ?>
        <li>
            <?php echo $this->Html->link(__('find_friend_find_friend', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'find_friends'), array('class' => $find_frnd_act)); ?>
        </li>
        <li>
            <?php echo $this->Html->link(__('find_friend_brows_projects', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'friend_projects'), array('class' => $browse_project_act)); ?>
        </li>

    </ul>
    <div class="clr"></div>

</div>

<div class="mt17">
    <div class="blue18 mb8">
        <span class="fl pl5"><?php __('get_social_right_pannel_manage'); ?></span>
        <div class="clr"></div>
    </div>
    <ul class="sidenav ie_radius">
        <li>
            <?php echo $this->Html->link(__('get_social_right_pannel_following', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'following'), array('class' => $following_act)); ?>
        </li>
        <li>
            <?php echo $this->Html->link(__('get_social_right_pannel_followers', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'followers'), array('class' => $follower_act)); ?>
        </li>
        <li>
            <?php echo $this->Html->link(__('get_social_right_pannel_blocked', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'blocked'), array('class' => $blocked_act)); ?>
        </li>

    </ul>
    <div class="clr"></div>

</div>

<div class="mt17">
    <div class="blue18 mb8">
        <span class="fl pl5">Opt Out</span>
        <div class="clr"></div>

    </div>
    <div class="grey14 pl5">
        <?php __('find_friend_do_not_want_to_follow_u'); ?>
    </div>

    <div class="grey14 pl5">
        <?php echo $this->Html->link(__('find_friend_pot_out_the_feature_entirely', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'set_opt_out'), array('class' => 'set_opt_out')); ?>

    </div>
    <div class="clr"></div>

</div>
