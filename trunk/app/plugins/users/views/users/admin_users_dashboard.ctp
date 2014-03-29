<div class="ochead">
    <div class="floatleft" id="breadcrumb">Users Dashboard</div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;"></div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
    <tr><td><ul class="dblist">
                <li>
                    <?php echo $this->Html->link($this->Html->image('admin/siteuser.png', array('alt' => '')) . '<br>Site Users', array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'), array('escape' => false, 'title' => 'Users', 'class' => 'vtip')); ?>
                </li>
                <li>
                    <?php echo $this->Html->link($this->Html->image('admin/privilege.png', array('alt' => '')) . '<br>Group Privileges</br>', array('plugin' => 'group_privileges', 'controller' => 'group_privileges', 'action' => 'index'), array('escape' => false, 'title' => 'Group Privileges', 'class' => 'vtip')); ?>
                </li>	  
            </ul>
            <div class="clear"></div>
        </td></tr>
</table>