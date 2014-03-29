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
            <?php 
            if (isset($this->params['pass'][0])) { ?>
                <div class="bluedbot"><h1><?php echo ucfirst($this->params['pass'][0]); ?><h1></div>
                        <?php } ?>
                        <?php
                        if (count($posts) > 0) {
                            foreach ($posts as $post) {
                                ?>
                                <div class="pb30 pt5">
                                    <div class=" column">
                                        <div class="blue30">
                                            <?php
                                             echo $this->Html->link(ucfirst($post ['BlogPost']['title']), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'detail', $post ['BlogPost']['slug']), array('escape' => false));
                                           ?>
                                        </div>
                                        <div class="pt10 grey13_light">
                                            <?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $post['BlogPost']['created']); ?>
                                            <?php echo $this->Html->link(count($post['BlogPostComment']) . ' ' . __('projt_dtl_project_comment', true), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'detail', $post ['BlogPost']['slug']), array('escape' => false, 'class' => 'cmnt-icon-grey')); ?>	
                                        </div>
                                    </div>
                                    <div class="clr"></div>
                                </div> 
                                <?php
                            }
                        } else { ?>
                            <div class="aligncenter"><?php __('category_project_empty_msg'); ?></div>
                        <?php } ?>
                        </div>
                        <div class="fr width220">
                            <div class="right_box">
                                <div class="br_grey p10">
                                    <div class="grey13_dark pl10 pt10"><strong><?php __('category_project_recent_post'); ?></strong></div>
                                    <div class="pt15 browse_links">
                                        <ul>
                                            <?php foreach ($recent_posts as $recent_post) { ?>
                                                <li class="dot_border2"><?php echo $this->Html->link(ucfirst($recent_post ['BlogPost']['title']), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'detail', $recent_post ['BlogPost']['slug']), array('escape' => false)); ?></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="right_box mt17">
                                <div class="br_grey p10">
                                    <div class="grey13_dark pl10 pt10"><strong><?php __('category_project_browse_cat'); ?></strong></div>
                                    <div class="pt15 browse_links">
                                        <ul>
                                            <?php $categories = $this->requestAction('/blogs/blogs/get_blog_categories', array('return'));
                                            foreach ($categories as $category) { ?>
                                                <li class="dot_border2"	><?php echo $this->Html->link(ucfirst($category['BlogCategory']['category_name']), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'category_project', $category['BlogCategory']['slug'])); ?></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clr"></div>
                        </div>
                        </div>