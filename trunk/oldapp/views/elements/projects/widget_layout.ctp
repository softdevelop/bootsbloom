<style>
    .widget_show{
        width: 800px;
    }
    .size{
        width: 500px;
    }
    .video_pane{
        width: 520px;
        border-right: 1px solid #E6E6E6;
    }

</style>

<script>
   
    function change_widget_code(size){
     
        if(size=='size-small'){
            $('#custom_width').val('480');
            $('#custom_height').val('360');
            $("#video_widget_code").html('<iframe frameborder="0" width="480" height="360"  src="<?php echo WEBSITE_URL; ?>projects/video_widget/<?php echo $project_detail['User']['slug']; ?>/<?php echo $project_detail['Project']['slug']; ?>" ></iframe>')
        }
        if(size=='size-medium'){
            $('#custom_width').val('640');
            $('#custom_height').val('480');
            $("#video_widget_code").html('<iframe frameborder="0" height="480" width="640"  src="<?php echo WEBSITE_URL; ?>projects/video_widget/<?php echo $project_detail['User']['slug']; ?>/<?php echo $project_detail['Project']['slug']; ?>" ></iframe>')
        }
        if(size=='size-large'){
            $('#custom_width').val('800');
            $('#custom_height').val('600');
            $("#video_widget_code").html('<iframe frameborder="0" height="600" width="800"  src="<?php echo WEBSITE_URL; ?>projects/video_widget/<?php echo $project_detail['User']['slug']; ?>/<?php echo $project_detail['Project']['slug']; ?>" ></iframe>')
        }
        if(size=='size-custom'){
            var width   =   $('#custom_width').val('');
            var height   =   $('#custom_height').val('');
         
        }
        
    }
    $(function() {

        $('#custom_height').click(function(){
            $("#widget-size_size-custom").attr('checked','true');
    
        })
        $('#custom_width').click(function(){
            $("#widget-size_size-custom").attr('checked','true');
    
        })
        $('#custom_width').bind("keyup input cut paste",function(b){
            $("#widget-size_size-custom").attr('checked','true');
            var c=4/3,
            d=$("input#custom_width").val();
            f=$("input#custom_height").val();
            f=Math.ceil(d/c);
            $("input#custom_height").val(f);
            $("#video_widget_code").html('<iframe frameborder="0" height="'+f+'" width="'+d+'"  src="<?php echo WEBSITE_URL; ?>projects/video_widget/<?php echo $project_detail['User']['slug']; ?>/<?php echo $project_detail['Project']['slug']; ?>" ></iframe>')
     
        });

        $('#custom_height').bind("keyup input cut paste",function(b){
            var c=4/3,
            d=$("input#custom_width").val();
            f=$("input#custom_height").val();
            d=Math.ceil(f*c);
            $("input#custom_width").val(d);
            $("#video_widget_code").html('<iframe frameborder="0" height="'+f+'" width="'+d+'"  src="<?php echo WEBSITE_URL; ?>projects/video_widget/<?php echo $project_detail['User']['slug']; ?>/<?php echo $project_detail['Project']['slug']; ?>" ></iframe>')
        });
    });
</script>


<div class="widget_show">
    <div class="fl video_pane">
        <div class="blue22 pb10"><?php __('project_detail_video_preview'); ?></div>
        <div >

            <textarea onclick="this.select()" class="textarea600" id="video_widget_code">
                <iframe frameborder="0" height="480" width="360"  src="<?php echo WEBSITE_URL; ?>projects/video_widget/<?php echo $project_detail['User']['slug']; ?>/<?php echo $project_detail['Project']['slug']; ?>" ></iframe>
            </textarea>
        </div>
        <div class="clr"></div>
        <div >
            <iframe scrolling="no" frameborder="0" width="480" height="300"  src="<?php echo WEBSITE_URL; ?>projects/video_widget/<?php echo $project_detail['User']['slug']; ?>/<?php echo $project_detail['Project']['slug']; ?>"></iframe>

        </div>
        <div class="clr"></div>
        <p class="grey13 pt10 pb10">
            <?php __('project_detail_widget_viedo_code'); ?>
        </p>
        <div class="size grey13">
            <div class="fl">
                <label>
                    <input type="radio"  value="size-small" checked name="widget-size" id="widget-size_size-small" onclick="change_widget_code(this.value);" class="radio" style="display: none;" />
                    <div class="size-sm">
                        480 x 360
                    </div>
                </label>
            </div>
            <div class="fl">
                <label>
                    <input type="radio" value="size-medium" name="widget-size" id="widget-size_size-medium" onclick="change_widget_code(this.value);" class="radio" style="display: none;">
                    <div class="size-md">
                        640 x 480
                    </div>
                </label>
            </div>
            <div class="fl">
                <label>
                    <input type="radio" value="size-large" name="widget-size" id="widget-size_size-large" onclick="change_widget_code(this.value);" class="radio" style="display: none;">
                    <div class="size-lg">
                        800 x 600
                    </div>
                </label>
            </div>
            <div class="fl">

                <input type="radio" value="size-custom" name="widget-size" id="widget-size_size-custom" onclick="change_widget_code(this.value);" class="radio" style="display: none;">
                <div class="custom">
                    <p>
                        <?php __('project_detail_widget_Custom_size'); ?>
                    </p>
                    <input type="text" id="custom_width" value="480" style="width: 30px" name="width" id="width" class="input-text">
                    x
                    <input type="text" id="custom_height" value="360" style="width: 30px" name="height" id="height" class="input-text">
                </div>

            </div>

        </div>
    </div>
    <div class="baseball-card pane with_video fr">
        <div class="blue22"><?php __('project_detail_widget_preview'); ?></div>
        <div class="clr"></div>
        <div class="code">
            <textarea onclick="this.select()"><iframe frameborder="0" height="410" src="<?php echo WEBSITE_URL; ?>projects/widget/<?php echo $project_detail['User']['slug']; ?>/<?php echo $project_detail['Project']['slug']; ?>" width="240"></iframe></textarea>
        </div>
        <div class="clr"></div>
        <iframe width="240" scrolling="no" height="450" frameborder="0" src="<?php echo WEBSITE_URL; ?>projects/widget/<?php echo $project_detail['User']['slug']; ?>/<?php echo $project_detail['Project']['slug']; ?>"></iframe> 
    </div>
    <div class="clr"></div>

</div>