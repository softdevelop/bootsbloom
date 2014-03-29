<script type="text/javascript">
    $(function(){
        $("#loadMoreContent").live('click', function(){
            $("#default_loading_div").hide();
        });
    })
</script>

<div class="grey_gradient">
    <div class="pt20">
        <div class="wrapper">
            <h2 class="pageheading">
                <?php echo $this->Html->link(__('discover', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'discover')); ?>/<?php echo $breadcrum; ?>
                <?php if (isset($tag_line)) {
                    if (!empty($tag_line)) { ?>
                        <!-- For Search -->
                        <?php if ($breadcrum == 'Search') { ?>
                            <span class="project_short_desc">
                                <?php echo $total_results . $tag_line; ?>
                            </span>
                        <?php } else { ?>
                            <!-- End -->

                            <span class="project_short_desc">
                                <?php echo $tag_line; ?>
                            </span>
                        <?php } ?>
                    <?php }
                } ?>
            </h2>
        </div>
    </div>
</div>



<div class="ptb21">
    <div class="wrapper">
        <div class="fl width75per">

            <!-- Staff Picks Section -->

            <?php if (!empty($staff_projects)) { ?>
                <div>
                    <div id="loading_content">
                        <?php
                        if (isset($filter_type) && ($filter_type == 'most_funded' || $filter_type == 'popular')) {
                            echo $this->element('projects/load_more_search_projects_by_backer');
                        } else {
                            echo $this->element('projects/load_more_search_projects');
                        }
                        ?>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr">
                    <?php echo $this->Html->image("front/dot.gif", array("width" => "1", "height" => "10")); ?>
                </div>
                <div id="loadmore_loader" class="aligncenter" style="display: none;">
                    <?php echo $this->Html->image('front/ajax-loader.gif'); ?>
                </div>
                <div id="loadContentId" class='loadmore'>
                    <?php
                    if ($current_page != $last_page) {
                        echo $this->Html->link($this->Html->tag('span', __('blog_load_more', true)), array('plugin' => false, 'controller' => 'projects', 'action' => $load_more_action, 'page' => $page), array('escape' => false, 'class' => 'loadmoreicon', 'id' => 'loadMoreContent'));
                    }
                    ?>
                </div>
            <?php } else { ?>
                <div class="p15">
                    <div class="grey13_dark pt10">
                        <h3><?php __('no_project_in_this'); ?>&nbsp;<?php __('make_sure'); ?></h3>
                    </div>
                </div>
            <?php } ?>
            <!-- Staff Picks Section  END -->
        </div>
        <?php echo $this->element('discover_right_panel'); ?>
    </div>
    <div class="clr"></div>
</div>