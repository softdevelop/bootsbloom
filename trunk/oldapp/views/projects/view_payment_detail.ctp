<script type="text/javascript">
    var project_slug    =   '<?php echo $project_detail['Project']['slug']; ?>';
    var user_slug    =   '<?php echo $project_detail['User']['slug']; ?>';
    var is_user_login   =   '<?php echo $is_user_login; ?>';
  
    var open_report_project   =   '<?php echo $open_report_project; ?>';
    var open_ask_question   =   '<?php echo $open_ask_question; ?>';
    
</script>

<?php
echo $this->Html->script(array(
    'front/project_detail.js'
));
?>

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
        <?php echo $this->Form->create('Project', array('action' => 'processPayment/' . $project_detail['Project']['slug'])); ?>
        <div class="fl pb80 greybrdrgt width60per pr50">
            <div class="blue30 uppercase"><?php __('project_stared_checkout_payapl'); ?></div>
            <div class="greybox divover mb12">
                <div class="p10 grey14">
                    <?php if ($this->Session->check('Message.flash')) { ?>
                        <div class="error pt10">
                            <?php echo $this->Session->flash(); ?>
                        </div>
                    <?php } ?>
                    <div class="fl uppercase bold width160"><?php __('project_edit_reward_pledge_amount'); ?></div>
                    <div class="fl  uppercase  grey14 width310">
                        <div class="bold fl pr10"> <?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?> <?php echo $pledge_info['amount']; ?> </div>
                        <div class="grey11"><?php echo $this->Html->link(__('project_view_payment_edit', true), array('controller' => 'projects', 'action' => 'pledge', $project_detail['Project']['slug'], $id)); ?></div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="greyboxtl"></div>
                <div class="greyboxtr"></div>
                <div class="greyboxbl"></div>
                <div class="greyboxbr"></div>
            </div>

            <div class="greybox mb12 divover grey14">
                <div class="p10">

                    <div class="fl width160 bold uppercase">
                        <?php __('project_view_payment_detail'); ?>
                    </div>
                    <div class="fl  grey14">
                        <?php
                        if ($pledge_info['reward']['id'] == 0) {
                            echo __('backer_no_thanks');
                        } else {
                            echo __('frnt_pledged', true) . ' ' . Configure::read('CONFIG_CURRENCYSYMB') . $pledge_info['reward']['pledge_amount'] . ' <span class="uppercase">' . __('projt_dtl_or_more', true) . '</span>';
                            ?>

                            <p>
                                <?php echo $pledge_info['reward']['description']; ?>
                            </p>
                            <p>
                                <?php echo $this->Time->get_month($pledge_info['reward']['est_delivery_month']) . " " . $pledge_info['reward']['est_delivery_year']; ?>
                            </p>

                        <?php }
                        ?>

                    </div>
                    <div class="clr"></div>
                </div>
                <div class="greyboxtl"></div>
                <div class="greyboxtr"></div>
                <div class="greyboxbl"></div>
                <div class="greyboxbr"></div>
            </div>
            <div class="pt24">
                <div class="fl">  <?php echo $this->Html->image('front/paypal.jpg', array("width" => "217", "height" => "64")); ?> </div>
                <div class="pt24"><?php echo $this->Form->submit(__('pledge_continue_payapl', true), array('class' => 'submit_but fr ie_radius')); ?></div>
              
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
