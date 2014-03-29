<script>
    $(function(){
        function equalHeight(group) {
			tallest = 0;
			group.height('');
			group.each(function() {
				thisHeight = $(this).height();
				
				if(thisHeight > tallest) {
					tallest = thisHeight;
					
				}
			});
			group.height(tallest);
		}
		equalHeight($("#helpbox>div"));
    });
</script>
<div class="wrapper grey14">
    <div class="fl pb80 greybrdrgt pt21 width68per pr50">
        <?php echo $page_content['Page']['description']; ?>
        <div id="helpbox" style = "padding-top:8px;">
			  <div class="fl rbluebg2 white14 pl10 pr33 width373"><span class="ptb15 block"><?php __('project_edit_have_question'); ?></span></div>
			  <div class="fl rbluebg3 white24 relative">
				  <div class="quoteicon">
					<?php echo $this->Html->image('quote2.png',array('width'=>'52','height'=>'46')); ?></div>
					<div class="fl"><?php echo $this->Html->link(__('project_edit_drop_line', true), 'javascript:void(0)', array('class' => 'ptb15 plr20 block', 'onclick' => 'contact_us()')); ?></div>
			  </div>
		 </div>
		 <div class="clr"></div>
    </div>

    <div class="fr width23per pt21 pb80"><?php echo $right_panel_contents[0]['Page']['description'.$lang_var]; ?></div>

    <div class="clr"></div>

</div>
<div id="contact_us" style="display: none; width: 100px;"></div>
