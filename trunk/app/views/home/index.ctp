<script type="text/javascript">
    $(document).ready(function(){
        $("#nav_category li").bind(
        "click", function(){
            var category_title= $(this).children("a").text();
            $('#category_name').html(category_title);
            
        });
    });
<?php if (isset($email_session)) { ?>

	var msg_text = '<?php echo $msg_text; ?>';
	var email_session = '<?php echo $email_session; ?>';
	var msg_category = $.trim(email_session);
	if(msg_category =='error'){
		var msg_type = 'error';
	}else{
		var msg_type = 'success';
	}
	noty({
		"animateOpen":{
			"height":"toggle"
		},
		"animateClose":{
			"height":"toggle"
		},
		"force": true, 
		"closeButton":true,
		"layout" : "top", 
		"text": msg_text, 
		"type": msg_type,
		"model":true
	});
                		
<?php } ?>
</script>
<div style="max-height:324px;overflow:hidden;background-color:#171A1A;" class="greybrdtb">
   <div class="h_video">
   <iframe width="100%" height="500px" src="//www.youtube.com/embed/xm0JEgDnoEM?rel=0" frameborder="0" allowfullscreen></iframe>
   </div>
   <!-- <div class="am-container" id="am-container">
        <?php
        if (count($random_project_images) > 0) {
            foreach ($random_project_images as $rpi) {
                echo $this->Html->link($this->Html->image(WEBSITE_IMG_URL . "headerimage.php?image=" . stripslashes($rpi['Project']['image']) . '&amp;height=108px&amp;width=200px', array('alt' => $rpi['Project']['title'])), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $rpi['User']['slug'], $rpi['Project']['slug']), array('escape' => false));
            }
        }
        ?>
    </div>	-->
</div>
<div class="darkgreybg">
    <div class="blackshade pt10">
        <div class="wrapper">
            <div class="fl axure20 mt20"><?php __('frnt_punch_line'); ?> &nbsp;</div>
            <div class="fl" style="margin-left: 145px;">
                <?php echo $this->Html->link(__('project_start_your_project', true), array('plugin' => false, 'controller' => 'home', 'action' => 'start'), array('class' => 'button_yellow1 ie_radius fl')); ?>
                <?php echo $this->Html->link(__('frnt_discover_grate_project', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'discover'), array('class' => 'button_blue1 ie_radius fl ml10')); ?>
            </div>
            <div class="fl"></div>
            <div class="clr"></div>
        </div>
    </div>
