<div class="grey_gradient" style="height:104px;">
    <div class="pt25 ">
        <div class="wrapper aligncenter">
            <h2 style="line-height: 23px;">
                <?php echo $html->image('front/bloghead.png', array('alt' => '', 'width' => '276', 'height' => '32')); ?>
                <span>EST. 2014</span>
            </h2>
        </div>
    </div>
</div>
<div class="ptb21">
    <div class="wrapper">
        <div class="fl width49per" id="blog">
            <div>
                <div id="loading_content">
                    <?php
                    echo $this->element('front/load_more_blog_content');
                    ?>
                </div>
                <?php if (count($blogs) > 0) { ?>
                    <div id="loadmore_loader" class="aligncenter" style="display: none;">
                        <?php echo $this->Html->image('front/ajax-loader.gif'); ?>
                    </div>
                    <div id="loadContentId" class='loadmore'>
                        <?php
                        if ($current_page != $last_page) {
                            echo $this->Html->link($this->Html->tag('span', __('blog_load_more', true)), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'blog', 'page' => $page), array('escape' => false, 'class' => 'loadmoreicon', 'id' => 'loadMoreContent'));
                        }
                        ?>
                    </div>
<?php } ?>            </div>
        </div>

        <div class="fr width49per">
            <div>
<?php echo $html->image(WEBSITE_IMG_URL . "image.php?image=" . $blog_image['Blog']['blog_image'] . '&height=344px&width=492px', array('alt' => '')); ?>
            </div>
            <div class="clr pt20"></div>
            <div class="right_box">
                <div class="width29per fl br_grey p10">
                    <div class="grey13_dark pl10 pt10"><strong><?php __('blog_browse'); ?></strong></div>
                    <div class="pt15 browse_links">
                        <ul>
                            <?php $categories = $this->requestAction('/blogs/blogs/get_blog_categories', array('return'));

                            foreach ($categories as $category) { ?>
                                <li><?php echo $this->Html->link(ucfirst($category['BlogCategory']['category_name']), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'category_project', $category['BlogCategory']['slug'])); ?>
                                </li>

                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php if(isset($project_of_day)){ ?>
                <div class="width62per fr p10">
                    <div class="grey13_dark pl10 pt10"><strong><?php __('blog_project_day'); ?></strong></div>
                    <div class="pt15">
                        <div class="proj_box ml10 fl">
						<?php echo $this->Html->image(WEBSITE_IMG_URL . "image.php?image=" . $project_of_day['Project']['image'] . '&height=75px&width=100px', array('alt' => '', 'height' => '75', 'width' => '100')); ?>
                        </div>
                        <div class="fr blue15 width60per">
							<div class="height35">
							<?php
                                                        
                                                        echo $this->Html->link(ucfirst($text->truncate($project_of_day['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project_of_day['User']['slug'], $project_of_day['Project']['slug'])); ?></div>
							<br />
							<?php 
							$user_city_info    =  $this->GeneralFunctions->get_json_to_city_name($project_of_day['User']['city_json']);
							if( $user_city_info['city_name'] !=''){
							?>
                            <span class="grey12"> 
                                <?php echo $this->Html->image('front/location-icon.png', array('alt' => '', 'width' => '17', 'height' => '17')); ?>
							
							<?php echo $user_city_info['city_name']; ?> 
							</span>
							<?php } ?>
							</div>
                        <div class="clr"></div>
                    </div>
                </div> 
                <?php } ?>
                <div class="clr"></div>
                
            </div>
            <div class="right_box mt17">
                <div class="p15">
                    <div class="grey13_dark pl10 pt10"><strong><?php __('blog_project_love'); ?></strong></div>
                    <div class="pt15 pl10">
<?php		if (count($fav_projects) > 0) 
			{
                foreach ($fav_projects as $records) { ?>
				
<?php 
						$project_img = $this->GeneralFunctions->get_project_image($records['Project']['id'], '160px', '200px');
						echo $this->Html->link($this->Html->image($project_img, array('width' => '200', 'height' => '160')), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $records['User']['slug'], $records['Project']['slug']),array('title'=>$records['Project']['title'],'escape'=>false));
?>
						
<?php			} 
			} ?>
			
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="bt1px txt_italic"><?php __('blog_left_bar_text'); ?></div>
            </div>
            <div class="right_box mt17">
                <div class="p15">
                    <div class="grey13_dark pt10"><strong><?php __('fascinating_post_project_new_old'); ?></strong></div>
                    <div>
                        <?php if (count($projects_updates) > 0) {
                            foreach ($projects_updates as $projects_update) { ?>
                                <div>	
                                    <div class="pt15">
                                        <div class="postimg_box">
        <?php echo $this->Html->link($this->Html->image($this->GeneralFunctions->show_project_image($projects_update['Project']['image'], "75px", "100px"), array('height' => 75, 'width' => 100)), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update_detail', $projects_update['User']['slug'], $projects_update['Project']['slug'], $projects_update['ProjectUpdate']['id']), array('escape' => false)); ?>

                                        </div>

                                        <div class="width75per fr">
											<div class="blue15">
        <?php echo $this->Html->link(ucfirst($projects_update['ProjectUpdate']['title']), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_update_detail', $projects_update['User']['slug'], $projects_update['Project']['slug'], $projects_update['ProjectUpdate']['id'])); ?>
											</div>
											<div class="grey14 pt7">
                                                <div class="height58">
        <?php echo strip_tags($text->truncate(ucfirst($projects_update['ProjectUpdate']['description']), 200, array('ending' => '...', 'exact' => true, 'html' => false))); ?>
                                                </div>

                                                 </div>
                                        </div>
                                    </div>

                                    <div class="clr pt10"></div>
                                    <div class="dot_border"></div>
                                    <div class="clr pt10"></div>
                                </div>
                            <?php }
                        } else { ?>
                            <div> <?php __('blog_no_project_update'); ?></div>
                            <?php } ?>
                        <div class="blue14">&raquo;
<?php echo $this->Html->link(__('c_more_project_update', true), array('plugin' => false, 'controller' => 'project_updates', 'action' => 'index')); ?>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="pt20">
              
            </div>
        </div>
        <div class="clr"></div>
    </div>
</div>