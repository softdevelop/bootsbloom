<?php echo $this->Html->script('/categories/js/categories.js'); ?>
<div class="ochead">
    <div class="floatleft" id="breadcrumb">
        <?php
        echo "All Archive Categories";
        ?>
    </div>
    <div class="floatright padtop_6px">

        <div class="floatleft" style="font-size:10px;">
<?php echo $this->Html->link("Back To Categories", array("plugin" => "categories", "controller" => "categories", "action" => "index"), array("class" => 'back_lnk')); ?>
            <?php echo $this->Html->link('Restore All', 'javascript:void(0);', array('class' => 'restore_all')); ?>
            <?php echo $this->Html->link('Delete All', 'javascript:void(0);', array('class' => 'delete_all')); ?>

        </div>
        <div class="clear"></div>
    </div>
    <div class="floatleft" style="font-size:10px;"></div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info'); ?></div>
<div class="pagging float_right "></div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>
<?php echo $this->element("admin/ajax_archive_index"); ?>

