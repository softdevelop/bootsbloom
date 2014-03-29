<?php 
//
// This source code was recovered by Recover-PHP.com
//


class NotificationsController extends AppController
{
    public $name = "Notifications";

    public function getrecent_notifications()
    {
        $user_id = $this->Session->read("Auth.User.id");
        $this->layout = false;
        $this->loadModel("UserActivity");
        $user = $this->Session->read("Auth.User");
        $this->Notification->updateAll(array( "Notification.is_read" => 1 ), array( "Notification.user_id" => $user["id"] ));
        $recentActivities = $this->Notification->find("all", array( "limit" => 10, "order" => "Notification.id DESC", "conditions" => array( "Notification.user_id" => $user["id"] ) ));
        $this->set("recentActivities", $recentActivities);
    }

    public function index()
    {
        $user = $this->Session->read("Auth.User");
        $recentActivities = $this->Notification->find("all", array( "limit" => 10, "order" => "Notification.id DESC", "conditions" => array( "Notification.user_id" => $user["id"] ) ));
        $this->set("recentActivities", $recentActivities);
    }

}




?>