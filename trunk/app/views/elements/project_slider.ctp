<?php echo $this->Html->script(array('project_slider.js')); ?>
<div id="slideshow_new"> 
    <?php if (count($project_countries) > 0) { ?>
        <div id="slidesContainer_new" class="marginleft-5px">
            <?php foreach ($project_countries as $project_country) { ?>
                <div class="slide_new">
                    <div>
                        <div class="sprite listingbxtl"></div>
                        <div class="listingbxt"></div>
                        <div class="sprite listingbxtr"></div>
                        <div class="clr"></div>
                    </div>
                    <div class="listingbxmid height411" >
                        <div class="pb14">
                            <?php 
                            echo $this->Html->link($this->Html->image($this->GeneralFunctions->show_project_image($project_country['Project']['image'], "150px", "200px"), array('height' => 150, 'width' => 200)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project_country['User']['slug'], $project_country['Project']['slug']),array('title'=>$project_country['Project']['title'],'escape'=>false));                           
                            ?>
                        </div>
                        <div class="grey13 height155 mb8 overflow" > 
                            <span class="blue14 block pb9">
                                <?php echo $this->Html->link(ucfirst($text->truncate($project_country['Project']['title'], 30, array('ending' => '...', 'exact' => false, 'html' => true))), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project_country['User']['slug'], $project_country['Project']['slug']),array('title'=>$project_country['Project']['title']));?>
                            </span>
                            <span class="block pb17"><?php __('frnt_By'); ?> <?php echo $this->Html->link($project_country['User']['name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $project_country['User']['slug'])); ?></span>
                            <?php echo ucfirst($text->truncate($project_country['Project']['short_description'], 200, array('ending' => '...', 'exact' => false, 'html' => true))); ?>
                        </div>
                        <div class="clr"></div>
                        <div class="mt29 ">
                             <?php 
                             $total_pledge_amount   =   $this->GeneralFunctions->get_total_pledge_amount($project_country['Backer']);
                                $total_funded_percentage= $this->GeneralFunctions->total_funded_percentage($project_country['Project']['id'],$project_country['Project']['funding_goal'],$project_country['Backer']);
                                if($total_funded_percentage>100){
                                    $total_funded_slider_percentage=100;
                                }else{
                                    $total_funded_slider_percentage=$total_funded_percentage;
                                }
                                
                                ?> 
                                <?php if (($project_country['Project']['project_end_date'] < time()) && ($total_pledge_amount >= $project_country['Project']['funding_goal'])) { ?>
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
									else if (($project_country['Project']['project_end_date'] < time()) && ($total_pledge_amount < $project_country['Project']['funding_goal'])) { 
                                        ?>
                                        <div class="yellow_unsuccess_bg">
                                            <div class="white_dark aligncenter">
                                                <!--<span style="height: 5px">Funding Unsuccessful</span> -->
                                                <span style="height: 5px"><?php __('cont_funding_unsuccessful'); ?>&nbsp;!</span>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                    // for running projects
									else if ($project_country['Project']['project_end_date'] > time()) {
                                        ?>                         
                                        <!-- Slider Bar -->
                                        <div class="" >
                                            <div class="project-pledged-wrap">
                                                <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
                                            </div>
                                        </div>
                                    <?php } ?>

                            <div class="grey13 pt10">
                                <div class="fl pr7">
                                    <strong>
                                        <?php echo $total_funded_percentage;?> %
                                    </strong> 
                                    <br><?php __('frnt_funded');?>
                                </div>
                                <div class="fl pl7 pr7">
                                    <strong><?php echo Configure::read('CONFIG_CURRENCYSYMB');?><?php echo $total_pledge_amount;?></strong> <br>
            							  <?php __('frnt_pledged'); ?>
                                </div>
                                <div class="fl pl7">
                                    <?php $time_rem  = $this->GeneralFunctions->show_left_time(time(), $project_country['Project']['project_end_date']); ?>
                                                                        <strong><?php  echo  $time_rem['time']; ?></strong> <br />
                                                                      <?php  echo sprintf( __('frnt_daystogo',true),$time_rem['unit']); ?>
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
        </div>
    <?php } else { ?>
        <div class="slide_onblank">
            <div class="aligncenter grey16"><?php __(''); ?></div>
        </div>

    <?php } ?>
</div>
