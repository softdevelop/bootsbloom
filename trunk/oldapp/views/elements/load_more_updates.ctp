<?php
if (count($project_updates) > 0) {
    foreach ($project_updates as $project_update) {
        ?>
        <div id="blog" class="pt10">
            <h1>
                <?php echo $this->Html->link(ucfirst($project_update['ProjectUpdate']['title']), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update_detail', $project_detail['User']['slug'], $project_detail['Project']['slug'], $project_update['ProjectUpdate']['id']), array('escape' => false)); ?>
            </h1>

            <div class="grey13_light fl"> 
                <span class="green-font"><?php __('project_update'); ?> #<?php echo $project_update['ProjectUpdate']['project_update_number']; ?></span>
                <span class="mt5 lh20 pl10"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $project_update['ProjectUpdate']['created']); ?>&ndash; <?php echo $this->Html->link(count($project_update['ProjectUpdateComment']) . ' ' . __('projt_dtl_project_comment', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update_detail', $project_detail['User']['slug'], $project_detail['Project']['slug'], $project_update['ProjectUpdate']['id']), array('escape' => false, 'class' => 'cmnt-icon-grey')); ?> </span>
                <div class="clr">&nbsp;</div>	
                <span class="pl10 fr">
<?php
	$share_url = Router::url(array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update_detail', $project_update['User']['slug'], $project_update['Project']['slug'], $project_update['ProjectUpdate']['id']), true);
	$this->Facebook->renderLike($share_url);
?>

                </span>
                <div class="clr">&nbsp;</div>	
            </div>	
            <div class="clr">&nbsp;</div>		
            <div>
                <p><?php echo ucfirst($text->truncate($project_update['ProjectUpdate']['description'], 300, array('ending' => '...', 'exact' => false, 'html' => true))); ?></p>
            </div>
            <div class="bluedbot"> </div>
        </div>
    <?php } ?>

    <?php
    if ($this->params['isAjax']) {
        if ($current_page != $last_page) {
            echo "=================" . $this->Html->url(array('plugin' => false, 'controller' => 'projects', 'action' => 'updates/', $project_detail['User']['slug'], $project_detail['Project']['slug'] . '/' . 'page:' . $page));
        } else {
            echo "=================";
        }
    }
} else {
    ?>

    <div class="right_box">
        <div class="bt1px txt_italic  aligncenter"><?php __('project_update_empty_msg'); ?></div>
    </div>

<?php } ?>
