<?php
if (count($projects) > 0) 
{
    foreach ($projects as $project) 
	{
		$total_pledge_amount = 0;
		
        if ($type == 'stared') 
		{
			$total_pledge_amount = $this->GeneralFunctions->get_total_pledge_amount($project['Project']['Backer']); 
			$user_image_url=$this->GeneralFunctions->get_user_profile_image_using_user_array($project['Project']['User'],'20px','20px'); ?>
			
        <div class="project_box">
<?php		
			if ($project['Project']['active'] == 1 && $project['Project']['is_cancelled'] == 1) 
			{ // for cancelled ?>

			   <div class="cancelled_ribbon">
					<div class="cancelled_ribbon_left"></div>
					<div class="cancelled_ribbon_bg">
						<div class="ribbon_detail">
							<div class="fl blk15 lh33 pl10"><strong><?php __('frnt_cancelled'); ?></strong></div>
						</div>
					</div>
					<div class="cancelled_ribbon_right"></div>
				</div>

<?php		}
            else if ($project['Project']['project_end_date'] < time() && $total_pledge_amount >= $project['Project']['funding_goal']) 
			{ // for funded ?>
         
                <div class="green_ribbon">
					<div class="yellow_left"></div>
					<div class="yellow_bg">
						<div class="ribbon_detail">
							<div class="fl blk15 lh33 pl10"><strong><?php __('frnt_funded'); ?></strong></div>
						</div>
					</div>
					<div class="yellow_right"></div>
				</div>

<?php		} 
			else if($project['Project']['active'] == 1 && $project['Project']['project_end_date'] > time())
			{ // currently running ?>
                 
				<div class="green_ribbon">
					<div class="ribbon_left"></div>
					<div class="ribbon_bg">
						<div class="ribbon_detail">
							<div class="fl blk15 lh33 pl10"><strong><?php __('frnt_funding'); ?></strong></div>
						</div>
					</div>
					<div class="ribbon_right"></div>
				</div>
<?php		} ?>

             <div class="box_top"></div>
                <div class="clr"></div>
                <div class="box_bg">
                    <div class="mrgn_auto width90per">
                        <div class="fl pro_video">

<?php		echo $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'], "210px", "280px"), array('height' => 210, 'width' => 280)); ?>

                        </div>
                        <div class="pro_detail">
                            <div class="blue18" id="project_name">

<?php
			if ($project['Project']['title'] != '') 
			{
				if ($project['Project']['active'] == 1) {
					/** if project is active * */
					echo $this->Html->link(ucfirst($project['Project']['title']), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project['Project']['User']['slug'], $project['Project']['slug']));
				} else {
					/** if project is not active * */
					echo $this->Html->link(ucfirst($project['Project']['title']), array('plugin' => false, 'controller' => 'projects', 'action' => 'edit', $project['Project']['User']['slug'], $project['Project']['id'].'#basics'));
				}
			} 
			else 
			{
				/** if project do not have title * */
				echo $this->Html->link(__('profile_untitle_project', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'edit', $project['Project']['User']['slug'], $project['Project']['id'].'#basics'));
			}
?>
								<br />
                                <span class="grey11"><?php echo strtolower(__('frnt_by')); ?>&nbsp;<?php echo $this->Html->link($project['Project']['User']['name'],array('plugin'=>'users','controller'=>'users','action'=>'profile','slug'=>$project['Project']['User']['slug']),array('target'=>'_blank')); ?></span>
                            </div>
                            <div class="clr"></div>
                            <div class="pro_txt"><?php echo ucfirst($text->truncate($project['Project']['short_description'], 200, array('ending' => '...', 'exact' => false, 'html' => true))); ?></div>
                            <div class="clr pt10"></div>
                            <div>
                                    <?php if ($project['Project']['Category']['category_name'] != '') { ?>
                                    <div class="fl">
                                       <?php echo $this->Html->image('front/documentry.png', array('width' => '17', 'height' => '17')); ?>
                                    </div>
                                    <div class="grey11 fl pt2"><?php echo $this->Html->link($project['Project']['Category']['category_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'category_projects', $project['Project']['Category']['slug'])); ?></div>
                                    <?php } ?>
                                <div class="fl pl5">
                                        <?php echo $this->Html->image('front/location-icon.png', array('width' => '17', 'height' => '17')); ?>  
                                </div>
                                <div class="grey11 fl pt2">
                                    <?php
                                    $project_city_info = $this->GeneralFunctions->get_json_to_city_name($project['Project']['project_city_json']);
                                    echo $this->Html->link($project_city_info['city_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'city/' . $project_city_info['id']));
                                    ?>
                                </div>
                                <!-- Show Update And Faq to Owner -->    

                               <?php if (($slug == $this->Session->read('Auth.User.slug'))) { ?>
                                    <div class="grey12 fr pt2 pr10">
                                    <?php echo $this->Html->link(__('remove', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'delete_stared_project', $project['StaredProject']['id']), array('escape' => false)); ?>
                                    </div>
                                <?php
                                }
                                ?>
                                <!-- Show Update And Faq to Owner -->    

                            </div>
                            <div class="clr pt5"></div>
            <?php if ($project['Project']['active'] == 1) { ?>
                        <?php /** *******if project is activate********** */ ?>
                                <div class="fnction_bg">
                                    <div class="running">
                                        <div class="aligncenter mt10">
                                            <?php
                                            $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($project['Project']['id'], $project['Project']['funding_goal'], $project['Project']['Backer']);
                                            if ($total_funded_percentage > 100) {
                                                $total_funded_slider_percentage = 100;
                                            } else {
                                                $total_funded_slider_percentage = $total_funded_percentage;
                                            }
                                            ?>
                                            <div class="project-pledged-wrap">
                                                <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
                                            </div>
                                        </div>
                                        <div class="clr"></div>
                                        <div class="mrgn_auto width82per pt5">
                                            <div class="fl grey11"><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $total_pledge_amount; ?> <?php __('frnt_pledged'); ?> </div>
                                            <div class="fr grey11"><?php echo $total_funded_percentage; ?> %  <?php __('frnt_funded'); ?></div>
                                        </div>
                                    </div>
                                    <div class="backker pl10">
                                        <div class="grey22 mt9"><?php echo count($project['Project']['Backer']); ?><br/>
                                            <span class="grey11"><?php __('projt_dtl_project_backers'); ?></span>
                                        </div>
                                    </div>
                                    <div class="funded">
                                        <div class="grey22 mt9"><?php
                                      
                                        if ($project['Project']['project_end_date'] < time()  && $total_pledge_amount >= $project['Project']['funding_goal']) { // for funded 
                                            __('frnt_funded');
                                        }else{
                                              
                                                if($project['Project']['active']==1 && $project['Project']['project_end_date'] > time()){ // currently running
                                                     __('frnt_funding');
                                                }
                    
                                            }
                                            
                                        ?><br/>
                                            <span class="grey11"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $project['Project']['project_end_date']); ?></span>
                                        </div>
                                    </div>
                                </div> 

<?php				}
					else 
					{ 
						/** *******if project is not activated********** */ ?>
						
                                <div class="fnction_bg">
                                    <div class="running">
                                        <div class="project-not-launched">
                                            <strong><?php __('project_not_launched'); ?></strong>
                                        </div>
                                    </div>
                                    <div class="ml10 pt15">
                                        <span class="grey14">(<?php __('only_u_can_c'); ?>)</span>
                                    </div>
                                </div>
<?php				} ?>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="box_bot"></div>
            </div>
            <div class="clr pt15"></div>
<?php 
		} // end of starred projects
		else
		{ // Start For non-starred projects
		
			$total_pledge_amount = $this->GeneralFunctions->get_total_pledge_amount($project['Backer']);  ?>
			
            <div class="project_box">
			
<?php 		if ($project['Project']['active'] == 1 && $project['Project']['is_cancelled'] == 1) 
			{ // for cancelled ?>

			   <div class="cancelled_ribbon">
					<div class="cancelled_ribbon_left"></div>
					<div class="cancelled_ribbon_bg">
						<div class="ribbon_detail">
							<div class="fl blk15 lh33 pl10"><strong><?php __('frnt_cancelled'); ?></strong></div>
						</div>
					</div>
					<div class="cancelled_ribbon_right"></div>
				</div>

<?php		}
			else if ($project['Project']['active'] == 1 && 
					 $project['Project']['project_end_date'] < time() && 
					 $total_pledge_amount >= $project['Project']['funding_goal']) 
			{ // for funded ?>

				<div class="green_ribbon">
					<div class="yellow_left"></div>
					<div class="yellow_bg">
						<div class="ribbon_detail">
							<div class="fl blk15 lh33 pl10"><strong><?php __('frnt_funded'); ?></strong></div>
						</div>
					</div>
					<div class="yellow_right"></div>
				</div>

<?php		} 
			else if($project['Project']['active'] == 1 && $project['Project']['project_end_date'] > time())
			{ // currently running ?>
          
				<div class="green_ribbon">
					<div class="ribbon_left"></div>
					<div class="ribbon_bg">
						<div class="ribbon_detail">
							<div class="fl blk15 lh33 pl10"><strong><?php __('frnt_funding'); ?></strong></div>
						</div>
					</div>
					<div class="ribbon_right"></div>
				</div>
			
<?php		} ?>

                <div class="box_top"></div>
                <div class="clr"></div>
                <div class="box_bg">
                    <div class="mrgn_auto width90per">
                        <div class="fl pro_video">
<?php		echo $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'], "210px", "280px"), array('height' => 210, 'width' => 280)); ?>
                        </div>
                        <div class="pro_detail">
                            <div class="blue18" id="project_name">

<?php		if ($project['Project']['title'] != '') 
			{
				if ($project['Project']['active'] == 1) 
				{
					/** if project is active * */
					echo $this->Html->link(ucfirst($project['Project']['title']), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project['User']['slug'], $project['Project']['slug']));
				} 
				else 
				{
					/** if project is not active * */
					echo $this->Html->link(ucfirst($project['Project']['title']), array('plugin' => false, 'controller' => 'projects', 'action' => 'edit', $project['User']['slug'], $project['Project']['id'].'#basics'));
				}
			} 
			else 
			{
				/** if project do not have title * */
				echo $this->Html->link(__('profile_untitle_project', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'edit', $project['User']['slug'], $project['Project']['id'].'#basics'));
			}
?>
								<br>
								<span class="grey11"><?php echo strtolower(__('frnt_by')); ?>&nbsp;<?php echo $this->Html->link($project['User']['name'],array('plugin'=>'users','controller'=>'users','action'=>'profile','slug'=>$project['User']['slug']),array('target'=>'_blank')); ?></span>
							</div>
                            <div class="clr"></div>
                            <div class="pro_txt"><?php echo ucfirst($text->truncate($project['Project']['short_description'], 200, array('ending' => '...', 'exact' => false, 'html' => true))); ?></div>
                            <div class="clr pt10"></div>
                            <div>

<?php		if ($project['Category']['category_name'] != '') 
			{ ?>
							<div class="fl">
							<?php echo $this->Html->image('front/documentry.png', array('width' => '17', 'height' => '17')); ?>
							</div>
							<div class="grey11 fl pt2"><?php echo $this->Html->link($project['Category']['category_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'category_projects', $project['Category']['slug'])); ?></div>

<?php		} ?>
							<div class="fl pl5">
								<?php echo $this->Html->image('front/location-icon.png', array('width' => '17', 'height' => '17')); ?>  
							</div>
							
							<div class="grey11 fl pt2">

<?php		$project_city_info = $this->GeneralFunctions->get_json_to_city_name($project['Project']['project_city_json']);
			echo $this->Html->link($project_city_info['city_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'city/' . $project_city_info['id']));
?>
							</div>
							<div class="clr pt5"></div>
                                <!-- Show Update And Faq to Owner -->    

<?php 		if (($project['Project']['active'] == 1 ) && 
				($project['User']['id'] == $this->Session->read('Auth.User.id')) && 
				 $project['Project']['is_cancelled']==0) 
			{ ?>

							<div class="grey12 fr pt2">
<?php echo $this->Html->link(__('profile_project_faq', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_faq', $project['User']['slug'], $project['Project']['slug']), array('escape' => false)); ?>
							</div> 

							<div class="grey12 fr pt2 pr10">
<?php echo $this->Html->link(__('profile_project_update', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update', $project['User']['slug'], $project['Project']['slug']), array('escape' => false)); ?>
							</div>
							
<?php		}

			// show edit link if project is not finished yet to user 
			if ($project['User']['id'] == $this->Session->read('Auth.User.id')) 
			{
				$remaining_time = $this->GeneralFunctions->get_remainig_time(time(), $project['Project']['project_end_date']);
				if ((($remaining_time > 0) || $project['Project']['active'] != 1) && $project['Project']['is_cancelled']==0) 
				{ ?>
							<div class="grey12 fr pt2 pr10">
<?php echo $this->Html->link(__('project_edit', true).'*', array('plugin' => false, 'controller' => 'projects', 'action' => 'edit',$project['User']['slug'], $project['Project']['id'].'#basics'), array('escape' => false)); ?>&nbsp;
							</div> 
                                      
<?php			} 
             
				if (($remaining_time > 0) && 
					($project['Project']['active']==1) && 
					$project['Project']['is_cancelled']==0)
				{  // show cancel link  ?> 
							<div class="grey12 fr pt2 pr10"></div> 
<?php 			} 
			} ?>
            
			<!-- Show Update And Faq to Owner -->    

						</div>
						<div class="clr pt5"></div>
						
<?php		if ($project['Project']['active'] == 1) 
			{ 
				/** *******if project is activate********** */ ?>
				
						<div class="fnction_bg">
							<div class="running">
							<div class="aligncenter mt10">

<?php			$total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($project['Project']['id'], $project['Project']['funding_goal'], $project['Backer']);
				if ($total_funded_percentage > 100) 
				{
					$total_funded_slider_percentage = 100;
				} 
				else 
				{
					$total_funded_slider_percentage = $total_funded_percentage;
				}
?>
							<div class="project-pledged-wrap">
								<div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
							</div>
						</div>
						<div class="clr"></div>
						<div class="mrgn_auto width82per pt5">
							<div class="fl grey11"><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $total_pledge_amount; ?> <?php __('frnt_pledged'); ?> </div>
							<div class="fr grey11"><?php echo $total_funded_percentage; ?> %  <?php __('frnt_funded'); ?></div>
						</div>
					</div>
					
					<div class="backker pl10">
						<div class="grey22 mt9"><?php echo count($project['Backer']); ?><br/>
							<span class="grey11"><?php __('projt_dtl_project_backers'); ?></span>
						</div>
					</div>
					<div class="funded">
						<div class="grey22 mt9">
						
<?php			if ($project['Project']['project_end_date'] < time() && $total_pledge_amount >= $project['Project']['funding_goal']) 
				{
					__('frnt_funded');
				}
				else if($project['Project']['active']==1 && $project['Project']['project_end_date'] > time())
				{ // currently running
					__('frnt_funding');
				}
?>
							<br/>
							<span class="grey11"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $project['Project']['project_end_date']); ?></span>
						</div>
					</div>
                                     
				</div> 
                            
<?php			if($type == 'created')
				{ 	
					if ($project['Project']['is_cancelled']==1 ) 
					{ ?>
						<div class="project-cancelled">
							<strong><?php __('frnt_project_cancelled'); ?></strong>
						</div>
<?php				} 
					else 
					{ ?>
						<div class="project-launched">
							<strong><?php __('project_launched'); ?></strong>
						</div>
<?php 				} 
				} 
			}
            else if($project['Project']['active'] == 2)
			{ 
                 /* If project is rejected by admin */ ?>
						<div class="fnction_bg">
							<div class="running">
								<div class="project-not-approved">
									<strong><?php echo sprintf(__('project_rejected',true),  Configure::read('CONFIG_SITE_TITLE')) ; ?></strong>
								</div>
							</div>
							<div class="ml10 pt15">
								<span class="grey14">(<?php __('only_u_can_c'); ?>)</span>
							</div>
						</div>
<?php		}
            else 
			{
				if($project['Project']['submitted_status'] == "1")
				{
				/** *******if project is not activated********** */ ?>
						<div class="fnction_bg">
							<div class="running">
								<div class="project-not-launched">
									<strong><?php __('Pending Approval'); ?></strong>
								</div>
							</div>
							<div class="ml10 pt15">
								<span class="grey14">(<?php __('only_u_can_c'); ?>)</span>
							</div>
						</div>
<?php 			}
				else
				{ ?>
						<div class="fnction_bg">
							<div class="running">
								<div class="project-not-launched">
									<strong><?php __('project_not_launched'); ?></strong>
								</div>
							</div>
							<div class="ml10 pt15">
								<span class="grey14">(<?php __('only_u_can_c'); ?>)</span>
							</div>
						</div>	
<?php						
				}

			}?>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="box_bot"></div>
            </div>
            <div class="clr pt15"></div>
        <?php }
        } ?>
    <?php
    if ($this->params['isAjax']) {
        if ($current_page != $last_page) {
            echo "=================" . $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'load_more_project_content/' . $type . '/' . $slug . '/page:' . $page));
        } else {
            echo "=================";
        }
    }
} else {
    if ($this->params['action'] == 'backed_projects') {
        ?>
        <div class="aligncenter pt40 grey14">
            <?php
            if ($this->Session->read('Auth.User.slug') == $slug) {
                $msg = sprintf(__('profile_project_backer_empty', true), $this->Html->link(__('discover', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'discover'), array('class' => 'blue16 ')));
            } else {
                $msg = sprintf(__('profile_project_backer_empty_other_users', true), $this->data['User']['name']);
            }
            ?>
        </div>
        <?php } else if ($this->params['action'] == 'starred_projects') { ?>
        <div class="aligncenter pt40 grey14">
            <?php
            if ($this->Session->read('Auth.User.slug') == $slug) {
                $msg = sprintf(__('profile_project_starred_empty', true), $this->Html->link(__('profile_find_now_lnk', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'discover'), array('class' => 'blue16 ')));
            } else {
                $msg = sprintf(__('profile_project_starred_empty_other_users', true), $this->data['User']['name']);
            }
            ?>
        </div>
        <?php } else if ($this->params['action'] == 'created_projects') { ?>
        <div class="aligncenter pt40 grey14"><?php
        if ($this->Session->read('Auth.User.slug') == $slug) {
            $msg = sprintf(__('profile_project_created_empty', true), $this->Html->link(__('profile_start_your_project_lnk', true), array('plugin' => false, 'controller' => 'home', 'action' => 'start'), array('class' => 'blue16 ')));
        } else {
            $msg = sprintf(__('profile_project_created_empty_other_users', true), $this->data['User']['name']);
        }
        ?></div>
    <?php } else if($this->params['action'] == 'user_comments'){?>
	
	<!--for new view page-->
		  <div class="aligncenter pt40 grey14"><?php
        if ($this->Session->read('Auth.User.slug') == $slug) {
            $msg = sprintf(__('profile_project_created_empty', true), $this->Html->link(__('profile_start_your_project_lnk', true), array('plugin' => false, 'controller' => 'home', 'action' => 'start'), array('class' => 'blue16 ')));
        } else {
            $msg = sprintf(__('profile_project_created_empty_other_users', true), $this->data['User']['name']);
        }
        ?></div>
	<?php }?>
    <div class="pt40 aligncenter grey14"><?php echo $msg; ?> </div>
<?php } ?>