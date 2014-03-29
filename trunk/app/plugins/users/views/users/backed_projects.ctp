<script type="text/javascript">
    $(document).ready(function() {
        var project_success =   0;
        var project_success_msg =   "";
<?php if (isset($project_success) && isset($project_success_msg)) { ?>
                project_success =   '<?php echo $project_success; ?>';
                project_success_msg =   '<?php echo $project_success_msg; ?>';
<?php } ?>
            if((project_success==1)){
        
                noty({
                    "text":project_success_msg,
                    "theme":"noty_theme_default",
                    "layout":"top",
                    "type":"success",
                    "animateOpen":{
                        "height":"toggle"
                    },
                    "animateClose":{
                        "height":"toggle"
                    },
                    "speed":500,
                    "timeout":5000,
                    "closeButton":true,
                    "closeOnSelfClick":true,
                    "closeOnSelfOver":false,
                    "modal":true
                });    
        
            }
  
        });
</script>
<?php $wesite_list = explode(',', $this->data['User']['website']); ?>
<?php echo $this->element("front/user_profile_tabs"); ?>
<?php echo $this->element("front/profile_projects"); ?>