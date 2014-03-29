<?php foreach ($following_users as $site_user) { ?>
    <div >
        <div class="qa_left column">
            <div>
                <?php
                $image_url = $this->GeneralFunctions->get_user_profile_image($site_user['User']['id'], '75px', '100px');
                echo $this->Html->link($this->Html->image($image_url, array('escape' => false, 'height' => '75', 'width' => '100')), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $site_user['User']['slug']), array('escape' => false));
                ?> 
            </div>
        </div>
        <div class="qa_right column">
            <div class="grey16 pl5"><?php echo $this->Html->link(ucfirst($site_user['User']['name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $site_user['User']['slug']), array('class' => 'bold')); ?></div>
            <div class="pt5 grey16">
                <?php if ($site_user['User']['country_json'] != '') { ?>
                    <?php echo $this->Html->image('front/location-icon.png', array('alt' => '', 'width' => '17', 'height' => '15')); ?>
                    <?php
                    $country = explode("##", $site_user['User']['country_json']);
                    $country1 = explode(":", $country[1]);
                    $country2 = explode(',', $country[1]);
                    $country_name = str_replace('"', "", $country2[0]);
                    echo $this->Html->link($country_name, array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'country/' . $site_user['User']['country']));
                    ?>
                <?php } ?>           
            </div>

            <div class="grey16 pt5"> 
                <?php echo $this->Html->image('front/badgeicon.png', array('heigth' => '17', 'width' => '17')); ?> 
				<?php __('project_detail_backed');?> <?php echo $this->GeneralFunctions->get_user_backed_projects($site_user['User']['id']); ?> <?php __('follow_projects');?>. </div>	
        </div>
        <div class="grey16 lh30" style="width: 100px;text-align: center;float: right">
            <?php
            if (!in_array($site_user['User']['id'], $following_friends)) {
                echo $this->Html->link(__('find_friend_follow',true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'follow', $site_user['User']['slug']), array('class' => 'button ie_radius follow'));
            } else {
                echo $this->Html->link(__('find_friend_unfollow',true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'unfollow', $site_user['User']['slug']), array('class' => 'button ie_radius unfollow'));
            }
            ?>
        </div>	
        <div class="clr"></div>
    </div>
    <div class="clr pt10"></div>
    <div class="dot_border"></div>
    <div class="clr pt10"></div>
<?php } ?>
<?php
if ($this->params['isAjax']) {
    if ($current_page != $last_page) {
        echo "=================" . $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'following' . '/page:' . $page));
    } else {
        echo "=================";
    }
}
?>