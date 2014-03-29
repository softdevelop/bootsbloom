<html>
<head>
	<title><?php echo $project_detail['Project']['title']; ?></title>
	
<?php
	echo $this->Html->css(array('front/widget.css'));
?>

</head>
<body>
	<div class="fl mr8">
		<div>
			<div class="sprite listingbxtl"></div>
			<div class="listingbxt"></div>
			<div class="sprite listingbxtr"></div>
			<div class="clr"></div>
		</div>
		<div class="listingbxmid">
			<div class="pb14">
				<?php
				$project_img = $this->GeneralFunctions->get_project_image($project_detail['Project']['id'], '150px', '200px');
				echo $this->Html->link($this->Html->image($project_img, array('width' => '200', 'height' => '150')), array('controller' => 'projects', 'action' => 'detail', $project_detail['User']['slug'], $project_detail['Project']['slug']),array('title'=>$project_detail['Project']['title'],'escape'=>false));
				?>
			</div>
			<div class="grey13 overflow">
				<span class="blue14 block pb9">
					<?php echo $this->Html->link(ucfirst($text->truncate($project_detail['Project']['title'],30,array('ending' => '...', 'exact' => false, 'html' => true))), array('controller' => 'projects', 'action' => 'detail', $project_detail['User']['slug'], $project_detail['Project']['slug']),array('title'=>$project_detail['Project']['title'])); ?>
				</span>
				<span class="block pb17">
					<?php __('frnt_by'); ?> <?php echo $project_detail['User']['name']; ?>
				</span>
				<?php echo ucfirst(substr($project_detail['Project']['short_description'], 0, 200)); ?>

			</div>
			<div class="clr"></div>
			<div class="grey13">
				<div class="fl ml15 mt10 iconlink"> 
					<?php
					$project_city_info = $this->GeneralFunctions->get_json_to_city_name($project_detail['Project']['project_city_json']);
					echo $this->Html->link($project_city_info['city_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'city', $project_city_info['id']), array('class' => 'locationicon block'));
					?>
				</div>
			</div>
			<div class="mt29 pb10">
				<?php
				$total_pledge_amount = $this->GeneralFunctions->get_total_pledge_amount($project_detail['Backer']);
				$total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($project_detail['Project']['id'], $project_detail['Project']['funding_goal'], $project_detail['Backer']);
				if ($total_funded_percentage > 100) {
					$total_funded_slider_percentage = 100;
				} else {
					$total_funded_slider_percentage = $total_funded_percentage;
				}
				?>
				<?php if (($project_detail['Project']['project_end_date'] < time()) && ($total_pledge_amount >= $project_detail['Project']['funding_goal'])) { ?>
					<!-- Success Bar -->
					<div class="greenbg">
						<div class="white_dark">
							<span style="height: 5px; padding-left:78px;"><?php __('cont_successful'); ?>&nbsp;!</span> 
						</div>
					</div>
					<!-- End Success Bar -->
					<?php
				}
				// for unsuccessful projects 
				if (($project_detail['Project']['project_end_date'] < time()) && ($total_pledge_amount < $project_detail['Project']['funding_goal'])) {
					?>
					<div class="yellow_unsuccess_bg">
						<div class="white_dark ">
							<span style="height: 5px; padding-left:78px;" ><?php __('cont_funding_unsuccessful'); ?>&nbsp;!</span> 

						</div>
					</div>
				<?php
				}
				// for running projects
				if ($project_detail['Project']['project_end_date'] > time()) {
					?>                         
					<!-- Slider Bar -->
					<div class="" >
						<div class="project-pledged-wrap">
							<div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
						</div>
					</div>
						<?php } ?>
				<div class="grey13 pt23">
					<div class="fl pr7"><strong><?php echo $total_funded_percentage; ?> %</strong> <br>
						<?php __('frnt_funded'); ?></div>
					<div class="fl pl7 pr7"><strong><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $total_pledge_amount; ?></strong> <br>
						<?php __('frnt_pledged'); ?></div>
					<div class="fl pl7">
						<?php $time_rem = $this->GeneralFunctions->show_left_time(time(), $project_detail['Project']['project_end_date']); ?>
						<strong><?php echo $time_rem['time']; ?></strong> <br />
						<?php echo sprintf(__('frnt_daystogo', true), $time_rem['unit']); ?>
					</div>
					<div class="clr"></div>
				</div>
			</div>
		</div>
		<div>
			<div class="sprite listingbxbl"></div>
			<div class="listingbxb"></div>
			<div class="sprite listingbxbr"></div>
			<div class="clr"></div>
		</div>
	</div>
</body>
</html>