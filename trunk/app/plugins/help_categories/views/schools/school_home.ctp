<?php
$language = $this->Session->read('Config.language');
if (empty($language)) {
    $language = 'eng';
}
?>
<div class="grey_gradient">
    <div class="pt24 pb17">
        <div class="wrapper aligncenter">
            <h2> <span class="help_headings"><?php __('school_best_practices');  ?> </span></h2>
        </div>
    </div>
</div>
<div class="ptb21">
    <div class="wrapper">
        <div class="help_main">
            <div class="clr pt20"></div>
            <div class="contant aligncenter">
                <div class="clr"></div>
                <div class="width700 aligncenter" style="margin: 0 auto">
                    <?php //list_c
                    if (count($school_categories) > 0) {
                        $flag = 1;
                        foreach ($school_categories as $school_category) {
                            if ($language == 'eng') {
                                $lang_var = '';
                            } else {
                                $lang_var = '_' . $language;
                            }
                            $school_category_title = $school_category['HelpCategory']['category_name' . $lang_var];
                            $category_slug = $school_category['HelpCategory']['slug' . $lang_var];
                            ?> 
                            <div class="height40 aligncenter width700 grey16" id="schoolcategory">
                                <div class="fl pl20 pt10 width90"> <?php __('project_faq_help_school_no'); ?>. <?php echo $flag; ?></div>
                                <div class="fl  front_slider alignlft pt10 width240">
                                    <?php echo $this->Html->link($school_category_title, array('plugin' => 'help', 'controller' => 'school', 'action' => '/school/' . $category_slug), array('class' => '')); ?>
                                </div>
                                <div class="fr text-right pr20 pt10 width200"><?php echo $this->Html->image(WEBSITE_IMG_URL . "image.php?image=" . $school_category['HelpCategory']['category_image'] . '&height=22px&width=20px', array('height' => '22px', 'width' => '20px')); ?></div>


                            </div>
                            <?php $flag++;
                        }
                    } else { ?>

<?php } ?>		
                </div>
                <div class="clr pt40"></div>
                <div class="subnav aligncenter height40 width700" style="margin: 0 auto;">
                    <div class="width200 pt15 bold fl "> <?php __('project_faq_other_help_content'); ?></div>
                    <div class="front_slider alignlft pt10 fl width120">&rarr;  <?php echo $this->Html->link(__('project_faq_help_center', true), array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help')); ?></div>
                    <!--<div class="front_slider alignlft pt10">&rarr;  <?php //echo $this->Html->link('Faq', array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help')); ?></div>-->


                </div>
                <div class="clr"></div>

            </div>
        </div>
        <div class="clr pt20"></div>
    </div>
</div>