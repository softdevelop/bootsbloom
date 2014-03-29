<div class="ochead" >
    <div class="floatleft" id="breadcrumb"><?php
if (isset($posts)) {
    foreach ($posts as $post) {
        echo ucfirst(substr($post, 0, 50));
    }
}
?>'s Comments</div>
    <div class="floatright padtop_6px">
        <div class="floatleft " style="font-size:10px;"></div>
        <div class="floatleft " style="font-size:10px;">
<?php echo $this->Html->link('Activate All', 'javascript:void(0);', array('class' => 'activate_all')); ?>
<?php echo $this->Html->link('Inactive All', 'javascript:void(0);', array('class' => 'inactivate_all')); ?>
<?php echo $this->Html->link('Delete All', 'javascript:void(0);', array('class' => 'delete_all')); ?>
<?php echo $this->Html->link("Back To Post", array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'index', $blog_id), array("class" => 'back_lnk')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info'); ?>
</div>
<div class="pagging float_right ">
    <?php echo $this->Form->create($model, array('url' => array_merge(array('action' => 'index'), $this->params['pass']))); ?>
    <?php echo $form->text("comment", array("class" => "status ui-widget-content ui-corner-all", 'value' => 'Comment', "onclick" => "if (this.value == 'Comment') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Comment'")); ?>
    &nbsp;&nbsp;
<?php echo $this->Form->button("Search", array('class' => 'search_lnk', 'escape' => false)); ?> &nbsp;&nbsp;
<?php echo $this->Form->hidden("post_id", array("value" => $post_id));
echo $this->Form->end(); ?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>
<?php echo $this->element("admin/comment_index"); ?>

