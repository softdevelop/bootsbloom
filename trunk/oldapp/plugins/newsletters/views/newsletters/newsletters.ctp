<div class="grey_gradient">
    <div class="pt20">
        <div class="wrapper">
            <h2 class="pageheading"><?php __('newsletter_archive'); ?>
            </h2>
        </div>
    </div>
</div>
<div class="pt20 pl207 width920">
    <div class="height35">
        <div class="fl grey14"><?php __('newsletter_title'); ?></div>
        <div class="fr">
            <form  id="newsletter_subscription_form_newsletter_page" onsubmit="return subscribe_newsletter('newsletter_subscription_form_newsletter_page')">
                <?php /********subscribe user letter when not login******** */  ?>
                <?php
					$login = $this->Session->read('Auth.User');
					if (empty($login)) {
                ?>
                    <div class="fl sprite txtbxlft_grey"></div>
                    <div class="fl greybg h36">
						<?php echo $form->text("Subscriber.email", array("class" => "txtbx260", 'value' => __('frnt_ur_email', true), "onclick" => "if (this.value == '" . __('frnt_ur_email', true) . "') this.value = ''", "onblur" => "if (this.value == '') this.value = '" . __('frnt_ur_email', true) . "'")); ?>
                    </div>
                    <div class="fl sprite txtbxrgt_grey"></div>
                    <div class="fl ml10"> 
						<?php echo $form->submit(__('frnt_join_newsletter', true), array('border' => '0', 'class' => 'submit_but ie_radius fl')); ?>
                    </div>
				<?php } else if ($login['receive_weekly_newsletter'] != 1) { ?>
				<?php /********when subscriber is login not subscribe yet******** */ ?>
                    <div class="fl greybg h36"></div>
                    <div class="fl ml10"> 
                    <?php echo $form->submit(__('frnt_join_newsletter', true), array('border' => '0', 'class' => 'submit_but ie_radius fl', 'id' => 'subscribe_newsletter_page')); ?>
                    </div>
                    <?php	} else { /********when subscriber is login subscribed too******** */ ?> 
                    <div class="grey14"><?php __('ur_subscriber_to_project_email'); ?></div>  
				<?php } ?>
                <div class="clr"></div>
            </form>
        </div>
    </div>	
    <div class="pt10 pb20" >
		<div id="loading_content">
        <?php echo $this->element('front/load_more_newsletter'); ?>
        </div><div class="clr"></div>
		<?php if (count($newsletter_lists) > 0) { ?>
			<div id="loadContentId" class='loadmore'>
                <?php
                if ($current_page != $last_page) {
                    echo $this->Html->link($this->Html->tag('span', __('blog_load_more', true)), array('plugin' => 'newsletters', 'controller' => 'newsletters', 'action' => 'newsletters', 'page' => $page), array('escape' => false, 'class' => 'loadmoreicon', 'id' => 'loadMoreContent'));
                }
                ?>
            </div>
            <div id="loadmore_loader" class="aligncenter" style="display: none;">
				<?php echo $this->Html->image('front/ajax-loader.gif'); ?>
            </div>
<?php } ?>
    </div>
</div>
