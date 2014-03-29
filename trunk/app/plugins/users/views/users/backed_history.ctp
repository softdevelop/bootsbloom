<script type="text/javascript">
    $(document).ready(function() {
        var project_success =   0;
        var project_success_msg =   "";
       <?php if (isset($project_success) && isset($project_success_msg)) { ?>
            project_success =   '<?php echo $project_success; ?>';
            project_success_msg =   '<?php echo $project_success_msg; ?>';
        <?php } ?>
        $('.clickable').click(function(){
            $(location).attr('href',$(this).find("#threadview").attr('href'));
        });
        if((project_success==1)){
            noty({
                "text":project_success_msg,
                "theme":"noty_theme_default",
                "layout":"top",
                "type":"success",
                "animateOpen":{"height":"toggle"},
                "animateClose":{"height":"toggle"},
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
<div class="grey_gradient">
    <div class="pt20"><div class="wrapper"><h2 class="pageheading"><?php __('manage_your_pledge'); ?></h2></div></div>
</div>
<div class="ptb21">
    <div class="innerwrapper">
        <div class="fl" id="loading_content">
            <div class="massage_h">
                <div class="fl pdetail"><strong><?php __('backer_history_project_detail'); ?></strong></div>
                <div class="fl pddetail"><strong><?php __('backer_history_pledge_detail'); ?></strong></div>
                <div class="fr pr20 backeraction"><strong><?php __('backer_history_action'); ?></strong></div>
            </div>
            <?php if (!empty($project_backers)) { echo $this->element('front/backer_history');?>
                <div class="clr"><?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "10")); ?></div>
                <div id="loadmore_loader" class="aligncenter" style="display: none;"><?php echo $this->Html->image('front/ajax-loader.gif'); ?></div>
                <div id="loadContentId" class='loadmore'><?php if ($current_page != $last_page) {
                        echo $this->Html->link($this->Html->tag('span', __('blog_load_more', true)), array('plugin' => 'users', 'controller' => 'users', 'action' => 'backed_history', 'page' => $page), array('escape' => false, 'class' => 'loadmoreicon', 'id' => 'loadMoreContent'));
                    }
                ?>
                </div>
            <?php } else { ?>
                <div class="user_d aligncenter"><?php __('backer_history_empty_msg'); ?></div>
            <?php } ?>
        </div>
        <div class="clr"></div>
    </div>
</div>
