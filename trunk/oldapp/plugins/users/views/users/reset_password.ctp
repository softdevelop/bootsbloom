<div class="darkgreybg greybrdtop">
    <div class="blackshade pt20">
        <div class="wrapper">
            <h2 class="pageheading"><?php __('stting_passwrd'); ?></h2>
        </div>
    </div>
</div>
<div class="ptb21">
    <div class="innerwrapper">  
        <?php echo $this->Form->create($model, array('url' => array('action' => 'reset_password', $token))); ?>
        <?php if ($this->validationErrors) { ?>
            <div class="error pt10" style="width:268px;">
                <?php
                echo "<ul>";
                foreach ($this->validationErrors['User'] as $error) {
                    ?>
                    <li><?php echo $error; ?></li>
                    <?php
                }
                echo "</ul>";
                ?>
            </div>
        <?php } ?>
        <div class="grey14"><?php __('create_6_character_long_passwrd'); ?></div>
        <div class="clr pt15"></div>
        <div id="password"></div>
        <div>
            <div>
                <div class="grey14 fl"><?php __('ur_new_passwrd'); ?></div>
            </div>
            <div class="clr pt7"></div>
            <div>
                <?php echo $this->Form->password('password', array('class' => 'input-text password')); ?>
            </div>
        </div>
        <div class="clr pt15"></div>
        <div>
            <div>
                <div class="grey14 fl"><?php __('confirm_new_passwrd'); ?></div>
            </div>
            <div class="clr pt7"></div>
            <div>
                <?php echo $this->Form->password('con_password', array('class' => 'input-text password')); ?>

            </div>
        </div>
        <div class="clr pt15"></div>
        <div> <?php echo $this->Form->submit(__('update_password', true) . '!', array('class' => 'submit_but ie_radius fl')); ?>
            <div class="clr"></div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="clr"></div>
</div>