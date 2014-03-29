<script type="text/javascript">
    	var load_more_link = 'home/'+'<?php echo $load_more_action . '/' . $page; ?>
	';
	var current_page	=	'
<?php echo $current_page; ?>
		';
		var last_page	=	'
<?php echo $last_page; ?>';</script>

<div  class="pt40 pb30 home_pagestrips">
    <div>
        <div class="aligncenter "><span class="popularicon blue30"><?php echo $title_for_layout; ?></span></div>
        <div class="sprite bottomshade"></div>
        <div class="clr">
            <?php echo $this -> Html -> image('front/dot.gif', array("width" => "1", "height" => "28", "alt" => "")); ?>
        </div>
        <?php  if (count($popular) > 0) {?>
            <div id="slideshow">
                <div id="slidesContainer" class="marginleft-5px">
                    <?php foreach ($popular as $pop_proejct) {?>
                        <div class="slide">
                            <div>
                                <div class="sprite listingbxtl"></div>
                                <div class="listingbxt"></div>
                                <div class="sprite listingbxtr"></div>
                                <div class="clr"></div>
                            </div>
                            <div class="listingbxmid">
                                <div class="pb14 pl251">
                                    <?php
									echo $this -> Html -> link($this -> Html -> image($this -> GeneralFunctions -> show_project_image(
										$pop_proejct['Project']['image'], "150px", "200"), 
										array('height' => 150, 'width' => 200)), 
										array(
												'plugin' => false, 
												'controller' => 'projects', 
												'action' => 'detail', 
												$pop_proejct['Project']['User']['slug'], 
												$pop_proejct['Project']['slug']
											 ), 
										array(
												'title' => $pop_proejct['Project']['title'], 
												'escape' => false)
											 );
                                    ?>
                                </div>
                                <div class="grey13 height155 pt142 "> 
                                    <span class="blue14 block pb9 overflow"><?php echo $this-> Html -> link(ucfirst(substr($pop_proejct['Project']['title'], 0, 30)), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $pop_proejct['Project']['User']['slug'], $pop_proejct['Project']['slug']), array('title' => $pop_proejct['Project']['title'])); ?></span> 
                                    <span class="block pb17 blue13"><?php __('frnt_by'); ?> 
									<?php echo $this -> Html -> link(ucfirst($pop_proejct['Project']['User']['name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $pop_proejct['Project']['User']['slug'])); ?>
									<?php //echo ucfirst($pop_proejct['Project']['User']['name']); ?></span> 
									<span class="overflow">
                                    <?php echo ucfirst(substr($pop_proejct['Project']['short_description'], 0, 200)); ?></span>
                                </div>
                                <div class="mt29 pb10">
                                    <?php
									$total_pledge_amount = $this -> GeneralFunctions -> get_total_pledge_amount($pop_proejct['Project']['Backer']);
									$total_funded_percentage = $this -> GeneralFunctions -> total_funded_percentage($pop_proejct['Project']['id'], $pop_proejct['Project']['funding_goal'], $pop_proejct['Project']['Backer']);
									if ($total_funded_percentage > 100) {
										$total_funded_slider_percentage = 100;
									} else {
										$total_funded_slider_percentage = $total_funded_percentage;
									}
                                    ?> 

                                    <?php if (($pop_proejct['Project']['project_end_date'] < time()) && ($total_pledge_amount >= $pop_proejct['Project']['funding_goal'])) { ?>
                                        <!-- Success Bar -->

                                        <div class="greenbg">
                                            <div class="white_dark aligncenter">
                                                <span style="height: 5px"><?php  __('cont_successful'); ?>&nbsp;!</span> 

                                            </div>
                                        </div>
                                        <!-- End Success Bar -->
                                        <?php
										}
										// for unsuccessful projects
										else if (($pop_proejct['Project']['project_end_date'] < time()) && ($total_pledge_amount < $pop_proejct['Project']['funding_goal'])) {
                                        ?>

                                        <div class="yellow_unsuccess_bg">
                                            <div class="white_dark aligncenter">
                                                <span style="height: 5px"><?php  __('cont_funding_unsuccessful'); ?>&nbsp;!</span> 

                                            </div>
                                        </div>
                                        <?php
										}
										// for running projects
										else if ($pop_proejct['Project']['project_end_date'] > time()) {
                                        ?>                         

                                        <!-- Slider Bar -->
                                        <div class="" >

                                            <div class="project-pledged-wrap">
                                                <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="grey13 pt23">
                                        <div class="fl pr7"><strong><?php echo $total_funded_percentage; ?> %</strong> <br>
                                            <?php __('frnt_funded'); ?></div>
                                        <div class="fl pl7 pr7"><strong><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $total_pledge_amount; ?></strong> <br>
                                            <?php __('frnt_pledged'); ?></div>
                                        <div class="fl pl7">
                                           <?php $time_rem = $this -> GeneralFunctions -> show_left_time(time(), $pop_proejct['Project']['project_end_date']); ?>
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

                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="aligncenter grey16"><span><?php __('project_getpopular_no_project_section'); ?></span></div>
        <?php } ?>
    </div>
</div>
