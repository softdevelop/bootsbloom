<div class="grey_gradient">   
   <div class="pt20">
	<div class="wrapper" >
            <h2 class="pageheading"><?php __('discover'); ?>
	                                    <div class="pb1 ">
										 </div>
                                <span class="grey16"<strong><?php __('abound'); ?>
                                                        </h3>
														
    </div>
	    </div>
</div>

<div class="ptb21">
    <div class="wrapper">
        <div class="fl width75per">
            <!-- Staff Picks Section -->
            <?php if (!empty($staff_projects)) { ?>
                <div
				
                    <h3><?php __('staff_picker'); ?></h3>
                    <div>
                        <?php foreach ($staff_projects as $staff_project) { ?>
                            <div class="fl mr25 mb15">
                                <div>
                                    <div class="sprite listingbxtl"></div>
                                    <div class="listingbxt"></div>
                                    <div class="sprite listingbxtr"></div>
                                    <div class="clr"></div>
                                </div>
                                <div class="listingbxmid height411" >
                                    <div class="pb14 ">
                                        <?php 
                                        echo $this->Html->link($this->Html->image($this->GeneralFunctions->show_project_image($staff_project['Project']['image'], "150px", "200px"), array('height' => 150, 'width' => 200)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $staff_project['User']['slug'], $staff_project['Project']['slug']),array('title'=>$staff_project['Project']['title'],'escape'=>false)); 
                                        ?>
                                    </div>
                                    <div class="grey13 height155 mb8 overflow" > 
                                        <span class="blue14 block pb9">
                                            <?php echo $this->Html->link(ucfirst(substr($staff_project['Project']['title'], 0, 30)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $staff_project['User']['slug'], $staff_project['Project']['slug']),array('title'=>$staff_project['Project']['title'])); ?>
                                        </span>
										
                                        <span class="block pb17 blue13"><?php __('frnt_by'); ?> <?php echo $this->Html->link(ucfirst($staff_project['User']['name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $staff_project['User']['slug'])); ?></span>
                                        <?php echo ucfirst(substr($staff_project['Project']['short_description'], 0, 200)); ?>
                                    </div>
                                    <div class="clr"></div>
                                    <div class="mt29">
                                        <?php
                                        $total_pledge_amount = $this->GeneralFunctions->get_total_pledge_amount($staff_project['Backer']);
                                        $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($staff_project['Project']['id'], $staff_project['Project']['funding_goal'], $staff_project['Backer']);
                                        if ($total_funded_percentage > 100) {
                                            $total_funded_slider_percentage = 100;
                                        } else {
                                            $total_funded_slider_percentage = $total_funded_percentage;
                                        }
                                        ?>
                                        <?php if (($staff_project['Project']['project_end_date'] < time()) && ($total_pledge_amount >= $staff_project['Project']['funding_goal'])) { ?>
                                            <!-- Success Bar -->
                                            <div class="greenbg">
                                                <div class="white_dark aligncenter">
                                                    <span style="height: 5px"><?php __('cont_successful'); ?>&nbsp;!</span> 

                                                </div>
                                            </div>
                                            <!-- End Success Bar -->
                                            <?php }
                                            // for unsuccessful projects 
                                        if (($staff_project['Project']['project_end_date'] < time()) && ($total_pledge_amount < $staff_project['Project']['funding_goal'])) {
                                            ?>
                                            <div class="yellow_unsuccess_bg">
                                                <div class="white_dark aligncenter">
                                                    <span style="height: 5px"><?php __('cont_funding_unsuccessful'); ?>&nbsp;!</span> 

                                                </div>
                                            </div>
                                            <?php
                                        }
                                        // for running projects
                                        if ($staff_project['Project']['project_end_date'] > time()) { ?>                         
                                            <!-- Slider Bar -->
                                            <div class="" >
                                                <div class="project-pledged-wrap">
                                                    <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="grey13 pt10">
                                            <div class="fl pr7"><strong><?php echo $total_funded_percentage; ?>%</strong> <br>
                                                <?php __('frnt_funded'); ?></div>
                                            <div class="fl pl7 pr7"><strong><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $total_pledge_amount; ?></strong> <br>
                                                <?php __('frnt_pledged'); ?></div>
                                            <div class="fl pl7">
                                                <?php $time_rem = $this->GeneralFunctions->show_left_time(time(), $staff_project['Project']['project_end_date']); ?>
                                                <strong><?php echo $time_rem['time']; // echo $this->GeneralFunctions->dateDiffTs(time(), $staff_project['Project']['project_end_date']);   ?></strong> <br>
                                                <?php echo sprintf(__('frnt_daystogo', true), $time_rem['unit']); //__('frnt_daystogo');  ?>
                                            </div>
                                            <div class="clr"></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="sprite listingbxbl"></div>
                                    <div class="listingbxb"></div>
                                    <div class="sprite listingbxbr"></div>
                                    <div class="clr"></div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="clr"></div>
                    </div>
                    <div class="morebutton mr42"> 
                        <?php echo $this->Html->link('<span>' . __('c_more_staff_picker', true) . '</span>', array('plugin' => false, 'controller' => 'projects', 'action' => 'staff_picks'), array('class' => 'fr', 'escape' => false)); ?>
                    </div>
                </div>
                <div class="clr">
                    <?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "10")); ?>
                </div>
            <?php } ?>
            <!-- Staff Picks Section  END -->
            <!-- Most Pledge This Week Section -->
            <?php if (!empty($most_pledge_this_week)) { ?>  
                <div>
                    <h3><?php __('popular_this_week'); ?></h3>
                    <div>
                        <?php foreach ($most_pledge_this_week as $m_pledge_this_week) { ?>
                            <div class="fl mr25 mb15">
                                <div>
                                    <div class="sprite listingbxtl"></div>
                                    <div class="listingbxt"></div>
                                    <div class="sprite listingbxtr"></div>
                                    <div class="clr"></div>
                                </div>
                                <div class="listingbxmid height411" >
                                    <div class="pb14 ">
                                        <?php 
                                        echo $this->Html->link($this->Html->image($this->GeneralFunctions->show_project_image($m_pledge_this_week['Project']['image'], "150px", "200px"), array('height' => 150, 'width' => 200)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $m_pledge_this_week['Project']['User']['slug'], $m_pledge_this_week['Project']['slug']),array('title'=>$m_pledge_this_week['Project']['title'],'escape'=>false)); 
                                        ?>
                                    </div>
                                    <div class="grey13 height155 mb8 overflow" > 
                                        <span class="blue14 block pb9">
                                            <?php echo $this->Html->link(ucfirst(substr($m_pledge_this_week['Project']['title'], 0, 30)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $m_pledge_this_week['Project']['User']['slug'], $m_pledge_this_week['Project']['slug']),array('title'=>$m_pledge_this_week['Project']['title'])); ?>
                                        </span>
                                        <span class="block pb17 blue13"><?php __('frnt_by'); ?>	<?php echo $this->Html->link(ucfirst($m_pledge_this_week['Project']['User']['name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $m_pledge_this_week['Project']['User']['slug'])); ?></span>
                                        <?php echo ucfirst(substr($m_pledge_this_week['Project']['short_description'], 0, 200)); ?>
                                    </div>
                                    <div class="clr"></div>
                                    <div class="mt29 ">
                                        <?php
                                        $total_pledge_amount = $this->GeneralFunctions->get_total_pledge_amount($m_pledge_this_week['Project']['Backer']);
                                        $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($m_pledge_this_week['Project']['id'], $m_pledge_this_week['Project']['funding_goal'], $m_pledge_this_week['Project']['Backer']);
                                        if ($total_funded_percentage > 100) {
                                            $total_funded_slider_percentage = 100;
                                        } else {
                                            $total_funded_slider_percentage = $total_funded_percentage;
                                        }
                                        ?> 
                                        <?php if (($m_pledge_this_week['Project']['project_end_date'] < time()) && ($total_pledge_amount >= $m_pledge_this_week['Project']['funding_goal'])) { ?>
                                            <!-- Success Bar -->

                                            <div class="greenbg">
                                                <div class="white_dark aligncenter">
                                                    <span style="height: 5px"><?php __('cont_successful'); ?>&nbsp;!</span> 

                                                </div>
                                            </div>

                                            <!-- End Success Bar -->
                                            <?php
                                        }

                                        // for unsuccessful projects 
                                        if (($m_pledge_this_week['Project']['project_end_date'] < time()) && ($total_pledge_amount < $m_pledge_this_week['Project']['funding_goal'])) {
                                            ?>

                                            <div class="yellow_unsuccess_bg">
                                                <div class="white_dark aligncenter">
                                                    <span style="height: 5px"><?php __('cont_funding_unsuccessful'); ?>&nbsp;!</span> 

                                                </div>
                                            </div>
                                            <?php   } // for running projects
                                        if ($m_pledge_this_week['Project']['project_end_date'] > time()) { ?>                         
                                            <!-- Slider Bar -->
                                            <div class="" >
                                                <div class="project-pledged-wrap">
                                                    <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="grey13 pt10">
                                            <div class="fl pr7"><strong><?php echo $total_funded_percentage; ?>%</strong> <br>
                                                <?php __('frnt_funded'); ?></div>
                                            <div class="fl pl7 pr7"><strong><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $total_pledge_amount; ?></strong> <br>
                                                <?php __('frnt_pledged'); ?></div>
                                            <div class="fl pl7">
                                                <?php $time_rem = $this->GeneralFunctions->show_left_time(time(), $m_pledge_this_week['Project']['project_end_date']); ?>
                                                <strong><?php echo $time_rem['time'];?></strong> <br>
                                                <?php echo sprintf(__('frnt_daystogo', true), $time_rem['unit']);?>
                                            </div>
                                            <div class="clr"></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="sprite listingbxbl"></div>
                                    <div class="listingbxb"></div>
                                    <div class="sprite listingbxbr"></div>
                                    <div class="clr"></div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="clr"></div>
                    </div>
                </div>
                <div class="morebutton mr42">
                    <?php echo $this->Html->link('<span>' . __('c_more_popular_project', true) . '</span>', array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'popular'), array('class' => 'fr', 'escape' => false)); ?>
                </div>
                <div class="clr">
                    <?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "10")); ?>
                </div>
            <?php } ?>
            <!-- Most Pledge This Week Section End  -->
            <!-- Recently Successful Project Section -->
            <?php if (!empty($recently_funded_projects)) { ?>
                <div>
                    <h3><?php __('recent_successful'); ?></h3>
                    <div>
                        <?php foreach ($recently_funded_projects as $recently_funded_project) { ?>
                            <div class="fl mr25 mb15">
                                <div>
                                    <div class="sprite listingbxtl"></div>
                                    <div class="listingbxt"></div>
                                    <div class="sprite listingbxtr"></div>
                                    <div class="clr"></div>
                                </div>
                                <div class="listingbxmid height411" >
                                    <div class="pb14 ">
                                        <?php 
                                        echo $this->Html->link($this->Html->image($this->GeneralFunctions->show_project_image($recently_funded_project['Project']['image'], "150px", "200px"), array('height' => 150, 'width' => 200)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $recently_funded_project['User']['slug'], $recently_funded_project['Project']['slug']),array('title'=>$recently_funded_project['Project']['title'],'escape'=>false)); 
                                        ?>
                                    </div>
                                    <div class="grey13 height155 mb8 overflow" > 
                                        <span class="blue14 block pb9">
                                            <?php echo $this->Html->link(ucfirst(substr($recently_funded_project['Project']['title'], 0, 30)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $recently_funded_project['User']['slug'], $recently_funded_project['Project']['slug']),array('title'=>$recently_funded_project['Project']['title'])); ?>
                                        </span>
                                        <span class="block pb17 blue13"><?php __('frnt_by'); ?> 
										<?php echo $this->Html->link(ucfirst($recently_funded_project['User']['name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $recently_funded_project['User']['slug'])); ?></span>
                                        <?php echo ucfirst(substr($recently_funded_project['Project']['short_description'], 0, 200)); ?>
                                    </div>
                                    <div class="clr"></div>
                                    <div class="mt29 ">
                                        <?php
                                        $total_pledge_amount = $this->GeneralFunctions->get_total_pledge_amount($recently_funded_project['Project']['Backer']);
                                        $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($recently_funded_project['Project']['id'], $recently_funded_project['Project']['funding_goal'], $recently_funded_project['Backer']);
                                        if ($total_funded_percentage > 100) {
                                            $total_funded_slider_percentage = 100;
                                        } else {
                                            $total_funded_slider_percentage = $total_funded_percentage;
                                        }
                                        ?> 
                                        <?php if (($recently_funded_project['Project']['project_end_date'] < time()) && ($total_pledge_amount >= $recently_funded_project['Project']['funding_goal'])) { ?>
                                            <!-- Success Bar -->

                                            <div class="greenbg">
                                                <div class="white_dark aligncenter">
                                                    <span style="height: 5px"><?php __('cont_successful'); ?>&nbsp;!</span> 

                                                </div>
                                            </div>

                                            <!-- End Success Bar -->
                                            <?php
                                        }
                                        // for unsuccessful projects 
                                        if (($recently_funded_project['Project']['project_end_date'] < time()) && ($total_pledge_amount < $recently_funded_project['Project']['funding_goal'])) {
                                            ?>
                                            <div class="yellow_unsuccess_bg">
                                                <div class="white_dark aligncenter">
                                                    <span style="height: 5px"><?php __('cont_funding_unsuccessful'); ?>&nbsp;!</span> 
                                                </div>
                                            </div>
                                            <?php } // for running projects
                                        if ($recently_funded_project['Project']['project_end_date'] > time()) { ?>                         
                                            <!-- Slider Bar -->
                                            <div class="" >
                                                <div class="project-pledged-wrap">
                                                    <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="grey13 pt10">
                                            <div class="fl pr7"><strong><?php echo $total_funded_percentage; ?>%</strong> <br>
                                                <?php __('frnt_funded'); ?></div>
                                            <div class="fl pl7 pr7"><strong><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $total_pledge_amount; ?></strong> <br>
                                                <?php __('frnt_pledged'); ?></div>
                                            <div class="fl pl7">
                                                <?php $time_rem = $this->GeneralFunctions->show_left_time(time(), $recently_funded_project['Project']['project_end_date']); ?>
                                                <strong><?php echo $time_rem['time']; ?></strong> <br>
                                                <?php echo sprintf(__('frnt_daystogo', true), $time_rem['unit']); //__('frnt_daystogo');  ?>
                                            </div>
                                            <div class="clr"></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="sprite listingbxbl"></div>
                                    <div class="listingbxb"></div>
                                    <div class="sprite listingbxbr"></div>
                                    <div class="clr"></div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="clr"></div>
                    </div>
                    <div class="morebutton mr42"> 
                        <a href="#" class="fr"><span><?php __('c_more_successful_project'); ?></span></a> 
                    </div>
                </div>
                <div class="clr">
                    <?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "10")); ?>
                </div>
            <?php } ?>
            <!-- Recently Successful Project Section End-->
            <!-- Most Funded Project Section -->
            <?php if (!empty($most_pledge_projects)) { ?>
                <div>
                    <h3><?php __('most_funded'); ?></h3>
                    <div>
                        <?php foreach ($most_pledge_projects as $most_pledge) { ?>
                            <div class="fl mr25 mb15">
                                <div>
                                    <div class="sprite listingbxtl"></div>
                                    <div class="listingbxt"></div>
                                    <div class="sprite listingbxtr"></div>
                                    <div class="clr"></div>
                                </div>
                                <div class="listingbxmid height411" >
                                    <div class="pb14 ">
                                        <?php 
                                        echo $this->Html->link($this->Html->image($this->GeneralFunctions->show_project_image($most_pledge['Project']['image'], "150px", "200px"), array('height' => 150, 'width' => 200)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $most_pledge['Project']['User']['slug'], $most_pledge['Project']['slug']),array('title'=>$most_pledge['Project']['title'],'escape'=>false)); 
                                        ?>
                                    </div>
                                    <div class="grey13 height155 mb8 overflow" > 
                                        <span class="blue14 block pb9">
                                            <?php echo $this->Html->link(ucfirst(substr($most_pledge['Project']['title'], 0, 30)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $most_pledge['Project']['User']['slug'], $most_pledge['Project']['slug']),array('title'=>$most_pledge['Project']['title'])); ?>
                                        </span>
                                        <span class="block pb17 blue13"><?php __('frnt_by'); ?> 
										<?php echo $this->Html->link(ucfirst($most_pledge['Project']['User']['name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $most_pledge['Project']['User']['slug'])); ?></span>
                                        <?php echo ucfirst(substr($most_pledge['Project']['short_description'], 0, 200)); ?>
                                    </div>
                                    <div class="clr"></div>

                                    <div class="mt29 ">
                                        <?php
                                        $total_pledge_amount = $this->GeneralFunctions->get_total_pledge_amount($most_pledge['Project']['Backer']);
                                        $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($most_pledge['Project']['id'], $most_pledge['Project']['funding_goal'], $most_pledge['Project']['Backer']);
                                        if ($total_funded_percentage > 100) {
                                            $total_funded_slider_percentage = 100;
                                        } else {
                                            $total_funded_slider_percentage = $total_funded_percentage;
                                        }
                                        ?> 
                                        <?php if (($most_pledge['Project']['project_end_date'] < time()) && ($total_pledge_amount >= $most_pledge['Project']['funding_goal'])) { ?>
                                            <!-- Success Bar -->

                                            <div class="greenbg">
                                                <div class="white_dark aligncenter">
                                                    <span style="height: 5px"><?php __('cont_successful'); ?>&nbsp;!</span> 

                                                </div>
                                            </div>

                                            <!-- End Success Bar -->
                                            <?php
                                        }
                                        // for unsuccessful projects 
                                        if (($most_pledge['Project']['project_end_date'] < time()) && ($total_pledge_amount < $most_pledge['Project']['funding_goal'])) {
                                            ?>

                                            <div class="yellow_unsuccess_bg">
                                                <div class="white_dark aligncenter">
                                                    <span style="height: 5px"><?php __('cont_funding_unsuccessful'); ?>&nbsp;!</span> 

                                                </div>
                                            </div>
                                            <?php } // for running projects
                                              if ($most_pledge['Project']['project_end_date'] > time()) {
                                            ?>                         
                                            <!-- Slider Bar -->
                                            <div class="" >
                                                <div class="project-pledged-wrap">
                                                    <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="grey13 pt10">
                                            <div class="fl pr7"><strong><?php echo $total_funded_percentage; ?> %</strong> <br>
                                                <?php __('frnt_funded'); ?></div>
                                            <div class="fl pl7 pr7"><strong><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $total_pledge_amount; ?></strong> <br>
                                                <?php __('frnt_pledged'); ?></div>
                                            <div class="fl pl7">
                                                <?php /* strong><?php echo $this->GeneralFunctions->dateDiffTs(time(), $recently_funded_project['Project']['project_end_date']); ?></strong> <br>
                                                  <?php __('frnt_daystogo'); */ ?>
                                                <?php $time_rem = $this->GeneralFunctions->show_left_time(time(), $most_pledge['Project']['project_end_date']); ?>
                                                <strong><?php echo $time_rem['time']; // echo $this->GeneralFunctions->dateDiffTs(time(), $staff_project['Project']['project_end_date']);   ?></strong> <br>
                                                <?php echo sprintf(__('frnt_daystogo', true), $time_rem['unit']); //__('frnt_daystogo');  ?>
                                            </div>
                                            <div class="clr"></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="sprite listingbxbl"></div>
                                    <div class="listingbxb"></div>
                                    <div class="sprite listingbxbr"></div>
                                    <div class="clr"></div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="clr"></div>
                    </div>
                    <div class="morebutton mr42">
                        <?php echo $this->Html->link('<span>' . __('c_more_most_funded_project', true) . '</span>', array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'most_funded'), array('class' => 'fr', 'escape' => false)); ?>
                    </div>
                </div>

                <div class="clr">
                    <?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "10")); ?>
                </div>
            <?php } ?>
            <!-- Most Funded Project Section End -->
            <!-- Project Updates Section Start -->
            <?php if (!empty($projects_updates)) { ?>
                <div class="right_box mt17">
                    <div class="p15">
                        <div class="grey13_dark pt10">
                            <h3><?php __('fascinating_post_project_new_old'); ?></h3>
                        </div>
                        <div>
                            <?php foreach ($projects_updates as $projects_update) {  //pr($projects_update); ?>
                                <div>
                                    <div class="pt15">
                                        <div class="img_box">
                                            <?php 
                                            echo $this->Html->link($this->Html->image($this->GeneralFunctions->show_project_image($projects_update['Project']['image'], "100px", "160px"), array('height' => 100, 'width' => 160)), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update_detail', $projects_update['Project']['User']['slug'], $projects_update['Project']['slug'], $projects_update['ProjectUpdate']['id']),array('escape'=>false)); 
                                          
                                            ?>

                                        </div>
                                        <div class="width75per fr">
                                            <div class="grey12 pt5">
                                                <span class="blue15"><?php echo $this->Html->link($projects_update['ProjectUpdate']['title'], array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update_detail', $projects_update['Project']['User']['slug'], $projects_update['Project']['slug'], $projects_update['ProjectUpdate']['id'])); ?></span> 
                                                <br />
                                                <?php echo $text->truncate($projects_update['ProjectUpdate']['description'], 200, array('ending' => '...', 'exact' => false, 'html' => true)); ?>
                                                <div class="pt10">
                                                    <span class="documentry-grey">

                                                        <?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $projects_update['ProjectUpdate']['created']); ?>
                                                    </span> <?php echo $this->Html->link(count($projects_update['ProjectUpdateComment']) . ' ' . __('projt_dtl_project_comment', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update_detail', $projects_update['Project']['User']['slug'], $projects_update['Project']['slug'], $projects_update['ProjectUpdate']['id'])); ?> </a>            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clr pt10"></div>
                                    <div class="dot_border"></div>
                                    <div class="clr pt10"></div>
                                </div>
                            <?php } ?>
                            <div class="blue14">&raquo;  
                                <?php echo $this->Html->link(__('c_more_project_update', true), array('plugin' => false, 'controller' => 'project_updates', 'action' => 'index')); ?>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
                <div class="clr">
                    <?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "10")); ?>
                </div>
                <!-- Projects Updates Section end -->
            <?php } ?>
        </div>
        <?php echo $this->element('discover_right_panel'); ?>
    </div>
    <div class="clr"></div>
</div>
