<div class="grey_gradient">
    <div class="pt20">
        <div class="wrapper">
            <h2 class="pageheading"><?php echo $this->Html->link(__('discover', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'discover')); ?> / <?php __('recen_update'); ?></h2>
        </div>
    </div>
</div>

<div class="ptb21">
    <div class="wrapper">
        <div class="fl width75per">
            <!-- Project Updates Section Start -->
            <?php if (!empty($projects_updates)) { ?>
                <div class=" mt17">
                    <div class="p15">
                        <div class="grey13_dark pt10">
                            <h3><?php __('fascinating_post_project_new_old'); ?></h3>
                        </div>
                        <div>
                            <div id="loading_content">
                                <?php
                                echo $this->element('projects/load_more_project_update');
                                ?>
                            </div>
                            <?php if (count($projects_updates) > 0) { ?>
                                <div id="loadmore_loader" class="aligncenter" style="display: none;">
                                    <?php echo $this->Html->image('front/ajax-loader.gif'); ?>
                                </div>
                                <div id="loadContentId" class='loadmore'>
                                    <?php
                                    if ($current_page != $last_page) {
                                        echo $this->Html->link($this->Html->tag('span', __('Load More', true)), array('plugin' => false, 'controller' => 'Project_updates', 'action' => 'index', 'page' => $page), array('escape' => false, 'class' => 'loadmoreicon', 'id' => 'loadMoreContent'));
                                    }
                                    ?>
                                </div>
    <?php } ?>

                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
                <div class="clr">
    <?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "10")); ?>
                </div>
                <!-- Projects Updates Section end -->
            <?php } else { ?>
                <?php __('project_update_no_update'); ?>
        <?php } ?>
        </div>
<?php echo $this->element('discover_right_panel'); ?>
    </div>
    <div class="clr"></div>
</div>