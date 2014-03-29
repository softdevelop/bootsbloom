<div class="graphTop">
<?php
	if(count($chartData) > 0){
		//pie chart
		echo $flashChart->begin(); 
		$flashChart->setData($chartData);
		echo $flashChart->setToolTip('#label#<br>#val# (#percent#) of #total#',array('colour'=>'#EEEEEE','background_colour'=>'#FFFFFF','stroke'=>5,'title_style'=>'color:#55A4F2;font-size:12px;font-weight:bold;'));
		echo $flashChart->setBgColour('#FAFAFA');
		echo $flashChart->chart('pie',array('gradient_fill'=>true,'radius'=>90,'no_labels'=>true,'start_angle'=>45));
		echo $flashChart->render(181,181); 
	}	
?>
</div>