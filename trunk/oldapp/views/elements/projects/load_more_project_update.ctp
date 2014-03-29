<?php if (count($projects_updates) > 0) {
    foreach ($projects_updates as $projects_update) { ?>
        <div>
            <div class="pt15">
                <div class="img_box">
                    <?php echo $this->Html->image($this->GeneralFunctions->show_project_image($projects_update['Project']['image'], "100px", "160px"), array('height' => 100, 'width' => 160)); ?>
                </div>
                <div class="width75per fr">
                    <div class="grey12 pt5">
                        <span class="blue15">
                            <?php echo $this->Html->link(ucfirst($projects_update['ProjectUpdate']['title']), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update_detail', $projects_update['User']['slug'], $projects_update['Project']['slug'], $projects_update['ProjectUpdate']['id'])); ?>
                        </span> 
                        <br />
                        <?php echo $text->truncate(ucfirst($projects_update['ProjectUpdate']['description']), 250, array('ending' => '...', 'exact' => false, 'html' => true)); ?>                        <div class="pt10">
                            <span class="documentry-grey">
                                <?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $projects_update['ProjectUpdate']['created']); ?>
                            </span>
                            <?php echo $this->Html->link(count($projects_update['ProjectUpdateComment']) . ' ' . __('projt_dtl_project_comment', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update_detail', $projects_update ['User']['slug'], $projects_update['Project']['slug'], $projects_update['ProjectUpdate']['id']), array('escape' => false, 'class' => 'cmnt-icon-grey')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr pt10"></div>
            <div class="dot_border"></div>
            <div class="clr pt10"></div>
        </div>
    <?php } 
    if ($this->params['isAjax']) {
        if ($current_page != $last_page) {
            echo "=================" . $this->Html->url(array('plugin' => false, 'controller' => 'project_updates', 'action' => 'index/', 'page:' . $page));
        } else {
            echo "=================";
        }
    }
} else {
    ?>
    <div class="aligncenter grey16 graybg"><?php __('project_more_project_update'); ?></div>
<?php } ?>