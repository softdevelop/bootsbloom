<?php
echo $this->Html->script(array(
    'jquery-ui-js/ui/jquery.ui.tabs.js',
));
?>
<style>
    .ui-selectmenu-menu{
        max-height: 150px;
    }
</style>
<?php echo $this->Html->script(array('admin/jquery.tokeninput.js')); ?>
<?php echo $this->Html->css(array('admin/token-input.css')); ?>
<script type="text/javascript">
    var old_date    =   '<?php echo date('Y,m,d', $end_date_time_stamp); ?>';
    var yr  =   '<?php echo date('Y', $end_date_time_stamp); ?>';
    var mnth  = '<?php echo date('m', $end_date_time_stamp); ?>';
    var dy  =   '<?php echo date('d', $end_date_time_stamp); ?>';
    var hr  =   '<?php echo date('H', $end_date_time_stamp); ?>';
    var mnt  =   '<?php echo date('i', $end_date_time_stamp); ?>';
        
    function check_limit_value(reward_id){
        if($("#RewardLimit_"+reward_id).attr('checked')){
            $("#limit_value_div_"+reward_id).show();
        }else{
            $("#limit_value_div_"+reward_id).hide();
        }
    }
    $(function() {
        $( "#tabs" ).tabs({
            
        });
        jss('ul.token-input-list', {
            background:'none'
        });
        jss('token-input-list', {
            width:'295px'
        });
        $( "#datepicker" ).datetimepicker({
            ampm: false,
            showTime: true,  
            constrainInput: false,  
            stepMinutes: 1,  
            stepHours: 1,  
            altTimeField: '',  
            time24h: false , 
            defaultDate: new Date(yr,mnth,dy),
            hour: hr,
            minute: mnt,
            onSelect: function(dateText, inst) { 
                $('#ProjectEndDate').val(dateText);
               
            }
            
        });
        $("#no_of_day").click(function(){
            $("#ProjectNoOfDay").attr('disabled',false);
            $("#calendar_container").hide();
        });
        
        $("#end_date_time").click(function(){
            if($('#end_date_time').attr('checked')){
                $("#calendar_container").show();
                $("#ProjectNoOfDay").attr('disabled','disabled');
                $('#sections').height($('#sections').height()+$('#calendar_container').height());
            }
            
        });
        $("#ProjectProjectCity").tokenInput(WEBSITE_ADMIN_URL+"projects/get_city",{
            animateDropdown: false,
            searchingText:false,
            tokenLimit: 1,
            hintText:false,
            searchText:'searching..',
            minChars: 3,
<?php if (!empty($this->data['Project']['project_city_json'])) { ?>
                            prePopulate: [<?php echo $this->data['Project']['project_city_json']; ?>
                    
                            ]
<?php } ?>
                   });   
               });
