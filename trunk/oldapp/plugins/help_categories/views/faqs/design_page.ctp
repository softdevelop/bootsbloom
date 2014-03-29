<div class="grey_gradient">
  <div class="pt24 pb17">
    <div class="wrapper aligncenter">
      <h2>
			<?php 
				$png = __('Png',true).'('.__('Bit_Map',true).')'; 
				$eps = __('Eps',true).'('.__('Vector',true).')'; 
			
			?>
			<span class = "style_heading"><?php __('Style_Guide_Title'); ?></span>
			<span><?php __('Style_Guide_Heading_Text');?></span> 
		</h2>
    </div>
  </div>
</div>
<div class="ptb21">
  <div class="wrapper">
    <div class=" aligncenter blue22 uppercase"><?php  //__('Style_Guide_Downlaod'); ?></div>
    <div class="clr pt20"></div>
    <div class="grey14  ">
      <h2><?php  __('Style_Guide_Rules'); ?> :</h2>
      <ul class="pt10">
        <li><?php __('Style_Guide_Product'); ?></li>
        <li><?php __('Style_Guide_Website'); ?></li>
        <li><?php __('Style_Guide_Strict'); ?></li>
      </ul>
    </div>
    <div class="clr pt20"></div>
    <div>
      <div class="faq">
		<span class="style_heading_2"><?php __('LOGOS'); ?></span>
		<span class="faq_doteat"></span>
        <div class="clr pt20"></div>
      </div>
      <div class="clr pt20"></div>
	  <div class="clr pt20"></div>
      <div>
        <div class="fl wid_305 aligncenter">
          <div class="logo_img"><?php echo $this->Html->image('front/logo/text-logo1.png',array('alt'=>'')); ?></div>
          <div class="clr pt20"></div>
          <div class="type_img"> 
			 <?php echo $this->Html->link($png,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download' , 'text-logo1.png'),array('class'=>'fl','escape'=>false)); ?>
			  <?php echo $this->Html->link($eps,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download' , 'text_logo.eps'),array('class'=>'fr','escape'=>false)); ?>
		  </div>
        </div>
        <div class="fl pl47 wid_305 aligncenter">
          <div class="logo_img"><?php echo $this->Html->image('front/logo/text-logo.png',array('alt'=>'')); ?></div>
          <div class="clr pt20"></div>
          <div class="type_img"> 
			<?php echo $this->Html->link($png,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download' , 'text-logo.png'),array('class'=>'fl','escape'=>false)); ?>
			 <?php echo $this->Html->link($eps,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download' , 'text_logo2.eps'),array('class'=>'fr','escape'=>false)); ?>
		  </div>
        </div>
        <div class="fr wid_305 aligncenter">
          <div class="logo_img"><?php echo $this->Html->image('front/logo/text-logo2.png',array('alt'=>'')); ?></div>
          <div class="clr pt20"></div>
          <div class="type_img"> 
			<?php echo $this->Html->link($png,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download' , 'text-logo2.png'),array('class'=>'fl','escape'=>false)); ?>
			<?php echo $this->Html->link($eps,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download' , 'text_logo3.eps'),array('class'=>'fr','escape'=>false)); ?>
		 </div>
        </div>
      </div>
      <div class="clr"></div>
    </div>
    <div class="clr pt40"></div>
    <div>
      <div class="faq"><span class="style_heading_2"><?php __('Style_Guide_Color'); ?></span><span class="faq_doteat"></span>
        <div class="clr pt20"></div>
      </div>
      <div class="clr pt40"></div>
      <div>
        <div class="fl wid_305 aligncenter">
          <div class="logo_img"><?php echo $this->Html->image('front/style_guide/white_color.png',array('alt'=>'')); ?></div>
          <div class="clr pt20"></div>
          <div class="color_code">
				<strong><?php __('CMYK'); ?>: </strong>	<span>0, 0, 0, 0</span><br>
				<strong><?php __('Hex'); ?>:</strong> 	<span>#FFFFFF</span><br>
				<strong><?php __('RGB'); ?>:</strong> 	<span>255, 255, 255</span><br> 
          </div>
        </div>
        <div class="fl pl47 wid_305 aligncenter">
          <div class="logo_img"><?php echo $this->Html->image('front/style_guide/blue_color.png',array('alt'=>'')); ?></div>
          <div class="clr pt20"></div>
          <div class="color_code">
				<strong><?php __('CMYK'); ?>: </strong>	<span>60, 39, 0, 0</span><br>
				<strong><?php __('Hex'); ?>:</strong> 	<span>#6390e3</span><br>
				<strong><?php __('RGB'); ?>:</strong> 	<span>99, 144, 227</span><br> 
				<strong><?php __('PMS'); ?>:</strong> 	<span>7452 C</span><br> 
          </div>
        </div>
        <div class="fr wid_305 aligncenter">
          <div class="logo_img"><?php echo $this->Html->image('front/style_guide/black_color.png',array('alt'=>'')); ?></div>
          <div class="clr pt20"></div>
          <div class="color_code">
				<strong><?php __('CMYK'); ?>: </strong>	<span>75, 68, 67, 90</span><br>
				<strong><?php __('Hex'); ?>:</strong> 	<span>#6390e3</span><br>
				<strong><?php __('RGB'); ?>:</strong> 	<span>0, 0, 0</span><br> 
				<strong><?php __('PMS'); ?>:</strong> 	<span>426 C</span><br> 
          </div>
        </div>
      </div>
      <div class="clr"></div>
    </div>
    <div class="clr pt40"></div>
    <div>
      <div class="faq">
		<span class="style_heading_2"><?php __('Style_Guide_Badges'); ?></span>
		<span class="faq_doteat"></span>
        <div class="clr pt20"></div>
      </div>
      <div class="clr pt20"></div>
	  <div class="clr pt20"></div>
      <div>
        <div class="fl wid_305 aligncenter">
          <div class="logo_img"><?php echo $this->Html->image('front/logo/Logo-colored1.png',array('alt'=>'')); ?></div>
          <div class="clr pt20"></div>
          <div class="type_img"> 
				<?php 
					echo $this->Html->link($png,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download/' . 'Logo-colored1.png'),array('class'=>'fl','escape'=>false));
				?>
				<?php echo $this->Html->link($eps,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download' , 'Logocolored.eps'),array('class'=>'fr','escape'=>false)); ?>
		  </div>
        </div>
        <div class="fl pl47 wid_305 aligncenter">
          <div class="logo_img"><?php echo $this->Html->image('front/logo/Logo-colored2.png',array('alt'=>'')); ?></div>
          <div class="clr pt20"></div>
          <div class="type_img"> 
				<?php echo $this->Html->link($png,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download' , 'Logo-colored2.png'),array('class'=>'fl','escape'=>false)); ?>
				<?php echo $this->Html->link($eps,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download' , 'Logocolored24.eps'),array('class'=>'fr','escape'=>false)); ?>
		 </div>
        </div>
        <div class="fr wid_305 aligncenter">
          <div class="logo_img"><?php echo $this->Html->image('front/logo/Logo-colored3.png',array('alt'=>'')); ?></div>
          <div class="clr pt20"></div>
          <div class="type_img"> 
				<?php echo $this->Html->link($png,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download' , 'Logo-colored3.png'),array('class'=>'fl','escape'=>false)); ?>
			
				<?php echo $this->Html->link($eps,array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'logo_download' , 'Logocolored242.eps'),array('class'=>'fr','escape'=>false)); ?>
		  </div>
        </div>
      </div>
      <div class="clr"></div>
    </div>
    <div class="clr pt40"></div>
  </div>
</div>