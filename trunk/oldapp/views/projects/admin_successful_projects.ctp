<script type="text/javascript">

    var user	=	'<?php echo $this->data['User']['name_json']; ?>';
	
</script>

<div class="ochead" >
    <div class="floatleft" id="breadcrumb">
        Successful Projects
    </div>
    <div class="floatright padtop_6px">

        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="width_306 float_left" ><?php echo $this->element('admin/paging_info'); ?>
</div>
<div class="pagging float_right">
    <?php echo $this->Form->create('Project', array('action' => 'successful_projects')); ?>
    <?php echo $form->text("title", array("class" => "status ui-widget-content ui-corner-all", 'value' => 'Project Title', "onclick" => "if (this.value == 'Project Title') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Project Title'")); ?>
    &nbsp;&nbsp;
    <?php echo $this->Form->button("Search", array('class' => 'search_lnk', 'escape' => false)); ?> &nbsp;&nbsp;
    <?php echo $this->Form->end(); ?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>

<?php echo $this->element('projects/admin_project_listing'); ?>