</script>
<div class="ochead">

    <div class="floatleft padtop_20px">Edit Project</div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;">
            <?php echo $this->Html->link("Back To Projects", array("plugin" => false, "controller" => "projects", "action" => "index"), array("class" => 'back_lnk')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear">
    <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
</div>
<?php if ($this->validationErrors) { ?>
    <div class="error pt10">
        <?php
        echo "<ul>";
        foreach ($this->validationErrors['Project'] as $error) {
            ?>
            <li><?php echo $error; ?></li>
            <?php
        }
        echo "</ul>";
        ?>
    </div>
<?php } ?>


<?php
echo $this->Form->create($model, array("class" => "form-horizontal", 'enctype' => 'multipart/form-data', 'action' => 'edit', $id));
echo $this->Form->hidden('active');
?>
<div class="demo">
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Basic</a></li>
            <li><a href="#tabs-2">Rewards</a></li>
            <li><a href="#tabs-3">Story</a></li>
            <li><a href="#tabs-4">Account</a></li>
        </ul>
        <div id="tabs-1">
            <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">


                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="odd_row">
                        <td align='left' width="19%" valign="top" class="padding_left_40">Project title<font color='red'>*</font></td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->text($model . ".title", array("class" => "ui-widget-content ui-corner-all")); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['title'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['title']; ?></div>
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
                        <td align='left' width="19%" valign="top" class="padding_left_40">Project Image<font color='red'>*</font></td>
                        <td width="1%" valign="top">:</td>
                        <td valign="top"> 
                            <table>
                                <tr>
                                    <td valign="top">
                                        <?php echo $this->Form->file($model . ".image_val", array("class" => 'ui-widget-content ui-corner-all')); ?> 
                                    </td>
                                    <td>
                                        <?php
                                        if (!empty($this->data[$model]['image'])) {
                                            echo $this->Html->image($this->GeneralFunctions->show_project_image($this->data[$model]['image'], '100px', '100px'));
                                        }
                                        ?>
                                    </td>
                                </tr>

                            </table>
                        </td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['image'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['image']; ?></div>
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
                        <td align='left' width="19%" valign="top" class="padding_left_40">Category<font color='red'>*</font></td>
                        <td width="1%" valign="top">:</td>
                        <td >  <?php echo $result = $this->GeneralFunctions->get_category_dropdown('Project', 'category_id', 'ProjectCategoryId', $this->data['Project']['category_id'], 'ui_dropdown'); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['category_id'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['category_id']; ?></div>
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

                    <tr class="even_row">
                        <td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>   

                    <tr class="even_row">
                        <td align='left' width="19%" valign="top" class="padding_left_40">Short blurb<font color='red'>*</font></td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $form->textarea($model . ".short_description", array("class" => "ui-widget-content ui-corner-all", 'style' => 'width:350px;height:150px;')); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['short_description'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px">
                                        <img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['short_description']; ?></div>
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
                        <td align='left' width="19%" valign="top" class="padding_left_40">Project Country<font color='red'>*</font></td>
                        <td width="1%" valign="top">:</td>
                        <td >
                            <?php echo $this->Form->input('Project.project_city', array('class' => 'ui-widget-content ui-corner-all', 'label' => false, 'div' => false)); ?>
                        </td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['project_country'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px">
                                        <img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['project_country']; ?></div>
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
                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td></tr>


                    <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td></tr>
                    <tr class="even_row">
                        <td align='left' width="19%" valign="top" class="padding_left_40">Funding Duration<font color='red'>*</font></td>
                        <td width="1%" valign="top">:</td>
                        <td > 
                            <?php
                            $disable_day = '';
                            if ($this->data['Project']['duration_type'] != 'no_of_days') {
                                //$disable_day = 'disabled';
                            }
                            ?>
                            <input type="hidden" id="no_of_day" name="data[Project][duration_type]"  value="no_of_days" />Number of days

                            <?php echo $this->Form->input('Project.no_of_day', array('class' => 'ui-widget-content ui-corner-all', 'label' => false, 'div' => false, 'error' => false, 'disabled' => $disable_day)); ?>        
                            <br/>
                            <?php
                           /* <input type="radio" id="end_date_time" <?php
                            if ($this->data['Project']['duration_type'] == 'date_and_time') {
                                echo 'checked="checked"';
                            }
                            ?> name="data[Project][duration_type]" value="date_and_time"  />End on date & time          

                            $display_style = "";
                            if ($this->data['Project']['duration_type'] != 'date_and_time') {
                                $display_style = 'style="display: none"';
                            }
                            ?>
                            <div id="calendar_container" <?php echo $display_style; ?> >
                                <div id="datepicker"></div>
                               */ ?>
                                <?php echo $this->Form->text('Project.end_date', array('type' => 'hidden')); ?>
                                <div class="clr"></div>
                                <div id="project-duration-timezone"></div>

                            </div>
                        </td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['end_date'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['category_id']; ?></div>
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
                        <td align='left' width="19%" valign="top" class="padding_left_40">Funding goal<font color='red'>*</font></td>
                        <td width="1%" valign="top">:</td>
                        <td > <?php echo $this->Form->input('Project.funding_goal', array('class' => 'ui-widget-content ui-corner-all', 'label' => false, 'div' => false, 'error' => false)); ?></td>
                        <td width="30%" valign="middle">
                            <?php if (isset($this->validationErrors[$model]['funding_goal'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px">
                                        <img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['funding_goal']; ?></div>
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

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="odd_row">
                        <td align='left' colspan="4" style="padding:10px 0px 10px 200px">
                            <table>
                                <tr><td>
                                        <?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button')); ?>
                                    </td>
                                    <td><?php
                                        echo $html->link('Cancel', array('action' => 'index'), array('escape' => false, 'class' => 'cancel_lnk'));
                                        ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="odd_row">
                        <td colspan="4">
                            <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Basic Tab Ends Here -->

        <div id="tabs-2">
            <?php
            $total_reward = 0;
            if (empty($this->data['Reward'])) {
                $reward_array = array(
                    'id' => '',
                    'pledge_amount' => 0.00,
                    'limit' => 0,
                    'limit_value' => 0,
                    'description' => '',
                    'est_delivery_month' => '',
                    'est_delivery_year' => '',
                );
                $rewards[0] = $reward_array;
            } else {
                $rewards = $this->data['Reward'];
            }
            ?>

            <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr class="odd_row">
                        <td colspan="4">
                            <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <?php foreach ($rewards as $reward) { ?>

                        <tr class="even_row">
                            <td colspan="4">
                                <a href="#" class="helplink">Reward #<?php echo $total_reward + 1; ?></a>
                            </td>
                        </tr>

                        <tr class="odd_row">
                            <td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                            </td>
                        </tr>   
                        <?php
                        if (!isset($reward['id'])) {
                            echo $this->Form->input("Reward.id", array('type' => 'hidden', 'name' => 'data[Reward][id][]', 'label' => false, 'error' => false, 'div' => false, 'value' => ""));
                        } else {
                            echo $this->Form->input("Reward.id", array('type' => 'hidden', 'name' => 'data[Reward][id][]', 'label' => false, 'error' => false, 'div' => false, 'value' => $reward['id']));
                        }
                        ?>
                        <tr class="odd_row">
                            <td align='left' width="19%" valign="top" class="padding_left_40">Pledge amount<font color='red'>*</font></td>
                            <td width="1%" valign="top">:</td>
                            <td >
                                <?php echo '$' . $reward['pledge_amount']; ?>
                            </td>
                            <td width="30%" valign="middle">
                                <?php if (isset($this->validationErrors[$model]['pledge_amount'])) { ?>
                                    <div  class="errormsg">
                                        <div class="floatleft padright_10px padtop_4px">
                                            <img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                        <div class="floatleft"><?php echo $this->validationErrors[$model]['pledge_amount']; ?></div>
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
                            <td colspan="4">
                                <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                            </td>
                        </tr>
                        <!-- Pledge Amount End Here -->

                        <tr class="odd_row">
                            <td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                            </td>
                        </tr>   

                        <tr class="odd_row">
                            <td align='left' width="19%" valign="top" class="padding_left_40">Description<font color='red'>*</font></td>
                            <td width="1%" valign="top">:</td>
                            <td >
                                <?php echo $reward['description']; ?>
                            </td>
                            <td width="30%" valign="middle">
                                <?php if (isset($this->validationErrors[$model]['description'])) { ?>
                                    <div  class="errormsg">
                                        <div class="floatleft padright_10px padtop_4px">
                                            <img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                        <div class="floatleft"><?php echo $this->validationErrors[$model]['description']; ?></div>
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
                            <td colspan="4">
                                <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                            </td>
                        </tr>

                        <!-- Description End Here -->

                        <tr class="odd_row">
                            <td colspan="4">
                                <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                            </td>
                        </tr>   

                        <tr class="odd_row">
                            <td align='left' width="19%" valign="top" class="padding_left_40">
                                Est. delivery date<font color='red'>*</font>
                            </td>
                            <td width="1%" valign="top">:</td>
                            <td valign="top">
                                <?php echo $this->Time->get_month($reward['est_delivery_month']) . " " . $reward['est_delivery_year']; ?>
                            </td>
                            <td width="30%" valign="middle">
                                <?php if (isset($this->validationErrors[$model]['month_select'])) { ?>
                                    <div  class="errormsg">
                                        <div class="floatleft padright_10px padtop_4px">
                                            <img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                        <div class="floatleft"><?php echo $this->validationErrors[$model]['month_select']; ?></div>
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
                            <td colspan="4">
                                <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                            </td>
                        </tr>
                        <!-- Estimate Delivery End Here -->

                        <tr class="odd_row">
                            <td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                            </td>
                        </tr>   

                        <tr class="odd_row">
                            <td align='left' width="19%" valign="top" class="padding_left_40"><?php if ($reward['limit'] == 1) { ?> Backers<font color='red'>*</font><?php } ?></td>
                            <td width="1%" valign="top">:</td>
                            <td >
                                <?php
                                if ($reward['limit'] == 1) {
                                    echo ' limited ( ' . $reward['limit_value'] . ' of ' . $reward['limit_value'] . ' left ) ';
                                }
                                ?>
                            </td>
                            <td width="30%" valign="middle">
    <?php if (isset($this->validationErrors[$model]['limit'])) { ?>
                                    <div  class="errormsg">
                                        <div class="floatleft padright_10px padtop_4px">
                                            <img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                        <div class="floatleft"><?php echo $this->validationErrors[$model]['limit']; ?></div>
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
                            <td colspan="4">
    <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                            </td>
                        </tr>
    <?php $total_reward++;
} ?>

                    <tr class="even_row">
                        <td align='left' colspan="4" style="padding:10px 0px 10px 200px">
                            <table>
                                <tr><td>
                                        <?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button')); ?>
                                    </td>
                                    <td><?php
                                        echo $html->link('Cancel', array('action' => 'index'), array('escape' => false, 'class' => 'cancel_lnk'));
                                        ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Rewards Tab ends here -->
        <div id="tabs-3">
            <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>  

                    <tr class="odd_row">
                        <td align='left' width="19%" valign="top" class="padding_left_40">Project Description<font color='red'>*</font></td>
                        <td width="1%" valign="top">:</td>
                        <td > 
                            <?php
                            echo $form->textarea('Project.description', array('label' => '', 'class' => 'ui-widget-content ui-corner-all', 'style' => 'width:250px;height:50px;'));
							echo $this->Editor->render('ProjectDescription');
                            echo $this->Form->hidden('Project.old_description', array('value' => $this->data['Project']['description']));
                            ?>
                        </td>
                        <td width="30%" valign="middle">
<?php if (isset($this->validationErrors[$model]['name'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['name']; ?></div>
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

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td></tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>

                    <tr class="even_row">
                        <td align='left' colspan="4" style="padding:10px 0px 10px 200px">
                            <table>
                                <tr><td>
                                        <?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button')); ?>
                                    </td>
                                    <td><?php
                                        echo $html->link('Cancel', array('action' => 'index'), array('escape' => false, 'class' => 'cancel_lnk'));
                                        ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="tabs-4">
            <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="odd_row">
                        <td align='left' width="19%" valign="top" class="padding_left_40">Paypal Email<font color='red'>*</font></td>
                        <td width="1%" valign="top">:</td>
                        <td > 
                            <?php echo $form->text('User.paypal_email', array("class" => "ui-widget-content ui-corner-all")); ?>
                        </td>
                        <td width="30%" valign="middle">
<?php if (isset($this->validationErrors[$model]['paypal_email'])) { ?>
                                <div  class="errormsg">
                                    <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                    <div class="floatleft"><?php echo $this->validationErrors[$model]['paypal_email']; ?></div>
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

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td></tr>

                    <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
                        </td>
                    </tr>
                    <tr class="even_row">
                        <td align='left' colspan="4" style="padding:10px 0px 10px 200px">
                            <table>
                                <tr><td>
                                        <?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button')); ?>
                                    </td>
                                    <td><?php
                                        echo $html->link('Cancel', array('action' => 'index'), array('escape' => false, 'class' => 'cancel_lnk'));
                                        ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?php echo $this->Form->end(); ?>