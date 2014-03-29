<?php
foreach ($user_activities as $user_activity) {

    $user_info = $this->GeneralFunctions->get_user_info($user_activity['UserActivity']['user_id'], array('User.name', 'User.slug', 'User.fb_image_url', 'User.profile_image'), '30px', '30px');
    if ($user_activity['UserActivity']['subject_type'] == 'project') {
        $project_info = $this->GeneralFunctions->get_project_info($user_activity['UserActivity']['subject_id']);
    }
    if ($user_activity['UserActivity']['activity_type'] == 'backed') {
        ?>
        <div>
            <div class="days_time"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $user_activity['UserActivity']['created']) ?></div>
            <div class="clr pt5"></div>
            <div class="project_box">
                 <div class="cancelled_ribbon">
                        <div class="cancelled_ribbon_left"></div>
                        <div class="cancelled_ribbon_bg">
                            <div class="ribbon_detail">
                                <div class="ribbon_img">

                                <?php echo $this->Html->image($user_info['User']['profile_image_url'], array('height' => 30, 'width' => 30)); ?>

                            </div>
                                <div class="fl blk12 lh18 pl10"><?php echo $user_info['User']['name']; ?><br />
                                    <span class="blk12 uppercase"><strong><?php __('backed_a_project');?></strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="cancelled_ribbon_right"></div>
                    </div>
                
                <div class="box_top"></div>
                <div class="clr"></div>
                <div class="box_bg">
                    <div class="mrgn_auto width90per">
                        <div class="fl pro_video">
                            <?php $project_img_url = $this->GeneralFunctions->show_project_image($project_info['Project']['image'], '210', '280');
                            echo $this->Html->image($project_img_url, array('height' => 210, 'width' => '280')); ?>
                        </div>
                        <div class="pro_detail">
                            <div class="blue18" id="project_name"><?php echo $this->Html->link($project_info['Project']['title'], array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project_info['User']['slug'], $project_info['Project']['slug'])); ?><br>
                                <span class="grey11">by <?php echo $project_info['User']['name']; ?> </span>
                            </div>
                            <div class="clr"></div>
                            <div class="pro_txt">
                                <?php echo $text->truncate($project_info['Project']['short_description'], 200, array('ending' => '...', 'exact' => false, 'html' => true));?>
                            </div>
                            <div class="clr pt10"></div>
                            <div>
                                <div class="fl">
                                    <?php echo $this->Html->image('front/documentry.png', array('height' => 17, 'width' => 17)); ?>
                                </div>
                                <div class="grey11 fl pt2"><?php echo $this->Html->link($project_info['Category']['category_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'category_projects', $project_info['Category']['slug'])); ?> </div>
                                <div class="fl pl10">
                                    <?php echo $this->Html->image('front/location-icon.png', array('height' => 17, 'width' => 17)); ?>
                                </div>
                                <div class="grey11 fl pt2">
                                    <?php
                                    $project_city_info = $this->GeneralFunctions->get_json_to_city_name($project_info['Project']['project_city_json']);
                                    echo $this->Html->link($project_city_info['city_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'city/' . $project_city_info['id']));
                                    ?> 
                                </div>
                            </div>
                            <div class="clr pt5"></div>
                            <div class="fnction_bg">
                                <div class="running">
                                    <div class="aligncenter mt10">
                                        <?php
                                        $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($project_info['Project']['id'], $project_info['Project']['funding_goal'], $project_info['Backer']);
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
                                        <div class="fl grey11"><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $this->GeneralFunctions->get_total_pledge_amount($project_info['Backer']); ?> <?php __('frnt_pledged'); ?> </div>
                                        <div class="fr grey11"><?php echo $total_funded_percentage; ?> % <?php __('frnt_funded'); ?> </div>
                                    </div>
                                </div>
                                <div class="backker pl10">
                                    <div class="grey22 mt9"><?php echo count($project_info['Backer']); ?><br>
                                        <span class="grey11"><?php __('projt_dtl_project_backers'); ?></span>
                                    </div>
                                </div>
                                <div class="funded">
                                    <div class="grey22 mt9"><?php __('frnt_funded'); ?><br>
                                        <span class="grey11"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $project_info['Project']['project_end_date']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
                <div class="box_bot"></div>
            </div>
        </div>
        <div class="clr pt40"></div>
        <?php }if ($user_activity['UserActivity']['activity_type'] == 'created') { ?>
        <div>
            <div class="days_time"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $user_activity['UserActivity']['created']) ?></div>
            <div class="clr pt5"></div>
            <div class="project_box">
                <div class="green_ribbon">
                    <div class="ribbon_left"></div>
                    <div class="ribbon_bg">
                        <div class="ribbon_detail">
                            <div class="ribbon_img">
                                <?php echo $this->Html->image($user_info['User']['profile_image_url'], array('height' => 30, 'width' => 30)); ?>
                            </div>
                            <div class="fl blk12 lh18 pl10"><?php echo $user_info['User']['name']; ?><br />
                                <span class="blk12 uppercase"><strong><?php __('created_a_project');?></strong></span></div>
                        </div>
                    </div>
                    <div class="ribbon_right"></div>
                </div>
                <div class="box_top"></div>
                <div class="clr"></div>
                <div class="box_bg">
                    <div class="mrgn_auto width90per">
                        <div class="fl pro_video">
                            <?php $project_img_url = $this->GeneralFunctions->show_project_image($project_info['Project']['image'], '210', '280'); ?>
                            <?php echo $this->Html->image($project_img_url, array('height' => 210, 'width' => '280')); ?>
                        </div>
                        <div class="pro_detail">
                            <div class="blue18" id="project_name"><?php echo $this->Html->link($project_info['Project']['title'], array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project_info['User']['slug'], $project_info['Project']['slug'])); ?><br>
                                <span class="grey11">by <?php echo $project_info['User']['name']; ?> </span>
                            </div>
                            <div class="clr"></div>
                            <div class="pro_txt">
                                <?php
                                echo $text->truncate($project_info['Project']['short_description'], 200, array('ending' => '...', 'exact' => false, 'html' => true))
                                ?>
                            </div>
                            <div class="clr pt10"></div>
                            <div>
                                <div class="fl">
                                    <?php echo $this->Html->image('front/documentry.png', array('height' => 17, 'width' => 17)); ?>
                                </div>
                                <div class="grey11 fl pt2"><?php echo $this->Html->link($project_info['Category']['category_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'category_projects', $project_info['Category']['slug'])); ?> </div>
                                <div class="fl pl10">
                                    <?php echo $this->Html->image('front/location-icon.png', array('height' => 17, 'width' => 17)); ?>
                                </div>
                                <div class="grey11 fl pt2">
                                    <?php
                                    $project_city_info = $this->GeneralFunctions->get_json_to_city_name($project_info['Project']['project_city_json']);
                                    echo $this->Html->link($project_city_info['city_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'city/' . $project_city_info['id']));
                                    ?> 
                                </div>
                            </div>
                            <div class="clr pt5"></div>

                            <div class="fnction_bg">
                                <div class="running">
                                    <div class="aligncenter mt10">
                                        <?php
                                        $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($project_info['Project']['id'], $project_info['Project']['funding_goal'], $project_info['Backer']);
                                        if ($total_funded_percentage > 100) {
                                            $total_funded_slider_percentage = 100;
                                        } else {
                                            $total_funded_slider_percentage = $total_funded_percentage;
                                        }
                                        
                                        $total_pledge_amount=$this->GeneralFunctions->get_total_pledge_amount($project_info['Backer']);
                                        ?>
                                        <div class="project-pledged-wrap">
                                            <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
                                        </div>

                                    </div>
                                    <div class="clr"></div>
                                    <div class="mrgn_auto width82per pt5">
                                        <div class="fl grey11"><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $total_pledge_amount  ?> <?php __('frnt_pledged'); ?> </div>
                                        <div class="fr grey11"><?php echo $total_funded_percentage; ?> % <?php __('frnt_funded'); ?> </div>
                                    </div>
                                </div>

                                <div class="backker pl10">
                                    <div class="grey22 mt9"><?php echo count($project_info['Backer']); ?><br>
                                        <span class="grey11"><?php __('projt_dtl_project_backers'); ?></span>
                                    </div>
                                </div>

                                <div class="funded">
                                    <div class="grey22 mt9"><?php
                                    if ($project_info['Project']['project_end_date'] < time()  && $total_pledge_amount >= $project_info['Project']['funding_goal']) { // for funded 
                                    __('frnt_funded');
                                    }else{
                                               /* if($project['Project']['active']==1 && $project['Project']['project_end_date'] < time()){   // active but time has gone away 
                                                __('frnt_not_funded');
                                                }
                                                else*/
                                                if($project_info['Project']['active']==1 && $project_info['Project']['project_end_date'] > time()){ // currently running
                                                     __('frnt_funding');
                                                }
                    
                                            }
                                    ?><br>
                                        <span class="grey11"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $project_info['Project']['project_end_date']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
                <div class="box_bot"></div>
            </div>

        </div>
        <div class="clr pt40"></div>
        <?php
    } else if ($user_activity['UserActivity']['subject_type'] == 'blog_post' && $user_activity['UserActivity']['activity_type'] == 'blog_post_comment') {
        $post_info = $this->GeneralFunctions->get_blog_post_info($user_activity['UserActivity']['subject_id']);
        if($post_info){
        ?>  
        <div>
            <div class="cmnt_right">
                <div class="width90per fr">
                    <div>
                        <div class="ribbon_detail">
                            <div class="ribbon_img">
                                    <?php echo $this->Html->image($user_info['User']['profile_image_url'], array('height' => 30, 'width' => 30)); ?>
                            </div>
                            <div class="fl blk12 lh18 pl10"><?php echo $user_info['User']['name']; ?><br />
                                <span class="blk12 uppercase"><strong><?php __('comment_blog_post');?></strong></span></div>
                        </div>
                        <div class="days_time pt20"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $user_activity['UserActivity']['created']); ?></div>
                    </div>

                    <div class="clr pt10"></div>
                    <div class="blue30"><?php echo $this->Html->link($post_info['BlogPost']['title'], array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'detail', $post_info['BlogPost']['slug'])); ?></div>
                    <div class="clr pt10"></div>

                    <div class="grey14 lh20">
        <?php echo $post_info['BlogPost']['description']; ?>
                    </div>
                    <div class="clr pt15"></div>


                    <div >
                        <div class="fl"> <?php echo $this->Html->image('front/cmnt-icon.png', array('width' => '14', 'height' => '13')); ?></div>
                        <div class="fl pl10 grey14"><strong><?php echo $this->Html->link('Post Comment', array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'detail', $post_info['BlogPost']['slug'])); ?></strong></div>
                        <div class="fr pl15"></div>
                    </div>

                    <div class="clr"></div>
                </div>
            </div>

        </div>

        <div class="clr pt40"></div>


    <?php }} elseif ($user_activity['UserActivity']['activity_type'] == 'project_comment') { ?>
        <div>
            <div class="days_time"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $user_activity['UserActivity']['created']) ?></div>
            <div class="clr pt5"></div>
            <div class="project_box">

                <div class="green_ribbon">
                    <div class="yellow_left"></div>
                    <div class="yellow_bg">
                        <div class="ribbon_detail">
                            <div class="ribbon_img">

        <?php echo $this->Html->image($user_info['User']['profile_image_url'], array('height' => 30, 'width' => 30)); ?>

                            </div>
                            <div class="fl blk12 lh18 pl10"><?php echo $user_info['User']['name']; ?><br />
                                <span class="blk12"><strong><?php __('comment_on_project'); ?></strong></span></div>
                        </div>
                    </div>
                    <div class="yellow_right"></div>
                </div>

                <div class="box_top"></div>
                <div class="clr"></div>
                <div class="box_bg">
                    <div class="mrgn_auto width90per">
                        <div class="fl pro_video">
        <?php $project_img_url = $this->GeneralFunctions->show_project_image($project_info['Project']['image'], '210', '280'); ?>

                            <?php echo $this->Html->image($project_img_url, array('height' => 210, 'width' => '280')); ?>
                        </div>
                        <div class="pro_detail">

                            <div class="blue18" id="project_name"><?php echo $this->Html->link($project_info['Project']['title'], array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project_info['User']['slug'], $project_info['Project']['slug'])); ?><br>
                                <span class="grey11"><?php __('frnt_by'); ?> <?php echo $project_info['User']['name']; ?> </span>
                            </div>

                            <div class="clr"></div>
                            <div class="pro_txt">
                            <?php echo $text->truncate($project_info['Project']['short_description'], 200, array('ending' => '...', 'exact' => false, 'html' => true)); ?>
                            </div>
                            <div class="clr pt10"></div>
                            <div>
                                <div class="fl">
                                     <?php echo $this->Html->image('front/documentry.png', array('height' => 17, 'width' => 17)); ?>
                                </div>
                                <div class="grey11 fl pt2"><?php echo $this->Html->link($project_info['Category']['category_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'category_projects', $project_info['Category']['slug'])); ?> </div>
                                <div class="fl pl10">
                                    <?php echo $this->Html->image('front/location-icon.png', array('height' => 17, 'width' => 17)); ?>
                                </div>
                                <div class="grey11 fl pt2">
                                    <?php
                                    $project_city_info = $this->GeneralFunctions->get_json_to_city_name($project_info['Project']['project_city_json']);
                                    echo $this->Html->link($project_city_info['city_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'city/' . $project_city_info['id']));
                                    ?> 
                                </div>
                            </div>
                            <div class="clr pt5"></div>
                            <div class="fnction_bg">
                                <div class="running">
                                    <div class="aligncenter mt10">
                                        <?php
                                        $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($project_info['Project']['id'], $project_info['Project']['funding_goal'], $project_info['Backer']);
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
                                        <div class="fl grey11"><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $this->GeneralFunctions->get_total_pledge_amount($project_info['Backer']); ?> <?php __('frnt_pledged'); ?> </div>
                                        <div class="fr grey11"><?php echo $total_funded_percentage; ?>%  <?php __('frnt_funded'); ?> </div>
                                    </div>
                                </div>
                                <div class="backker pl10">
                                    <div class="grey22 mt9"><?php echo count($project_info['Backer']); ?><br>
                                        <span class="grey11"><?php __('projt_dtl_project_backers'); ?></span>
                                    </div>
                                </div>
                                <div class="funded">
                                    <div class="grey22 mt9"><?php __('frnt_funded'); ?><br>
                                        <span class="grey11"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $project_info['Project']['project_end_date']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
                <div class="box_bot"></div>
            </div>
        </div>
        <div class="clr pt40"></div>
    <?php } else if ($user_activity['UserActivity']['activity_type'] == 'commnet') { ?>
        <div>
            <div class="cmnt_left">
                <div class="cmnt_proimg_main">
                    <div class="cmnt_proimg">
                        <?php echo $this->Html->image('front/comic-img.jpg', array('width' => '135', 'height' => '105')); ?>
                    </div>
                    <div class="clr pt5"></div>
                    <div class="blue14"><strong>MARVEL</strong></div>
                    <div class="clr pt15"></div>
                    <div>
                        <div class="fl">
                            <?php echo $this->Html->image('front/documentry.png', array('width' => '17', 'height' => '17')); ?>
                        </div>
                        <div class="grey11 fl pt2">Comics</div>
                    </div>
                    <div class="clr pt5"></div>
                    <div>
                        <div class="fl">
                            <?php echo $this->Html->image('front/location-icon.png', array('width' => '17', 'height' => '17')); ?>
                        </div>
                        <div class="grey11 fl pt2">Los Angeles, CA</div>
                    </div>
                </div>
            </div>
            <div class="cmnt_right">
                <div class="width90per fr">
                    <div>
                        <div class="ribbon_detail">
                            <div class="ribbon_img">
                                <?php echo $this->Html->image('front/user-img.jpg', array('width' => '30', 'height' => '30')); ?>
                            </div>
                            <div class="fl blk12 lh18 pl10">Denial Kerry <br>
                            <span class="blk12"><strong>BACKED A PROJECT</strong></span></div>
                        </div>
                        <div class="days_time pt20">5 days ago</div>
                    </div>
                    <div class="clr pt10"></div>
                    <div class="blue30">June 27</div>
                    <div class="clr pt10"></div>
                    <div class="grey14 lh20">
                        I've decided to include a second wave of limited edition posters to my rewards. These pieces are limited to editions of 10 and run between $375- $500. I'll continue updating as I upload and price them. 
                    </div>
                    <div class="clr pt15"></div>

                    <div>
        <?php echo $this->Html->image('front/cmnt-img1.jpg', array('width' => '560', 'height' => '513')); ?>
                        <br />
                        <?php echo $this->Html->image('front/cmnt-img2.jpg', array('width' => '560', 'height' => '471')); ?>
                    </div>

                    <div class="clr pt15"></div>

                    <div>
                        <div class="fl"> <?php echo $this->Html->image('front/cmnt-icon.png', array('width' => '14', 'height' => '13')); ?></div>
                        <div class="fl pl10 grey14"><strong>Post Comment</strong></div>
                        <div class="fl pl15"><?php echo $this->Html->image('front/fb-like.jpg', array('width' => '45', 'height' => '20')); ?></div>
                    </div>

                    <div class="clr"></div>
                </div>
            </div>

        </div>
        <div class="clr pt40"></div>
    <?php
    } else if (($user_activity['UserActivity']['activity_type'] == 'user_follow') && ($user_activity['UserActivity']['subject_type'] == 'user')) {
        $following_info = $this->GeneralFunctions->get_user_info($user_activity['UserActivity']['subject_id'], array('User.name', 'User.slug', 'User.fb_image_url', 'User.profile_image'), '30px', '30px');
        ?>
        <div class="grey13 pl15">
            <div class="width90per">
                <div class="fl pr10">
                    <?php echo $this->Html->image($user_info['User']['profile_image_url'], array('height' => 30, 'width' => 30)); ?> 
                </div>
                <div class="width82per">
                    <div class="fl pr10"><?php echo $this->Html->link($user_info['User']['name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $user_info['User']['slug'])); ?> is now following </div>
                    <div class="fl pr10">
                        <?php echo $this->Html->image($following_info['User']['profile_image_url'], array('height' => 30, 'width' => 30)); ?> 
                    </div>
                    <div class="fl" >
                        <?php echo $this->Html->link($following_info['User']['name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $following_info['User']['slug'])); ?> 
                    </div>
                    <div class="fr days_time">on <?php echo date(CONFIGURE::read('FRONT_UPDATES_DATE_FORMAT'), $user_activity['UserActivity']['created']); ?></div>
                </div>
            </div>
        </div>
        <div class="clr pt10"></div>
        <div class="dot_border"></div>
        <div class="clr pt10"></div>
        <div class="clr pt40"></div>
    <?php } 
    } ?>
