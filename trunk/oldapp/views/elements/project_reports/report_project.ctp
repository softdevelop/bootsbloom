<div class="pl10">
    <div class="forgot_password">
        <?php __('project_report_this_project_to'); ?><?php Configure::read('CONFIG_SITE_TITLE'); ?>
    </div>
</div>
<div class="modal_dialog_body pl10">

    <div id="project-issues">
        <?php echo $this->Form->create('ProjectReport', array('id' => 'ProjectReportForm', 'type' => 'POST', 'url' => WEBSITE_FRONT_URL . "project_reports/report_project/" . $project_detail['User']['slug'] . '/' . $project_detail['Project']['slug'], 'name' => 'frmRegister')); ?>
        <ul class="report">
            <?php
            $c = 0;
            foreach ($project_report_types as $project_report_type) {
                ?>
                <li><div class="choice"><input type="radio" value="<?php echo $project_report_type['ProjectReportType']['id']; ?>"  name="data[ProjectReport][report_id]" id="report_type_<?php echo $project_report_type['ProjectReportType']['id'] ?>"  class="radio_but" <?php if ($c == 0) {echo 'checked="checked"';} ?> ></div>
                    <div class="label">
                        <label for="flagging_kind_spam">
                            <strong><?php echo $project_report_type['ProjectReportType']['report_title']; ?></strong> 
                                <?php if ($project_report_type['ProjectReportType']['id'] == 5) {
                                    echo $project_detail['Category']['category_name'];
                                } 
                                echo $project_report_type['ProjectReportType']['report']; ?>

                        </label>
                    </div>
                </li>
    <?php $c++; } ?>
        </ul>
        <div class="clr pt10"> </div>
        <div  class="panes">
            <div id="details-spam" class="pane" style="display: block;">
                <div class="report">
                    <label class="label"> <strong><?php __('project_report_reason'); ?></strong></label>
                        <?php echo $form->textarea('ProjectReport.suggestion', array('class' => 'con_input-text required', 'style' => 'width:98%;height:50px;')); ?>
                    <div class="clr"> </div>
                    <span id="ProjectReportSuggestion_error"> </span>
                </div>
            </div>
        </div>
        <div class="clr pt10"> </div>
        <div style="" class="panes fl">
            <div id="category_select" class="pane" style="display: none;">
                <div class="report">
                    <label class="label"><strong><?php __('project_report_suggest_category'); ?></strong></label>
                    <?php echo $this->GeneralFunctions->get_category_dropdown('ProjectReport', 'category_id', 'ProjectReportCategoryId', '', '', 'style="width:98%;"'); ?>
                    <span id="ProjectReportCategoryId_error"> </span>
                </div>
            </div>


        </div>
<?php echo $this->Form->end(); ?>

    </div>
</div>
<script type="text/javascript">
  
    $(document).ready(function() {
        $("input[type=radio][id^=report_type_]").live('click', function() {
            if($(this).val()==5){
                $("#category_select").show();
                $("#details-spam").hide();
            }else{
                $("#category_select").hide();
                $("#details-spam").show();
            }
        });
    });
</script>

