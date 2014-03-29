
<div class="greybg_light">
    <div class="wrapper ptb15 aligncenter grey15_dark"> <span class="blue40 block"><?php __('project_edit_account_housekeeping'); ?></span><?php __('project_edit_account_name_important_detail'); ?></div>
</div>

<div class="wrapper grey14">
    <!-- Left Div -->
    <div class="fl pb80 greybrdrgt pt21 width68per pr50">
        <div id="account_errors" >

        </div>
        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('project_edit_account_contact_details'); ?></div>
                <div class="fl width1490 ">
                    <strong> <?php __('project_edit_account_email_verification'); ?></strong>
                    <div class="grey12"> 
                        <?php if ($this->data['User']['email_authenticated'] == '0') { ?>
                            <?php __('project_edit_account_need_verification'); ?>&nbsp;<strong><?php echo $this->data['User']['email']; ?></strong>&nbsp;<?php __('project_edit_account_need_verification_detail'); ?>
                            <br />
                            <?php echo $html->link(__('send_email_verification', true), 'javascript:void(0);', array('onclick' => 'verification_email()')); ?>
                        <?php } else { ?>
                            <?php __('project_edit_account_email_verified'); ?>
                        <?php } ?>
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
		<?php echo $right_panel_contents[4]['Page']['description'.$lang_var]; ?>       
    </div>
    <!-- End Right Div -->
