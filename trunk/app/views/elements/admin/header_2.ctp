<div class="floatleft"><?php echo $this->Html->image("admin/logo.png", array("alt" => "")); ?>  </div>
<div class="floatright padtop_15px padright_10px">
    <div>Welcome, <?php echo $this->Session->read("Auth.admin.name"); ?></div>
    <div class="padtop_10px">
        <div class="floatright">
            <?php echo $this->Html->link($this->Html->image("admin/logout_but.jpg", array("alt" => "", "width" => "65", "height" => "22")), array("plugin" => "users", "controller" => "users", "action" => "logout"), array('escape' => false)); ?>
        </div>
        <div class="floatright padright_10px">
            <?php echo $this->Html->link($this->Html->image("admin/settings_but.jpg", array("alt" => "", "width" => "65", "height" => "22")), array('plugin' => 'settings', 'controller' => 'settings', 'action' => 'index'), array('escape' => false)); ?>
        </div>
        <div class="floatright padright_10px">
            <?php echo $this->Html->link($this->Html->image("admin/myaccount_but.jpg", array("alt" => "", "width" => "65", "height" => "22")), array("plugin" => "users", "controller" => "users", "action" => "myaccount"), array('escape' => false)); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
