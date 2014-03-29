<script type="text/javascript">
    $(function(){
        var dl = $('<dl>');
   
        $('#faqSection').append(dl);
		
        $('dt').live('click',function(){
            var dd = $(this).next();
		
            if(!dd.is(':animated')){
                dd.slideToggle();
                $(this).toggleClass('opened');
            }
			
        });
    });
</script>

<div class="blue18"><?php __('project_payment_frequently_asked_question');?> </div>
<div class="mt17">


    <div class="faqlist" id="faqSection">
        <div >
            <dt class="pb10"><span class="icon"></span><?php __('project_payment_responce_fulfilling_promises'); ?></dt>

            <dd style="display: none;" class="pb10">
                <p>  <?php 
				
				$title= Configure::read('CONFIG_SITE_TITLE'); ?> 
				<?php  echo sprintf( __('project_payment_right_rule_third',true),$title); ?>	
				</p>
            </dd>
        </div>
        <div class="clr"></div>
        <dt class="pb10 "><span class="icon"></span><?php __('project_payment_right_rule_fourth'); ?></dt>
        <dd style="display: none;" class="pb10">
            <p>   <?php $end_date= $this->GeneralFunctions->get_project_ending_date_format($project_detail['Project']['project_end_date']); 
				echo sprintf( __('project_payment_right_rule_fifth',true),$end_date);
			?> </p>
        </dd>
        <div class="clr"></div>
        <dt class="pb10 "><span class="icon"></span><?php __('project_payment_right_rule_sixth'); ?></dt>
        <dd style="display: none;" class="pb10">
            <p> <?php $title= Configure::read('CONFIG_SITE_TITLE');
					echo sprintf(__('project_payment_right_rule_Seventh',true),$title);
					?> </p>
        </dd>
        <div class="clr"></div>
        <dt class="pb10">
        <span class="icon"></span><?php __('project_payment_right_rule_eight');?></dt>
        <dd style="display: none;" class="pb10">
            <p><?php $end_date= $this->GeneralFunctions->get_project_ending_date_format($project_detail['Project']['project_end_date']); 
					echo sprintf(__('project_payment_right_rule_ninth',true),$end_date);
			?>.</p>
        </dd>

        <div class="clr"></div>
        <dt class="pb10">
        <span class="icon"></span><?php __('project_payment_right_rule_tenth');?></dt>
        <dd style="display: none;" class="pb10">
            <p><?php $name=$project_detail['User']['name']; 
					echo sprintf(__('project_payment_right_rule_eleventh',true),$name);
				?></p>
        </dd>
    </div>

</div>
<div class="pt28">

</div>