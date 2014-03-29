<div class="backed fl">
    <div class="fl wid_150">
        <h2><?php echo $this->Html->link(__('backed', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'backed_projects', 'slug' => $this->params['slug']), array('style' => 'color:#43A9FE; text-decoration:none')); ?> (<?php echo $total_backed_project; ?>)
        </h2>
    </div>
    <?php if ($this->Session->read('Auth.User.id') == $this->data['User']['id']) {  ?>
        <div class="fl wid_150">
            <h2><?php echo $this->Html->link(__('created', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'created_projects', 'slug' => $this->params['slug']), array('style' => 'color:#43A9FE; text-decoration:none')); ?> (<?php echo $this->GeneralFunctions->get_user_created_projects($this->data['User']['id']); ?>)
            </h2>
        </div>
    <?php }else{ ?>
     <div class="fl user_launched">
            <h2><?php echo $this->Html->link(__('launched', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'created_projects', 'slug' => $this->params['slug']), array('style' => 'color:#43A9FE; text-decoration:none')); ?> (<?php echo $this->GeneralFunctions->get_user_launched_projects($this->data['User']['id']); ?>)
            </h2>
        </div>
        
    <?php } ?>
	
    <div class="fl wid_250">
        <h2><?php echo $this->Html->link(__('Comments', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'user_comments', 'slug' => $this->params['slug']), array('style' => 'color:#43A9FE; text-decoration:none')); ?> (<?php echo $this->GeneralFunctions->get_usertotal_comments($this->data['User']['id']); ?>)
        </h2>
    </div>
</div>