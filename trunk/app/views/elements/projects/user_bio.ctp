<div id="projectby">
    <div >
        <div class="avatar">
            <?php $user_profile_image = $this->GeneralFunctions->get_user_profile_image($project_detail['User']['id'],'220px','220px'); ?>
            <?php echo $this->Html->image($user_profile_image, array('width' => '220', 'height' => '220', 'class' => 'avatar-large')); ?>
            <ul class="accountability">
                <li ><?php
                    if (($this->params['controller'] == 'projects' && $this->params['action'] == 'preview') || ($this->params['controller'] == 'projects' && $this->params['action'] == 'draft') || ($project_detail['User']['slug']==$this->Session->read('Auth.User.slug'))) {
                        echo __('project_detail_contact_me');
                    } else {
                        echo $this->Html->link(__('project_detail_contact_me',true), 'javascript:void(0)', array('onclick' => 'return open_ask_question_fun("send_message");', 'class' => 'button ie_radius contact_me'));
                    }
                    ?>
                </li>

                <li class="backed-more">
                    <span class="icon"></span>
                    <span class="text backedicon">
                        <?php echo $this->Html->link(__('project_detail_backed',true).' '. $project_detail['User']['backed_projects'] .' '. __('projt_dtl_user_bio_project',true),array('plugin'=>'users', 'controller'=>'users', 'action'=>'backed_projects', 'slug' => $project_detail['User']['slug']), array('class' => '')); ?>

                    </span>
                </li>
            </ul>
        </div>
        <div class="info">
            <div class="fl"> <h3><?php echo $this->Html->link($project_detail['User']['name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $project_detail['User']['slug'])); ?></h3>
            </div>
             <div class="clr"></div>
            <p class="byline pb10">
                <span class="locationicon fl">
                  
                    <?php 
                    $user_city_info    =  $this->GeneralFunctions->get_json_to_city_name($project_detail['User']['city_json']);
                    echo $this->Html->link($user_city_info['city_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'city', $user_city_info['id']), array('class' => '')); ?> 
                </span>

                <span class="divider fl">·</span>
                <span class="last-login fl">
                    <?php __('projt_dtl_last_login'); ?>
                    <?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $project_detail['User']['last_login']); ?>
                </span>
                <span class="divider fl">·</span>
                <span class="view-profile fl">
                    <?php echo $this->Html->link(__('project_detail_full_profile',true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $project_detail['User']['slug'])); ?>

                </span>
            </p>
            <div class="clr"></div>
            <p class="word-wrap"><?php echo $project_detail['User']['biography']; ?></p>
            <br />
            <?php
            if (!empty($project_detail['User']['website'])) {

                $websites = explode(",", $project_detail['User']['website']);
                ?>
                <b class="links-title"><?php __('websites'); ?></b>
                <ul class="links">
                    <?php foreach ($websites as $website) { ?>
                        <li>
                            <?php echo $this->Html->link($website, 'http://' . $website, array('target' => '_blank')); ?>

                        </li>
							
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </div>
    <div class="bottom">
        <b><?php __('project_detail_created_projects'); ?><span>(<?php echo count($project_detail['User']['user_current_projects']); ?>)</span></b>
        <ul class="created-projects">
            <?php foreach ($project_detail['User']['user_current_projects'] as $current_projects) { ?>
            <li class="current">
                    <?php
                    if (empty($current_projects['Project']['image'])) {
                        $image = WEBSITE_IMG_URL . 'image.php?image=missing_full.png&height=150px&width=150px';
                    } else {
                        
                    }$image = WEBSITE_IMG_URL . 'image.php?image=' . $current_projects['Project']['image'] . '&height=90px&width=90px';
                    echo $this->Html->link($this->Html->image($image, array('height' => '72', 'width' => '95', 'alt' => $current_projects['Project']['title'])), array('controller' => 'projects', 'action' => 'detail', $project_detail['User']['slug'], $current_projects['Project']['slug']), array('escape' => false));
                    ?>
                    <br />
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
