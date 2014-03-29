<?php foreach ($following_users as $site_user) { ?>
    <div >
        <div class="qa_left column">
            <div>
                <?php
                $image_url = $this->GeneralFunctions->get_user_profile_image($site_user['Following']['id'], '75px', '100px');
                echo $this->Html->link($this->Html->image($image_url, array('escape' => false, 'height' => '75', 'width' => '100')), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $site_user['Following']['slug']), array('escape' => false));
                ?> 
            </div>
        </div>
        <div class="qa_right column">
            <div class="grey16 pl5"><?php echo $this->Html->link(ucfirst($site_user['Following']['name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $site_user['Following']['slug']), array('class' => 'bold')); ?></div>
            <div class="pt5 grey16">
                <?php if ($site_user['Following']['country_json'] != '') { ?>
                    <?php echo $this->Html->image('front/location-icon.png', array('alt' => '', 'width' => '17', 'height' => '15')); ?>
                    <?php
                    $country = explode("##", $site_user['Following']['country_json']);
                    $country1 = explode(":", $country[1]);
                    $country2 = explode(',', $country[1]);
                    $country_name = str_replace('"', "", $country2[0]);
                    echo $this->Html->link($country_name, array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'country/' . $site_user['Following']['country']));
                    ?>
                <?php } ?>           
            </div>

            <div class="grey16 pt5"> 
                <?php echo $this->Html->image('front/badgeicon.png', array('heigth' => '17', 'width' => '17')); ?> <?php __('project_detail_backed'); ?> <?php echo $this->GeneralFunctions->get_user_backed_projects($site_user['Following']['id']); ?> <?php __('follow_projects');?>. </div>	
        </div>
        <?php if(!in_array($site_user['Following']['id'], $blocked_users_list)) {  // if user not Blocked ?>
        <div  class="grey16 lh30" id="not_blocked_<?php echo $site_user['Following']['slug'];?>" >
            <div class="fl"> <?php echo $this->Html->link(__('follow_block',true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'block', $site_user['Following']['slug']),array('class'=>'block')); ?></div>
                <div style="width: 100px;text-align: center;float: right">

                    <?php
                    if (!in_array($site_user['Following']['id'], $following_friends)) {
                        echo $this->Html->link(__('find_friend_follow',true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'follow', $site_user['Following']['slug']), array('class' => 'button ie_radius follow'));
                    } else {
                        echo $this->Html->link(__('find_friend_unfollow',true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'unfollow', $site_user['Following']['slug']), array('class' => 'button ie_radius unfollow'));
                    }
                    ?>

                </div>	
            </div>
        <?php }else{ ?>
        <div  class="grey16 lh30" id="blocked_<?php echo $site_user['Following']['slug'];?>">
            <div style="width: 100px;text-align: center;float: right">
                    <?php
                   if(in_array($site_user['Following']['id'], $blocked_users_list)){
                        echo $this->Html->link(__('get_social_right_pannel_blocked',true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'unblock', $site_user['Following']['slug']), array('class' => 'button ie_radius unblock'));
                    }
                    ?>

                </div>	
        </div>
        <?php } ?>
        <div class="clr"></div>
    </div>
    <div class="clr pt10"></div>
    <div class="dot_border"></div>
    <div class="clr pt10"></div>
<?php } ?>
<?php
if ($this->params['isAjax']) {
    if ($current_page != $last_page) {
        echo "=================" . $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'followers' . '/page:' . $page));
    } else {
        echo "=================";
    }
}
?>
