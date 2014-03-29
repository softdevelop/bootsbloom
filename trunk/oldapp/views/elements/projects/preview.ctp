<script type="text/javascript">
  
    $(function() {
        $("#get_share_link,#disable_share_link").unbind('click');
        $("#see_full_bio").unbind('click');
        $("#see_full_bio").click(function(){
            $('#bio_info').modal({
                minHeight:500,
                minWidth:800
            })
        });
    
        $("#get_share_link,#disable_share_link").click(function(){
            $('#saving-layer').show();
            $.ajax({
                url:HOST_URL+$("#get_share_link").attr('href')   
            }).done(function(data){
                var jsondata= $.parseJSON(data);
                if(jsondata.share_token!=''){
                    $(".share_url").html('');
                    $(".share_url").html(jsondata.url);
                    $("#sharing_enabled").show();
                    $("#sharing_disabled").hide();
                }else{
                    $(".share_url").html('');
                    $(".share_url").html(jsondata.url);
                    $("#sharing_enabled").hide();
                    $("#sharing_disabled").show();
               
                }
                $('#saving-layer').hide();
                return false;
            }); 
            return false;
        });
    
    });
</script>
<div class="bluebg" style="line-height: 40px;text-align: center">
    <?php if($this->params['action']=='preview'){ 
        if($this->data['Project']['active']!=1){ // display if project is not active
        ?>
    <div class="">
        <div id="sharing_disabled"  class="black17" <?php if (!empty($this->data['Project']['project_preview_token'])) { ?> style="display: none;"  <?php } ?>> Let friends or collaborators preview your project. <span class="grey17"><?php echo $this->Html->link('Get preview link', array('controller' => 'projects', 'action' => 'share', $this->data['Project']['id']), array('id' => 'get_share_link')); ?></span> </div>
        <div id="sharing_enabled" class="black17"  <?php if (empty($this->data['Project']['project_preview_token'])) { ?> style="display: none;"  <?php } ?>> Here's your preview link : <span class="share_url"><?php echo WEBSITE_URL . 'projects/draft/' . $this->data['User']['slug'] . '/' . $this->data['Project']['id'] . '/' . $this->data['Project']['project_preview_token']; ?> </span> <span class="grey17"> <?php echo $this->Html->link('Disable Preview Link', array('controller' => 'projects', 'action' => 'share', $this->data['Project']['id']), array('id' => 'disable_share_link')); ?> </span></div>
    </div>
    <?php } } ?>
     <?php if($this->params['action']=='draft'){ ?>
    <div class="">
        <div class="heading_23" > This is not a live project. This is a draft shared by <?php echo $this->data['User']['name'];?> for feedback. </div>
        <div class="clr"></div>
        <div class="grey14">Note that all projects must comply with the <?php Configure::read('CONFIG_SITE_TITLE');?> <?php echo $this->Html->link('Project Guidelines',array('plugin'=>'pages','controller'=>'pages','action'=>'display','guidelines'));  ?> to launch. <?php echo $this->data['User']['name'];?> may disable this link at any time
</div>
    </div>
    <?php } ?>
</div>
<div class="grey_gradient">
    <div class="pt24">
        <div class="wrapper">
            <h2> <?php echo $this->data['Project']['title']; ?></h2>
            <div class="mt29">
                <div class="fl">
                    <ul class="user_tabs">
                        <li><a href="javascript:void(0);"><?php __('projt_dtl_project_home'); ?></a></li>
                        <li><a href="javascript:void(0);"><?php __('projt_dtl_project_update'); ?> <span> 0 </span></a> </li>
                        <li><a href="javascript:void(0);"><?php __('projt_dtl_project_backers'); ?> <span> 0 </span></a> </li>
                        <li><a href="javascript:void(0);"><?php __('projt_dtl_project_comment'); ?> <span> 0 </span></a> </li>
                    </ul>
                </div>
              
                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>
<div class="tab_container">
    <div id="tab1" class="tab_content">
        <div class="ptb21">
            <div class="wrapper">
                <div class="abprolft">
					<div class="wrapper615">
                        <div class="imgbrd4">
                            <div id="project_image"><?php echo $this->Html->image($this->GeneralFunctions->get_project_image($project_detail['Project']['id'], '605px', ''), array('width' => '605', 'height' => '')) ?></div>
                        </div>
                    </div>
                    <div>
                        <div>
                            <div class="fl sprite bxlft"></div>
                            <div class="fl bxtop blue22 uppercase"> <?php __('projt_dtl_about_project'); ?></div>
                            <div class="fl sprite bxrgt"></div>
                            <div class="clr"></div>
                        </div>
                        <div class="bxmid">
                            <div class="boxshade grey14 lh20 imgbrd1 word-wrap">
                                <?php echo $this->data['Project']['description']; ?>
                            </div>
                        </div>
                        <div>
                            <div class="fl sprite bxlft_bot"></div>
                            <div class="fl bxbot"></div>
                            <div class="fl sprite bxrgt_bot"></div>
                            <div class="clr"></div>
                        </div>
                    </div>
                </div>
                <?php echo $this->element('projects/project_detail_right_panel'); ?>
                <div class="clr"></div>
            </div>
        </div>
    </div>

</div>
<div style="display: none;" id="bio_info"><?php echo $this->element('projects/user_bio');?></div>