<div class="footerbg">
    <div class="wrapper">
        <div class="clr">
            <?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "15")); ?>  
        </div>
        <div class="fl width270 pr10"> <span class="blue15 uppercase block mb23"><?php __('frnt_browse_categories'); ?></span>
            <ul class="footerlinks">
                <?php
                $categories = $this->requestAction('/categories/get_main_categories', array('return'));

                foreach ($categories as $category) {
                    ?>
                    <li><?php echo $this->Html->link(ucfirst($category['Category']['category_name']), array('plugin' => false, 'controller' => 'projects', 'action' => 'category_projects', $category['Category']['slug']), array()); ?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="fl width450 greybrdlr grey14">

            <form  id="newsletter_subscription_form_footer" onsubmit="return subscribe_newsletter('newsletter_subscription_form_footer')">
                <div class="plr10">
                    <div><span class="blue15 uppercase block mb12"><?php __('frnt_weekly_newsletter'); ?></span>
                        <?php
                        /*                         * ******when user is not unsubscriber******** */
                        $login = $this->Session->read('Auth.User');

                        if (empty($login)) {
                            __('frnt_project_report_email');
                        } else
                        if ((!empty($login)) && ($login['receive_weekly_newsletter'] != 1)) {
                            __('frnt_project_report_email');
                        } else {
                            /** ******when user is unsubscribered******** */
                            __('ur_subscriber_to_project_email');
                        }
                        ?>
                    </div>
                    <div class="mt17 mb15">
                        <?php /**                         * *****subscribe user letter when not login******** */ ?>
                        <?php if (empty($login)) { ?>
                            <div class="fl sprite txtbxlft_grey"></div>
                            <div class="fl greybg h36">
                                <?php echo $form->text("Subscriber.email", array("class" => "txtbx260", 'value' => __('frnt_ur_email', true), "onclick" => "if (this.value == '" . __('frnt_ur_email', true) . "') this.value = ''", "onblur" => "if (this.value == '') this.value = '" . __('frnt_ur_email', true) . "'")); ?>
                            </div>
                            <div class="fl sprite txtbxrgt_grey"></div>
                            <div class="fl ml10"> 
                                <?php echo $this->Form->submit(__('frnt_join_newsletter', true), array('border' => '0', 'class' => 'submit_but ie_radius fl')); ?>
                            </div>

                        <?php } else
                        if ($login['receive_weekly_newsletter'] != 1) { ?>
                            <?php /*                             * ******when user is login not subscribe yet******** */ ?>
                            <div class="fl greybg h36"></div>
                            <div class="fl ml10"> 
                                <?php echo $this->Form->submit(__('frnt_join_newsletter', true), array('border' => '0', 'class' => 'submit_but ie_radius fl', 'id' => 'subscribe_newsletter_logedin_user')); ?>
                            </div>
                            <?php
                        } else {
                            /* * ******when user is login subscribed too******** */
                            $newsletter = $this->requestAction(array('plugin' => 'newsletters', 'controller' => 'newsletters', 'action' => 'get_latest_newsletter'), array('return'));
                            echo $this->Html->link($newsletter['Newsletter']['title'], array('plugin' => 'newsletters', 'controller' => 'newsletters', 'action' => 'newsletter_detail', $newsletter['Newsletter']['slug']));
                        }
                        ?>
                        <div class="clr"></div>
                    </div>
                </div>
              
            </form>
            <div class="copyrightbar">
                <div class="plr10 ptb21">
                    <div class="mb12 blue15 uppercase"><?php __('frnt_bhoom_facebook') ?><?php echo $this->Html->link('FACEBOOK', Configure::read('CONFIG_FACEBOOK_LNK'), array('target' => '_blank')); ?></div>
                    <div class="grey14">
                        <?php $this->Facebook->renderLike(Configure::read('CONFIG_FACEBOOK_LNK')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="fl width250 pl15">
            <div class="mb23 blue15 uppercase"><?php __('frnt_cont_bhoomboost'); ?>

            </div>
            <ul class="sociallink">
                <li class="twitter"><?php echo $this->Html->link(__('frnt_on_twitter', true), Configure::read('CONFIG_TWITTER_LNK'),array('target'=>'_blank')); ?></li>
                <li class="rss">
                    <?php echo $this->Html->link(__('frnt_our_blog', true), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'blog')); ?>
                </li>
                <?php
                $social_pages = $this->GeneralFunctions->get_page_content_by_id(array('23', '24'), array('Page.id', 'Page.title', 'Page.title_hy', 'Page.slug', 'Page.slug_hy'));
                ?>
                <li class="team">
                    <?php echo $this->Html->link($social_pages[0]['Page']['title' . $lang_var], array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display', $social_pages[0]['Page']['slug' . $lang_var])); ?>
                </li>
                <li class="work">
                    <?php echo $this->Html->link($social_pages[1]['Page']['title' . $lang_var], array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display', $social_pages[1]['Page']['slug' . $lang_var])); ?>
                </li>
            </ul>
        </div>
        <div class="clr">
            <?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "15")); ?>  
        </div>
    </div>
    <div class="copyrightbar ptb13">
        <div class="wrapper grey14">
            <?php
            $pages = $this->GeneralFunctions->get_page_content_by_id(array('13', '15', '18'), array('Page.id', 'Page.title', 'Page.title_hy', 'Page.slug', 'Page.slug_hy'));
            ?> 
            <div class="fl">
                <?php
                echo $this->Html->link(__('frnt_contact_us', true), 'javascript:void(0)', array('onclick' => 'contact_us()'));
                foreach ($pages as $page) {
                    echo ' | ' . $this->Html->link(ucfirst($page['Page']['title' . $lang_var]), array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display', $page['Page']['slug' . $lang_var]), array('escape' => false));
                }
                echo ' | ';
                echo $this->Html->link(__('frnt_help', true), array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help'), array());
				
                ?>
                &nbsp;
                <?php echo $this->Html->link('English', '/eng') . " | " . $this->Html->link('Armenian', '/hy'); ?>

            </div>


            <div class="fr"><?php echo Configure::read('CONFIG_COPYRIGHT'); ?></div>

            <div class="clr"></div>
        </div>
    </div>
    <div id="contact_us" style="display: none; width: 100px;"></div>
</div>

