<script type="text/javascript">
    var blog_post_slug	=	 '<?php echo $post_details['BlogPost']['slug']; ?>';
    function post_comment(){
       
        $.ajax({
            type: "POST",
            url: WEBSITE_URL+'blogs/blog_posts/post_comment/'+blog_post_slug,
            data: $('#BlogPostDetailForm').serialize(),
            success:function(result){
                result_splite=	result.split('||');
                if(result_splite[0]=='error'){
                    var type= 'error';
						
                }else{
                    var type= 'success';
				
                }
                $('#BlogPostComment').val('');		
                noty({
                    "text":result_splite[1],
                    "theme":"noty_theme_default",
                    "layout":"top",
                    "type":type,
                    "animateOpen":{
                        "height":"toggle"
                    },
                    "animateClose":{
                        "height":"toggle"
                    },
                    "speed":500,
                    "timeout":5000,
                    "closeButton":true,
                    "closeOnSelfClick":false,
                    "closeOnSelfOver":false,
                    "modal":true
                }); 			
            }
        })
        return false;
	
    }	
	
</script>

<div class="grey_gradient">
    <div class="pt24 pb17">
        <div class="wrapper aligncenter">
            <h2> <?php echo $this->Html->image('front/bloghead.png', array('alt' => '', 'width' => '276', 'height' => '32')); ?><span>EST. 2014</span> </h2>
        </div>
    </div>
</div>
<div class="ptb21">
    <div class="wrapper">
        <div class="fl width76per" id="blog">
            <div>
                <h1><?php echo ucfirst($post_details['BlogPost']['title']); ?></h1>
                <div class="grey13_light"><?php echo date( Configure::read('FRONT_UPDATES_DATE_FORMAT'), $post_details['BlogPost']['created']); ?>&ndash; <?php echo $this->Html->link(count($post_details['BlogPostComment']) .' '.__('projt_dtl_project_comment',true), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'detail', $post_details ['BlogPost']['slug']), array('escape' => false, 'class' => 'cmnt-icon-grey')); ?> </div>
                <div>
                    <p><?php echo ucfirst($post_details['BlogPost']['description']); ?></p>
                </div>
                <div class="tag">
				<?php echo $this->Html->link(ucfirst($post_details ['BlogCategory']['category_name']), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'category_project', $post_details['BlogCategory']['slug']), array('escape' => false)); ?></div>
            </div>
            <div class="commentbx">
                <h1 class="p10"><?php __('projt_dtl_project_comment'); ?></h1>
                <div class="greybg_light">

                    <div id="loading_content">
                        <?php
                        echo $this->element('front/load_more_comment');
                        ?>
                    </div>
                    <?php if (count($post_comment) > 0) { ?>
                        <div id="loadmore_loader" class="aligncenter" style="display: none;">
                            <?php echo $this->Html->image('front/ajax-loader.gif'); ?>
                        </div>
                        <div id="loadContentId" class='loadmore'>
                            <?php
                            if ($current_page != $last_page) {
                                echo $this->Html->link($this->Html->tag('span', __('blog_load_more', true)), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'detail', $slug . '/' . 'page' => $page), array('escape' => false, 'class' => 'loadmoreicon', 'id' => 'loadMoreContent'));
                            }
                            ?>
                        </div>
                <?php } ?>
                </div>
                <?php
                $user_check = $this->Session->read('Auth.User.id');
                if (isset($user_check)) {
                    if ($post_details['BlogPost']['allow_comment'] == 1) {
                        ?>
                        <?php
                        echo $this->Form->create($model, array('onsubmit' => 'return post_comment()'));
                        ?>
                        <div class="p10">
                            <h1><?php __('blog_leave_comment'); ?><span class="mandatory_field">*</span></h1>
                            <div>
                                <?php echo $form->textarea($model . '.comment', array('label' => '', 'class' => 'textarea725', 'style' => '')); ?>
                            </div>
                            <div class="ptb10">
                                <?php echo $form->submit(__('blog_post_comment',true), array('border' => '0', 'class' => 'button ie_radius fl')); ?>
                                <div class="pt4 pl10 fl grey12_light"><?php __('blog_leave_comment_text'); ?> </div>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <?php echo $form->end(); ?>
                        <?php } else { ?>

                        <div class="height40 aligncenter pt25">
                            <span class="black16">
                                   <?php __('blog_comment_not_allwed'); ?>
                            </span>
                        </div>	
                    <?php }
                } else { ?>

                    <div class="height40 aligncenter pt25">
                        <span class="black16">
                            <?php echo $this->Html->link(__('blog_login_to_comment',true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'), array('escape' => false)); ?>
                        </span>
                    </div>	
                <?php } ?>


            </div>
        </div>
        <div class="fr width220">
            <div class="right_box mt17">
                <div class="br_grey p10">
                    <div class="grey13_dark pl10 pt10"><strong><?php __('blog_recent_post'); ?> </strong></div>
                    <div class="pt15 browse_links">
                        <ul>
                            <?php foreach ($recent_posts as $recent_post) { ?>
                                <li class="dot_border2"><?php echo $this->Html->link(ucfirst($recent_post ['BlogPost']['title']), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'detail', $recent_post ['BlogPost']['slug']), array('escape' => false)); 
								
								?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="right_box mt17">
                <div class="br_grey p10">
                    <div class="grey13_dark pl10 pt10"><strong><?php __('blog_browse_categories'); ?></strong></div>
                    <div class="pt15 browse_links">
                        <ul>
                            <?php $categories = $this->requestAction('/blogs/blogs/get_blog_categories', array('return'));
                            foreach ($categories as $category) { ?>
                                <li class="dot_border2"><?php echo $this->Html->link(ucfirst($category['BlogCategory']['category_name']), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'category_project', $category['BlogCategory']['slug'])); ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clr"></div>
    </div>
</div>