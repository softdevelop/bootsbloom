<script type="text/javascript">
    $(document).ready(function() {
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
<?php 
echo $javascript->link('front/swfobject.js');
$wesite_list = explode(',', $this->data['User']['website']);
echo $this->element("front/user_profile_tabs");

$wesite_list = explode(',', $this->data['User']['website']);

$paginator->options = array('url' =>
    array_merge(array('slug' => $this->params['slug']), $this->passedArgs)
);
?>
<!--condition for this view can not load this element start -->

<div class="ptb21">
    <div class="wrapper">
        <div class="profile_right2" style="padding-top:100px">
            <div>
                <?php
                    echo $this->element('front/profile_page_tab');  ?>
                <div class="clr"></div>  
                <div id="loading_content">
                    <?php
                    if (count($projects) > 0) {
                        foreach ($projects as $project) {
                            $total_pledge_amount = 0;
                          
                            ?>

                            <div class="fl wid_250 pos_wrp" style="margin-top:30px">

                                <?php echo $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'], "210px", "280px"), array('height' => 210, 'width' => 210)); ?>
                                <div class="count_date">
                                    <?php $time_rem = $this->GeneralFunctions->show_left_time(time(), $project['Project']['project_end_date']);
                                    echo $time_rem['time'].' '. sprintf(__('frnt_daystogo', true), $time_rem['unit']); ?>

                                </div>
                                <div class="grey16 width90per">
                                    <?php
                                    if ($project['Project']['title'] != '') {
                                        if ($project['Project']['active'] == 1) {
                                            //if project is active 
                                            echo $this->Html->link(ucfirst($project['Project']['title']), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project['User']['slug'], $project['Project']['slug']));
                                        } else {
                                            //if project is not active 
                                            echo $this->Html->link(ucfirst($project['Project']['title']), array('plugin' => false, 'controller' => 'projects', 'action' => 'edit', $project['User']['slug'], $project['Project']['id'] . '#basics'));
                                        }
                                    } else {
                                        // if project do not have title 
                                        echo $this->Html->link(__('profile_untitle_project', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'edit', $project['User']['slug'], $project['Project']['id'] . '#basics'));
                                    }
                                    ?>
                                </div>
                            </div>


                            <?php
                        }
                    } else {
                        if ($this->Session->read('Auth.User.slug') == $slug) {
                            $msg = sprintf(__('profile_project_backer_empty', true), $this->Html->link(__('discover', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'discover'), array('class' => 'blue16 ')));
                        } else {
                            $msg = sprintf(__('profile_project_backer_empty_other_users', true), $this->data['User']['name']);
                        }
                        ?>
                        <div class="pt200 aligncenter grey14"><?php echo $msg; ?> </div>

<?php } ?>

                </div>  

            </div>
            <div class="clr "></div>
        </div> 
    </div>	
</div>

<div class="clr pt40"></div>
