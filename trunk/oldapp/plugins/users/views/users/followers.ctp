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
        
        $('.block').live('click',function(){
        var link = this;
        $(link).hide();
        $(link).text('Unblock');
        $(link).addClass('unblock');
        $.ajax({
            type: "POST",
            url: this.href
        }).done(function(data) { 
            data    =   $.trim(data);
            $(link).attr('href',data);
            $(link).removeClass('block');
            return false;
        });
        return false;
        });
        
        $('.unblock').live('click',function(){
        var link = this;
        $(link).text('Follow');
        $(link).addClass('follow');
        $.ajax({
            type: "POST",
            url: this.href
        }).done(function(data) { 
            data    =   $.trim(data);
            $(link).attr('href',data);
            $(link).removeClass('unblock');
            return false;
        });
        return false;
        });
        });
</script>
<div class="grey_gradient">
    <div class="pt20"><div class="wrapper"><h2 class="pageheading"><?php __('find_friend_get_social');?><span><?php __('find_friend_follow_friend_discover_project');?></span></h2></div></div>
</div>
<div class="ptb21">
    <div class="wrapper">
        <div class="mid_overbx mb23">
            <div class="fl pb80 greybrdrgt width68per pr50">
                <div>
                    <div id="loading_content">
                        <?php if ($following_users) { echo $this->element('front/load_follower_friends');
                            } else { ?>
                                <div class="pt40 aligncenter grey16"><?php __('follow_u_r_not_following_any_one'); ?>.</div>
                        <?php } ?>
                    </div>
                    <div class="clr"></div>
                        <?php if($following_users){ ?>
                    <div id="loadmore_loader" class="aligncenter" style="display: none;">
                            <?php echo $this->Html->image('front/ajax-loader.gif'); ?>
                    </div>
                    <div id="loadContentId" class='loadmore'>
                            <?php if ($current_page != $last_page) { echo $this->Html->link($this->Html->tag('span', __('blog_load_more', true)), array('plugin' => 'users', 'controller' => 'users', 'action' => 'followers', 'page' => $page), array('escape' => false, 'class' => 'loadmoreicon', 'id' => 'loadMoreContent'));}?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="fr width23per pb80"><?php echo $this->element('front/get_social_right_panel'); ?></div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
</div>