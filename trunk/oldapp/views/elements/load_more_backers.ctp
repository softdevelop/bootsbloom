<?php
if (count($project_backers) > 0) {
    foreach ($project_backers as $project_backer) {
        ?>
        <div >
            <div class="qa_left column">
                <div>
                    <?php $user_array['User'] = $project_backer['User'];
                    ?>
                    <?php $user_image_url = $this->GeneralFunctions->get_user_profile_image_using_user_array($user_array, '75px', '100px');
                    echo $this->Html->image($user_image_url, array('width' => '100', 'height' => '75')); ?>
                </div>
            </div>
            <div class="qa_right column">
                <div class="grey16 pl5"><?php echo $this->Html->link(ucfirst($project_backer['User']['name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $project_backer['User']['slug']), array('class' => 'bold')); ?></div>
                <div class="pt5 grey16">
                    <?php if ($project_backer['User']['country_json'] != '') { ?>
                        <?php echo $this->Html->image('front/location-icon.png', array('alt' => '', 'width' => '17', 'height' => '15')); ?>
                        <?php
                        $country = explode("##", $project_backer['User']['country_json']);
                        $country1 = explode(":", $country[1]);
                        $country2 = explode(',', $country[1]);
                        $country_name = str_replace('"', "", $country2[0]);
                        echo $this->Html->link($country_name, array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'country/' . $project_backer['User']['country']));
                        ?>
                    <?php } ?>           
                </div>
                <div class="grey16 lh30 "> </div>	
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
            echo "=================" . $this->Html->url(array('plugin' => false, 'controller' => 'projects', 'action' => 'project_backers/', $project_detail['User']['slug'], $project_detail['Project']['slug'] . '/' . 'page:' . $page));
        } else {
            echo "=================";
        }
    }
} else {
    ?>

    <div class="right_box">
        <div class="bt1px txt_italic  aligncenter"> <?php __('project_backer_empty_msg'); ?></div>
    </div>

<?php } ?>
