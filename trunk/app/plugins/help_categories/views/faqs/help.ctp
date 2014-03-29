<?php 
	echo $this->Html->script(array(
		'front/jquery.tokeninput_help.js',
		'jquery-ui-js/ui/jquery.ui.autocomplete.js'
	));
	
	echo $this->Html->css(array(
		'front/token-input.css'
	));

	$language = $this->Session->read('Config.language');
	if (empty($language)) {
		$language = 'eng';
	}
?>

<style type="text/css">
    .token-input-delete-token {padding-top:5px;}
    li.token-input-token p{padding-top:5px;}
    #token-input-HelpPostPostTitle{width:355px !important;}
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $("#HelpPostPostTitle").tokenInput(WEBSITE_URL+"help_categories/faqs/get_post_title",{
            animateDropdown: false,
            searchingText:false,
            tokenLimit: 1,
            hintText:false,
            onAdd: function (item) {
                var myArray = item.id.split('##');
                var cat_slug =myArray[2];
                var post_tile =myArray[1];
                var cat_section  ='faq';
                window.location = WEBSITE_URL+'help/help-detail/'+cat_section+'/'+cat_slug+'#'+post_tile;
            }
           
        });
        $('.token-input-list').attr('style','height:27px; padding:3px 2px 6px; background: -moz-linear-gradient(center top , #F5F5F5, #FFFFFF) repeat-x scroll center top #FFFFFF; background-color:#FFFFFF; border: 1px solid #CCCCCC; width:390px;font-size: 16px;');

        $('li.token-input-input-token input').attr('style','width:357px;');
        $('div.token-input-dropdown').attr('style','');
        $('div.token-input-dropdown').attr('style',' position: absolute; width: 395px; background-color: #fff; overflow: hidden;border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc; cursor: default; font-size: 16px;  font-family: Verdana;z-index: 1;');
    });
</script>

