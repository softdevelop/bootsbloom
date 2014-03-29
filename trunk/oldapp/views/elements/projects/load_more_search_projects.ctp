<?php 
if ($staff_projects) {
    foreach ($staff_projects as $staff_project) {
    ?>

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
                     echo $this->Html->link($this->Html->image($this->GeneralFunctions->show_project_image($staff_project['Project']['image'], "150px", "200"), array('height' => 150, 'width' => 200)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $staff_project['User']['slug'], $staff_project['Project']['slug']),array('title'=>$staff_project['Project']['title'],'escape'=>false)); 
                    ?>
                </div>
                <div class="grey13 height155 mb8 overflow" > 
                    <span class="blue14 block pb9">
                        <?php echo $this->Html->link(ucfirst(substr($staff_project['Project']['title'], 0, 30)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $staff_project['User']['slug'], $staff_project['Project']['slug']),array('title'=>$staff_project['Project']['title'])); ?>
                    </span>
                    <span class="block pb17 blue13"><?php __('frnt_by'); ?> <?php echo $this->Html->link(ucfirst($staff_project['User']['name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $staff_project['User']['slug'])); ?>
					<?php //echo ucfirst($staff_project['User']['name']); ?></span>
                    <?php echo ucfirst(substr($staff_project['Project']['short_description'], 0, 200)); ?>
                </div>
                <div class="clr"></div>
                <div class="mt29 ">
                     <?php
                        $total_pledge_amount    = $this->GeneralFunctions->get_total_pledge_amount($staff_project['Backer']);
                        
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
                                        <span style="height: 5px"><?php  __('cont_successful');?>&nbsp;!</span> 

                                    </div>
                                </div>

                                <!-- End Success Bar -->
                            <?php
                            }
                            
                            // for unsuccessful projects 
                            if (($staff_project['Project']['project_end_date'] < time()) && ($total_pledge_amount < $staff_project['Project']['funding_goal'])) {  ?>
                                
                                <div class="yellow_unsuccess_bg">
                                    <div class="white_dark aligncenter">
                                        <span style="height: 5px"><?php  __('cont_funding_unsuccessful');?>&nbsp;!</span> 

                                    </div>
                                </div>
                            <?php } 
                            
                            // for running projects
                            if ($staff_project['Project']['project_end_date'] > time()) {
                                ?>                         

                                <!-- Slider Bar -->
                                <div class="" >

                                    <div class="project-pledged-wrap">
                                        <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
                                    </div>
                                </div>
                            <?php } ?>

                    <div class="grey13 pt10">
                        <div class="fl pr7"><strong><?php echo $total_funded_percentage; ?> %</strong> <br />
                                                							   <?php __('frnt_funded');?></div>
                        <div class="fl pl7 pr7"><strong><?php echo Configure::read('CONFIG_CURRENCYSYMB');?><?php echo $total_pledge_amount; ?></strong> <br>
                                                							  <?php __('frnt_pledged'); ?></div>
                        <div class="fl pl7">
                             <?php $time_rem = $this->GeneralFunctions->show_left_time(time(), $staff_project['Project']['project_end_date']); ?>
                                    <strong><?php echo $time_rem['time']; ?></strong> <br />
                                    <?php echo sprintf(__('frnt_daystogo', true), $time_rem['unit']); ?>
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
        <?php
    }
    if ($this->params['isAjax']) {
        if ($current_page != $last_page) {
            echo "=================" . $this->Html->url(array('plugin' => false, 'controller' => 'projects', 'action' => $load_more_action, 'page:' . $page));
        } else {
            echo "=================";
        }
    }
}?>
