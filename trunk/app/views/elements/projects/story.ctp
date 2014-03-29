<script type="text/javascript">
    $(document).ready(function() {        
		$.project_story();
	});
</script>

<div class="greybg_light">
    <div class="wrapper ptb15 aligncenter grey15_dark"> <span class="blue40 block"><?php __('project_edit_meet_ur_project'); ?></span> <?php __('project_edit_give_name_details'); ?></div>
</div>

<div class="wrapper grey14">
    <!-- Left Div -->
    <div class="fl pb80 greybrdrgt pt21 width68per pr50">
        <div id="story_errors" >

        </div>
        <?php if ($this->validationErrors) { ?>
            <div class="error pt10">
                <?php echo "<ul>";
                foreach ($this->validationErrors['Project'] as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } echo "</ul>"; ?>
            </div>
        <?php } ?>
        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7" ><?php __('project_edit_project_description'); ?></div>
                <div class="fl width1490 grey12">
					<div><?php __('project_description_label'); ?></div>
					<br />
				</div>
				<div class="fr width630 grey12">
                    <div>
						<?php
							echo $form->textarea('Project.description', array('name'=>'data[Project][description]','label' => '', 'class' => 'ui-widget-content ui-corner-all', 'style' => 'width:630px;height:350px;'));
							echo $this->Form->hidden('Project.old_description', array('value' => $this->data['Project']['description']));
						?>
						<script type="text/javascript">
							tinymce.init({ 
								selector: '#ProjectDescription',
								toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
								plugins: [
									"advlist autolink lists link image charmap print preview anchor",
									"searchreplace visualblocks code fullscreen",
									"insertdatetime media table contextmenu paste jbimages"
								],
								relative_urls: false,
								setup: function(editor) {
									editor.on('change', function(e) {
										handleFormChanged();
									});
								}
							});
						</script>
                    </div>	
                </div>
                <div class="clr"></div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>
    </div>
    <!-- Left Div -->
    <!-- Right Div --> 
    <div class="fr width23per pt21 pb80">
        <div class="greybox tip">
            <a href="<?php echo WEBSITE_URL; ?>display/how-to-make-an-awesome-project" target="_blank"><?php __('project_edit_how_to'); ?><br />
                <?php __('project_edit_awesome_project'); ?></a>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>
        <div class="mt17">
            <?php echo $right_panel_contents[2]['Page']['description'.$lang_var]; ?>
        </div>
    </div>
    <!-- End Right Div -->

	