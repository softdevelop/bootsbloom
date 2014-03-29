<div class="signin">
    <?php echo $this->Form->create('User', array('url' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'))); ?>
    <div class="heading_23 grey14"><?php __('sign_in'); ?> <?php __('OR'); ?> <span class=""><?php echo $this->Html->link(__('sign_me_up', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'signup')); ?></span></div>
    <div class="clr pt10"></div>
    <div class="grey13"><?php __('sign_in_to_continue') ?>.</div>

    <div class="clr pt20"></div>
    <?php if ($this->Session->check('Message.flash')) { ?>
        <div class="error pt10">
            <?php
            echo "<ul>";
            ?>
            <li><?php echo $this->Session->flash(); ?></li>
            <?php
            echo "</ul>";
            ?>
        </div>
    <?php } ?>
    <div>
        <div class="grey14 fl"><?php __('email'); ?></div>
        <div class="clr pt7"></div>
        <div>
            <?php echo $this->Form->input('login_email', array('class' => 'input-text', 'id' => 'login_email', 'tabindex' => 1, 'label' => false, 'error' => FALSE)); ?>
        </div>
    </div>
    <div class="clr pt20"></div>

    <div>
        <div>
            <div class="grey14 fl"><?php __('password'); ?></div>
            <div class="blue11 fr">
            </div>
        </div>
        <div class="clr pt7"></div>
        <div>

            <?php echo $this->Form->password('login_password', array('class' => 'input-text password', 'id' => 'login_password', 'tabindex' => 2, 'label' => false, 'error' => FALSE)); ?>
        </div>
    </div>
    <div class="clr pt15"></div>
    <div>
        <div class="fl">
            <?php echo $this->Form->checkbox('remember_me', array('label' => false, 'value' => 1, 'div' => false)); ?>

        </div>
        <div class="fl grey13 pl10"><?php __('remember_me'); ?></div>
    </div>
    <div class="clr pt15"></div>
    <div>  <?php echo $this->Form->submit(__('sign_me_in', true) . '!', array('class' => 'button ie_radius')); ?>
        <div class="clr"></div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<!-- Facebook Connect -->
<div class="signin ml75">
    <div class="heading_23"><?php __('sign_in_facebook') ?></div>
    <div class="clr pt10"></div>
    <div class="grey13"><?php __('its_fast_easy') ?><?php __('its_fast_easy'); ?></div>
    <div class="clr pt20"></div>
    <div class="grey11 width217 alignleft">
        <span class="fl">
            <a href="#" onclick="facebook_login()" >
<?php
                echo $this->Html->image('front/f_icon.png', array('height' => 36, 'width' => 36));
?>
            </a>
        </span>
        <span class="pt10 f14 alignleft">&nbsp;
            <?php __('front_connect_with_facebook'); ?>	
        </span>
    </div>
    <div class="clr pt20"></div>
    <div class="grey13 "><?php __('we_never_post') ?></div>
</div>
<div class="clr"></div>
