<script type="text/javascript">
    $(function(){
        
        // Show Notification Message
        var project_success =   0;
        var project_success_msg =   "";
        <?php if (isset($project_success) && isset($project_success_msg)) { ?>
                    project_success =   '<?php echo $project_success; ?>';
                    project_success_msg =   '<?php echo $project_success_msg; ?>';
        <?php } ?>
     
       

        if((project_success==1)){
        
            noty({
                "text":project_success_msg,
                "theme":"noty_theme_default",
                "layout":"top",
                "type":"success",
                "animateOpen":{
                    "height":"toggle"
                },
                "animateClose":{
                    "height":"toggle"
                },
                "speed":500,
                "timeout":5000,
                "closeButton":true,
                "closeOnSelfClick":true,
                "closeOnSelfOver":false,
                "modal":true
            });    
        
        }
   });
</script>  
<div class="ptb21">
    <div class="innerwrapper">
        <div class="grey14 lh20 imgbrd1"> 
            <div id="the-pitch" class="pb10 height330">
                <div class="fl width565 pt15" >
                    <?php 
					echo $start_project_content['Page']['description' . $lang_var];
					
                    $user_info = $this->Session->read('Auth.User');
                    if (!empty($user_info)) {
                        if (count($user_projects) > 0) {
                            ?>
                            <div class="pb10 grey20 lh33">
                                <?php __('here_you_can_edit'); ?>
                            </div>
                        <?php }
                    } ?>
                </div>
                <div class="fr pl10  width415 grey18 pt10">
				
<?php	if(isset($start_project_content['Project']))
		{
			echo $this->Html->image($this->GeneralFunctions->get_project_image($start_project_content['Project']['id'], '605px', ''), array('width' => '605', 'height' => ''));
		}
?>
                    <div class="aligncenter width338 pl25 grey16">
                        <i><?php __('each_every'); ?> <?php echo Configure::read('CONFIG_SITE_TITLE'); ?> <?php __('project_independent_someone_like_u'); ?></i></div>
                </div>
            </div>
            <div class="clr"></div>
            <?php
            if (!empty($user_info)) {
                if (count($user_projects) > 0) {
 
                    ?>
            <div id="action-button" class="f30 pl5">
                        <?php
                        if (count($user_projects) > 0) {
                            $text = __('project_edit_ur_project', true);
                            $span = '<span class="start_project fl">&nbsp;</span>';
                        }
                        echo $span;
                        echo $this->Html->link(strtoupper($text), array('plugin' => 'users', 'controller' => 'users', 'action' => 'created_projects','slug'=>$this->Session->read('Auth.User.slug')), array('class' => 'edit_button_on_start ie_radius fl'));
                        ?>
                    </div>
            
                <?php }
            }
            ?>	
            <div id="the-action" class="clr pt40">
                    <?php if (count($user_projects) > 0) { ?>
                    <div class="pb10 grey20 lh33">
						<?php //__('here_you_can_edit_down'); ?>
					</div>
                    <?php } ?>
                <div id="action-button" class="f30 pl5">
                    <?php
                    if (count($user_projects) > 0) {
                        $text = __('frnt_start_anew_project', true);
                        $span = '<span class="start_project fl">&nbsp;</span>';
                    } else {
                        $text = __('frnt_start_project', true);
                        $span = '';
                    }
                    echo $span;	
                    echo $this->Html->link($text, array('plugin' => false, 'controller' => 'projects', 'action' => 'guidelines'), array('class' => 'button ie_radius fl'));
                    ?>
                </div>

            </div><br/>
            <div class="pt40 pl10">
                <span class="school_link_container">
                    <?php
                    /** *language detection here * */
                    $language = $this->Session->read('Config.language');
                    if ($language != 'hy') {
                        ?>
                        <?php
                        $val = sprintf(__('make_awesome_project', true), Configure::read('CONFIG_SITE_TITLE'));
                        echo $this->Html->link($val, array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display', 'how-to-make-an-awesome-project'), array('escape' => false, 'class' => 'school-link', 'target' => '_blank'));
                    } else {
                        $val = sprintf(__('make_awesome_project', true), Configure::read('CONFIG_SITE_TITLE'));
                        echo $this->Html->link($val, array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display', 'comment-faire-un-projet-genial'), array('escape' => false, 'class' => 'school-link', 'target' => '_blank'));
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="clr"></div>
</div>
