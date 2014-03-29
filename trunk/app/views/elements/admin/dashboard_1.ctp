<?php echo $this->Session->flash(); ?>
<div class="ochead">
    <div class="floatleft">Dashboard</div>
    <div class="floatright padtop_6px">
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<ul class="dblist">
    <li>
        <?php echo $this->Html->link($this->Html->image('admin/project_icon.png',array('alt'=>'')).'<br>Project <br>Dashboard', array("plugin" => false, "controller" => "projects", "action" => "dashboard"),array('escape'=>false,'title'=>'Project  Dashboard','class'=>'vtip'));?>
    </li>
    <li>
        <?php echo $this->Html->link($this->Html->image('admin/blog_icon.png', array('alt' => '')) . '<br>Blogs', array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'blog_dashboard'), array('escape' => false, 'title' => 'Blogs', 'class' => 'vtip')); ?>
    </li>
    <li>
        <?php echo $this->Html->link($this->Html->image('admin/utilities_icon.png', array('alt' => '')) . '<br>Static Pages', array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index'), array('escape' => false, 'title' => 'Static Pages', 'class' => 'vtip')); ?>
    </li>
    <li>
        <?php echo $this->Html->link($this->Html->image('admin/newsletter_icon.png', array('alt' => '')) . '<br>Newsletters', array('plugin' => 'newsletters', 'controller' => 'newsletters', 'action' => 'newsletters_dashboard'), array('escape' => false, 'title' => 'Newsletters', 'class' => 'vtip')); ?>
    </li>
    <li>
        <?php echo $this->Html->link($this->Html->image('admin/user_icon.png', array('alt' => '')) . '<br>Users', array('plugin' => 'users', 'controller' => 'users', 'action' => 'users_dashboard'), array('escape' => false, 'title' => 'Users', 'class' => 'vtip')); ?>
    </li>
    <li>
        <?php echo $this->Html->link($this->Html->image('admin/Monthly-Reports.png', array('alt' => '')) . '<br>Reports', array('plugin' => false, 'controller' => 'projects', 'action' => 'reports'), array('escape' => false, 'title' => 'Reports', 'class' => 'vtip')); ?>
    </li>
	<li>
        <?php echo $this->Html->link($this->Html->image('admin/help.png', array('alt' => '')) . '<br>Help', array('plugin' => "help_categories", 'controller' => 'faqs', 'action' => 'help_dashboard'), array('escape' => false, 'title' => 'Help', 'class' => 'vtip')); ?>
    </li>
</ul>
<div class="clear"></div>