<div class="help_ptb21">
    <div class="wrapper">
		<div class="help_main">
		<!--Best Practice Div Start Here-->	
                <div class="help_ptb21 aligncenter">
						<span class=  "help_headins_2"><?php __('school_best_practices'); ?></span>
						<span class="faq_doteat"></span>
                </div>
				 <div class="clr"></div>
                <div class="school">
                    <p><?php __('faq_body_text_1'); ?> </p>
                    <ul>
                        <li>
                            <?php echo $this->Html->image('front/ksr-school-icon-1.gif'); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->image('front/ksr-school-icon-2.gif'); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->image('front/ksr-school-icon-3.gif'); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->image('front/ksr-school-icon-4.gif'); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->image('front/ksr-school-icon-5.gif'); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->image('front/ksr-school-icon-6.gif'); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->image('front/ksr-school-icon-7.gif'); ?>
                        </li>
                        <li>
							<?php echo $this->Html->image('front/ksr-school-icon-8.gif'); ?>
                        </li>
                    </ul>
                  </div>
                   <div class="clr"></div>
					<div>
						<div class="fl blue_box">
							<h2><?php __('Boostbloom_Actions'); ?><br>
							<span>-<?php  __('For'); ?> <label><?php  __('Successful'); ?> </label><?php  __('Projects'); ?>-</span></h2>
							<div class="clr"></div>
							<ul>
								<li>
									<?php echo $this->Html->image('front/front_faq/video_icon.png');?>
									<?php echo $this->Html->link(__('Make_video',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/making-a-video')); ?>
								</li>
								<li>
									<?php echo $this->Html->image('front/front_faq/star_icon.png');?>
									<?php echo $this->Html->link(__('Offer_Great_Reward',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/creating-rewards')); ?>
								</li>
								<li>
									<?php echo $this->Html->image('front/front_faq/post_icon.png');?>
									<?php echo $this->Html->link(__('Post_Link_Page',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/your-project-description')); ?>
								</li>
								<li>
									<?php echo $this->Html->image('front/front_faq/user_icon.png');?>
									<?php echo $this->Html->link(__('Share_Project',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/promoting-your-project')); ?>
								</li>
								<li>
									<?php echo $this->Html->image('front/front_faq/watch_icon.png');?>
									<?php echo $this->Html->link(__('Update_Few_days',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/project-updates')); ?>
								</li>
								<li>
									<?php echo $this->Html->image('front/front_faq/note_icon.png');?>
									<?php echo $this->Html->link(__('Answer_Questions',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/promoting-your-project')); ?>
								</li>
							</ul>
						 </div>
							<div class="fl">
								<?php echo $this->Html->link(strtoupper(__('chk_out', true)), array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school_home'),array('class'=>'chech_out'));?>
								
							</div>
						<div class="fr blue_box">
							<h2><?php __('Boostbloom_Mistake'); ?></h2>
							<div class="clr"></div>
							<ul class="img_right">
								<li>
									<?php echo $this->Html->image('front/front_faq/icon1.png',array('height'=>'30','width'=>'34'));?>
									<?php echo $this->Html->link(__('Unrealistic_Goal',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/whats-a-goal')); ?>
								</li>
								<li>
									<?php echo $this->Html->image('front/front_faq/icon2.png');?>
									<?php echo $this->Html->link(__('No_Video',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/making-a-video')); ?>
								</li>
								<li>
									<?php echo $this->Html->image('front/front_faq/icon3.png');?>
									<?php echo $this->Html->link(__('Never_Tell',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/promoting-your-project')); ?>
								</li>
								<li>
									<?php echo $this->Html->image('front/front_faq/icon4.png',array('height'=>'30','width'=>'34'));?>
									<?php echo $this->Html->link(__('Uninspiring_Rewards',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/creating-rewards')); ?>
								</li>
								<li>
									<?php echo $this->Html->image('front/front_faq/icon5.png');?>
									<?php echo $this->Html->link(__('Profit_Passion',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/building-your-project')); ?>
								</li>
								<li>
									<?php echo $this->Html->image('front/front_faq/icon6.png');?>
									<?php echo $this->Html->link(__('No_Upadte',true),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/project-updates')); ?>
								</li>
							</ul>
						</div>
					</div>
					<!--Best Practice Div End Here-->
				<div class="clr "></div>
				<!--Faq Div Start Here-->
				
					<div class="faq"><span class="help_headins_2"><?php __('frnt_faq'); ?></span><span class="faq_doteat"></span></div>
					<div class="clr pt20"></div>
						<p class = "aligncenter faq_bot_text"><?php __('Faq_Text_Message'); ?><p>
						
						<div class="clr pt10"></div>
					<div class="contant">
						
						<div class="">
							<?php
							$cat_count = 1;
							
							
							foreach ($faq_posts as $faq_post) {
									
									$faq_action = $faq_post['HelpCategory']['category_name' . $lang_var];
								?>
								<div class="faq_help_list <?php if ($cat_count == count($faq_posts)) {
								echo "none";
							} ?>">
									<?php
									$category_slug = $faq_post['HelpCategory']['slug' . $lang_var];
									echo $this->Html->link($faq_post['HelpCategory']['category_name' . $lang_var], array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help_detail', 'faq/' . $category_slug), array('class' => 's_li_h'));
									?> 
									<ul>
										<?php
										foreach ($faq_post['Posts'] as $posts) {
											$post_slug = $posts['HelpPost']['slug' . $lang_var];
											$post_title = $posts['HelpPost']['post_title' . $lang_var];
											$post_title_slug = $posts['HelpPost']['slug' . $lang_var];
											?>
											<li>
											<?php echo $this->Html->link(ucfirst($text->truncate($post_title, 44, array('ending' => '...', 'exact' => false, 'html' => true))), array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help_detail', 'faq/' . $category_slug . '/#' . $post_title_slug)); ?>
											</li>
									<?php } ?>
									</ul>
								<?php echo $this->Html->link(__('see_all', true), array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help_detail', 'faq/' . $category_slug), array('class' => 'see_all white14')); ?>
								</div>
			<?php $cat_count++;
		} ?>


						</div>
						<div class="clr pt80"></div>
						<div>
							<div class="down_guide_line">
								<div class="g_line">
									<span class="faq_text"><?php __('Faq_guidelines'); ?></span>
									<span class="backers_doteat"></span>
								</div>
								<p><?php echo sprintf(__('faq_guideline_text_1',true),  Configure::read("CONFIG_SITE_TITLE"),'<br>','<br>',$this->Html->link(__('school_best_practices', true), array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school_home')),$this->Html->link(__('frnt_faq', true), array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help_detail', 'faq/boostbloom-basics'))) ; ?></p>
							</div>
							<?php 
								
								$pages = $this->GeneralFunctions->get_page_content_by_id(array('91'), array('Page.id', 'Page.title', 'Page.title_hy', 'Page.slug', 'Page.slug_hy'));
							
							?>
							<div class="down_guide_line ">
								<div class="g_line"><span class="faq_text"><?php __('faq_Stats'); ?></span><span class="share_doteat"></span></div>
								<p><?php echo sprintf(__('faq_Stats_Text_1',true),  Configure::read("CONFIG_SITE_TITLE"),$this->Html->link($pages[0]['Page']['title' . $lang_var], array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display', $pages[0]['Page']['slug' . $lang_var])),'<br>'); ?> 
								<?php
									echo $this->Html->link(__('chk_out', true), array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school_home'));
								?></p>
							</div>
							<div class="down_guide_line g_last_w" >
								<div class="g_line"><span class="faq_text"><?php __('faq_style_guide'); ?></span><span class="down_doteat"></span></div>
								<p>
									<?php echo sprintf(__('faq_Goodies_text',true),  '<br>',$this->Html->link(__('faq_Goodies_text_lnk', true), array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'design_page'))); ?> 
								</p>
							</div>
						</div>
						<div class="clr pt40"></div>
						<div class="let_us"><?php __('faq_contact_us'); ?> <?php echo Configure::read("CONFIG_SITE_TITLE"); ?> ?
								<?php echo $html->link(__('faq_let_us_knw', true), 'mailto:' . Configure::read('CONFIG_EMAIL'), array('escape' => false)); ?>
						</div>
					</div>
					<!--Faq Div Here-->
				</div>
        <div class="clr pt20"></div>
    </div>
</div>
