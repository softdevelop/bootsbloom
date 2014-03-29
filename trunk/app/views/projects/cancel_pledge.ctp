<script type="text/javascript">
    var project_slug    =   '<?php echo $project_detail['Project']['slug']; ?>';
    var user_slug    =   '<?php echo $project_detail['User']['slug']; ?>';
    var is_user_login   =   '<?php echo $is_user_login; ?>';
  
    var open_report_project   =   '<?php echo $open_report_project; ?>';
    var open_ask_question   =   '<?php echo $open_ask_question; ?>';
    // var video_file   =   '<?php echo PROJECT_FLV_VIDEO_HTTP_PATH . $project_detail['Project']['flv_file_name']; ?>';
    //var video_image   =   '<?php echo PROJECT_VIDEO_IMG_HTTP_PATH . $project_detail['Project']['video_image']; ?>';
    
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
        <?php echo $this->Form->create('Project', array('action' => 'cancel_pledge/' . $backer_info['Backer']['id'] . '/' . $project_detail['Project']['slug'])); ?>
        <div class="fl pb80 greybrdrgt width60per pr50">
            <div class="blue30 uppercase"><?php __('project_cancel_pledge_amount'); ?></div>
            <div class="greybox divover mb12">
                <div class="p10 grey14">
                    <?php if (isset($error)) { ?>
                        <div class="error pt10">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>
                    <div class="fl uppercase bold width160"><?php __('project_edit_reward_pledge_amount'); ?></div>
                    <div class="fl  uppercase  grey14 width310">
                        <div class="bold fl pr10"> <?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?> <?php echo $backer_info['Backer']['amount']; ?> </div>

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
                        if ($backer_info['Reward']['id'] == 0) {
                            echo "No Thanks";
                        } else {
                            echo __('projt_dtl_pledge') . " " . Configure::read('CONFIG_CURRENCYSYMB') . $backer_info['Reward']['pledge_amount'] . '<span class="uppercase"> ' . __('backer_or_more', true) . '</span>';
                            ?>

                            <p>
                                <?php echo $backer_info['Reward']['description']; ?>
                            </p>
                            <p>
                                <?php echo $this->Time->get_month($backer_info['Reward']['est_delivery_month']) . " " . $backer_info['Reward']['est_delivery_year']; ?>
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
                <div class="pt24"><?php echo $this->Form->submit('Continue for Cancellation', array('class' => 'submit_but fr ie_radius')); ?></div>
                <div class="clr"></div>

            </div>
        </div>

        <?php
        echo $this->Form->hidden('Reward.cancel_pledge');

        echo $this->Form->end();
        ?>

        <div class="fr width34per pb80">
<?php echo $this->element('projects/project_payment_faq'); ?>
        </div>
        <div class="clr"></div>
    </div>
</div>
<div style="display: none;" id="bio_info">

    <?php echo $this->element('projects/user_bio'); ?>


</div> 