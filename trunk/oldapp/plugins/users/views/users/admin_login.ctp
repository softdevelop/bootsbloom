<?php echo $this->Form->create($model, array('action' => 'login', 'class' => 'form-horizontal')); ?>
<div class="auth-form"><div class="loginhbg">Please Login</div>
    <div class="lboxpad">
        <?php echo $this->Session->flash(); ?>
        <div class="infomsg martop_3px"  style="display:none;">
            <div class="floatleft padright_10px"><?php echo $this->Html->image("admin/info_icon.gif", array("alt" => "", "width" => "14", "height" => "15")); ?></div>
            <div class="floatleft">An informative message goes here</div>
            <div class="floatright"><?php echo $this->Html->image("admin/close_info.gif", array("alt" => "", "width" => "16", "height" => "16")); ?></div>
            <div class="clear"></div>
            <div class="infotl"></div>
            <div class="infotr"></div>
            <div class="infobl"></div>
            <div class="infobr"></div>
        </div>
        <div class="padtop_10px dgray12"><strong><?php echo $form->label('email', __d('users', 'Email', true), array('class' => "control-label")); ?></strong></div>
        <div><?php echo $this->Html->image("admin/dot.gif", array("alt" => "", "width" => "1", "height" => "5")); ?></div>
        <div><div class="floatleft"><?php echo $this->Html->image("admin/inleft.gif", array("alt" => "", "width" => "3", "height" => "33")); ?></div>
            <div class="inbg"><?php echo $form->text('email', array("class" => "inbox298")); ?></div>
            <div class="floatleft"><?php echo $this->Html->image("admin/inright.gif", array("alt" => "", "width" => "3", "height" => "33")); ?></div>
            <div class="clear"></div>
        </div>
        <div class="padtop_10px dgray12"><strong><?php echo $form->label('passwd', __d('users', 'Password', true), array('class' => "control-label")); ?></strong></div>
        <div><?php echo $this->Html->image("admin/dot.gif", array("alt" => "", "width" => "1", "height" => "5")); ?></div>
        <div><div class="floatleft"><?php echo $this->Html->image("admin/inleft.gif", array("alt" => "", "width" => "3", "height" => "33")); ?></div>
            <div class="inbg"><?php echo $form->password('passwd', array("class" => "inbox298")); ?></div>
            <div class="floatleft"><?php echo $this->Html->image("admin/inright.gif", array("alt" => "", "width" => "3", "height" => "33")); ?></div>
            <div class="clear"></div>
        </div>
        <div class="padtop_15px">
            <div class="floatleft padtop_6px padright_5px"><input type="checkbox" name="data[User][remember_me]" value="1"/></div>
            <div class="floatleft padtop_6px">Remember Me</div>
            <div class="floatright"><span><input type="submit" class="login_lnk" value="Login"/></span> 
            </div>
            <div class="clear"></div>
        </div>
        <div class="forgot_password"><?php echo $this->Html->link('Forgot password', array('plugin' => 'users', 'controller' => 'users', 'action' => 'recover_password')); ?></div>
    </div>
    <div class="loginhl"></div>
    <div class="loginhr"></div>
    <div class="rpbl"></div>
    <div class="rpbr"></div>
</div>
<?php echo $form->end();?>