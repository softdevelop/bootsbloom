
<script type="text/javascript">
   
<?php if (isset($update_comment)) { ?>

        var msg_text = '<?php echo $msg_text; ?>';
        var password_session = '<?php echo $update_comment; ?>';
        var msg_type1 = $.trim(password_session);
        if(msg_type1 =='error'){
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
            "model":true
        });
<?php } ?>
</script>

<?php echo $this->element('project_tabs'); ?> 
<div class="tab_container"> 
    <div id="tab1" class="tab_content">
        <div class="ptb21">
            <div class="wrapper">
                <div class="abprolft" id="blog">
                    <div id="blog" class="pt10">
                        <h1>
                            <?php echo $project_update_detail['ProjectUpdate']['title']; ?>
                        </h1>
                        <div class="grey13_light"> <?php echo date('F, d Y', $project_update_detail['ProjectUpdate']['created']); ?>&ndash; <?php echo $this->Html->link(count($project_update_detail['ProjectUpdateComment']) . ' comment', array('plugin' => false, 'controller' => 'home', 'action' => 'project_update_detail', $project_detail['User']['slug'], $project_detail['Project']['slug'], $project_update_detail['ProjectUpdate']['id'],), array('escape' => false, 'class' => 'cmnt-icon-grey')); ?> </div>
                        <div>
                            <p><?php echo ucfirst($project_update_detail['ProjectUpdate']['description']); ?></p>
                        </div>
                        <div class="bluedbot"> </div>
                    </div>
                    <div class="commentbx ">
                        <h1 class="p10"><?php __('projt_dtl_project_comment') ?></h1>
                        <div class="greybg_light">
                            <div>
                                <div id="loading_content">
                                    <?php echo $this->element('load_more_updates_comment'); ?>
                                </div>
                                <div class="clr"></div>
                                <?php if (count($project_update_comment) > 0) { ?>
                                    <div id="loadmore_loader" class="aligncenter" style="display: none;">
                                        <?php echo $this->Html->image('front/ajax-loader.gif'); ?>
                                    </div>
                                    <div class="clr ptb10"></div>
                                    <div id="loadContentId" class='loadmore'>
                                        <?php
                                        if ($current_page != $last_page) {
                                            echo $this->Html->link($this->Html->tag('span', __('Load More', true)), array('plugin' => false, 'controller' => 'home', 'action' => 'project_update_detail', $project_detail['User']['slug'], $project_detail['Project']['slug'], $project_update_detail['ProjectUpdate']['id'] . '/' . 'page' => $page), array('escape' => false, 'class' => 'loadmoreicon', 'id' => 'loadMoreContent'));
                                        }
                                        ?>
                                    </div>
<?php } ?>
                            </div>
                        </div>
                        <?php
                        $user_check = $this->Session->read('Auth.User.id');
                        if (isset($user_check)) {
                            ?>

                                <?php echo $this->Form->create($model, array('url' => array('plugin' => false, 'controller' => 'home', 'action' => 'project_update_detail', $project_detail['User']['slug'], $project_detail['Project']['slug'], $project_update_detail['ProjectUpdate']['id']))); ?>
                            <div>
                                    <?php if ($this->validationErrors) { ?>
                                    <div class="error pt10">
                                        <?php
                                        echo "<ul>";
                                        foreach ($this->validationErrors['ProjectUpdateComment'] as $error) {
                                            ?>
                                            <li><?php echo $error; ?></li>
                                            <?php
                                        }
                                        echo "</ul>";
                                        ?>
                                    </div>
    <?php } ?>
                            </div>
                            <div class="p10">
                                <h1><?php __('blog_leave_comment'); ?><span class="mandatory_field">*</span></h1>
                                <div>
    <?php echo $form->textarea('ProjectUpdateComment.comment', array('label' => '', 'class' => 'textarea725', 'style' => 'width:583px;')); ?>
                                </div>
                                <div class="ptb10">
    <?php echo $form->submit('Post Comment', array('border' => '0', 'class' => 'button ie_radius fl')); ?>
                                    <div class="pt4 pl10 fl grey12_light"><?php __('blog_leave_comment_text'); ?></div>
                                    <div class="clr"></div>
                                </div>
                            </div>
                            <?php echo $form->end(); ?>
                            <?php } else { ?>

                            <div class="height40 aligncenter pt25">
                                <span class="black16">
                                    <?php echo $this->Html->link('Log in to leave a comment', array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'), array('escape' => false)); ?>
                                </span>
                            </div>	
                        <?php } ?>

                    </div>

                </div>
                <?php echo $this->element('projects/project_detail_right_panel'); ?>
                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>

<div style="display: none;" id="bio_info">
    <?php echo $this->element('projects/user_bio'); ?>
</div> 

<div style="display: none;" id="widget_div">
    <?php echo $this->element('projects/widget_layout'); ?>
</div> 

