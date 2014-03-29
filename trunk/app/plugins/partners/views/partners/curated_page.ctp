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
            <h2 class="pageheading"><?php __('curated_pages'); ?></h2>
        </div>
    </div>
</div>

<div class="ptb21">
    <div class="wrapper">
        <div class="fl width75per">
            <!-- Curated Page Section -->
            <?php if (!empty($curatedpages)) { ?>
                <div>
                    <div id="loading_content">
                        <?php  echo $this->element('curated_page_element'); ?>
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
                        echo $this->Html->link($this->Html->tag('span', __('blog_load_more', true)), array('plugin' => 'partners', 'controller' => 'partners', 'action' => $load_more_action, 'page' => $page), array('escape' => false, 'class' => 'loadmoreicon', 'id' => 'loadMoreContent'));
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
            <!-- Curated Page Section  END -->
        </div>
        <?php echo $this->element('discover_right_panel'); ?>
    </div>
    <div class="clr"></div>
</div>