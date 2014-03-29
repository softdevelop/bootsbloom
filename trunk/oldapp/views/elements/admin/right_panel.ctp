<div id="rightpanel" style="height: 974px;">
    <div class="rpbox">
        <div class="rphbg">
            <div class="floatleft">Quick Summary</div>
            <div class="floatright padtop_4px">

                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="padall_10px">
            <div class="qlist">
                <div class="floatleft"><?php echo $this->Html->link('Total Users', array("plugin" => "users", "controller" => "users", "action" => "index"), array("class" => "right_link")); ?></div>
                <div class="floatright"><?php echo $right_panel['site_user']; ?></div>
                <div class="clear"></div>
            </div>
            <div class="qlist">
                <div class="floatleft"><?php echo $this->Html->link('Admin Users', array("plugin" => "users", "controller" => "users", "action" => "a_users"), array("class" => "right_link")); ?></div>
                <div class="floatright"><?php echo $right_panel['admin_user']; ?></div>
                <div class="clear"></div>
            </div>
            <div class="qlist">
                <div class="floatleft"><?php echo $this->Html->link('Total Projects', array('plugin' => false, 'controller' => 'projects', 'action' => 'index'), array("class" => "right_link")); ?></div>
                <div class="floatright"><?php echo $right_panel['projects']; ?></div>
                <div class="clear"></div>
            </div>
            <div class="qlist">
                <div class="floatleft"><?php echo $this->Html->link('Project Categories', array("plugin" => "categories", "controller" => "categories", "action" => "index"), array("class" => "right_link")); ?></div>
                <div class="floatright"><?php echo $right_panel['categories']; ?></div>
                <div class="clear"></div>
            </div>

        </div>
        <div class="rphl"></div>
        <div class="rphr"></div>
        <div class="rpbl"></div>
        <div class="rpbr"></div>
    </div>
    <div> <?php echo $this->Html->image("admin/dot.gif", array("alt" => "", "width" => "1", "height" => "10")); ?>
    </div>
    <div>
        <?php echo $this->Html->image("admin/dot.gif", array("alt" => "", "width" => "1", "height" => "10")); ?>
    </div>

    <div> <?php echo $this->Html->image("admin/dot.gif", array("alt" => "", "width" => "1", "height" => "10")); ?></div>
</div>