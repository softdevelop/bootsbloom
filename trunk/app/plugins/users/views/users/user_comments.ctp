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
<?php //echo $this->element("front/profile_projects"); ?>

<?php
$wesite_list = explode(',', $this->data['User']['website']);

$paginator->options = array('url' =>
    array_merge(array('slug' => $this->params['slug']), $this->passedArgs)
);
?>
<!--condition for this view can not load this element start -->

<div class="ptb21">
    <div class="wrapper">
        <?php /*         * *******Edit profile link********** */ ?>
        <div  style="padding-top:100px">
            <div>
                 <?php
                    echo $this->element('front/profile_page_tab');  ?>
                <div class="clr"></div>  
               
                <div id="loading_content">
                 <?php
                       echo $this->element('front/load_more_user_comment'); 
                    ?>

                </div>  
                 <?php if(count($user_comments)>0){ ?> 
                <div id="loadmore_loader" class="aligncenter" style="display: none;">
                    <?php echo $this->Html->image('front/ajax-loader.gif'); ?>
                </div>
                <div id="loadContentId" class='loadmore'>
                    <?php
                          if($current_page!=$last_page){
                                echo $this->Html->link($this->Html->tag('span',__('blog_load_more',true)),array('plugin' => 'users', 'controller' => 'users', 'action' => 'user_comments','slug'=> $slug, 'page' => $page),array('escape'=>false,'class'=>'loadmoreicon','id' => 'loadMoreContent'));
                              
                          } ?>
                </div>
                <?php } ?>	
            </div>
            <div class="clr "></div>
        </div> 
    </div>	
</div>

<div class="clr pt40"></div>
