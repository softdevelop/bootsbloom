<div class="ochead">
    <?php echo $category_name['Faq']['category_name']; ?>'s Post
    <div class="floatright padtop_6px">
        <?php if (isset($parent_id) && $parent_id > 1) { ?>
            <div class="floatleft" style="font-size:10px;">

                <?php echo $this->Html->link("Back To Parent List", array("plugin" => "help_categories", "controller" => "faqs", "action" => "index", $category_name['Faq']['parent_id']), array("class" => 'back_lnk')); ?>
            </div>  
        <?php } ?>
        <div class="floatleft" style="font-size:10px;">
            <?php echo $this->Html->link('Activate All', 'javascript:void(0);', array('class' => 'activate_all')); ?>
            <?php echo $this->Html->link('Inactive All', 'javascript:void(0);', array('class' => 'inactivate_all')); ?>
            <?php echo $this->Html->link("Add Post", array("plugin" => "help_categories", "controller" => "faq_posts", "action" => "add_faq_post", $parent_id), array("class" => 'add_lnk')); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info'); ?></div>
<div class="pagging float_right ">
    <?php echo $this->Form->create($model, array('url' => array('plugin' => 'help_categories', 'controller' => 'faq_posts', 'action' => 'index', $parent_id)));?>
    <?php echo $form->text('post_title', array('placeholder' => 'Post', 'class' => 'status ui-widget-content ui-corner-all')); ?>&nbsp;&nbsp;
    <?php echo $this->Form->button("Search", array('class' => 'search_lnk', 'escape' => false)); ?> &nbsp;&nbsp;
<?php echo $this->Form->end(); ?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>
<?php echo $this->element("admin/faq_post"); ?>

