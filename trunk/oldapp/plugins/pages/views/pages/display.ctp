<div class="grey_gradient">
  <div class="pt20">
    <div class="wrapper">
      <h2 class="pageheading"><?php 
		$language=$this->Session->read('Config.language');
		if($language !='hy'){ 
			echo ucwords($page_data[$model]['title']);
		}else {
			echo ucwords($page_data[$model]['title_hy']);
		}	  ?>
	 </h2>
    </div>
  </div>
</div>
<div class="ptb21">
  <div class="innerwrapper">
	<div class="grey14 lh20 imgbrd1"> 
		<?php
			if(!empty($page_data)){
				if($language !='hy'){ 
					echo ucfirst($page_data[$model]['description']);
			} else {
					echo ucfirst($page_data[$model]['description_hy']);
			} } else{ ?>
			<div class="aligncenter grey16 innerwrapper ">
				<span class="valignmiddle pt157">
				<?php __('page_empty_msg');?>
				</span>
			</div>
		<?php } ?>
	</div>
  </div>
  <div class="clr"></div>
</div>
