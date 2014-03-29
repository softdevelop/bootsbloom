<?php
if (isset($this->params['pass'][1])) {
    $language = $this->params['pass'][1];
} else {
    $language = 'eng';
}
//pr($model); exit; 
?>
<script type="text/javascript">

    $(document).ready(function() {
        //Default Action
        $(".tab_content").hide(); //Hide all content
<?php if ($language == 'eng') { ?>
            $("ul.tabs li:first").addClass("active").show(); //Activate first tab
            $(".tab_content:first").show(); //Show first tab content
<?php } else
if ($language == 'hy') { ?>
            $("#french").addClass("active").show(); //Activate first tab
            $("#tab2").show(); //Show first tab content
<?php } ?>
        //On Click Event
        $("ul.tabs li").click(function() {
            $("ul.tabs li").removeClass("active"); //Remove any "active" class
            $(this).addClass("active"); //Add "active" class to selected tab
            $(".tab_content").hide(); //Hide all tab content
            var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
            $(activeTab).fadeIn(); //Fade in the active content
            return false;
        });
    }); 
</script>
<div class="ochead">
    <div class="floatleft padright_10px">
    </div>
    <div class="floatleft padtop_20px">New Category</div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;">
            <?php
            if ($add_category['HelpCategory']['parent_id'] != 0) {
                echo $this->Html->link("Back To Categories", array("plugin" => "help_categories", "controller" => "faqs", "action" => "index", $add_category['HelpCategory']['parent_id']), array("class" => 'back_lnk'));
            } else {

                echo $this->Html->link("Back To Categories", array("plugin" => "help_categories", "controller" => "faqs", "action" => "index", 1), array("class" => 'back_lnk'));
            }
            ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>

<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>
<?php echo $this->Session->flash(); ?>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <div class="wrapper">		

            <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <?php
                echo $this->Form->create($model, array('url' => array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'add_category', $parent_id, 'eng')));
                if (isset($parent_id)) {
                    echo $this->Form->hidden('parent_id', array('value' => $parent_id));
                    echo $this->Form->hidden('section', array('value' => 'faq'));
                }
                ?>
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td></tr>
                    <tr class="odd_row">
                        <td align='left' width="19%" valign="top" class="padding_left_40">Category Name<font color='red'>*</font></td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".category_name", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['category_name'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['category_name']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="odd_row" ><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>

                    <tr><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="even_row">
                        <td align='left' width="19%" valign="top" class="padding_left_40">Category Name in Armenian<font color='red'>*</font></td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".category_name_hy", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['category_name_hy'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['category_name_hy']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="even_row" ><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>

                    <tr class="odd_row">
                        <td align='left' colspan="4" style="padding:10px 0px 10px 200px">
                            <table>
                                <tr><td>
                                        <?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button')); ?>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <?php echo $form->end(); ?>
            </div>
        </div>
    </div>

</div>