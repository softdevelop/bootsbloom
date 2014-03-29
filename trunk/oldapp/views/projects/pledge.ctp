<script type="text/javascript">
    var project_slug    =   '<?php echo $project_detail['Project']['slug']; ?>';
    var user_slug    =   '<?php echo $project_detail['User']['slug']; ?>';
    var is_user_login   =   '<?php echo $is_user_login; ?>';
  
    var open_report_project   =   '<?php echo $open_report_project; ?>';
    var open_ask_question   =   '<?php echo $open_ask_question; ?>';
</script>

<?php	echo $this->Html->script(array('front/project_detail.js'));	?>

<div class="greybg_light">
    <div class="wrapper ptb21 aligncenter grey15_dark">
        <span class="blue40 block pb5">
            <?php echo $project_detail['Project']['title']; ?></span>
        <?php __('frnt_by'); ?> <?php echo $this->Html->link($project_detail['User']['name'], 'javascript:void(0);', array('id' => 'see_full_bio', 'class' => 'blue15')); ?>
    </div>
</div>
<div class="clr"></div>
<div class="wrapper grey14">
    <div class="mid_overbx mb23">
        <?php
        // pr($this->data);
        echo $this->Form->create('Project', array('action' => 'pledge/' . $project_detail['Project']['slug'] . '/' . $id));
        ?>   
        <div class="fl pb80 greybrdrgt width60per pr50">
            <div class="blue30 uppercase"><?php __('project_pledger_alright'); ?>!</div>
            <div class=" pb17"><?php __('project_pledger_enter_amount'); ?>&nbsp;(<?php __('about_pledger_amount'); ?>)</div>
            <div class="bluebg radius6 mb12">
                <div class="p10"> 
                        <?php if (isset($this->validationErrors['Backer']['amount'])) { ?>
                        <div class="error pt10">
    <?php echo $this->validationErrors['Backer']['amount']; ?>

                        </div>
<?php } ?>
                    <div class="fl blue40 pr10 pl10"><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?></div>
                    <div class="fl width220 grey12">
<?php echo $this->Form->text('Backer.amount', array('class' => 'input-text200')); ?>

                    </div>
                    <div class="fl pt15 pl10"><?php __('project_pledger_any_amount_of'); ?> <?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $project_detail['Reward'][0]['pledge_amount']; ?> <?php __('projt_dtl_or_more'); ?>.</div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="grey22 pb10 pt10"><?php __('project_pledger_select_reward_ur'); ?></div>
                <?php if (isset($this->validationErrors['Backer']['reward_id'])) { ?>
                <div class="error pt10">
    <?php echo $this->validationErrors['Backer']['reward_id']; ?>

                </div>
<?php } ?>
            <div class="greybox radius6 divover mb8">
                <div class="p10">
                    <div class="fl">

                        <input type="radio" name="data[Backer][reward_id]" <?php
if ($this->data['Backer']['reward_id'] == 0) {
    echo "checked";
}
?> value="0"/>
                    </div>
                    <div class="fl pl8 width160 bold"><?php __('project_pledger_no_reward'); ?></div>
                    <div class="fl wid440"><?php __('project_pledger_no_want_to_help_project'); ?></div>

                    <div class="clr"></div>
                </div>
            </div>
                        <?php foreach ($project_detail['Reward'] as $reward) { ?>
                <div class="greybox radius6 divover mb8">
                    <div class="p10">
                        <div class="fl">
                            <?php
                            $disabled = '';
                            $sold='';
                            if ($reward['limit'] == 1) {
                                $allowd_backers = $this->GeneralFunctions->get_total_backer_on_reward($reward['id'], $project_detail['Backer']);
                                if ($allowd_backers >= $reward['limit_value']) {
                                    $disabled = "disabled='disabled'";
                                    $sold   =   "<strong>Sold Out</strong>";
                                }
                            }
                            ?>

                            <input type="radio" name="data[Backer][reward_id]" <?php echo $disabled; ?> <?php if ($this->data['Backer']['reward_id'] == $reward['id']) { echo "checked"; } ?> value="<?php echo $reward['id']; ?>" />
                        </div>
                        <div class="fl pl8 width160 bold"><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $reward['pledge_amount']; ?>+</div>
                        <div class="fl wid440"><?php echo $reward['description']; ?><br /><?php echo $sold; ?></div>

                        <div class="clr"></div>
                    </div>
                </div>
<?php } ?>
            <div class="pt24">
        <?php echo $this->Form->submit(__('pledge_continue_next', true), array('class' => 'submit_but fr ie_radius')); ?>
                <div class="clr"></div>

            </div>
        </div>

<?php echo $this->Form->end(); ?>

        <div class="fr width34per pb80">
<?php echo $this->element('projects/project_payment_faq'); ?>
        </div>
        <div class="clr"></div>
    </div>
</div>

<div style="display: none;" id="bio_info">

<?php echo $this->element('projects/user_bio'); ?>


</div> 
