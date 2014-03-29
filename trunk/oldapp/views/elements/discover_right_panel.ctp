<?php echo $this->Html->script(array('front/jquery.tokeninput.js')); ?>
<?php echo $this->Html->css(array('front/token-input.css')); ?>
<style type="text/css">

    li.token-input-token p{padding:6px;}
    .token-input-delete-token {padding-top:5px;}
    div.token-input-dropdown {width:214px;}


</style>
<script type="text/javascript">
    $(document).ready(function() {
     
        $("#ProjectCity").tokenInput(WEBSITE_URL+"projects/get_city",{
            animateDropdown: false,
            searchingText:false,
            tokenLimit: 1,
            hintText:false,
            onAdd: function (item) {
                var myArray = item.id.split('##');
                // alert(myArray[0]); 
                var country_id =myArray[0];
                window.location = WEBSITE_URL+'projects/index/city/'+country_id;
            }
           
        });
		 
        $('div.token-input-dropdown').attr('style',' position: absolute; width: 215px; background-color: #fff; overflow: hidden;border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc; cursor: default; font-family: Verdana;z-index: 1;');
		 
        
    });
	
	
	
</script>

<div class="fr width22per greybrdlft pl25 mt35">
    <div>
        <div class="blue18 mb8">
            <span class="sprite featuredico"><?php __('featured'); ?></span>
            <span class="fl pl5"><?php __('featured'); ?></span>
            <div class="clr"></div>
        </div>
        <ul class="sidenav ie_radius">
            <li>
                <?php
                $staff_picks_class = '';
                if ($this->params['action'] == 'staff_picks') {
                    $staff_picks_class = 'act';
                }
                echo $this->Html->link(__('staff_picker', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'staff_picks'), array('class' => $staff_picks_class));
                ?> 
            </li>
            <li>
                <?php
                $recently_launched_act_class = "";
                $popular_act_class = "";
                $ending_soon_act_class = "";
                $most_funded_act_class = "";
				
				
                if (isset($filter_type)) {
                    if ($filter_type == 'popular') {
                        $popular_act_class = 'act';
                    }
                    if ($filter_type == 'recently_launched') {
                        $recently_launched_act_class = 'act';
                    }
                    if ($filter_type == 'ending_soon') {
                        $ending_soon_act_class = 'act';
                    }
                    if ($filter_type == 'most_funded') {
                        $most_funded_act_class = 'act';
                    }
					
                }
				
                ?>
            </li>
            <li><?php echo $this->Html->link(__('recent_launched', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'recently_launched'), array('class' => $recently_launched_act_class)); ?></li>
            <li>

                <?php echo $this->Html->link(__('ending-soon', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'ending_soon'), array('class' => $ending_soon_act_class)); ?>
            </li>
            <li>

                <?php echo $this->Html->link(__('most_funded', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'most_funded'), array('class' => $most_funded_act_class)); ?>
            </li>
        </ul>
    </div>
    <div>
        <div class="blue18 mb8">
            <span class="sprite categoryico"><?php __('Categories'); ?></span>
            <span class="fl pl5"><?php __('Categories'); ?></span>
            <div class="clr"></div>
        </div>
        <ul class="sidenav ie_radius">

            <?php
            foreach ($cat_list as $cat) {
                $active_class = "";
                ?>
                <li>
                    <?php
                    if (isset($active_category)) {
                        if ($active_category == $cat['Category']['slug']) {
                            $active_class = 'act';
                        }
                    }

                    echo $this->Html->link($cat['Category']['category_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'category_projects', $cat['Category']['slug']), array('class' => $active_class));
                    if ($this->params['action'] == 'category_projects') {
                        if (($category_info['Category']['parent_id'] == $cat['Category']['id']) || ($active_category == $cat['Category']['slug'])) {
                            if (isset($cat['Category']['subcategories'])) {
                                ?>
                                <ul>
                                    <?php
                                    foreach ($cat['Category']['subcategories'] as $sabcat) {
                                        if ($active_category == $sabcat['slug']) {
                                            $active_class = 'act';
                                        } else {
                                            $active_class = "";
                                        }
                                        ?>
                                        <li><?php echo $this->Html->link($sabcat['category_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'category_projects', $sabcat['slug']), array('class' => $active_class)); ?></li>
                                    <?php } ?>
                                </ul>
                                <?php
                            }
                        }
                    }
                    ?>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div>
        <div class="blue18 mb8">
            <span class="sprite locationico"><?php __('location'); ?></span>
            <span class="fl pl5"><?php __('location'); ?></span>
            <div class="clr"></div>
        </div>
        <ul class="sidenav ie_radius">

            <?php
            foreach ($cities as $city) {
                $active_class = "";
                if (isset($search_country)) {
                    if ($search_country == $city['City']['id']) {
                        $active_class = 'act';
                    }
                }
                ?>
                <li><?php echo $this->Html->link($city['City']['name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'city', $city['City']['id']), array('class' => $active_class)); ?></li>
<?php } ?>

        </ul>
    </div>
    <div class="relative mt10 pb10"> 
        <a href="#" class="searchglass2">
<?php echo $this->Html->image('front/searchglass.png', array('width' => 24, 'height' => 22)); ?>
        </a>

<?php echo $this->Form->input('Project.city', array('class' => 'input-text2', 'label' => false, 'div' => false)); ?>

    </div>

</div>