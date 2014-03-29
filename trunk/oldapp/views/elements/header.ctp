<div class="blackbg">
    <div class="wrapper">
        <div class="fl">
            <?php echo $this->Html->link(Configure::read('CONFIG_SITE_TITLE'), array('plugin' => '', 'controller' => 'home', 'action' => 'index'), array("class" => "sprite logo")); ?>

            <span class="white15 fl ml24 mt38"><?php __('header_punch_line'); ?></span>
            <div class="clr"></div>
        </div>
        <div class="fr mt8" style="width: 500px;">
            <?php
            if (!$this->Session->check('Auth.User.id')) {
                $md_class = 'mb15';
                $mt_class = 'fr mainnavi13 ml24 mt8';
                $search_class = 'txtbx275';
            } else {
                $md_class = 'mb5';
                $mt_class = 'fr mainnavi13 ml24';
                $search_class = 'txtbx206';
            }
            ?>

            <div class="<?php echo $md_class; ?>">

                <?php if (!$this->Session->check('Auth.User.id')) { ?>
                    <div class="<?php echo $mt_class; ?>">

                        <?php echo $this->Html->link(__('frnt_sign_up', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'signup'), array('class' => 'nomar')); ?> | <?php echo $this->Html->link(__('frnt_sign_in', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'), array("class" => "nomar")); ?>
                    </div>
					

                <?php } else {
                    $unread_messages    =   $this->GeneralFunctions->get_unread_messages($this->Session->read('Auth.User.id'));
                    $unread_notifications   =    $this->GeneralFunctions->get_unread_notifications($this->Session->read('Auth.User.id'));
                    ?>
					<!--<div><?php //echo $this->Html->link(__('Rss', true), array('controller' => 'projects', 'action' => 'rssfeeds')); ?></div>-->
                    <div class="<?php echo $mt_class; ?>">

                        <ul id="menu-sub">
                            <li id="menu-sub-message" class="dropdown">
                                <?php echo $this->Html->link('<span class="icon-message">' . __('frnt_messages', true) . '</span>', array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index'), array('escape' => false, 'title' => 'Inbox')); ?>
								
                                <span class="menu-dropdown-corner"></span>
                                <div id="menu-messages-children" class="dropdown-child">
                                    <ul id="menu-messages-list" class="hit-list">
                                        <li class="first">
                                            <h4><?php __('inbox'); ?></h4>
                                        </li>
                                        <li><?php __('frnt_messages_loding'); ?></li>
                                        <li class="last">
                                            <?php echo $this->Html->link(__('View_messages', true), array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index'), array('class' => 'button-neutral')); ?>
                                        </li>
                                    </ul>
                                </div>
								
                                <?php if($unread_messages>0) { ?><span class="count"><?php  echo $unread_messages; ?></span> <?php } ?>

                            </li>
                            <li id="menu-sub-activity" class="dropdown">
                                <?php echo $this->Html->link('<span class="icon-activity">' . __('notification', true) . '</span>', array('plugin' => false, 'controller' => 'notifications', 'action' => 'index'), array('escape' => false)); ?>
                                <span class="menu-dropdown-corner"></span>
                                <div id="menu-activity-children" class="dropdown-child">
                                    <ul id="menu-activity-list" class="hit-list">
                                        <li class="first">
                                            <h4><?php __('recent_activity'); ?></h4>
                                        </li>
                                        <li><?php // __('no_activity_yet'); ?></li>
                                    </ul>
                                </div>
								<?php if($unread_notifications>0) { ?><span class="count"><?php  echo $unread_notifications; ?></span> <?php } ?>
                            </li>
                            <li id="menu-sub-me" class="dropdown">
                                <a href="<?php echo WEBSITE_URL . "users/profile/" . $this->Session->read('Auth.User.slug'); ?>">
                                    <span id="me-avatar">
                                        <?php
                                        $user_image_url = $this->GeneralFunctions->get_user_profile_image($this->Session->read('Auth.User.id'), '20px', '20px');
                                        echo $this->Html->image($user_image_url, array('width' => '20', 'height' => '20'));
                                        ?>
                                    </span><?php __('me'); ?><span class="icon-dropdown"></span>
                                </a>
                                <div data-user_dropdown_backer_creator_columns_path="/users/dropdown_backer_creator_columns" class="NS_layouts__user_dropdown">
                                    <span class="menu-dropdown-corner"></span>
                                    <div id="menu-me-children" class="dropdown-child creator">
                                        <ul id="menu-me-account">
                                            <li>
                                                <h4><?php __('my_account'); ?></h4>
                                            </li>
                                            <li>
						<?php echo $this->Html->link(__('my_profile', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $this->Session->read('Auth.User.slug'))); ?>
                                            </li>
                                            <li>
                                                <?php
                                                echo $this->Html->link(__('manage_your_pledge', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'backed_history'));
                                                ?>
                                            </li>
                                            <li>
                                                <?php
                                                echo $this->Html->link(__('profile_stared_my_stared_project', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'starred_projects', 'slug' => $this->Session->read('Auth.User.slug')));
                                                ?>
                                            </li>
                                            <li>
                                                <?php echo $this->Html->link(__('edit_setting', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit_profile')); ?>
                                            </li>
                                            <li class="logout">
                                                <?php echo $this->Html->link(__('frnt_logout', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'), array('class' => 'more-button', 'onclick' => 'FB.logout();', 'id' => 'logout_link')); ?>
                                            </li>
                                        </ul>
                                        <div class="NS_layouts__user_dropdown_backer_creator_columns">
                                            <ul id="menu-me-created">
                                                <li>
                                                    <h4><?php echo $this->Html->link(__('my_created_project',true),array('plugin'=>false, 'controller'=>'home','action'=>'start'),array('class'=>'createdproject')); ?></h4>
                                                    <div class="aligncenter mt40"><?php echo $this->Html->image('front/loading.gif'); ?></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php } ?>

                <?php echo $this->Form->create('Project', array('url' => array('plugin' => false, 'controller' => 'projects', 'action' => 'index'), 'id' => 'search_form')); ?>
                <div class="fr">
                    <div class="fl sprite txtbxlft"></div>
                    <div class="fl whitebg h28">
                        <?php echo $this->Form->input('Project.search', array('class' => $search_class, 'type' => 'text', 'label' => false)); ?>

                    </div>
                    <div class="fl whitebg h28">
                        <?php echo $this->Html->link('Search', 'javascript:void(0);', array('class' => 'sprite searchglass', 'onclick' => 'javascript:$("#search_form").submit();')); ?>
                    </div>
                    <div class="fl sprite txtbxrgt"></div>
                    <div class="clr"></div>
                </div>
                <?php echo $this->Form->end(); ?>
                <div class="clr"></div>
            </div>
            <div class="mainnavi">
                <?php
                $blog_active_class = "";
                $discover_active_class = "";
                $faq_active_class = "";

                if ($this->params['action'] == 'blog') {
                    $blog_active_class = 'act';
                }
                if ($this->params['action'] == 'discover') {
                    $discover_active_class = 'act';
                }
                if ($this->params['plugin'] == 'help_categories') {
                    $faq_active_class = 'act';
                }
                if (!isset($start_proj_class)) {
                    $start_proj_class = '';
                }
                ?>
                <?php echo $this->Html->link(__('frnt_descover_project', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'discover'), array("class" => 'add_lnk ' . $discover_active_class)); ?>

                <?php echo $this->Html->link(__('frnt_start_new_project', true), array('plugin' => false, 'controller' => 'home', 'action' => 'start'), array('class' => $start_proj_class)); ?>

                <?php
                echo $this->Html->link(__('frnt_blog', true), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'blog'), array("class" => 'add_lnk ' . $blog_active_class));
                echo $this->Html->link(__('frnt_help', true), array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help'), array("class" => 'add_lnk ' . $faq_active_class));
                ?>
            </div>
        </div>
        <div class="clr"></div>
    </div>
</div>
