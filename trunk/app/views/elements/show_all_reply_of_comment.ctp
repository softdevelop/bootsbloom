<?php 
foreach ($all_reply as $backer_comment) {  ?>
			<div class="clr"></div>
			<div class="pt10">
			  <div class="qa_left column">
				<?php /*                 * ***** profile image ******** */ 
                $userId =   $backer_comment['ProjectCommentThread']['user_id'];
                
                ?>
                <?php $user_image_url = $this->GeneralFunctions->get_user_profile_image($userId,'75px','100px');
                echo $this->Html->image($user_image_url, array('width' => '100', 'height' => '75')); ?>
                          </div>
			<div class="qa_right column">
				<div class="grey16 width491">
				<?php
				echo $this->Html->link(ucfirst($backer_comment['User']['name']),array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile','slug'=>$backer_comment['User']['slug']),array('class'=>'bold')); ?>
				<span class="pl10">
                                <?php  echo date('F, d Y , H : i: s ',$backer_comment['ProjectCommentThread']['created']); 
				?></span>
				</div>
				<div class="grey14 lh20 pt10 word-wrap width485"><?php echo ucfirst($backer_comment['ProjectCommentThread']['message']); ?></div> 
				
				
			</div>
			</div>
			<div class="clr pt10"></div>
			<div class="dot_border"></div>
			<div class="clr pt10"></div>
			<div id="<?php echo $backer_comment['ProjectCommentThread']['id']; ?>" ></div>
	<?php } ?>