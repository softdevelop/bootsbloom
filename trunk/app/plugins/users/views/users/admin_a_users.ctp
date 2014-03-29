<?php echo $this->Html->script('/users/js/user.js'); ?>
<?php echo $this->Form->create($model, array('class' => '')); ?>
<div class="ochead">
    <div class="floatleft" id="breadcrumb">All Users</div>
    <div class="floatright padtop_6px">
        <div class="floatleft" style="font-size:10px;">
            <a href="javascript:void(0);" class="activate_all">Activate All</a>
            <a href="javascript:void(0);" class="inactivate_all">Inactive All</a>
            <?php echo $this->Html->link("Add User", array("plugin" => "users", "controller" => "users", "action" => "add_user"), array("class" => 'add_lnk')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="floatleft padright_10px" style="font-size:10px;"></div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info'); ?></div>
<div class="pagging float_right ">
    <?php echo $this->Form->create($model, array('class' => '')); ?>
    <?php echo $form->text('name', array('placeholder' => 'Name OR Email', 'class' => 'status ui-widget-content ui-corner-all')); ?>&nbsp;&nbsp;
    <?php echo $this->Form->button("Search", array('class' => 'search_lnk', 'escape' => false)); ?> &nbsp;&nbsp;
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $form->end(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>
<?php echo $this->element("admin/users/ajax_index"); ?>