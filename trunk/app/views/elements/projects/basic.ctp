<script type="text/javascript">
    var old_date    =   '<?php echo date('Y,m,d', $end_date_time_stamp); ?>';
    var yr  =   '<?php echo date('Y', $end_date_time_stamp); ?>';
    var mnth  =   '<?php echo date('m', $end_date_time_stamp); ?>';
    var dy  =   '<?php echo date('d', $end_date_time_stamp); ?>';
    var hr  =   '<?php echo date('H', $end_date_time_stamp); ?>';
    var mnt  =   '<?php echo date('i', $end_date_time_stamp); ?>';
    mnth  = mnth-1;
    $(document).ready(function() {
        var section_height  =   $('#sections').height();
       
      <?php if ($this->validationErrors) { ?>  
       
       $('#sections').height(section_height+100);
       // alert( $('#sections').height());
      // alert(section_height+50);
       <?php }else{ ?>
             $('#sections').height(1013);
           <?php } ?>
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
                $('#ProjectEditForm input[type=hidden]').trigger('change'); 
            }
           
        });
        $.project_basics();
     
        $("#fileUpload").uploadify({
            'uploader': WEBSITE_IMG_URL+'front/uploadify.swf',
            'cancelImg': 'cancel.png',
            'script': WEBSITE_URL+'projects/save_project_image/'+project_id,
            'buttonText': 'Select Files',
            'checkScript': false,
            'folder':'projects',
            'displayData': 'percentage',
            'auto' : true,
            'simUploadLimit': 1,
            'sizeLimit': (1024*1024*10),
            'onError': function(a, b, c, d, e){
			
				if(d.type=='File Size'){
					noty({
						"text":uploading_image_only_size,
						"theme":"noty_theme_default",
						"layout":"top",
						"type":"error",
						"animateOpen":{
							"height":"toggle"
						},
						"animateClose":{
							"height":"toggle"
						},
						"speed":500,
						"timeout":5000,
						"closeButton":true,
						"closeOnSelfClick":false,
						"closeOnSelfOver":false,
						"modal":true
					});    	
				} 
            },
            'onComplete': function(a, b, c, d, e){
				
                d = $.trim(d);
                 if(d=='error'){
                        noty({
							"text":uploading_image_only_jpg_png_gif,
							"theme":"noty_theme_default",
							"layout":"top",
							"type":"error",
							"animateOpen":{
								"height":"toggle"
							},
							"animateClose":{
								"height":"toggle"
							},
							"speed":500,
							"timeout":5000,
							"closeButton":true,
							"closeOnSelfClick":false,
							"closeOnSelfOver":false,
							"modal":true
						});    	
                        return false;
                }
                $('#project_image_div').html('<img src="'+WEBSITE_IMG_URL+'image.php?image='+d+'&height=150px&width=200px" />');
                $('#review_project_image_div').html('<img src="'+WEBSITE_IMG_URL+'image.php?image='+d+'&height=150px&width=200px" />');
                $('#project_uploaded_image').html('<img src="'+WEBSITE_IMG_URL+'image.php?image='+d+'&height=100px&width=100px" />');
            },
						
            'onAllComplete': function(event,data){
			
                //something here
            }
        });
	
       	
        $("#ProjectProjectCity").tokenInput(WEBSITE_URL+"projects/get_city",{
            animateDropdown: false,
            tokenLimit: 1,
            hintText:false,
            minText:2,
            searchText:false,
        
<?php if (!empty($this->data['Project']['project_city_json'])) { ?>
                    prePopulate: [<?php echo $this->data['Project']['project_city_json']; ?>
                    ]
<?php } ?>
            });
    
            $('#token-input-ProjectProjectCountry').attr('style','');
            $('#token-input-ProjectProjectCountry').attr('style','height:18px;background-color:#FFFFFF;width:208px;');
            $('.token-input-list').attr('style','height:18px; padding:3px 10px 6px; background: -moz-linear-gradient(center top , #F5F5F5, #FFFFFF) repeat-x scroll center top #FFFFFF; background-color:#FFFFFF; border: 1px solid #CCCCCC; width:208px');
            $('.token-input-dropdown').attr('style','width:208px;');
        });
</script>
<style type="text/css">
    #basics_tab li.token-input-token p {
        float: left;
        padding: 0;
        margin: 0;
        padding-top:3px;
    }
</style>
<div class="greybg_light">
    <div class="wrapper ptb15 aligncenter grey15_dark"> <span class="blue40 block"><?php __('project_edit_basic_project_title'); ?></span><?php __('project_edit_basic_project_sub'); ?></div>
</div>

