<script type="text/javascript">
  /*  $(document).ready(function() {
  
    $("#accept_project_agreement").click(function(){
        if($("#accept_project_agreement").is(':checked')){
          
            $("#project_submit_button").addClass('launch_project_blue');
            $("#project_submit_button").removeClass('launch_project');
        }else{
            $("#project_submit_button").removeClass('launch_project_blue');
            $("#project_submit_button").addClass('launch_project');
        }
    });
    
    $("#project_submit_button").click(function(){//alert("FSDFSDF"); return false;
        if($("#accept_project_agreement").is(':checked')){ //alert("FSDFSDF"); return false;
            $('#saving-layer').show();
            $("#ProjectCreateFormTT").submit(); 
        }else{
            
        }
        
    });
    });*/
</script> 
<?php echo $this->Form->create('Project', array('url' => array('plugin'=>false,'controller'=>'projects','action'=>'final_review',$user_slug,$project_id),'id'=>'ProjectCreateForm')); ?>
<div class="grey_gradient">
    <div class="pt20">
        <div class="wrapper">
            <h2 class="pageheading"><?php echo $page_detail['Page']['title' . $lang_var]; //echo $lang_var; ?>
            </h2>
        </div>
    </div>
</div>
<div class="ptb21">
    <div class="innerwrapper">
        <div class="grey14 lh20 imgbrd1"> 
            <?php echo $page_detail['Page']['description' . $lang_var]; ?>
        </div>
        <div class="clr"></div>
        <div class="grey14 lh20 imgbrd1"> 
            <?php echo $this->Form->checkbox('accept_agreement', array('value' => '1', 'div' => false, 'label' => false, 'id' => 'accept_project_agreement')); ?> &nbsp;<?php __('project_final_review_checkbox') ?><?php echo ', the ' . __('frnt_term_use', true) . __('and_the', true) . Configure::read("CONFIG_SITE_TITLE") . __('project_guidelines', true); ?>
        </div>

        <div class="pt10">
            <div class="grey14 fl pr10"> 
                <?php 
                //echo $this->Form->submit(__('launch_project_now', true), array('class' => 'launch_project ie_radius', 'id' => 'project_submit_button','div'=>false));
                //array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $user_slug)
                 echo $this->Html->link(__('launch_project_now', true),'javascript:void(0);', array('class' => 'button_grey ie_radius', 'id' => 'project_submit_button')); ?> &nbsp; &nbsp; &nbsp;
            </div>

            <div class="grey14 fl"> 
                <?php echo $this->Html->link(__('project_edit_ur_project', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'edit', $user_slug, $project_id), array('class' => 'button_grey ie_radius')); ?>
            </div>
        </div>
    </div>

</div>

<div class="ptb13">
    <div >

    </div>
    <div class="clr"></div>
</div>
<?php echo $this->Form->end(); ?>