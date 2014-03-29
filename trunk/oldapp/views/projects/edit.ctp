<?php
echo $this->Html->script(array(
    'front/project_functions.js',
));
?>
<script type="text/javascript">
    var formChanged = false;  
    var count = '<?php echo count($this->data['User']['website']); ?>';
  
</script>
<div id="screen">

    <?php echo $this->Form->create('Project', array('action' => 'edit')); ?>
    <div id="sections">
        <ul class="target">
            <li id="guidelines-panel" class="target_panel">
                <?php echo $this->element('projects/guideline'); ?>
            </li>
            <li id="basics-panel" class="target_panel">
                <?php echo $this->element('projects/basic'); ?>

            </li>
            <li id="rewards-panel" class="target_panel">
                <?php echo $this->element('projects/rewards'); ?>
            </li>				
            <li id="story-panel" class="target_panel">
                <?php echo $this->element('projects/story'); ?>
            </li>
            <li id="about_you-panel" class="target_panel">
                <?php echo $this->element('projects/about_you'); ?>
            </li>
            <li id="account-panel" class="target_panel">

                <?php echo $this->element('projects/account'); ?>
            </li>
            <li id="review-panel" class="target_panel">

                <?php echo $this->element('projects/review'); ?>
            </li>
        </ul>
    </div>
    <div id="preview_section" style="display: none;">

    </div>
    <?php echo $this->Form->hidden('Project.active'); ?>
    <?php echo $this->Form->end(); ?>
</div>


<div class="clr"></div>
</div>

<div class="footer_fix">
    <div class="blackshade2 ptb10">
        <div class="wrapper">
            <div class="fr ml24 mt17">
                <?php echo $this->Html->link(__('project_edit_exit', true), array('controller' => 'home', 'action' => 'index'), array('class' => 'exiticon')); ?>
            </div>
            <?php if($this->data['Project']['active']!=1) { ?>
            <div class="fr ml75 mt17">
                <?php echo $this->Html->link(__('project_delete_project', true), array('controller' => 'projects', 'action' => 'cancel_project', $this->data['User']['slug'], $this->data['Project']['id']), array('class' => "deleteicon")); ?>
            </div>
            <?php } ?>
            <div class="fr ml15"><a href="<?php echo $this->Html->url(array('controller' => 'projects', 'action' => 'draft', $this->data['User']['slug'], $this->data['Project']['id'], 0)) ?>" target="_blank" class="button_yellow ie_radius" id="preview_but">Preview</a></div>
            <div class="fr ml15"><a href="javascript:void(0);" class="button_blue ie_radius" id="next_but"><?php __('project_edit_next'); ?></a></div>
            <div class="fr ml15"><a href="javascript:void(0);" style="display: none" id="project_save_but"  class="save_but_green ie_radius"><?php __('project_edit_dave'); ?></a></div>
            <div class="fr ml15"><a href="javascript:void(0);" style="display: none" id="submit_but"  class="save_but_green ie_radius">SUBMIT</a></div>
            <div class="fr ml15"><a href="javascript:void(0);" style="display: none" id="discard_changes"   class="button_grey ie_radius"><?php __('project_edit_discard_changes'); ?></a></div>
            <div class="fr"><a href="javascript:void(0);" id="back_but"  class="button_grey ie_radius"><?php __('project_edit_back'); ?></a></div>
            <div class="clr"></div>
        </div>
    </div>
</div>
