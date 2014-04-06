<li class="first">
    <h4> <?php echo $this->Html->link(__('recent_activity',true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'activity','slug'=>$this->Session->read('Auth.User.slug')), array('alt' => '', 'escape' => false,'class'=>'createdproject'));?></h4>
</li>
<?php
if (count($recentActivities) > 0) {
    foreach ($recentActivities as $recentActivity) {
        if ($recentActivity['Notification']['notification_type'] == 'follow') {
            ?>
            <li>
                <?php
                $follow_user = $this->GeneralFunctions->get_user_info($recentActivity['Notification']['subject_id'], $fields = array('User.name', 'User.profile_image', 'User.fb_image_url'));
                if(isset($friend['User']['name'])) {
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /><span class="pt10">'.$friend['User']['name'].' '.__('notification_comment_project_owner',true). '</span></div></div>';
                } else {
                    
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /></div></div>';
                }
                echo $this->Html->link($div, array('plugin' => false, 'controller' => 'notifications', 'action' => 'index'), array('alt' => '', 'escape' => false));
                //echo $this->Html->link($div, array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile','slug'=>$this->Session->read('Auth.User.slug')), array('alt' => '', 'escape' => false));
                ?>           
            </li>
            <?php
        }
        else  if ($recentActivity['Notification']['notification_type'] == 'friend_created_project') {
            
            ?>
            <li>
                <?php
                $project = $this->GeneralFunctions->get_project_info($recentActivity['Notification']['subject_id'], $fields = array('User.name','User.slug', 'User.profile_image', 'User.fb_image_url','Project.title','Project.slug','Project.image','Project.title'));
               // pr($project);
                if(isset($friend['User']['name'])) {
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /><span class="pt10">'.$friend['User']['name'].' '.__('notification_comment_project_owner',true). '</span></div></div>';
                } else {
                    
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /></div></div>';
                }
                echo $this->Html->link($div, array('plugin' => false, 'controller' => 'projects', 'action' => 'detail',$project['User']['slug'],$project['Project']['slug']), array('alt' => '', 'escape' => false));
               // echo $this->Html->link($div, array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile','slug'=>$this->Session->read('Auth.User.slug')), array('alt' => '', 'escape' => false));
                ?>           
            </li>
            <?php
       
        }
         else  if ($recentActivity['Notification']['notification_type'] == 'friend_backed_project') {
            ?>
            <li>
                <?php
                $project = $this->GeneralFunctions->get_project_info($recentActivity['Notification']['subject_id'], $fields = array('User.name','User.slug', 'User.profile_image', 'User.fb_image_url','Project.title','Project.slug','Project.image','Project.title'));
                $friend = $this->GeneralFunctions->get_user_info($recentActivity['Notification']['friend_id'], $fields = array('User.name','User.slug', 'User.profile_image'));
                
                if(isset($friend['User']['name'])) {
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /><span class="pt10">'.$friend['User']['name'].' '.__('notification_comment_project_owner',true). '</span></div></div>';
                } else {
                    
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /></div></div>';
                }
                echo $this->Html->link($div, array('plugin' => false, 'controller' => 'projects', 'action' => 'project_backers',$project['User']['slug'],$project['Project']['slug']), array('alt' => '', 'escape' => false));
               // echo $this->Html->link($div, array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile','slug'=>$this->Session->read('Auth.User.slug')), array('alt' => '', 'escape' => false));
                ?>           
            </li>
            <?php
       
        }
        else  if ($recentActivity['Notification']['notification_type'] == 'project_update_posted') {
            ?>
            <li>
                <?php
                $project = $this->GeneralFunctions->get_project_info($recentActivity['Notification']['subject_id'], $fields = array('User.name','User.slug', 'User.profile_image', 'User.fb_image_url','Project.title','Project.slug','Project.image','Project.title'));
                if(isset($friend['User']['name'])) {
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /><span class="pt10">'.$friend['User']['name'].' '.__('notification_comment_project_owner',true). '</span></div></div>';
                } else {
                    
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /></div></div>';
                }
                echo $this->Html->link($div, array('plugin' => false, 'controller' => 'projects', 'action' => 'updates',$project['User']['slug'],$project['Project']['slug']), array('alt' => '', 'escape' => false));
               // echo $this->Html->link($div, array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile','slug'=>$this->Session->read('Auth.User.slug')), array('alt' => '', 'escape' => false));
                ?>           
            </li>
            <?php
       
        }
        else  if ($recentActivity['Notification']['notification_type'] == 'backed_own_project') {
            ?>
            <li>
                <?php
                $project = $this->GeneralFunctions->get_project_info($recentActivity['Notification']['subject_id'], $fields = array('User.name','User.slug', 'User.profile_image', 'User.fb_image_url','Project.title','Project.slug','Project.image','Project.title'));
                $friend = $this->GeneralFunctions->get_user_info($recentActivity['Notification']['friend_id'], $fields = array('User.name','User.slug', 'User.profile_image'));
               if(isset($friend['User']['name'])) {
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /><span class="pt10">'.$friend['User']['name'].' '.__('notification_comment_project_owner',true). '</span></div></div>';
                } else {
                    
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /></div></div>';
                }
                echo $this->Html->link($div, array('plugin' => false, 'controller' => 'projects', 'action' => 'project_backers',$project['User']['slug'],$project['Project']['slug']), array('alt' => '', 'escape' => false));
               // echo $this->Html->link($div, array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile','slug'=>$this->Session->read('Auth.User.slug')), array('alt' => '', 'escape' => false));
                ?>           
            </li>
            <?php
       
        }
        else  if ($recentActivity['Notification']['notification_type'] == 'comment_own_project') {
            ?>
            <li>
                <?php
                $project = $this->GeneralFunctions->get_project_info($recentActivity['Notification']['subject_id'], $fields = array('User.name','User.slug', 'User.profile_image', 'User.fb_image_url','Project.title','Project.slug','Project.image','Project.title'));
                $friend = $this->GeneralFunctions->get_user_info($recentActivity['Notification']['friend_id'], $fields = array('User.name','User.slug', 'User.profile_image'));
                
                if(isset($friend['User']['name'])) {
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /><span class="pt10">'.$friend['User']['name'].' '.__('notification_comment_project_owner',true). '</span></div></div>';
                } else {
                    
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /></div></div>';
                }
                
                echo $this->Html->link($div, array('plugin' => false, 'controller' => 'projects', 'action' => 'backer_comment',$project['User']['slug'],$project['Project']['slug']), array('alt' => '', 'escape' => false));
               // echo $this->Html->link($div, array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile','slug'=>$this->Session->read('Auth.User.slug')), array('alt' => '', 'escape' => false));
                ?>           
            </li>
            <?php
       
        }
        
        else  if ($recentActivity['Notification']['notification_type'] == 'project_cancelled') {
            ?>
            <li>
                <?php
                $project = $this->GeneralFunctions->get_project_info($recentActivity['Notification']['subject_id'], $fields = array('User.name','User.slug', 'User.profile_image', 'User.fb_image_url','Project.title','Project.slug','Project.image','Project.title'));
                $friend = $this->GeneralFunctions->get_user_info($recentActivity['Notification']['friend_id'], $fields = array('User.name','User.slug', 'User.profile_image'));
                
                if(isset($friend['User']['name'])) {
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /><span class="pt10">'.$friend['User']['name'].' '.__('notification_comment_project_owner',true). '</span></div></div>';
                } else {
                    
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). ' - Backed project has been cancelled </strong><br /></div></div>';
                }
                
                echo $this->Html->link($div, array('controller' => 'projects', 'action' => 'detail', $project['User']['slug'], $project['Project']['slug']), array('alt' => '', 'escape' => false));
                
                ?>           
            </li>
            <?php
       
        }
		
        else  if ($recentActivity['Notification']['notification_type'] == 'project_successed') {
            ?>
            <li>
                <?php
                $project = $this->GeneralFunctions->get_project_info($recentActivity['Notification']['subject_id'], $fields = array('User.name','User.slug', 'User.profile_image', 'User.fb_image_url','Project.title','Project.slug','Project.image','Project.title'));
                $friend = $this->GeneralFunctions->get_user_info($recentActivity['Notification']['friend_id'], $fields = array('User.name','User.slug', 'User.profile_image'));
                
                if(isset($friend['User']['name'])) {
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /><span class="pt10">'.$friend['User']['name'].' '.__('notification_comment_project_owner',true). '</span></div></div>';
                } else {
                    
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). ' project successfully funded </strong><br /></div></div>';
                }
                
                echo $this->Html->link($div, array('controller' => 'projects', 'action' => 'profile', $project['User']['slug'], $project['Project']['slug']), array('alt' => '', 'escape' => false));
                
                ?>           
            </li>
            <?php
       
        }
		
        else  if ($recentActivity['Notification']['notification_type'] == 'project_unsuccessed') {
            ?>
            <li>
                <?php
                $project = $this->GeneralFunctions->get_project_info($recentActivity['Notification']['subject_id'], $fields = array('User.name','User.slug', 'User.profile_image', 'User.fb_image_url','Project.title','Project.slug','Project.image','Project.title'));
                $friend = $this->GeneralFunctions->get_user_info($recentActivity['Notification']['friend_id'], $fields = array('User.name','User.slug', 'User.profile_image'));
                
                if(isset($friend['User']['name'])) {
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /><span class="pt10">'.$friend['User']['name'].' '.__('notification_comment_project_owner',true). '</span></div></div>';
                } else {
                    
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). ' project not successfully funded </strong><br /></div></div>';
                }
                
                echo $this->Html->link($div, array('controller' => 'projects', 'action' => 'detail', $project['User']['slug'], $project['Project']['slug']), array('alt' => '', 'escape' => false));
                
                ?>           
            </li>
            <?php
       
        }
		
        else  if ($recentActivity['Notification']['notification_type'] == 'project_reward_survey') {
            ?>
            <li>
                <?php
                $project = $this->GeneralFunctions->get_project_info($recentActivity['Notification']['subject_id'], $fields = array('User.name','User.slug', 'User.profile_image', 'User.fb_image_url','Project.title','Project.slug','Project.image','Project.title'));
                $friend = $this->GeneralFunctions->get_user_info($recentActivity['Notification']['friend_id'], $fields = array('User.name','User.slug', 'User.profile_image'));
                
                if(isset($friend['User']['name'])) {
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /><span class="pt10">'.$friend['User']['name'].' '.__('notification_comment_project_owner',true). '</span></div></div>';
                } else {
                    
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>'.$project['User']['name'] ."(". ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). ' ) sent to you an email </strong><br /></div></div>';
                }
                
                echo $this->Html->link($div, array('controller' => 'projects', 'action' => 'detail', $project['User']['slug'], $project['Project']['slug']), array('alt' => '', 'escape' => false));
                
                ?>           
            </li>
            <?php
        }
		
        else  if ($recentActivity['Notification']['notification_type'] == 'project_ending_soon') {
            ?>
            <li>
                <?php
                $project = $this->GeneralFunctions->get_project_info($recentActivity['Notification']['subject_id'], $fields = array('User.name','User.slug', 'User.profile_image', 'User.fb_image_url','Project.title','Project.slug','Project.image','Project.title'));
                $friend = $this->GeneralFunctions->get_user_info($recentActivity['Notification']['friend_id'], $fields = array('User.name','User.slug', 'User.profile_image'));
                
                if(isset($friend['User']['name'])) {
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>' . ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). '</strong><br /><span class="pt10">'.$friend['User']['name'].' '.__('notification_comment_project_owner',true). '</span></div></div>';
                } else {
                    
                    $div = '<div><div class="fl">' . $this->Html->image($this->GeneralFunctions->show_project_image($project['Project']['image'],'40px','40px'), array('height' => 40, 'width' => 40, 'escape' => false)) . '</div><div class="fl pl5"><strong>'. ucfirst($text->truncate( $project['Project']['title'], 40, array('ending' => '...', 'exact' => false, 'html' => true))). ' will ends in just 48 hours. </strong><br /></div></div>';
                }
                
                echo $this->Html->link($div, array('controller' => 'projects', 'action' => 'detail', $project['User']['slug'], $project['Project']['slug']), array('alt' => '', 'escape' => false));
                
                ?>           
            </li>
            <?php
       
        }
		
		
    }
} else {
    ?>
    <li><?php __('frnt_notification_empty'); ?></li>
<?php } ?>
<li class="last"> <?php echo $this->Html->link(__('View_activity', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'activity','slug'=>$this->Session->read('Auth.User.slug')), array('class' => 'button-neutral')); ?></li>
