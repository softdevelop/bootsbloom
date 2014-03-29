<div class="ochead">
    <?php if (!isset($category_name)) { ?>
        FAQ Categories 
    <?php } else {
        echo ucfirst(substr($category_name['HelpCategory']['category_name'], 0, 20)); ?>'s Sub Categories 
    <?php } ?>
    <div class="floatright padtop_6px">
        <?php if (isset($parent_id) && $parent_id > 1) { ?>
            <div class="floatleft" style="font-size:10px;">

                <?php echo $this->Html->link("Back To Parent List", array("plugin" => "help_categories", "controller" => "faqs", "action" => "index", $category_name['HelpCategory']['parent_id']), array("class" => 'back_lnk')); ?>
            </div>  
        <?php } ?>
        <div class="floatleft" style="font-size:10px;">
            <?php echo $this->Html->link('Activate All', 'javascript:void(0);', array('class' => 'activate_all')); ?>
            <?php echo $this->Html->link('Inactive All', 'javascript:void(0);', array('class' => 'inactivate_all')); ?>
            <?php if (!empty($this->params['pass'])) { ?>
                <?php echo $this->Html->link("Add Category", array("plugin" => "help_categories", "controller" => "faqs", "action" => "add_category", $parent_id), array("class" => 'add_lnk'));
            } ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="floatleft padright_10px" style="font-size:10px;"><?php //echo $this->element('admin/paging_info');     ?></div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info'); ?></div>
<div class="pagging float_right ">
    <?php
    echo $this->Form->create($model, array('url' => array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'index', $parent_id)));
    echo $this->Form->hidden('section', array('value' => 'faq'));
    echo $form->text("category_name", array("class" => "status ui-widget-content ui-corner-all", 'value' => 'Category', "onclick" => "if (this.value == 'Category') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Category'"));
    ?>
    &nbsp;&nbsp;
<?php echo $this->Form->button("Search", array('class' => 'search_lnk', 'escape' => false)); ?> &nbsp;&nbsp;
<?php echo $this->Form->end(); ?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>
<?php echo $this->element("admin/faq"); ?>