</div>
<div class="home_pagestrips">
    <!-- <div class="pageshadow">
        <div class="wrapper ptb26">
            <?php
            if (!empty($slideerCategories)) {
                ?>
                <div class="uppercase grey22">
                    <?php __('frnt_Staff_Picks'); ?> : <span class="blue22" id="category_name"><?php
						foreach ($slideerCategories as $category) 
						{
							if (count($category['Project']) > 0) 
							{
								echo ucfirst($category['Category']['category_name']);
								break;
							}
						}
                    ?></span>
                </div> 
                <div class="staffbx mt9">

                    <div style="height: 465px;">

                        <div class="fl mr15 column" style="height: 465px;">
                            <ul class="stafflisting ptb7 pl8" id="nav_category">
                                <?php
                                $count = 0;
                                foreach ($slideerCategories as $category) {
                                    if (count($category['Project']) > 0) {
                                        ?>
                                        <li>
                                            <?php echo $this->Html->link(ucfirst($category['Category']['category_name']), '#section-' . $count, array('class' => (($count++ == 0) ? 'act' : ''))); ?>
                                        </li>
                                    <?php }
                                } ?>
                            </ul>
                        </div>
                        <div id="container">
                            <?php
                            $count = 0;
                            foreach ($slideerCategories as $category) {
                                if (count($category['Project']) > 0) {
                                    ?>
                                    <div class="fr width803" id="section-<?php echo $count; ?>"> 
                                        <?php foreach ($category['Project'] as $project) { ?>
                                            <div class="fl width350 mr35 column">
                                                <div class="fl">
                                                    <div class="relative">
                                                        <?php
                                                        if ($project['image'] != '') {
															$project_img = $this->GeneralFunctions->get_project_image($project['id'], '259px', '350px');
                                                            echo $this->Html->link($this->Html->image($project_img, array('width' => '350')), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project['User']['slug'], $project['slug']), array('escape' => false));
                                                        } else {
                                                            echo $this->Html->link($this->Html->image("front/missing_little.png", array("width" => "350", "height" => "259")), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project['User']['slug'], $project['slug']), array('escape' => false));
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="pt20 grey14">
                                                        <div>
                                                            <h1 class="front_slider">
                                                                <?php echo $this->Html->link(ucfirst($text->truncate($project['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project['User']['slug'], $project['slug']),array('title'=>$project['title'])); ?>
                                                            </h1>
                                                            <div class="pt5"><?php __('frnt_By'); ?> <?php echo $this->Html->link(ucfirst($project['User']['name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $project['User']['slug'])); ?></div>
                                                            <div class="pt10"><?php echo ucfirst($text->truncate($project['short_description'], 163, array('ending' => '...', 'exact' => false, 'html' => true))); ?></div>
                                                        </div>
                                                        <div class="mtb10">
                                                            <?php
                                                            $total_pledge_amount = $this->GeneralFunctions->get_total_pledge_amount($project['Backer']);
                                                            $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($project['id'], $project['funding_goal'], $project['Backer']);
                                                            if ($total_funded_percentage > 100) {
                                                                $total_funded_slider_percentage = 100;
                                                            } else {
                                                                $total_funded_slider_percentage = $total_funded_percentage;
                                                            }
                                                            ?> 
                                                            <div>

                                                                <div class="project-pledged-slider-wrap">
                                                                    <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-slider-pledged"></div>
                                                                </div>
                                                            </div>                                                    
                                                            <div class="pt15">
                                                                <div class="fl width29per pr10 greybrdrgt"><strong><?php echo $total_funded_percentage; ?> %</strong> <br>
                                                                    <?php __('frnt_funded'); ?></div>
                                                                <div class="fl width29per pl10 pr10 greybrdrgt"><strong><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $total_pledge_amount; ?></strong> <br>
                                                                    <?php __('frnt_pledged'); ?></div>
                                                                <div class="fl width29per pl10">

                                                                    <?php $time_rem = $this->GeneralFunctions->show_left_time(time(), $project['project_end_date']); ?>
                                                                    <strong><?php echo $time_rem['time']; ?></strong> <br>
                                                                    <?php echo sprintf(__('frnt_daystogo', true), $time_rem['unit']); ?>
                                                                </div>
                                                                <div class="clr"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clr"></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="column sidelink" style="height:465px;">
                                            <?php echo $this->Html->link($this->Html->image('front/seeall' . $lang_var . '.png', array("width" => "16", "height" => "179", "alt" => "")), array('plugin' => false, 'controller' => 'projects', 'action' => 'discover'), array('escape' => false, 'class' => 'seeall')); ?> 
                                        </div>
                                    </div>
                                    <?php
                                    $count++;
                                }
                            }
                            ?>
                        </div>

                        <div class="clr"></div>
                    </div>
                    <div class="sprite staffbxtl"></div>
                    <div class="sprite staffbxtr"></div>
                    <div class="sprite staffbxbl"></div>
                    <div class="sprite staffbxbr"></div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#nav_category').onePageNav({
                            currentClass:'act'		
                        });
                    });
                </script>
            <?php } else { ?>
                <div class="uppercase grey22 aligncenter"><?php __('frnt_no_category'); ?></div>
            <?php } ?>
        </div>
    </div> -->
</div>

<div  class="pt40 pb30 home_pagestrips">
    <div class="wrapper">
        <div class="aligncenter blue30 " id="country_name">
            <div id="location_front">
                <span class="locationicon3" id="country">
                    <?php echo $user_country; ?> </span>
                <span><?php echo $html->link(__('frnt_change_city', true), 'javascript:void(0);', array('onclick' => 'change_city()')); ?></span>

            </div>
        </div>
        <div id="country_search" style="display:none" class="aligncenter blue30 ml420" ></div>
        <div class="sprite bottomshade"></div>
        <div class="clr">

            <?php echo $this->Html->image('front/dot.gif', array("width" => "1", "height" => "28", "alt" => "")); ?>
        </div>
        <div id="project_slide">
            <?php echo $this->element('project_slider'); ?>
        </div>
    </div>

</div>

<?php echo $this->requestAction(array('plugin' => false, 'controller' => 'home', 'action' => 'getpopular')); ?>

<div class="pt40 pb30">
    <div class="wrapper">

        <div class="clr">
<?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "20")); ?>  
        </div>
        <div class="sprite bottomshade"></div>
        <div class="clr">
<?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "28")); ?>  
        </div>
        <div>
            <div class="fl grey16 width48per">
                <?php $where_project_page = $this->GeneralFunctions->get_page_content_by_id(array('81'), array('Page.id', 'Page.title', 'Page.title_hy', 'Page.slug', 'Page.slug_hy', 'Page.description', 'Page.description_hy')); ?>
                <span class="blue30 block"><?php echo $where_project_page[0]['Page']['title' . $lang_var] ?></span><?php
                echo $text->truncate($where_project_page[0]['Page']['description' . $lang_var], 100, array('ending' => '...', 'exact' => false, 'html' => true));
                echo $this->Html->link(__('frnt_lrn_mor', true), array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display', $where_project_page[0]['Page']['slug' . $lang_var]));
                ?>

            </div>
            <div class="fr grey16 width48per founderlist"> 
                <?php
                foreach ($random_users as $random_user) {
                    $user_image_url = $this->GeneralFunctions->get_user_profile_image_using_user_array($random_user, '50px', '50px');
                    echo $this->Html->link($this->Html->image($user_image_url, array("width" => "50", "height" => "50", 'alt' => $random_user['User']['name'])), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $random_user['User']['slug']), array('escape' => false));
                }
                ?>

                <div class="clr"></div>
            </div>
            <div class="clr"></div>
        </div>
    </div>
</div>
