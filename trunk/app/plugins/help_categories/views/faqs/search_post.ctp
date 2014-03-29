<div id="top">&nbsp;</div>
<?php
$language = $this->Session->read('Config.language');
if (empty($language)) {
    $language = 'eng';
}
?>
<?php echo $this->Html->script(array('front/jquery.tokeninput.js')); ?>
<?php echo $this->Html->css(array('front/token-input.css')); ?>
<style type="text/css">
    .token-input-delete-token {padding-top:5px;}
    li.token-input-token p{padding-top:5px;}
    #token-input-HelpPostPostTitle{width:355px !important;}
</style>
<script type="text/javascript">

    $(document).ready(function() {
        $("#HelpPostPostTitle").tokenInput(WEBSITE_URL+"help_categories/faqs/get_post_title",{
            animateDropdown: false,
            searchingText:false,
            tokenLimit: 1,
            hintText:false,
            onAdd: function (item) {
                var myArray = item.id.split('##');
                var cat_slug =myArray[2];
                var post_tile =myArray[1];
                var cat_section  ='faq';
                window.location = WEBSITE_URL+'help/help-detail/'+cat_section+'/'+cat_slug+'#'+post_tile;
            }
           
        });
		
        $('.token-input-list').attr('style','height:27px; padding:3px 2px 6px; background: -moz-linear-gradient(center top , #F5F5F5, #FFFFFF) repeat-x scroll center top #FFFFFF; background-color:#FFFFFF; border: 1px solid #CCCCCC; width:390px;font-size: 16px;');
		
        $('#token-input-HelpPostPostTitle').addClass('search_icon');
        $('#token-input-HelpPostPostTitle').attr('style','width:390px;');
        $('div.token-input-dropdown').attr('style','');
        $('div.token-input-dropdown').attr('style',' position: absolute; width: 410px; background-color: #fff; overflow: hidden;border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc; cursor: default; font-size: 16px;  font-family: Verdana;z-index: 1;');
    });
	
<?php if (!isset($data_title)) { ?>
        window.location = WEBSITE_URL+'help/help-detail/faq/boostbloom-basics';
<?php } ?>		
</script>
<div class="ptb21">
    <div class="wrapper">
        <?php echo $this->element("front/help_left_bar"); ?>
        <div class="fl search_page mt35">
            <div class="search_post_title">
                <?php __('search_post_for'); ?> "<?php if (isset($data_title)) {
                    echo $data_title;
                } ?>"
                <span class="grey12"><i>( <?php echo count($category_posts) ?><?php __('search_post_faq_found'); ?> )</i></span>
            </div>
            <div class="search_box search_page_mar"><?php echo $this->Form->input('HelpPost.post_title', array('class' => 'search_icon', 'label' => false, 'div' => false)); ?></div>
            <div class="clr pt20"></div>
                <?php if (count($category_posts) > 0) { ?>
                <div class="ans ">
                    <?php
                    $flag = 0;
                    foreach ($category_posts as $category_post) {
                        $last_post = count($category_post);

                        if ($language == 'eng') {
                            $lang_var = '';
                        } else {
                            $lang_var = '_' . $language;
                        }
                        $post_title = $category_post['HelpPost']['post_title' . $lang_var];
                        $category_description = $category_post['HelpPost']['description' . $lang_var];
                        ?>
                        <div class="<?php
                if ($flag != '0') {
                    echo 'faq_border';
                }
                        ?>">
                            <h2 class="<?php
                        if ($flag != '0') {
                            echo 'pt20';
                        }
                        ?> faq_title" id="<?php echo $post_title; ?>"><?php echo $post_title; ?></h2>
                            <p class=""><?php echo $category_description; ?></p>
                        </div>
                    <?php $flag++;
                } ?></div>
<?php } else { ?>
                <div class="grey12 aligncenter">
    <?php __('search_post_empty_search') ?>
                </div>
<?php } ?>
            <div class="clr pt20"></div>
        </div>
    </div>
    <div class="clr"></div>
</div>
