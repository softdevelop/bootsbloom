<li>
    <h4><?php __('my_created_project');?></h4>
</li>
<li>
    <?php echo $this->Html->link(__('all_my_projects',true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'created_projects', 'slug' => $this->Session->read('Auth.User.slug')),array('class'=>'createdproject')); ?>
</li>
<?php
if (!empty($projects)) {
    foreach ($projects as $project) {
        ?>
<li class="my-launched-project">

            <?php
            if (empty($project['Project']['title'])) {
                $title = 'Untitled';
            } else {
                $title = $project['Project']['title'];
            }
            $remaining_time = $this->GeneralFunctions->get_remainig_time(time(), $project['Project']['project_end_date']);
            if ($project['Project']['active'] == 1) {
                if ($remaining_time > 0) {
                    echo $this->Html->link($title, array('controller' => 'projects', 'action' => 'edit', $this->Session->read('Auth.User.slug'), $project['Project']['id'].'#basics'),array('style'=>'border-bottom:none'));
                } else {
                    echo $this->Html->link($title, array('controller' => 'projects', 'action' => 'detail', $this->Session->read('Auth.User.slug'), $project['Project']['slug']),array('style'=>'border-bottom:none'));
                }
            } else {
                echo $this->Html->link($title, array('controller' => 'projects', 'action' => 'edit', $this->Session->read('Auth.User.slug'), $project['Project']['id'].'#basics'),array('style'=>'border-bottom:none'));
            }
            ?>           

        </li>
        <?php
    }
} else {
    ?>
    <li class="my-launched-project">
    <?php __('no_project_yet'); ?>
    </li>
    <?php } ?>
