<?php echo $this->element('project_tabs'); ?> 
<script>
    $(function(){
        function equalHeight(group) {
			tallest = 0;
			group.height('');
			group.each(function() {
				thisHeight = $(this).height();
				
				if(thisHeight > tallest) {
					tallest = thisHeight;
					
				}
			});
			group.height(tallest);
		}
		equalHeight($("#helpbox>div"));
    });
</script>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <div class="ptb21">
            <div class="wrapper">
                <div class="abprolft">
                    <div class="wrapper615">
                        <div class="imgbrd4">
                            <div id="project_image"><?php echo $this->Html->image($this->GeneralFunctions->get_project_image($project_detail['Project']['id'], '605px', ''), array('width' => '605', 'height' => '')) ?></div>
                        </div>
                        <div class="mtb10">
                            <?php echo $this->element('social_media_counter'); ?>   
                        </div>
                    </div>
                    <div>
                        <div>
                            <div class="fl sprite bxlft"></div>
                            <div class="fl bxtop blue22 uppercase"> <?php __('projt_dtl_about_project'); ?></div>
                            <div class="fl sprite bxrgt"></div>
                            <div class="clr"></div>
                        </div>
                        <div class="bxmid">
                            <div class="boxshade grey14 lh20 imgbrd1 word-wrap">
                                <?php echo $project_detail['Project']['description']; ?>

                            </div>
                        </div>
                        <div>
                            <div class="fl sprite bxlft_bot"></div>
                            <div class="fl bxbot"></div>
                            <div class="fl sprite bxrgt_bot"></div>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div>
                        <div class="ml10"><div class="blue22 uppercase ptb10"><?php __('project_detail_faqs'); ?><span class="f14">s</span></div>
                            <div class="grey14 mb23" id="faqSection">
                                <ul>
                                    <?php if (!empty($project_detail['ProjectAskedQuestion'])) { ?>
										<dl>
<?php                                       	foreach ($project_detail['ProjectAskedQuestion'] as $faq) { ?>
                                            <dt ><span class="icon"></span><?php echo $faq['question']; ?></dt>
                                            <dd>
                                                <?php echo $faq['answer']; ?>
                                                <br />
                                                <span class="blue11"> <?php __('project_detail_last_update'); ?> <?php echo date('D M d,h:i a e', $faq['modified']); ?></span>
                                            </dd>
                                        <?php } ?>

										</dl>
<?php                                   } ?>   
                                </ul>
                            </div>
                        </div>
                        <?php if ($project_detail['User']['id'] != $this->Session->read('Auth.User.id')) { ?>
							<div id="helpbox">
							  <div class="fl rbluebg2 white14 pl10 pr33 width330"><span class="ptb7 block"><?php __('project_detail_have_question'); ?></span></div>
							  <div class="fl rbluebg3 white24 relative">
								  <div class="quoteicon">
									<?php echo $this->Html->image('quote2.png',array('width'=>'52','height'=>'46')); ?></div>
									<div class="fl"><?php echo $this->Html->link(__('project_detail_ask_question', true), 'javascript:void(0)', array('class' => 'pt10 pb9 plr20 block', 'id' => 'ask_question')); ?></div>
							  </div>
							 </div>
							 <div class="clr"></div>
							<div class="grey14 ptb21">
                                <?php echo $this->Html->link(__('project_detail_report_project_to', true) . ' ' . 'Boostbloom', 'javascript:void(0);', array('class' => 'pt10 pb9 plr20 block', 'id' => 'report_project')); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php echo $this->element('projects/project_detail_right_panel'); ?>
                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>
<div style="display: none;" id="bio_info"><?php echo $this->element('projects/user_bio');?></div> 
<div style="display: none;" id="widget_div"><?php echo $this->element('projects/widget_layout');?></div> 

