<div class="grey_gradient">
    <div class="pt20">
        <div class="wrapper">
            <h2 class="pageheading">
                <?php echo __('inbox'); ?>
            </h2>
        </div>
    </div>
</div>
<div class="ptb21">
    <div class="innerwrapper">
        <div class="fl">
            <div class="massage_h">
                <div class="fl name"><strong><?php __('cont_sender_name'); ?></strong></div>
                <div class="fl"><strong><?php __('message_message_tile'); ?></strong></div>
                <div class="fr replies"><strong><?php __('message_replies'); ?></strong></div>

            </div>
            <script type="text/javascript">
                $(function(){
                    $('.clickable').click(function(){
                        $(location).attr('href',$(this).find("#threadview").attr('href'));
                    });
                });
            </script>
            <?php
            if (count($inboxMessages) > 0) {
				//pr($inboxMessages);
                foreach ($inboxMessages as $message) {
                    ?>
                    <div class="user_d fl">
                        <div class="name fl">
                            <?php
                            $user_image_url = $this->GeneralFunctions->get_user_profile_image($message['sender']['id'], '20px', '20px');
                            echo $this->Html->image($user_image_url, array('width' => '20', 'height' => '20'));
                            ?>

                            <p><span class="blue14"><?php echo $this->Html->link(ucwords($message['sender']['user_name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $message['sender']['slug'])); ?></span><br>
                                <span><?php echo date('M, d Y h:i a', $message['message']['created']); ?></span></p></div>
                        <div class="clickable">
                            <div class="fl"><?php echo $message['project']['title']; ?><br>
                                <p><span><?php echo substr($message['message']['message'], 0, 80) . '...'; ?> </span></p></div>
                            <div class="fr replies">
                                <div class="numd"><?php if($message[0]['replies']==1){echo '0';}else{ echo $message[0]['replies']; }?></div>
                            </div>
							<?php echo $this->Html->link(__('message_read_more', true) . '...', array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index', $message['sender']['slug'], $message['project']['slug']), array('alt' => '', 'style' => 'display:none;', 'id' => 'threadview')); ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="user_d aligncenter"><?php __('message_no_message_found'); ?></div>
                <?php
            }
            ?>
        </div>
        <div class="clr"></div>
    </div>
</div>
