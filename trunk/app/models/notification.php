<?php 
//
// This source code was recovered by Recover-PHP.com
//


class Notification extends AppModel
{
    public $name = "Notification";
    
    /**
     * using a notification
     * 
     */
    public function create_noti($user_id, $notification_type = '', $subject_id, $subject_type = 'project', $friend_id = 0)
    {
        $this->set(array(
            'user_id' => $user_id,
            'notification_type' => $notification_type,
            'subject_id' => $subject_id,
            'subject_type' => $subject_type,
            'friend_id' => $friend_id,
            'is_read' => 0,
            'created' => time(),
        ));
        $this->save();
    }
}
