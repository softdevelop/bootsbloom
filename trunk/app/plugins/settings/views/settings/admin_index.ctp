<?php
	echo $this->Html->script(array('jquery-ui-js/ui/jquery.ui.tabs.js'));
?>
<?php echo $this->Html->script(array('admin/jquery.tokeninput.js')); ?>
<?php echo $this->Html->css(array('admin/token-input.css')); ?>
<script type="text/javascript">
    $(function() {
        $( "#tabs" ).tabs({});
        $("a.next_lnk").click(function() {
            $("#tabs").tabs("select",  
            $("#tabs").tabs("option", "selected") + 1);
        });
        $("a.pre_lnk").click(function() {
            $("#tabs").tabs("select", 
            $("#tabs").tabs("option", "selected") - 1
        );
    });
    var  country_id    =   $("#country").val();
    $("#SettingCity").tokenInput(WEBSITE_ADMIN_URL+"settings/get_cities/"+country_id,{
		animateDropdown: false,
		searchingText:false,
		tokenLimit: 1,
		hintText:false,
		searchText:'searching..',
		minChars: 3,
		<?php if (!empty($this->data['Setting']['city_json'])) { ?>
			prePopulate: [<?php echo $this->data['Setting']['city_json']; ?>]
		<?php } ?>
        });  
        $("#country").change(function(){
            country_id    =   $("#country").val();
            $("#city_span").html('');
            $("#city_span").html('<input type="text" id="SettingCity" name="data[Setting][city]" class="ui-widget-content ui-corner-all" >')
           
            $("#SettingCity").tokenInput(WEBSITE_ADMIN_URL+"settings/get_cities/"+country_id,{
                animateDropdown: false,
                searchingText:false,
                tokenLimit: 1,
                hintText:false,
                searchText:'searching..',
                minChars: 3
            });  
	
        }); 
    });
</script>

<?php echo $this->Form->create($model, array("url" => array("action" => "index"),'enctype'=>'multipart/form-data')); ?>
<div class="ochead">
    <div class="floatleft" id="breadcrumb">Config Management </div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;"></div>
        <div class="floatleft padright_10px" style="font-size:10px;">
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>

