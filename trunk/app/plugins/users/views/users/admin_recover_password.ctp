<?php echo $this->Form->create($model, array('action' => 'recover_password', 'class' => 'form-horizontal')); ?>
<div class="auth-form">
    <div class="loginhbg">Please Enter Email Address</div>
    <div class="lboxpad">
        <?php echo $this->Session->flash(); ?>	
        <div class="padtop_10px dgray12"><strong><?php echo $form->label('useremail', __d('users', 'User Email', true), array('class' => "control-label")); ?></strong></div>
        <div>
            <?php echo $this->Html->image("admin/dot.gif", array("alt" => "", "width" => "1", "height" => "5")); ?>
        </div>
        <div>
            <div class="floatleft">
                <?php echo $this->Html->image("admin/inleft.gif", array("alt" => "", "width" => "3", "height" => "33")); ?>
            </div>
            <div class="inbg">
                <?php echo $form->text('email', array("class" => "inbox298")); ?>
            </div>
            <div class="floatleft">
                <?php echo $this->Html->image("admin/inright.gif", array("alt" => "", "width" => "3", "height" => "33")); ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="padtop_15px">
            <span class="floatleft">
                <?php echo $form->submit('Submit', array('border' => '0', 'class' => 'login_lnk')); ?>
            </span>
            <span class="floatleft padding_left_20"><?php echo $html->link('Cancel', array('action' => 'admin_login'), array('escape' => false, 'class' => 'cancel_lnk')); ?></span>				   
            <div class="clear"></div>
        </div>
    </div>
    <div class="loginhl"></div>
    <div class="loginhr"></div>
    <div class="rpbl"></div>
    <div class="rpbr"></div>
</div>
<?php echo $form->end();?>
