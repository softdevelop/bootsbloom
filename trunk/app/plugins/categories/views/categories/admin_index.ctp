<?php echo $this->Html->script('/categories/js/categories.js'); ?>


<div class="ochead">
    <div class="floatleft" id="breadcrumb">
        <?php
        if ($parent_id > 0) {
            echo $category[$model]['category_name'] . "'s Categories";
        } else {
            echo "All Categories";
        }
        ?>
    </div>
    <div class="floatright padtop_6px">
        <?php if ($parent_id > 0) { ?>
            <div class="floatleft" style="font-size:10px;">

                <?php echo $this->Html->link("Back To Parent List", array("plugin" => "categories", "controller" => "categories", "action" => "index", $category[$model]['parent_id']), array("class" => 'back_lnk')); ?>
            </div>  
        <?php } ?>
        <div class="floatleft" style="font-size:10px;">
            <?php echo $this->Html->link('Activate All', 'javascript:void(0);', array('class' => 'activate_all')); ?>
            <?php echo $this->Html->link('Inactive All', 'javascript:void(0);', array('class' => 'inactivate_all')); ?>
            <?php echo $this->Html->link("Add Category", array("plugin" => "categories", "controller" => "categories", "action" => "add_category", $parent_id), array("class" => 'add_lnk')); ?>
            <?php echo $this->Html->link("List Archive Categories", array("plugin" => "categories", "controller" => "categories", "action" => "archive_categories"), array("class" => 'archieve_categories')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="floatleft padright_10px" style="font-size:10px;"></div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info'); ?></div>
<div class="pagging float_right ">
    <?php echo $this->Form->create($model, array('class' => '')); ?>
    <?php echo $form->text("category_name", array("class" => "status ui-widget-content ui-corner-all", 'value' => 'Category', "onclick" => "if (this.value == 'Category') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Category'")); ?>
    &nbsp;&nbsp;
    <?php echo $this->Form->hidden('parent_id', array('value' => $parent_id)); ?>
    <?php echo $this->Form->button("Search", array('class' => 'search_lnk', 'escape' => false)); ?> &nbsp;&nbsp;
    <?php echo $this->Form->end(); ?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>
<?php echo $this->element("admin/ajax_index"); ?>