<div class="wrapper grey14">

    <!-- Left Div -->
    <div class="fl pb80 greybrdrgt pt21 width68per pr50">
        <div id="basics_errors" >

        </div>
        <?php if ($this->validationErrors) { ?>
            <div class="error pt10">
                <?php echo "<ul>";
                foreach ($this->validationErrors['Project'] as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } echo "</ul>"; ?>
            </div>
        <?php } ?>
        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('project_edit_project_image'); ?></div>
                <div class="fl width1490 grey12">
                    <div id="project_uploaded_image" class="fl pr10">
                        <?php
                        if (!empty($this->data['Project']['image']))
                            echo $this->Html->image('image.php?image=' . $this->data['Project']['image'] . '&height=100px&width=100px');
                        ?>
                    </div>
                    <div id="fileUpload" class="fr pl10"><?php __('project_edit_problem_with_javascript'); ?></div>
                    <div class="clr"></div>
                    <div class="mt5"><?php __('project_edit_project_image_description');?></div>
					<div class="mt5"><b><?php __('image_ratio'); ?></b></div>
                </div>
                <div class="clr"></div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>
        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('project_edit_project_title'); ?></div>
                <div class="fl width1490 grey12">
                    <?php echo $this->Form->input('Project.title', array('class' => 'input-text600', 'maxlength' => '60', 'label' => false, 'error' => false)); ?>

                    <span class="character_counter_container"><span class="character_counter"></span>/60</span>
                    <div class="mt5"><?php __('project_edit_project_title_description'); ?></div>
                 </div>
                <div class="clr"></div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>
        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('project_edit_category'); ?></div>
                <div class="fl width1490 grey12">
                    <?php echo $result = $this->GeneralFunctions->get_category_dropdown('Project', 'category_id', 'ProjectCategoryId', $this->data['Project']['category_id'], array('class' => 'select600', 'error' => false)); ?>
					<div class="mt5"><?php __('project_edit_category_description'); ?></div>	
                </div>
                <div class="clr"></div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>
        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('project_edit_short_blurb'); ?></div>
                <div class="fl width1490 grey12">
                    <?php echo $this->Form->textarea('Project.short_description', array('class' => 'textarea600', 'maxlength' => '300', 'error' => false)); ?>
                    <?php __('project_edit_short_blurb_word_limit'); ?>
                    <span class="character_counter_container"><span class="character_counter"></span>/300</span>
                </div>
                <div class="clr"></div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>
        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('project_edit_project_location'); ?></div>
                <div class="fl width1490 grey12">
                    <span class="search-icon-text"></span>
                    <span id="basics_tab" style="background-color: #FFF">
                        <?php echo $this->Form->input('Project.project_city', array('class' => 'input-text600-search', 'label' => false, 'div' => false, 'error' => false)); ?>
                    </span>
                    <div class="mt5"><?php __('project_edit_project_location_description'); ?></div>
                </div>
                <div class="clr"></div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>

        <?php if ($this->data['Project']['active'] == 0) { ?>
            <div class="greybox mb12">
                <div class="p10">
                    <div class="fl width160 pt7"><?php __('project_edit_funding_duration'); ?></div>
                    <div class="fl width1490 grey12">
                        <div class="fl">
                            <?php
                            $disable_day = '';
                            if ($this->data['Project']['duration_type'] != 'no_of_days') {
                               // $disable_day = 'disabled';
                            }
                            ?>
                            <div class="fl"> 
                                <input type="hidden" id="no_of_day" name="data[Project][duration_type]" value="no_of_days" /><?php __('project_edit_no_days'); ?>
                            </div>
                            <div class="fr">
                                <?php echo $this->Form->input('Project.no_of_day', array('class' => 'input-text601', 'label' => false, 'div' => false, 'error' => false, 'disabled' => $disable_day)); ?> <span><?php //__('project_edit_recommend_30'); ?></span>
                            </div>
                        </div>
                        <div class="clr"></div>
                        <?php /* Date Calender Div Removed  
                        <div class="fl">
                            <div class="fl"><input type="radio" id="end_date_time" <?php if ($this->data['Project']['duration_type'] == 'date_and_time') {
                                echo 'checked="checked"';
                            } ?> name="data[Project][duration_type]" value="date_and_time"  /><?php __('project_edit_end_date_time'); ?></div>
                            <div class="fr">
                                <?php
                                $display_style = "";
                                if ($this->data['Project']['duration_type'] != 'date_and_time') {
                                    $display_style = 'style="display: none"';
                                }
                                ?>
                                <div id="calendar_container" <?php echo $display_style; ?> >
                                    <div id="datepicker"></div>

    <?php echo $this->Form->text('Project.end_date', array('type' => 'hidden')); ?>
                                    <div class="clr"></div>



                                    <div id="project-duration-timezone">
    <?php __('project_edit_ur'); ?> <?php echo $this->Html->link('time zone', array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit_profile'), array('target' => '_blank')); ?> <?php __('project_edit_is'); ?>: <?php echo $timezone->display($this->Session->read('Auth.User.timezone')); ?> <!-- Eastern Time  (US &amp; Canada) -->
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="clr"></div>
                        Div Calender Removed Comment End */ ?>
                         <div class="mt5"><?php __('project_edit_funding_duration_description'); ?></div>
						 <div class="clr"></div>
						 <div class="pt5"> <?php __('funding_duration_msg') ?></div>
                    </div>
                   
                    <div class="clr"></div>
                </div>
                <div class="greyboxtl"></div>
                <div class="greyboxtr"></div>
                <div class="greyboxbl"></div>
                <div class="greyboxbr"></div>
            </div>
<?php } else { ?>

            <div class="greybox mb12">
                <div class="p10">
                    <div class="fl width160 pt7"><?php __('project_edit_funding_duration'); ?></div>
                    <div class="fl mt5 width1490 grey12">
                    <?php $time_rem = $this->GeneralFunctions->show_left_time(time(), $this->data['Project']['project_end_date']);
                    echo $time_rem['time'].'&nbsp;';
                    echo sprintf(__('frnt_daystogo', true), $time_rem['unit']); ?>

                    </div>
                    <div class="clr"></div>
                </div>
                <div class="greyboxtl"></div>
                <div class="greyboxtr"></div>
                <div class="greyboxbl"></div>
                <div class="greyboxbr"></div>
            </div>
<?php } ?>
        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('project_edit_funding_goal'); ?></div>
                <div class="fl width1490 grey12">

                    <div> 
                        <div class="mt5 fl pt7"><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?> </div>
                        <div class="fl mt5">
                            <?php
                            if ($this->data['Project']['active'] == 0) {
                                //echo $this->Form->input('Project.funding_goal', array('class' => 'input-text602', 'label' => false, 'div' => false, 'error' => false));
                                echo $this->Form->input('Project.funding_goal', array('class' => 'input-text', 'label' => false, 'div' => false, 'error' => false));
                            } else {
                                echo " <strong>" . $this->data['Project']['funding_goal'] . " </strong>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>




    </div>
    <!-- Left Div -->
    <!-- Right Div --> 

    <div class="fr width23per pt21 pb80">
        <div class="greybox tip"><a href="<?php echo WEBSITE_URL; ?>display/how-to-make-an-awesome-project" target="_blank"><?php __('project_edit_how_to'); ?><br />
<?php __('project_edit_awesome_project'); ?></a>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>
        <div class="mt17">
            <div>
                <div class="sprite listingbxtl"></div>
                <div class="listingbxt"></div>
                <div class="sprite listingbxtr"></div>
                <div class="clr"></div>
            </div>
            <div class="listingbxmid">
                <div class="pb14">
                    <div id="project_image_div">

                        <?php
                        if (!empty($this->data['Project']['image'])) {
                            echo $this->Html->image('image.php?image=' . $this->data['Project']['image'] . '&height=150px&width=200px');
                        } else {
                            echo $this->Html->image('front/missing_little.png');
                        }
                        ?>
                    </div>
                </div>
                <div class="grey13">
                        <?php echo $this->Form->hidden('Project.old_title', array('value' => $this->data['Project']['title'])); ?>
                        <?php echo $this->Form->hidden('Project.old_short_description', array('value' => $this->data['Project']['short_description'])); ?> 
                    <span class="blue14 block pb9" id="changed_project_title"><?php echo $this->data['Project']['title']; ?></span> <span class="block pb17"><?php __('frnt_by'); ?> <?php echo $this->data['User']['name']; ?></span>
                    <span class="word-wrap" id="changed_project_blurb"><?php echo $this->data['Project']['short_description']; ?></span> </div>
                <div class="mt29 pb10">
                    <div>
                        <?php
                        $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($this->data['Project']['id'], $this->data['Project']['funding_goal'], $this->data['Backer']);
                        if ($total_funded_percentage > 100) {
                            $total_funded_slider_percentage = 100;
                        } else {
                            $total_funded_slider_percentage = $total_funded_percentage;
                        }
                        ?> 
                        <div class="project-pledged-wrap">
                            <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
                        </div>


                    </div>
                    <div class="grey13 pt15">
                        <div class="fl pr10"><strong><?php echo $total_funded_percentage; ?>%</strong> <br>
                            <?php __('frnt_funded'); ?></div>
                        <div class="fl pl10 pr10"><strong><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $this->GeneralFunctions->get_total_pledge_amount($this->data['Backer']); ?></strong> <br>
<?php __('frnt_pledged'); ?></div>
                        <div class="fl pl10">
<?php if(!isset($this->data['Project']['project_end_date'])){
    $this->data['Project']['project_end_date']='';
}
$time_rem = $this->GeneralFunctions->show_left_time(time(), $this->data['Project']['project_end_date']); ?>
                            <strong><?php echo $time_rem['time']; ?></strong> <br>
<?php echo sprintf(__('frnt_daystogo', true), $time_rem['unit']); ?>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
            <div>
                <div class="sprite listingbxbl"></div>
                <div class="listingbxb"></div>
                <div class="sprite listingbxbr"></div>
                <div class="clr"></div>
            </div>
        </div>
        
        <div class="mt17">
            <div>
                <div class="sprite listingbxtl"></div>
                <div class="listingbxt"></div>
                <div class="sprite listingbxtr"></div>
                <div class="clr"></div>
            </div>
            <div class="listingbxmid">
                
               <div class="mt5"><?php __('Choose your project picture carefully, It is the first thing potential backers will see!'); ?></div>
                
            </div>
            <div>
                <div class="sprite listingbxbl"></div>
                <div class="listingbxb"></div>
                <div class="sprite listingbxbr"></div>
                <div class="clr"></div>
            </div>
        </div>
    </div>

    <!-- End Right Div -->
