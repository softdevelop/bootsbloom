<li class="first">
    <h4><?php __('inbox'); ?></h4>
</li>
<?php
//pr($recentMessages);
if (count($recentMessages) > 0) {
    foreach ($recentMessages as $message) {
        ?>
        <li>
            <?php
			$user_info = $this->GeneralFunctions->get_user_info($message['sender']['id'], $fields = array('User.name', 'User.profile_image', 'User.fb_image_url'));
			
			$div = '<div><div class="fl">' . $this->Html->image($user_info['User']['profile_image_url'], array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' .$user_info['User']['name'] .'<br/>'.$this->Text->truncate($message['message']['message'], 40, array('ending' => '...', 'exact' => false, 'html' => true)).'</strong></div></div>';
			
			echo $this->Html->link($div, array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index'), array('alt' => '', 'escape' => false));
			
           //echo $this->Html->link($this->Text->truncate($message['message']['message'], 55, array('ending' => '...', 'exact' => false, 'html' => true)), array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index', $message['sender']['slug'], $message['project']['slug']), array('alt' => ''));
            ?>           
        </li>
        <?php
    }
} else {
    ?>
    <li><?php __('frnt_messages_empty'); ?></li>
<?php } ?>
<li class="last">
    <?php echo $this->Html->link(__('View_messages', true), array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index'), array('class' => 'button-neutral')); ?>
</li>
