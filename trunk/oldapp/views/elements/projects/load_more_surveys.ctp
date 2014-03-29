<?php 
	if (count($project_surveys) > 0) {
		$count =	1;
		foreach ($project_surveys as $project_survey) {
 ?>
        <div id="blog" class="pt10">
            <h3><?php echo ucfirst($project_survey['ProjectSurvey']['survey_subject']); ?></h3>
            <div class="grey13_light fl pl5"> 
                <span class="green-font"><?php __('project_survey'); ?> #<?php echo $count++; ?></span>
                <span class="mt5 lh20 pl10"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $project_survey['ProjectSurvey']['created']); ?>&nbsp;<span class="black-font"><?php echo __('project_survey_reward'); ?>&nbsp;<?php if($project_survey['ProjectSurvey']['reward_id'] > 0){	echo $selectRewardData[$project_survey['ProjectSurvey']['reward_id']];}else{ echo __('all_reward_backers'); } ?> </span></span>
             </div>	
            <div class="clr"></div>	
            <div class="pl5">
                <?php echo ucfirst($project_survey['ProjectSurvey']['survey_message']); ?>
            </div>
            <div class="bluedbot"> </div>
        </div>
<?php 
		}
	} else {
?>
    <div class="right_box">
        <div class="bt1px txt_italic  aligncenter"><?php __('project_survey_empty_msg'); ?></div>
    </div>
<?php } ?>
