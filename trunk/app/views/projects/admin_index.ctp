<script type="text/javascript">
    var user	=	'<?php echo $this->data['User']['name_json']; ?>';
</script>

<div class="ochead" >
    <div class="floatleft" id="breadcrumb">
        <?php if (isset($project_owner)) { ?>
            <?php echo $project_owner; ?>'s
        <?php } ?>
		Project List
    </div>
    <div class="floatright padtop_6px">

        <div class="floatleft dgray17 pt2">Filter By: </div>
        <div class="floatleft pr10">
            <?php
            if (!isset($user_id)) {
                echo $this->Form->create('Project', array('action' => 'index'));
            } else {
                echo $this->Form->create($model, array('action' => 'index/' . $user_id));
            }
            ?>
            <?php echo $form->select('filters', $project_filter, $projec_condition, array('id' => 'filters_dropdown', 'name' => 'filters', 'empty' => false, 'label' => '', 'class' => 'span2 ui_dropdown', 'onchange' => "this.form.submit();")); ?>
            <?php echo $form->end(); ?>
        </div>
        <?php if (isset($user_id)) { ?>
            <div class="floatleft" style="font-size:11px;">
                <?php echo $this->Html->link("Back To Users", array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'), array("class" => 'back_lnk')); ?>
            </div>
        <?php } ?>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="width_306 float_left" ><?php echo $this->element('admin/paging_info'); ?>
</div>
<div class="pagging float_right">
    <?php if (isset($user_id)) { ?>
        <?php echo $this->Form->create('Project', array('action' => 'index/' . $user_id)); ?>
    <?php } else { ?>
        <?php echo $this->Form->create('Project', array('action' => 'index'));
    } ?>
    <?php echo $form->text("title", array("class" => "status ui-widget-content ui-corner-all", 'value' => 'Project Title', "onclick" => "if (this.value == 'Project Title') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Project Title'")); ?>
    &nbsp;&nbsp;
    <?php echo $this->Form->button("Search", array('class' => 'search_lnk', 'escape' => false)); ?> &nbsp;&nbsp;
    <?php echo $this->Form->end(); ?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>

<?php echo $this->element('projects/admin_project_listing'); ?>
