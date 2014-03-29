<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Projects Dashboard</div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;"></div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
    <tr><td>
            <ul class="dblist">
                <li>
                    <?php echo $this->Html->link($this->Html->image('admin/project_icon.png', array('alt' => '')) . '<br>Project', array("plugin" => false, "controller" => "projects", "action" => "index"), array('escape' => false, 'title' => 'Project', 'class' => 'vtip')); ?>
                </li>

                <li>
                    <?php echo $this->Html->link($this->Html->image('admin/category_icon.png', array('alt' => '')) . '<br>Project <br>Categories', array("plugin" => "categories", "controller" => "categories", "action" => "index"), array('escape' => false, 'title' => 'Project  Categories', 'class' => 'vtip')); ?>
                </li>

                <li>
                    <?php echo $this->Html->link($this->Html->image('admin/pending_project.png', array('alt' => '')) . '<br>Pending for<br>Approval', array("plugin" => false, "controller" => "projects", "action" => "pending_projects"), array('escape' => false, 'title' => 'Pending for Approval', 'class' => 'vtip')); ?>
                </li>
                <li>
                    <?php echo $this->Html->link($this->Html->image('admin/successful_projects.png', array('alt' => '')) . '<br>Successful <br>Projects', array("plugin" => false, "controller" => "projects", "action" => "successful_projects"), array('escape' => false, 'title' => 'Successful Project', 'class' => 'vtip')); ?>
                </li>
                <li>
                    <?php echo $this->Html->link($this->Html->image('admin/cancellaton_request.png', array('alt' => '')) . '<br>Project Cancellation<br />Requests', array("plugin" => false, "controller" => "project_cancellation_requests", "action" => "index"), array('escape' => false, 'title' => 'Project Cancellation Requests', 'class' => 'vtip')); ?>
                </li>

            </ul>

            <div class="clear"></div>
        </td></tr>
</table>