<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Blogs</div>
    <div class="floatright padtop_6px">
        <div class="floatleft" style="font-size:10px;"></div>
        <div class="floatleft " style="font-size:10px;">

        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info'); ?>
</div>
<div class="pagging float_right ">
    <?php echo $this->Form->create($model, array('class' => '')); ?>

    <?php echo $form->text("name", array("class" => "status ui-widget-content ui-corner-all", 'value' => 'Name', "onclick" => "if (this.value == 'Name') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Name'")); ?>

    &nbsp;&nbsp;
    <?php echo $this->Form->button("Search", array('class' => 'search_lnk', 'escape' => false)); ?> &nbsp;&nbsp;
    <?php echo $this->Form->end(); ?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>
<?php echo $this->element("admin/blog_index"); ?>

