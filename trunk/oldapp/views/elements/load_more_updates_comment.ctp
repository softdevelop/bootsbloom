<?php
if (count($project_update_comment) > 0) {
    foreach ($project_update_comment as $project_update) {
        ?>
        <div class="commenthold">
            <div class="commentimg2">
                <?php
                $user_array['User'] = $project_update['User'];
                ?>
                <?php $user_image_url = $this->GeneralFunctions->get_user_profile_image_using_user_array($user_array, '30px', '39px');
                echo $this->Html->image($user_image_url, array('width' => '39', 'height' => '30')); ?>
            </div>
            <div class="width560 lh20 grey14 fr  ">
                <div class="pb5">
        <?php echo $this->Html->link($project_update['User']['name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $project_update['User']['slug']), array('class' => 'blue_link')); ?> 
                    <span class="grey13"><?php echo date('F, d Y', $project_update['ProjectUpdateComment']['created']); ?></span>
                </div>

                <div><?php echo ucfirst($project_update['ProjectUpdateComment']['comment']); ?></div>
            </div>
            <div class="clr"></div>
        </div>
    <?php } ?>
    <?php
    if ($this->params['isAjax']) {
        if ($current_page != $last_page) {
            echo "=================" . $this->Html->url(array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update_detail/', $project_detail['User']['slug'], $project_detail['Project']['slug'], $project_update['ProjectUpdateComment']['update_id'] . '/' . 'page:' . $page));
        } else {
            echo "=================";
        }
    }
} else {
    ?>
    <div class="right_box">
        <div class="bt1px txt_italic  aligncenter"><?php __('blog_no_comment'); ?></div>
    </div>
<?php } ?>