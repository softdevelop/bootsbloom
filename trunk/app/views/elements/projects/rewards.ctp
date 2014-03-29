<script type="text/javascript">
    <?php if(count($this->data['Reward'])==0){ ?>
    var total_reward    =   '<?php echo count($this->data['Reward'])+1; ?>';
    
    <?php }else{ ?>
        var total_reward    =   '<?php echo count($this->data['Reward']); ?>';
    <?php } ?>
    var next_reward =   total_reward;
    var reward_counter=total_reward;
    $(document).ready(function() {
        $("#add_more_rewards").click(function(){
           reward_counter++;
            handleFormChanged();
            $.ajax({
                url:HOST_URL+$("#add_more_rewards").attr('href')+'/'+project_id+'/'+next_reward+'/'+reward_counter
                
            }).done(function(data){
             next_reward++;   
            
                $("#reward_append_to_div").append(data);
                $('#sections').height($('#sections').height()+292);
                return false;
            });
            
            return false;
        });
    });
    
   
</script>

<input type="hidden" id="total_re" value="<?php echo count($this->data['Reward']); ?>" />
<div class="greybg_light">
    <div class="wrapper ptb15 aligncenter grey15_dark"> 
        <span class="blue40 block"><?php __('project_edit_reward_title'); ?></span>
        <?php __('project_edit_reward_title_description'); ?>

    </div>
</div>

