<?php echo $this->Html->script('/staticimages/js/admin/staticimages.js'); ?>
<div class="ochead" >
    <div class="floatleft" id="breadcrumb">System Images</div>
    <div class="floatright padtop_6px">
        <div class="floatleft " style="font-size:10px;"></div>
        <div class="floatleft " style="font-size:10px;">
            <?php echo $this->Html->link("Add New", array("action" => "add_image"), array("class" => 'add_lnk')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info'); ?>
</div>
<div class="pagging float_right " >
    <?php echo $this->Form->create($model, array('class' => '')); ?>
    <?php echo $form->text('caption', array('placeholder' => 'Image Caption', 'class' => 'status ui-widget-content ui-corner-all')); ?>&nbsp;&nbsp;
    <?php echo $this->Form->button("Search", array('class' => 'search_lnk', 'escape' => false)); ?> &nbsp;&nbsp;
    <?php echo $this->Form->end(); ?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>
<?php echo $this->element("admin/static_image_index"); ?>
