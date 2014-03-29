<?php
if (empty($this->params['pass'])) {
    $this->params['pass'][1] = 'boostbloom-basics';
    $this->params['pass'][0] = 'faq';
}

$language = $this->Session->read('Config.language');
if (empty($language)) {
    $language = 'eng';
}
if ($language == 'eng') {
    $lang_var = '';
} else {
    $lang_var = '_' . $language;
}
?>
<div class="fl width22per  pl25 mt35 search_left">
    <span class="blue18"> 
        <?php echo $this->Html->link('FAQ', array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help_detail', 'faq/'.$faq_categories_and_subcategories[0]['HelpCategory']['slug' . $lang_var]), array('class' => 'blue18')); ?>
    </span>
    <div class="<?php
        if (($this->params['pass'][0] == 'faq') || ($this->params['action'] == 'search_post')) {
            echo 'block';
        } else {
            echo 'display_none';
        }
        ?>">
        <?php foreach ($faq_categories_and_subcategories  as $faq_categories_and_subcategory){ 
            $category_slug = $faq_categories_and_subcategory['HelpCategory']['slug' . $lang_var];
            $cat_title = $faq_categories_and_subcategory['HelpCategory']['category_name' . $lang_var];
           
          //  pr($faq_categories_and_subcategory);?>
        
         <div>
            <div class="blue18 mb8">  <span class="fl pl5 <?php
         if (isset($this->params['pass'][1]) && $this->params['pass'][1] ==$category_slug) {
             echo "selected_cate";
         }
        ?>">
                <?php echo $this->Html->link($cat_title, array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help_detail', 'faq/'.$category_slug), array('class' => 'blue18')); ?>
                </span>
                <div class="clr"></div>
            </div>
            <ul class="sidenav ie_radius">
                <?php
                foreach ($faq_categories_and_subcategory['SubCategories'] as $faq_category) { 

                    if ($language == 'eng') {
                        $lang_var = '';
                    } else {
                        $lang_var = '_' . $language;
                    }
                    $faq_title = $faq_category['HelpCategory']['category_name' . $lang_var];
                    $faq_slug= $faq_category['HelpCategory']['slug' . $lang_var];
                    ?>
                    <li><?php
                    
                        echo $this->Html->link($faq_title, array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help_detail', 'faq/'.$category_slug.'#'.$faq_slug));
                       
                        ?>
                    </li>		
<?php } ?>
            </ul>
        </div>
        
        
        <?php }?>
     
    </div>
    <br/><br/>
    <span class="blue18"> 
    <?php echo $this->Html->link(__('school_best_practices', true), array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school_home', 'school/'), array('class' => 'blue18 capitals')); ?></span>
    <div class="<?php
    if (isset($this->params['pass'][0]) && ( $this->params['pass'][0] == 'school')) {
        echo 'block';
    } else {
        echo 'display_none';
    }
    ?>">

        <div>

            <ul class="sidenav ie_radius">
                <?php
                foreach ($school_categories as $school_category_key => $school_category) {

                    if (isset($this->params['pass'][1]) && ($this->params['pass'][1] == $school_category['HelpCategory']['slug'])) {
                        $_SESSION['school_no'] = $school_category_key + 1;
                    }

                    if ($language == 'eng') {
                        $lang_var = '';
                    } else {
                        $lang_var = '_' . $language;
                    }
                    $category_school = $school_category['HelpCategory']['category_name' . $lang_var];
                    $category_school_slug = $school_category['HelpCategory']['slug' . $lang_var];
                      if ($this->params['pass'][1] == $category_school_slug) {
                            $selected_cate= 'selected_cate';
                        }else{
                            $selected_cate='';
                        }
                    ?>
                    <li class="<?php echo $selected_cate; ?>">
                        <?php echo $this->Html->link($category_school, array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school', 'school/' . $category_school_slug)); ?>
                    </li>		
<?php } ?>
            </ul>
        </div>							
    </div>	
</div>
