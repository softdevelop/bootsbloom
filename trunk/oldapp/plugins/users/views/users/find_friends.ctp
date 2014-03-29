<script type="text/javascript">
    $(function(){
        $('.follow').live('click',function(){
            var link = this;
            $(link).text('Unfollow');
            $(link).addClass('unfollow');
            $.ajax({
                type: "POST",
                url: this.href
            }).done(function(data) { 
                data    =   $.trim(data);
                $(link).attr('href',data);
                $(link).removeClass('follow');
            
           
                return false;
            });
            return false;
        }); 
   
        $('.unfollow').live('click',function(){
            var link = this;
            $(link).text('Follow');
            $(link).addClass('follow');
            $.ajax({
                type: "POST",
                url: this.href
            }).done(function(data) { 
                data    =   $.trim(data);
                $(link).attr('href',data);
                $(link).removeClass('unfollow');
            
           
                return false;
            });
            return false;
        });
    });
</script>
<div class="grey_gradient">
    <div class="pt20">
        <div class="wrapper"><h2 class="pageheading"><?php __('find_friend_get_social'); ?><span><?php __('find_friend_follow_friend_discover_project'); ?></span></h2></div>
    </div>
</div>
<div class="ptb21">
    <div class="wrapper">
        <div class="mid_overbx mb23">
            <div class="fl pb80 greybrdrgt width68per pr50">
                <div><div id="loading_content">
                    <?php if ($site_users) { ?>
                        <div class="clr pt10"></div>
                        <div class="dot_border"></div>
                        <div class="clr pt10"></div>
                        <?php foreach ($site_users as $site_user) { ?>
                        <div >
                            <div class="qa_left column">
                                <div><?php $image_url = $this->GeneralFunctions->get_user_profile_image($site_user['User']['id'], '75px', '100px'); echo $this->Html->link($this->Html->image($image_url, array('escape' => false, 'height' => '75', 'width' => '100')), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $site_user['User']['slug']), array('escape' => false));?> </div>
                            </div>
                            <div class="qa_right column">
                                <div class="grey16 pl5"><?php echo $this->Html->link(ucfirst($site_user['User']['name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $site_user['User']['slug']), array('class' => 'bold')); ?></div>
                                <div class="pt5 grey16">
                                <?php if ($site_user['User']['country_json'] != '') {
                                            echo $this->Html->image('front/location-icon.png', array('alt' => '', 'width' => '17', 'height' => '15'));
                                            $country = explode("##", $site_user['User']['country_json']);
                                            $country1 = explode(":", $country[1]);
                                            $country2 = explode(',', $country[1]);
                                            $country_name = str_replace('"', "", $country2[0]);
                                            echo $this->Html->link($country_name, array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'country/' . $site_user['User']['country']));
                                             } ?>           
                                </div>
                                <div class="grey16 pt5"><?php echo $this->Html->image('front/badgeicon.png', array('heigth' => '17', 'width' => '17')); ?> <?php __('project_detail_backed'); ?> <?php echo $this->GeneralFunctions->get_user_backed_projects($site_user['User']['id']); ?> <?php __('find_friend_project'); ?>.</div></div>
                                <div class="grey16 lh30" style="width: 100px;text-align: center;float: right">
                                <?php if (!in_array($site_user['User']['id'], $following_friends)) {
                                    echo $this->Html->link(__('find_friend_follow', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'follow', $site_user['User']['slug']), array('class' => 'button ie_radius follow'));
                                    } else {
                                        echo $this->Html->link(__('find_friend_unfollow', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'unfollow', $site_user['User']['slug']), array('class' => 'button ie_radius unfollow'));
                                    } ?>
                                    </div>	
                                    <div class="clr"></div>
                                </div>
                                <div class="clr pt10"></div>
                                <div class="dot_border"></div>
                                <div class="clr pt10"></div>
                            <?php }
                        } else { ?>
                            <div class="pt40 aligncenter grey16"><?php __('find_friend_no_friend_found'); ?><?php echo Configure::read('CONFIG_SITE_TITLE'); ?>.</div>
                        <?php } ?>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="fr width23per pb80"><?php echo $this->element('front/get_social_right_panel'); ?></div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
</div>