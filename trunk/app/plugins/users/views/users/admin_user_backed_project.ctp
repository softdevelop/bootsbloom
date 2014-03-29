<div class="ochead">
    <div class="floatleft" id="breadcrumb"><?php if (isset($user_name)) { echo $user_name['User']['name'];}?>'s backed Project</div>
    <div class="floatright padtop_6px">
        <div class="floatleft" style="font-size:10px;"><?php echo $this->Html->link("Back To User", array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'), array("class" => 'back_lnk')); ?></div>
        <div class="clear"></div>
    </div>
    <div class="floatleft padright_10px" style="font-size:10px;"></div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info'); ?></div>
<div class="pagging float_right">
<?php echo $this->Form->create(null, array('url' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'admin_user_backed_project', $user_id))); ?><?php echo $form->text('title', array('placeholder' => 'Project Title', 'class' => 'status ui-widget-content ui-corner-all')); ?>&nbsp;&nbsp;
    <?php echo $this->Form->button("Search", array('class' => 'search_lnk', 'escape' => false)); ?> &nbsp;&nbsp;
    <?php echo $this->Form->end(); ?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>
<?php echo $this->element("admin/users/user_backed_project_list"); ?>