<div class="wrapper grey14">
    <!-- Left Div -->
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


    <div class="fl pb80 greybrdrgt pt21 width68per pr50">
        <div id="rewards_errors" >

        </div>
        <?php foreach ($rewards as $reward) { ?>

            <div id="reward_append_to_div_<?php echo $total_reward; ?>">  

                <div class="fl   pt21 width68per greybox pr50 width100per" >
                    <?php
                    if ($this->validationErrors) {

                        if (isset($this->validationErrors['Project']['Reward'][$total_reward])) {
                            ?>
                            <div>
                                <div class="error pt10">
                                    <?php
                                    echo "<ul>";

                                    foreach ($this->validationErrors['Project']['Reward'][$total_reward] as $error) {
                                        ?>
                                        <li><?php echo $error; ?></li>
                                        <?php
                                    }
                                    echo "</ul>";
                                    ?>
                                </div>
                            </div> 
                        <?php }
                    } ?>

                    <div>
                        <?php
                        if (!isset($reward['id'])) {
                            echo $this->Form->input("Reward.id", array('type' => 'hidden', 'name' => 'data[Reward][id][]', 'label' => false, 'error' => false, 'div' => false, 'value' => ""));
                        } else {
                            echo $this->Form->input("Reward.id", array('type' => 'hidden', 'name' => 'data[Reward][id][]', 'label' => false, 'error' => false, 'div' => false, 'value' => $reward['id']));
                        }
                        if ($this->data['Project']['active'] == 0) {    // edit if project is not active yet.
                            ?>
                            <div class="greybox mb12">
                                <div class="p10">
                                    <div class="fl width160 pt10">
                                            <?php echo $this->Html->link(__('project_edit_rewards',true).'#'.($total_reward + 1),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school_home'),array('class'=>'helplink','target'=>'_blank')); ?>
                                    </div>
                                    <div class="fl width1490 grey12">

                                        <div class="rewardbox">
                                            <div class="greybrdbot">
                                                <div class="fl">
                                                    <div class="rewardfield"><?php __('project_edit_reward_pledge_amount'); ?></div>
                                                    <div class="fl">
                                                        <?php echo $this->Form->input("Reward.pledge_amount", array('type' => 'text', 'name' => 'data[Reward][pledge_amount][]', 'class' => 'input-text100', 'label' => false, 'error' => false, 'div' => false, 'value' => $reward['pledge_amount'])); ?>

                                                    </div>
                                                    <div class="clr"></div>    
                                                </div>
                                                <div class="deletebutton">
                                                    <!-- Delete -->
                                                    <?php
                                                    if (!isset($reward['id']) || empty($reward['id'])) {
                                                        $reward_id = 0;
                                                    } else {
                                                        $reward_id = $reward['id'];
                                                    }echo $this->Html->link(__('project_edit_reward_delete', true), 'javascript:void(0);', array('onclick' => "remove_reward('" . $total_reward . "','" . $reward_id . "')"));
                                                    ?>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                            <div class="greybrdbot">
                                                <div class="rewardfield h94"><?php __('project_edit_reward_description'); ?></div>
                                                <div class="fl">

                                                    <?php echo $this->Form->textarea("Reward.description", array('class' => 'textarea60', 'name' => 'data[Reward][description][]', 'label' => false, 'error' => false, 'value' => $reward['description'])); ?>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                            <div class="greybrdbot">
                                                <div class="rewardfield">Est. <?php __('project_edit_reward_delivery_date'); ?></div>
                                                <div class="fl">

                                                     <?php echo $this->Time->month_select('Project.month_select', $reward['est_delivery_month'], array('label' => false, 'error' => false, 'empty' => 'Select Month', 'name' => 'data[Reward][est_delivery_month][]', 'error' => false, 'div' => false, 'class' => 'select230')); ?>
                                                </div>
                                                <div class="fl">
                                                    <?php echo $this->Time->year_select('Project.est_delivery_year', $reward['est_delivery_year'], 5, array('label' => false, 'error' => false, 'empty' => 'Select Year', 'name' => 'data[Reward][est_delivery_year][]', 'error' => false, 'div' => false, 'class' => 'select138')); ?>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                            <div class="ptb9">
                                                <div class="fl backersico2 mr40 mt5">0 <?php __('projt_dtl_project_backers'); ?></div>
                                                <div class="fl pt10">
                                                    <?php
                                                    $checked = "";
                                                    if ($reward['limit'] == 1) {
                                                        $checked = 'checked';
                                                    }
                                                    echo $this->Form->checkbox("Reward.limit", array('class' => '', 'label' => false, 'name' => 'data[Reward][limit][]', 'value' => 1, 'error' => false, 'hiddenField' => false, 'id' => 'RewardLimit_' . $total_reward, 'onclick' => 'return check_limit_value(' . $total_reward . ')', 'checked' => $checked));
                                                    ?>

                                                </div>
                                                <div class="fl pl5 pt10">
                                                    <div class="fl">
                                                        <?php __('project_edit_reward_limit_available'); ?>
                                                    </div>

                                                </div>


                                                <div class="fl pl5" style="padding-bottom: 0px;padding-top: 0px">
                                                    <span id="limit_value_div_<?php echo $total_reward; ?>" <?php if ($reward['limit'] != 1) { ?> style="display: none;" <?php } ?>><?php echo $this->Form->text('Reward.limit_value', array('class' => 'input-text100', 'name' => 'data[Reward][limit_value][]', 'error' => false, 'id' => 'RewardLimitValue_' . $total_reward, 'value' => $reward['limit_value'])); ?></span>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                        </div>




                                    </div>
                                    <div class="clr"></div>
                                </div>
                                <div class="greyboxtl"></div>
                                <div class="greyboxtr"></div>
                                <div class="greyboxbl"></div>
                                <div class="greyboxbr"></div>
                            </div>
                     <?php } else { // display if project  is active 
                         $total_backer_on_reward=0;
                                if (!isset($reward['id']) || empty($reward['id'])) {
                                    $reward_id = '';
                                } else {
                                    $reward_id = $reward['id'];
                                }
                         
                            $total_backer_on_reward     =    $this->GeneralFunctions->get_total_backer_on_reward($reward_id, $this->data['Backer']);
                            if($total_backer_on_reward>0){
                            ?>
                            <div class="fl  grey14 pt7">
                                <strong><?php __('project_edit_rewards'); ?> #<?php echo $total_reward + 1; ?></strong></div>
                            <div class="fr width1490">
                                <div class="fl  grey14 pt7 width100per">
                                    <div class="fl pr5 width48per" style="width:100px;">
                                        <?php __('projt_dtl_pledge'); ?> 
                                    </div>
                                    <div class="fl"> 
                                        <div class="fl">
                                            <span class="fl"><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?></span>  <span class="fr"><?php echo $reward['pledge_amount']; ?> <?php __('project_edit_or'); ?> <?php __('project_edit_reward_more'); ?>
                                            <?php echo $this->Form->input("Reward.pledge_amount", array('type' => 'hidden', 'name' => 'data[Reward][pledge_amount][]', 'class' => 'input-text100', 'label' => false, 'error' => false, 'div' => false, 'value' => $reward['pledge_amount'])); ?> </span>
                                        </div>

                                    </div>

                                </div>
                                <div class="clr"></div>
                                <div class="fl  grey14 pt7 width100per">
                                    <div class="fl"> 
                                        <span class="backersico"></span>  <?php echo $total_backer_on_reward; ?> <?php __('projt_dtl_project_backers'); ?>  
                                        <?php
                                        if ($reward['limit'] == 1) {
                                            echo ' limited ( ' . $reward['limit_value'] . ' of ' . $reward['limit_value'] . ' left ) ';
                                        }
                                        ?>
                                    </div>

                                </div>
                                <div class="clr"></div>
                                <div class="fl  grey14 pt7 width100per">
                                    <div class="fl"> 
                                        <?php echo $reward['description']; ?>
                                        <?php echo $this->Form->input("Reward.description", array('name' => 'data[Reward][description][]', 'type'=>'hidden', 'error' => false, 'value' => $reward['description'])); ?>
                                    </div>

                                </div>
                                <div class="clr"></div>
                                <div class="fl  grey14 pt7 width100per">
                                    <?php __('projt_dtl_estimated_delivery'); ?>: <?php echo $this->Time->get_month($reward['est_delivery_month']) . " " . $reward['est_delivery_year']; ?>
                                    <?php echo $this->Form->input("Reward.est_delivery_month", array('name' => 'data[Reward][est_delivery_month][]', 'type'=>'hidden', 'error' => false, 'value' => $reward['est_delivery_month']));
                                        echo $this->Form->input("Reward.est_delivery_year", array('name' => 'data[Reward][est_delivery_year][]', 'type'=>'hidden', 'error' => false, 'value' => $reward['est_delivery_year']));
                                        echo $this->Form->input("Reward.limit", array('name' => 'data[Reward][limit][]', 'type'=>'hidden', 'error' => false, 'value' => $reward['limit'])); 
                                        echo $this->Form->input("Reward.limit_value", array('name' => 'data[Reward][limit_value][]', 'type'=>'hidden', 'error' => false, 'value' => $reward['limit_value'])); ?>
                                </div>

                                <div class="clr"></div>
                            </div>
                            <?php } if($total_backer_on_reward==0){ ?>
                               <div class="greybox mb12">
                                <div class="p10">
                                    <div class="fl width160 pt10">
                                            <?php echo $this->Html->link(__('project_edit_rewards',true).'#'.($total_reward + 1),array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school_home'),array('class'=>'helplink','target'=>'_blank')); ?>
                                    </div>
                                    <div class="fl width1490 grey12">

                                        <div class="rewardbox">
                                            <div class="greybrdbot">
                                                <div class="fl">
                                                    <div class="rewardfield"><?php __('project_edit_reward_pledge_amount'); ?></div>
                                                    <div class="fl">
                                                        <?php echo $this->Form->input("Reward.pledge_amount", array('type' => 'text', 'name' => 'data[Reward][pledge_amount][]', 'class' => 'input-text100', 'label' => false, 'error' => false, 'div' => false, 'value' => $reward['pledge_amount'])); ?>

                                                    </div>
                                                    <div class="clr"></div>    
                                                </div>
                                                <div class="deletebutton">
                                                    <!-- Delete -->
                                                    <?php
                                                    if (!isset($reward['id']) || empty($reward['id'])) {
                                                        $reward_id = 0;
                                                    } else {
                                                        $reward_id = $reward['id'];
                                                    }echo $this->Html->link(__('project_edit_reward_delete', true), 'javascript:void(0);', array('onclick' => "remove_reward('" . $total_reward . "','" . $reward_id . "')"));
                                                    ?>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                            <div class="greybrdbot">
                                                <div class="rewardfield h94"><?php __('project_edit_reward_description'); ?></div>
                                                <div class="fl">

                                                    <?php echo $this->Form->textarea("Reward.description", array('class' => 'textarea60', 'name' => 'data[Reward][description][]', 'label' => false, 'error' => false, 'value' => $reward['description'])); ?>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                            <div class="greybrdbot">
                                                <div class="rewardfield">Est. <?php __('project_edit_reward_delivery_date'); ?></div>
                                                <div class="fl">

                                                     <?php echo $this->Time->month_select('Project.month_select', $reward['est_delivery_month'], array('label' => false, 'error' => false, 'empty' => 'Select Month', 'name' => 'data[Reward][est_delivery_month][]', 'error' => false, 'div' => false, 'class' => 'select230')); ?>
                                                </div>
                                                <div class="fl">
                                                    <?php echo $this->Time->year_select('Project.est_delivery_year', $reward['est_delivery_year'], 5, array('label' => false, 'error' => false, 'empty' => 'Select Year', 'name' => 'data[Reward][est_delivery_year][]', 'error' => false, 'div' => false, 'class' => 'select138')); ?>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                            <div class="ptb9">
                                                <div class="fl backersico2 mr40 mt5">0 <?php __('projt_dtl_project_backers'); ?></div>
                                                <div class="fl pt10">
                                                    <?php
                                                    $checked = "";
                                                    if ($reward['limit'] == 1) {
                                                        $checked = 'checked';
                                                    }
                                                    echo $this->Form->checkbox("Reward.limit", array('class' => '', 'label' => false, 'name' => 'data[Reward][limit][]', 'value' => 1, 'error' => false, 'hiddenField' => false, 'id' => 'RewardLimit_' . $total_reward, 'onclick' => 'return check_limit_value(' . $total_reward . ')', 'checked' => $checked));
                                                    ?>

                                                </div>
                                                <div class="fl pl5 pt10">
                                                    <div class="fl">
                                                        <?php __('project_edit_reward_limit_available'); ?>
                                                    </div>

                                                </div>


                                                <div class="fl pl5" style="padding-bottom: 0px;padding-top: 0px">
                                                    <span id="limit_value_div_<?php echo $total_reward; ?>" <?php if ($reward['limit'] != 1) { ?> style="display: none;" <?php } ?>><?php echo $this->Form->text('Reward.limit_value', array('class' => 'input-text100', 'name' => 'data[Reward][limit_value][]', 'error' => false, 'id' => 'RewardLimitValue_' . $total_reward, 'value' => $reward['limit_value'])); ?></span>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                        </div>




                                    </div>
                                    <div class="clr"></div>
                                </div>
                                <div class="greyboxtl"></div>
                                <div class="greyboxtr"></div>
                                <div class="greyboxbl"></div>
                                <div class="greyboxbr"></div>
                            </div>
                            <?php } ?>
    <?php } ?>
                    </div>
                    <div class="greyboxtl"></div>
                    <div class="greyboxtr"></div>
                    <div class="greyboxbl"></div>
                    <div class="greyboxbr"></div>

                </div>

                <div class="clr"><br /></div>
            </div>

            <?php
            $total_reward++;
        }
        ?>

        <div id="reward_append_to_div"> 

        </div>


            <?php echo $this->Form->hidden('Reward.remove_ids', array('value' => '', 'id' => 'remove_ids')); ?>
            <?php //if ($this->data['Project']['active'] == 0) { ?>
                <span class="fl addmore_but">
                <?php echo $this->Html->link('ADD MORE', array('plugin' => false, 'controller' => 'projects', 'action' => 'add_more_rewards'), array('id' => 'add_more_rewards')); ?>
                </span>
            <?php //} ?>
    </div>

    <!-- Left Div -->
    <!-- Right Div --> 

    <div class="fr width23per pt21 pb80">
        <div class="greybox tip">
            <?php $pages = $this->GeneralFunctions->get_page_content_by_id(array('74'), array('Page.id', 'Page.slug', 'Page.slug_hy','Page.title','Page.title_hy'));
            echo $this->Html->link(ucfirst($pages[0]['Page']['title'.$lang_var]), array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display', $pages[0]['Page']['slug' . $lang_var])); ?>
           <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>
        <div class="clr"></div>
        <div class="mt17">
            <?php echo $right_panel_contents[1]['Page']['description'.$lang_var]; ?>
        </div>
    </div>
</div>
<!-- End Right Div -->