<div class="pb5" ><?php echo $this->Session->flash(); ?></div>
<div class="demo">
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Global</a></li>
            <li><a href="#tabs-6">Start Project Video</a></li>
            <li><a href="#tabs-2">Contact</a></li>
            <li><a href="#tabs-3">Social Media Info</a></li>
            <li><a href="#tabs-4">Paging Settings</a></li>
            <li><a href="#tabs-5">PayPal Settings</a></li>
        </ul>
        <div id="tabs-1">
            <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                        <td align="left" width="35%" class="padding_left_40">Description</td>
                        <td align="center" width="5%"></td>
                        <td align="left" width="30%">Values</td>
                        <td ></td>
                    </tr>
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Default Language</td>
                        <td width="1%" valign="top">:</td>
                        <td > 
                            <?php
                            $languages = Configure::read('languages');
                            echo $this->Form->select($model . '.site_default_language', $languages, null, array('empty' => false, 'class' => 'ui_dropdown'));
                            ?>
                        </td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['site_default_language'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['site_default_language']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   
                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Global From Name</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".fromname", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['fromname'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['fromname']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td></tr>
                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Global Reply To Email</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".reply_to_email", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['reply_to_email'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['reply_to_email']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr> 	

                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   
                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Site Title</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".site_title", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['site_title'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['site_title']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>
                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Meta Description</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->textarea($model . ".meta_description", array("class" => "ui-widget-content ui-corner-all", "style" => "width:250px;height:90px;")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['meta_description'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['meta_description']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>   
                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Meta keywords</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->textarea($model . ".meta_keywords", array("class" => "ui-widget-content ui-corner-all", "style" => "width:250px;height:90px;")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['meta_keywords'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['meta_keywords']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Default Currency Symbol</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php $pound = '&pound;';
                            echo $form->input('Setting.currencySymb', array('label' => '', 'options' => Configure::read('currency_symbol'), null, 'class' => 'ui-widget-content ui-corner-all', 'style' => 'width:300px;')); ?></td>
                        <td width="30%" valign="middle"> 
                            <?php if (isset($this->validationErrors[$model]['currencySymb'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['currencySymb']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr >
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Default Currency</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php $pound = '&pound;';
                            echo $form->input('Setting.currency', array('label' => '', 'options' => Configure::read('currencies'), null, 'class' => 'ui-widget-content ui-corner-all', 'style' => 'width:300px;')); ?></td>
                        <td width="30%" valign="middle"> 
                            <?php if (isset($this->validationErrors[$model]['currency'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['currencies']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr >	

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Default Country</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->input('Setting.country', array('label' => '', 'options' => $countries, null, 'class' => 'ui-widget-content ui-corner-all', 'id' => 'country', 'style' => 'width:300px;', 'multiple' => false, 'error' => false)); ?></td>
                        <td width="30%" valign="middle"> 
                            <?php if (isset($this->validationErrors[$model]['country'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['country']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr >	

                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Default City</td>
                        <td width="1%" valign="top">:</td>
                        <td ><span id="city_span"> <?php // 'options' =>$cities,
                            echo $form->input('Setting.city', array('label' => '', null, 'class' => 'ui-widget-content ui-corner-all', 'style' => 'width:300px;', 'multiple' => false, 'error' => false)); ?></span>
                        </td>
                        <td width="30%" valign="middle"> 
                            <?php if (isset($this->validationErrors[$model]['city'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['city']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr >	

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>

                    <tr class="odd_row">
                        <td align='center' colspan="4" >
                            <table><tr><td>
								<?php echo $form->Html->link('Next', '#tabs-2', array('border' => '0', 'class' => 'next_lnk')); ?>
							</td>
							<td><?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button', 'div' => false));?></td>
							</tr></table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="tabs-6">
            <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Start Project Video</td>
                        <td width="1%" valign="top">:</td>
                        <td > 
                            <?php
                            
                            echo $this->Form->input($model . '.start_project_video_file',array('type'=>'file','label'=>false));
                            ?>
                        </td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['start_project_video_file'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['start_project_video_file']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="tabs-2">
            <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>		</td></tr>
                    <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                        <td colspan='4' align="left" class="padlft_15px">Contact Detail</td>
                    </tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Phone</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".phone", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['phone'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['phone']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td></tr>
                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Fax</td>
                        <td width="1%" valign="top">:</td>
                        <td >  <?php echo $form->text($model . ".fax", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['fax'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['fax']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Email</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".email", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['email'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['email']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Postal Address</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->textarea($model . ".postal_address", array("class" => "ui-widget-content ui-corner-all", "style" => "width:250px;height:90px;")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['postal_address'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['postal_address']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="odd_row">
                        <td align='center' colspan="4" >
                            <table><tr>
									<td><?php	echo $form->Html->link('Previous', '#tabs-1', array('border' => '0', 'class' => 'pre_lnk')); ?></td>
                                    <td><?php	echo $form->Html->link('Next', '#tabs-3', array('border' => '0', 'class' => 'next_lnk')); ?></td>
                                    <td><?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button', 'div' => false)); ?></td>
                            </tr></table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="tabs-3">
            <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>
                    <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                        <td colspan='4' align="left" class="padlft_15px">Follow US On</td>
                    </tr>
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td></tr>
                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">	Twitter</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".twitter_lnk", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['twitter_lnk'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['twitter_lnk']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>  
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Facebook</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".facebook_lnk", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['facebook_lnk'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['facebook_lnk']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Facebook App Id</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".facebook_app_id", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['facebook_app_id'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['facebook_app_id']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Facebook Api Key</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".facebook_api_key", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['facebook_api_key'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['facebook_api_key']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Facebook Secret</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".facebook_secret", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['facebook_secret'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['facebook_secret']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Meet Our Team</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".meet_team", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['meet_team'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['meet_team']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td></tr>
                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Work With Us</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".work_with_us", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['work_with_us'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['work_with_us']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td></tr>
                    <tr class="even_row">
                        <td align='center' colspan="4" >
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
									<td><?php echo $form->Html->link('Previous', '#tabs-2', array('border' => '0', 'class' => 'pre_lnk')); ?></td>
									<td><?php echo $form->Html->link('Next', '#tabs-4', array('border' => '0', 'class' => 'next_lnk')); ?></td>
                                    <td><?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button', 'div' => false)); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></div>         
        </div>
        <div id="tabs-4">
            <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                        <td colspan='4' align="left" class="padlft_15px">Paging Limit</td>
                    </tr>
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">News Letter</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".newsletter", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['newsletter'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['newsletter']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Project Comment</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".project_comment", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['project_comment'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['project_comment']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Project Listing</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".project_listing", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['project_listing'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['project_listing']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Project Update</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".project_update", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['project_update'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['project_update']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Project Backers</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".project_backers", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['project_backers'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['project_backers']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Blog listing</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".blog_listing", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['blog_listing'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['blog_listing']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>


                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">Blog Comments</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".blog_comments", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['blog_comments'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['blog_comments']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row">
                        <td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                    </tr>
                    <tr class="even_row">
                        <td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                    </tr>
                    <tr class="even_row">
                        <td align='center' colspan="4" >
                            <table>
                                <tr><td>
                                        <?php echo $form->Html->link('Previous', '#tabs-3', array('border' => '0', 'class' => 'pre_lnk')); ?>
                                    </td>
                                    <td><?php echo $form->Html->link('Next', '#tabs-5', array('border' => '0', 'class' => 'next_lnk')); ?></td>
                                    <td><?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button', 'div' => false)); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></div>
        </div>

        <div id="tabs-5">
            <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>
                    <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                        <td colspan='4' align="left" class="padlft_15px">Paypal Settings</td>
                    </tr>
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   
                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">PayPal Username</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".paypal_api_username", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['paypal_api_username'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['paypal_api_username']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   
                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">PayPal Password</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".paypal_api_password", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['paypal_api_password'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['paypal_api_password']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   
                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">PayPal Signature</td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->textarea($model . ".paypal_api_signature", array("class" => "ui-widget-content ui-corner-all", "style" => "width:250px;height:90px;")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['paypal_api_signature'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['paypal_api_signature']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   
                    <tr class="even_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">PayPal Mode</td>
                        <td width="1%" valign="top">:</td>
                        <td > 
                            <?php echo $form->input($model . '.paypal_mode', array('label' => '', 'options' => array('sandbox' => 'Sand box ', 'production' => 'Production'), null, 'class' => 'ui_dropdown')); ?>
                        </td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['paypal_mode'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['paypal_mode']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="odd_row">
                        <td align='left' width="35%" valign="top" class="padding_left_40">PayPal Commission</td>
                        <td width="1%" valign="top">:</td>
                        <td> 
                            <?php echo $form->text($model . ".paypal_commission", array("class" => "ui-widget-content ui-corner-all")); ?>
                        </td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['paypal_commission'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['paypal_commission']; ?></div>
                                    <div class="clear"></div>
                                    <div class="errtl"></div>
                                    <div class="errtr"></div>
                                    <div class="errbl"></div>
                                    <div class="errbr"></div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>	
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>


                    <tr class="even_row">
                        <td align='left' colspan="5" style="padding:10px 0px 10px 352px">
                            <table>
                                <tr><td>
                                        <?php echo $form->Html->link('Previous', '#tabs-4', array('border' => '0', 'class' => 'pre_lnk')); ?></td>
                                    <td>
                                        <?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button')); ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div> 
        </div>
    </div>
</div>
<?php echo $form->end(); ?>
