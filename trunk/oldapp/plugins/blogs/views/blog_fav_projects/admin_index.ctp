<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Projects We Love</div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>
<?php echo $this->element("admin/fav_project_index"); ?>

<div class="pagging float_left ">
    <?php echo $this->Form->create($model, array('url' => array("plugin" => "blogs", "controller" => "blog_fav_projects", "action" => "add"))); ?>

    <?php echo $form->text("project_id", array("class" => "status ui-widget-content ui-corner-all", 'value' => 'Project id', "onclick" => "if (this.value == 'Project id') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Project id'")); ?>

    &nbsp;&nbsp;
    <?php echo $this->Form->button("Add project", array('escape' => false)); ?> &nbsp;&nbsp;
    <?php echo $this->Form->end(); ?>
</div>