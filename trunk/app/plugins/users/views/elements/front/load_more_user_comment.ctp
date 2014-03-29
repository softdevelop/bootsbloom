<?php
if (count($user_comments) > 0) {
    foreach ($user_comments as $project_comment) {
//pr($project_comment);
        ?>
        <div class="comments_container">

            <div class="cought_sign"><span>&#34;</span>


                <?php echo ucfirst($project_comment['ProjectComment']['comment']); ?>
            </div>

            <div class="block mb12" class="pb10">
                <span class="blue15"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $project_comment['ProjectComment']['created']); ?> </span> <span class="grey12"><?php __('from_the_project'); ?></span> <span class="blue15"><?php echo $this->Html->link(ucfirst($this->GeneralFunctions->get_project_title($project_comment['ProjectComment']['project_id'])), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project_comment['User']['slug'], $this->GeneralFunctions->get_project_title($project_comment['ProjectComment']['project_id'], 1)), array('title' => ucfirst($this->GeneralFunctions->get_project_title($project_comment['ProjectComment']['project_id'])), 'escape' => false)); ?></span>

            </div>

        </div>
        <div class="height_15">&nbsp;</div>
        <?php
    }

    if ($this->params['isAjax']) {
        if ($current_page != $last_page) {
            echo "=================" . $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'user_comments','slug'=> $slug . '/page:' . $page));
        } else {
            echo "=================";
        }
    }
} else {
    ?>
    <div class="comments_container">

        <div class="cought_sign">

            <?php __('There_is_no_comments'); ?>
        </div>

    </div>
    <div class="height_15">&nbsp;</div>
<?php } ?>