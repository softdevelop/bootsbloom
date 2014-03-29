<div id="top">&nbsp;</div>

<?php
	$language = $this->Session->read('Config.language');
	if (empty($language)) {
		$language = 'eng';
	}

	echo $this->Html->script(array(
		'front/jquery.tokeninput.js'
	));

	echo $this->Html->css(array(
		'front/token-input.css'
	)); 
?>

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
		
        $('div.token-input-dropdown').attr('style','');
        $('div.token-input-dropdown').attr('style',' position: absolute; width: 393px; background-color: #fff; overflow: hidden;border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc; cursor: default; font-size: 16px;  font-family: Verdana;z-index: 1;');
    });
</script>

<div class="ptb21">
    <div class="wrapper">
        <?php echo $this->element("front/help_left_bar"); ?>
        <div class="fl search_page mt35">
            <h1><?php
        $category_title = $category_name['HelpCategory']['category_name' . $lang_var];

        if (isset($category_title)) {
            echo $category_title;
        }
        ?></h1>

            <?php
            foreach ($sub_category_id as $sub_category) {
                $category_name = $sub_category['HelpCategory']['category_name' . $lang_var];
                $category_slug = $sub_category['HelpCategory']['slug' . $lang_var];
                ?>
                <div class="ques pt20 clr">
                    <h2 class="faq_title"><?php echo $category_name; ?></h2>
                    <?php
                    foreach ($category_posts as $category_post) {
                        if ($category_post['HelpPost']['parent_id'] == $sub_category['HelpCategory']['id']) {

                            $post_title = $category_post['HelpPost']['post_title' . $lang_var];
                            $post_slug = $category_post['HelpPost']['slug' . $lang_var];
                            ?>
                            <div>
                                <?php echo $this->Html->link($post_title, '#' . $post_slug); ?>
                            </div>
                        <?php }
                    } ?>
                </div>
            <?php } ?>

            <div class="q_line"></div>
            <div class="clr pt20"></div>
            <?php
            foreach ($sub_category_id as $sub_category) {

                $category_name = $sub_category['HelpCategory']['category_name' . $lang_var];
                $category_slug = $sub_category['HelpCategory']['slug' . $lang_var];
                ?>
                <div class="ans ">
                    <span class="top"><?php echo $this->Html->link('Top', '#top'); ?></span>
                    <h1 id="<?php echo $category_slug; ?>" class="pt20"><?php echo $category_name; ?></h1>
                    <?php
                    $flag = 0;
                    foreach ($category_posts as $category_post) {
                        $last_post = count($category_post);
                        if ($category_post['HelpPost']['parent_id'] == $sub_category['HelpCategory']['id']) {
                            $post_title = $category_post['HelpPost']['post_title' . $lang_var];
                            $post_slug = $category_post['HelpPost']['slug' . $lang_var];
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
                            ?> faq_title" id="<?php echo $post_slug; ?>"><?php echo $post_title; ?></h2>
                                <p class=""><?php echo $category_description; ?></p>
                            </div>
                            <?php
                            $flag++;
                        }
                    }
                    ?>
                    <div class="q_line pb20"></div>
                </div>
            <?php } ?>
            <div class="clr pt20"></div>
        </div>
    </div>
    <div class="clr"></div>
</div>