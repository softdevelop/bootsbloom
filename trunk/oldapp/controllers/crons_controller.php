<?php 
//
// This source code was recovered by Recover-PHP.com
//


class CronsController extends AppController
{
    public $name = "Crons";
    public $uses = array( "Project", "Pages.Page", "Users.User", "Categories.Category", "Reward", "Country", "StaredProject", "Backer", "PaymentLog", "ProjectComment", "ProjectUpdate", "ProjectAskedQuestions", "Emaillog", "UserActivity", "Rewards", "ProjectTransaction", "UserFollow" );
    public $layout = false;
    public $autoRender = false;

    public function beforeFilter()
    {
        parent::beforefilter();
        $this->set("model", $this->modelClass);
        if( !Configure::read("App.defaultEmail") ) 
        {
            Configure::write("App.defaultEmail", Configure::read("noreply_email.email"));
        }

        if( !isset($this->params["prefix"]) ) 
        {
            $this->Auth->allow("*");
        }

    }

    public function send_newsletter()
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $this->loadModel("SendEmailBackup");
        $newsletters = $this->SendEmailBackup->find("all", array( "conditions" => array(  ), "limit" => 10 ));
        if( $newsletters ) 
        {
            foreach( $newsletters as $newsletter ) 
            {
                $from = $newsletter["SendEmailBackup"]["email_from"];
                $to = $newsletter["SendEmailBackup"]["email_to"];
                $subject = $newsletter["SendEmailBackup"]["subject"];
                $this->set("message", $newsletter["SendEmailBackup"]["message"]);
                $this->set("newsletter_info", $newsletter);
                $element = "newsletter";
                $this->_sendMail($to, $from, $replyTo = "", $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
                $this->Email->reset();
                $this->SendEmailBackup->id = $newsletter["SendEmailBackup"]["id"];
                $this->SendEmailBackup->delete();
            }
        }

        $this->loadModel("ProjectSurvey");
        $this->loadModel("Backer");
        $project_surveys = $this->ProjectSurvey->find("all", array( "conditions" => array( "ProjectSurvey.flag" => "0" ), "limit" => 5 ));
        $oneTimeLimit = 50;
        if( 0 < count($project_surveys) ) 
        {
            foreach( $project_surveys as $survey ) 
            {
                if( 0 < $survey["ProjectSurvey"]["backers_count"] ) 
                {
                    $conditions = array( "Backer.project_id" => $survey["ProjectSurvey"]["project_id"] );
                    $start_index = $oneTimeLimit * $survey["ProjectSurvey"]["current_cron_index"];
                    if( 0 < $survey["ProjectSurvey"]["reward_id"] ) 
                    {
                        $conditions["Backer.reward_id"] = $survey["ProjectSurvey"]["reward_id"];
                    }

                    $this->Backer->recursive = 0;
                    $backersList = $this->Backer->find("all", array( "conditions" => $conditions, "limit" => $start_index . "," . $oneTimeLimit ));
                    if( !empty($backersList) ) 
                    {
                        foreach( $backersList as $backerData ) 
                        {
                            $this->SendEmailBackup->create();
                            $emailData["email_to"] = $backerData["User"]["email"];
                            $emailData["email_from"] = $survey["User"]["email"];
                            $emailData["subject"] = $survey["ProjectSurvey"]["survey_subject"];
                            $emailData["message"] = $survey["ProjectSurvey"]["survey_message"];
                            $emailData["date"] = time();
                            $this->SendEmailBackup->save($emailData, false);
                        }
                    }

                    $surveyData["ProjectSurvey"]["id"] = $survey["ProjectSurvey"]["id"];
                    if( $oneTimeLimit < $survey["ProjectSurvey"]["backers_count"] ) 
                    {
                        $surveyData["ProjectSurvey"]["backers_count"] = $survey["ProjectSurvey"]["backers_count"] - $oneTimeLimit;
                    }
                    else
                    {
                        $surveyData["ProjectSurvey"]["backers_count"] = 0;
                        $surveyData["ProjectSurvey"]["flag"] = 1;
                    }

                    $surveyData["ProjectSurvey"]["current_cron_index"] = $survey["ProjectSurvey"]["current_cron_index"] + 1;
                    $this->ProjectSurvey->save($surveyData, false);
                }

            }
        }

    }

    public function reauthorize_payment_token()
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $find_backers_to_reauth = $this->Backer->find("all", array( "conditions" => array( "Backer.payment_status='authorized'", "Backer.is_cancelled" => 0 ), "fields" => array( "Backer.id", "Backer.transaction_id", "Backer.created", "Backer.amount" ), "order" => "Backer.created asc" ));
        foreach( $find_backers_to_reauth as $backer ) 
        {
            $purchase_date = $backer["Backer"]["created"];
            $todate = time();
            $purchase_days = ($todate - $purchase_date) / 86400;
            if( 3 < $purchase_days ) 
            {
                $paymentInfo["transaction_id"] = $backer["Backer"]["transaction_id"];
                $paymentInfo["amount"] = $backer["Backer"]["amount"];
                $paymentInfo["currency"] = $backer["Backer"]["currency"];
                $result = $this->Paypal->processPayment($paymentInfo, "DoReauthorization");
                $ack = strtoupper($result["ACK"]);
                if( $ack == "SUCCESS" ) 
                {
                    $update_auth = array(  );
                    $update_auth["Backer"]["id"] = $backer["Backer"]["id"];
                    $update_auth["Backer"]["payment_status"] = "reauthorize";
                    $update_auth["Backer"]["reauthorize_date"] = time();
                    $this->Backer->save($update_auth);
                    $this->Backer->create();
                }
                else
                {
                    $update_auth = array(  );
                    $update_auth["Backer"]["id"] = $backer["Backer"]["id"];
                    $update_auth["Backer"]["payment_status"] = "reauthorize_error";
                    $this->Backer->save($update_auth);
                    $this->Backer->create();
                }

            }

        }
    }

    public function process_payment_by_project()
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $today = time();
        App::import("Helper", "GeneralFunctions");
        $generalHelperObj = new GeneralFunctionsHelper();
        $find_completed_projects = $this->Project->find("first", array( "conditions" => array( "Project.project_end_date <" => $today, "Project.is_cancelled" => 0, "Project.is_payment_processed" => 0, "Project.submitted_status" => 1, "Project.active" => 1 ) ));
        if( $find_completed_projects ) 
        {
            if( 0 < count($find_completed_projects["Backer"]) ) 
            {
                $total_pleadge = $this->CommonFunction->get_total_pledge_amount($find_completed_projects["Backer"]);
                $funding_goal = $find_completed_projects["Project"]["funding_goal"];
                if( $funding_goal <= $total_pleadge ) 
                {
                    $backers = $find_completed_projects["Backer"];
                    $backer_list = array(  );
                    foreach( $backers as $backer ) 
                    {
                        $backerInfo = $generalHelperObj->get_user_info($backer["user_id"]);
                        $paymentInfo = array(  );
                        $backer_list[] = array( "name" => $backerInfo["User"]["name"], "email" => $backerInfo["User"]["email"] );
                        $paymentInfo["authorization_id"] = $backer["transaction_id"];
                        $paymentInfo["amount"] = $backer["amount"];
                        $paymentInfo["CompleteCodeType"] = "Complete";
                        $paymentInfo["currency"] = $backer["currency"];
                        $do_capture_result = $this->Paypal->processPayment($paymentInfo, "DoCapture");
                        $ack_do_capture = strtoupper($do_capture_result["ACK"]);
                        if( $ack_do_capture != "SUCCESS" ) 
                        {
                            $this->Backer->id = $backer["id"];
                            $update_backer_payment_status = array(  );
                            $update_backer_payment_status["Backer"]["id"] = $backer["id"];
                            $update_backer_payment_status["Backer"]["payment_status"] = "capture_failed";
                            $update_backer_payment_status["Backer"]["capture_date"] = time();
                            $update_backer_payment_status["Backer"]["captured_status"] = $do_capture_result["L_LONGMESSAGE0"];
                            $this->Backer->save($update_backer_payment_status);
                            $this->Backer->create();
                            $paymentlog["PaymentLog"]["backer_id"] = $backer["id"];
                            $paymentlog["PaymentLog"]["user_id"] = $backer["id"];
                            $paymentlog["PaymentLog"]["project_id"] = $find_completed_projects["Project"]["id"];
                            $paymentlog["PaymentLog"]["payment_log_message"] = "capture_failure";
                            $this->PaymentLog->save($paymentlog);
                            $this->PaymentLog->create();
                            $to = $backerInfo["User"]["email"];
                            $subject = "Payment captured for transaction " . $backer["transaction_id"];
                            $body = "Payment not  captured regarding transaction id " . $backer["transaction_id"] . " for project id" . $find_completed_projects["Project"]["id"] . " due to error " . $do_capture_result["L_LONGMESSAGE0"];
                            $this->set("body", $body);
                            $element = "send_capture_and_transaction";
                            $replyTo = "";
                            $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                            $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
                        }
                        else
                        {
                            $this->Backer->id = $backer["id"];
                            $update_backer_payment_status = array(  );
                            $update_backer_payment_status["Backer"]["id"] = $backer["id"];
                            $update_backer_payment_status["Backer"]["payment_status"] = "captured";
                            $update_backer_payment_status["Backer"]["capture_date"] = time();
                            $update_backer_payment_status["Backer"]["captured_status"] = $do_capture_result["L_LONGMESSAGE0"];
                            $this->Backer->save($update_backer_payment_status);
                            $this->Backer->create();
                            $paymentlog["PaymentLog"]["backer_id"] = $backer["id"];
                            $paymentlog["PaymentLog"]["user_id"] = $backer["id"];
                            $paymentlog["PaymentLog"]["project_id"] = $find_completed_projects["Project"]["id"];
                            $paymentlog["PaymentLog"]["payment_log_message"] = "captured";
                            $this->PaymentLog->save($paymentlog);
                            $this->PaymentLog->create();
                            $to = $backerInfo["User"]["email"];
                            $subject = "Payment captured for transaction " . $backer["transaction_id"];
                            $body = "Dear " . $backerInfo["User"]["name"] . "<br />";
                            $body .= "Project " . $find_completed_projects["Project"]["title"] . " has been funded successfully and we have captured payment regarding transaction id " . $backer["transaction_id"] . " for project " . $find_completed_projects["Project"]["title"];
                            $this->set("body", $body);
                            $element = "send_capture_and_transaction";
                            $replyTo = "";
                            $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                            $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
                        }

                    }
                    $to = $find_completed_projects["User"]["email"];
                    $subject = "Backers List for project " . $find_completed_projects["Project"]["title"];
                    $this->set("backer_list", $backer_list);
                    $this->set("project_info", $find_completed_projects);
                    $element = "send_backers_email_list";
                    $replyTo = "";
                    $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                    $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
                    $this->Project->id = $find_completed_projects["Project"]["id"];
                    $update_project = array(  );
                    $update_project["Project"]["id"] = $find_completed_projects["Project"]["id"];
                    $update_project["Project"]["is_payment_processed"] = 1;
                    $update_project["Project"]["is_successful"] = 1;
                    $update_project["Project"]["project_success_date"] = time();
                    $this->Project->save($update_project);
                    $payment_transaction = array(  );
                    if( is_null($find_completed_projects["Project"]["admin_commission"]) ) 
                    {
                        if( is_null(Configure::read("CONFIG_PER_PROJECT_ADMIN_COMMISSION")) ) 
                        {
                            $admin_commission = 0;
                        }
                        else
                        {
                            $admin_commission = Configure::read("CONFIG_PER_PROJECT_ADMIN_COMMISSION");
                        }

                    }
                    else
                    {
                        $admin_commission = $find_completed_projects["Project"]["admin_commission"];
                    }

                    $paypal_commission = Configure::read("CONFIG_PAYPAL_COMMISSION");
                    if( empty($paypal_commission) ) 
                    {
                        $paypal_commission = 0;
                    }

                    $result = $this->CommonFunction->calculate_amount_for_project_owner($total_pleadge, $admin_commission, $paypal_commission);
                    $payment_transaction["ProjectTransaction"] = $result;
                    $payment_transaction["ProjectTransaction"]["project_id"] = $find_completed_projects["Project"]["id"];
                    $payment_transaction["ProjectTransaction"]["pledge_amount"] = $total_pleadge;
                    $this->ProjectTransaction->save($payment_transaction);
                    $this->Project->create();
                    return NULL;
                }

                $backers = $find_completed_projects["Backer"];
                foreach( $backers as $backer ) 
                {
                    $backerInfo = $generalHelperObj->get_user_info($backer["user_id"]);
                    if( $backer["payment_status"] == "reauthorize" || $backer["payment_status"] == "authorized" ) 
                    {
                        $paymentInfo["token"] = $backer["transaction_id"];
                        $do_void_result = $this->Paypal->processPayment($paymentInfo, "DoVoid");
                        $ack_do_void = strtoupper($do_void_result["ACK"]);
                        if( $ack_do_void != "SUCCESS" ) 
                        {
                            $this->Backer->id = $backer["id"];
                            $update_backer_payment_status = array(  );
                            $update_backer_payment_status["Backer"]["id"] = $backer["id"];
                            $update_backer_payment_status["Backer"]["payment_status"] = "void_failed";
                            $update_backer_payment_status["Backer"]["void_date"] = time();
                            $update_backer_payment_status["Backer"]["void_status"] = $do_void_result["L_LONGMESSAGE0"];
                            $this->Backer->save($update_backer_payment_status);
                            $this->Backer->create();
                            $paymentlog["PaymentLog"]["backer_id"] = $backer["id"];
                            $paymentlog["PaymentLog"]["user_id"] = $backer["user_id"];
                            $paymentlog["PaymentLog"]["project_id"] = $find_completed_projects["Project"]["id"];
                            $paymentlog["PaymentLog"]["payment_log_message"] = "void_failed";
                            $this->PaymentLog->save($paymentlog);
                            $this->PaymentLog->create();
                        }
                        else
                        {
                            $this->Backer->id = $backer["id"];
                            $update_backer_payment_status = array(  );
                            $update_backer_payment_status["Backer"]["id"] = $backer["id"];
                            $update_backer_payment_status["Backer"]["payment_status"] = "voided";
                            $update_backer_payment_status["Backer"]["void_date"] = time();
                            $update_backer_payment_status["Backer"]["void_status"] = "success";
                            $this->Backer->save($update_backer_payment_status);
                            $this->Backer->create();
                            $paymentlog["PaymentLog"]["backer_id"] = $backer["id"];
                            $paymentlog["PaymentLog"]["user_id"] = $backer["user_id"];
                            $paymentlog["PaymentLog"]["project_id"] = $find_completed_projects["Project"]["id"];
                            $paymentlog["PaymentLog"]["payment_log_message"] = "voided";
                            $this->PaymentLog->save($paymentlog);
                            $this->PaymentLog->create();
                        }

                        $to = $backerInfo["User"]["email"];
                        $subject = "Funding is not successfull for " . $find_completed_projects["Project"]["title"];
                        $this->set("backerInfo", $backerInfo);
                        $this->set("backer", $backer);
                        $this->set("find_completed_projects", $find_completed_projects);
                        $element = "project_unsuccess_backer";
                        $replyTo = "";
                        $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                        $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
                    }

                }
                $this->Project->id = $find_completed_projects["Project"]["id"];
                $this->Project->saveField("is_payment_processed", 1);
                $this->Project->create();
                return NULL;
            }

            $this->Project->id = $find_completed_projects["Project"]["id"];
            $this->Project->saveField("is_payment_processed", 1);
            $this->Project->create();
        }

    }

    public function send_following_user_notification()
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $this->loadModel("TempUserNotification");
        $this->loadModel("CronSendNotificationEmail");
        $this->loadModel("Notification");
        $temp_notification = $this->TempUserNotification->find("first");
        $following_users = $this->UserFollow->find("all", array( "conditions" => array( "UserFollow.follow_user_id" => $temp_notification["TempUserNotification"]["user_id"] ), "fields" => array( "User.name", "Following.id", "Following.email", "Following.name", "Following.receive_weekly_newsletter", "Following.notify_follower_backs_launch", "Following.notify_getting_new_follower", "Following.notify_created_project_pledges", "Following.notify_created_project_comment", "Following.notify_backing_project_update", "Following.is_opt_out" ) ));
        if( $temp_notification["TempUserNotification"]["activity_type"] == "backed" ) 
        {
            if( $temp_notification["TempUserNotification"]["subject_type"] == "project" ) 
            {
                $project_detail = $this->CommonFunction->get_project_info($temp_notification["TempUserNotification"]["subject_id"], array( "Project.title", "Project.slug", "Project.id", "User.slug", "User.name" ));
                $project_url = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"];
            }

            if( $following_users ) 
            {
                foreach( $following_users as $following_user ) 
                {
                    if( $following_user["Following"]["is_opt_out"] == 0 && $following_user["Following"]["notify_follower_backs_launch"] == 1 ) 
                    {
                        $cron_table_array = array(  );
                        $cron_table_array["CronSendNotificationEmail"]["to"] = $following_user["Following"]["email"];
                        $cron_table_array["CronSendNotificationEmail"]["from"] = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                        $cron_table_array["CronSendNotificationEmail"]["subject"] = $following_user["User"]["name"] . " backed a project.";
                        $body = "Hi " . $following_user["Following"]["name"] . ", <br />\\n";
                        $body .= $following_user["User"]["name"] . " backed a project <a href=\"" . $project_url . "\">" . $project_detail["Project"]["title"] . "</a>";
                        $cron_table_array["CronSendNotificationEmail"]["content"] = $body;
                        $this->CronSendNotificationEmail->save($cron_table_array);
                        $this->CronSendNotificationEmail->create();
                        $notification_array = array(  );
                        $notification_array["Notification"]["user_id"] = $following_user["Following"]["id"];
                        $notification_array["Notification"]["notification_type"] = "friend_backed_project";
                        $notification_array["Notification"]["subject_id"] = $temp_notification["TempUserNotification"]["subject_id"];
                        $notification_array["Notification"]["subject_type"] = "project";
                        $notification_array["Notification"]["is_read"] = 0;
                        $notification_array["Notification"]["friend_id"] = $temp_notification["TempUserNotification"]["user_id"];
                        $this->Notification->save($notification_array);
                        $this->Notification->create();
                    }

                }
            }

        }

        if( $temp_notification["TempUserNotification"]["activity_type"] == "created" ) 
        {
            if( $temp_notification["TempUserNotification"]["subject_type"] == "project" ) 
            {
                $project_detail = $this->CommonFunction->get_project_info($temp_notification["TempUserNotification"]["subject_id"], array( "Project.title", "Project.slug", "Project.id", "User.slug", "User.name" ));
                $project_url = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"];
            }

            foreach( $following_users as $following_user ) 
            {
                if( $following_user["Following"]["is_opt_out"] == 0 && $following_user["Following"]["notify_follower_backs_launch"] == 1 ) 
                {
                    $cron_table_array = array(  );
                    $user_notification_link = Router::url(array( "plugin" => "users", "controller" => "users", "action" => "detail" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"];
                    $cron_table_array["CronSendNotificationEmail"]["to"] = $following_user["Following"]["email"];
                    $cron_table_array["CronSendNotificationEmail"]["from"] = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                    $cron_table_array["CronSendNotificationEmail"]["subject"] = $following_user["User"]["name"] . " created a project.";
                    $body = "Hi " . $following_user["Following"]["name"] . ", <br />";
                    $body .= $following_user["User"]["name"] . " created a project <a href=\"" . $project_url . "\">" . $project_detail["Project"]["title"] . ".</a><br />";
                    $cron_table_array["CronSendNotificationEmail"]["content"] = $body;
                    $this->CronSendNotificationEmail->save($cron_table_array);
                    $this->CronSendNotificationEmail->create();
                    $notification_array = array(  );
                    $notification_array["Notification"]["user_id"] = $following_user["Following"]["id"];
                    $notification_array["Notification"]["notification_type"] = "friend_created_project";
                    $notification_array["Notification"]["subject_id"] = $temp_notification["TempUserNotification"]["subject_id"];
                    $notification_array["Notification"]["is_read"] = 0;
                    $notification_array["Notification"]["subject_type"] = "project";
                    $notification_array["Notification"]["friend_id"] = $temp_notification["TempUserNotification"]["user_id"];
                    $this->Notification->save($notification_array);
                    $this->Notification->create();
                }

            }
        }

        $this->TempUserNotification->deleteAll(array( "TempUserNotification.id" => $temp_notification["TempUserNotification"]["id"] ));
    }

    public function send_notification_from_cron_table()
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $this->loadModel("TempUserNotification");
        $this->loadModel("CronSendNotificationEmail");
        $this->loadModel("Notification");
        $data = $this->CronSendNotificationEmail->find("all", array( "limit" => 10 ));
        if( $data ) 
        {
            foreach( $data as $mail ) 
            {
                $to = $mail["CronSendNotificationEmail"]["to"];
                $from = $mail["CronSendNotificationEmail"]["from"];
                $subject = $mail["CronSendNotificationEmail"]["subject"];
                $body = $mail["CronSendNotificationEmail"]["content"];
                $this->set("body", $body);
                $element = "cron_email_notification";
                $replyTo = "";
                $this->_sendMail($to, $from, $replyTo = "", $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
                $this->CronSendNotificationEmail->deleteAll(array( "CronSendNotificationEmail.id" => $mail["CronSendNotificationEmail"]["id"] ));
            }
        }

    }

    public function send_project_updates_notification()
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $this->loadModel("Notification");
        $this->loadModel("TempProjectNotification");
        $this->loadModel("CronSendNotificationEmail");
        $projects_updates = $this->TempProjectNotification->find("first");
        $reminded_users = $this->StaredProject->find("list", array( "conditions" => array( "StaredProject.project_id" => $projects_updates["TempProjectNotification"]["project_id"] ), "fields" => array( "StaredProject.user_id", "StaredProject.email" ) ));
        $backers = array(  );
        if( $projects_updates ) 
        {
            if( $projects_updates["TempProjectNotification"]["activity_type"] == "update_posted" ) 
            {
                $this->Project->bindModel(array( "hasMany" => array( "ProjectUpdate" => array( "conditions" => array( "ProjectUpdate.id" => $projects_updates["TempProjectNotification"]["subject_id"] ) ) ) ));
                $project_detail = $this->Project->find("first", array( "conditions" => array( "Project.id" => $projects_updates["TempProjectNotification"]["project_id"] ) ));
                $project_url = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"];
                foreach( $project_detail["Backer"] as $backer ) 
                {
                    $backers[] = $backer["user_id"];
                }
                if( !empty($backers) ) 
                {
                    $backers_details = $this->User->find("all", array( "conditions" => array( "User.id " => $backers ) ));
                    pr($backers_details);
                    if( $backers_details ) 
                    {
                        foreach( $backers_details as $backers_detail ) 
                        {
                            $body = "";
                            $project_n = array(  );
                            $project_n["CronSendNotificationEmail"]["subject"] = Configure::read("CONFIG_SITE_TITLE") . " Reminder! " . $project_detail["Project"]["title"] . " project's update posted.";
                            $body = "Hello there!";
                            $body .= "A new update about " . "<a href='" . Router::url(array( "plugin" => false, "controller" => "projects", "action" => "updates" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"] . "'>" . $project_detail["Project"]["title"] . "</a>" . " has been posted by " . $project_detail["User"]["name"] . ". Click on the link right below to check it out!";
                            $body .= "<br />You're receiving this one-time email because you have backed this project on " . Configure::read("CONFIG_SITE_TITLE") . ". <br />";
                            $project_n["CronSendNotificationEmail"]["content"] = $body;
                            $project_n["CronSendNotificationEmail"]["to"] = $backers_detail["User"]["email"];
                            $project_n["CronSendNotificationEmail"]["from"] = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                            $this->CronSendNotificationEmail->save($project_n);
                            $this->CronSendNotificationEmail->create();
                            if( $backers_detail ) 
                            {
                                $notification_array = array(  );
                                $notification_array["Notification"]["user_id"] = $backers_detail["User"]["id"];
                                $notification_array["Notification"]["notification_type"] = "project_update_posted";
                                $notification_array["Notification"]["subject_id"] = $projects_updates["TempProjectNotification"]["project_id"];
                                $notification_array["Notification"]["is_read"] = 0;
                                $notification_array["Notification"]["subject_type"] = "project";
                                $this->Notification->save($notification_array);
                                $this->Notification->create();
                            }

                        }
                    }

                }

                if( $reminded_users ) 
                {
                    foreach( $reminded_users as $user_id => $user ) 
                    {
                        $body = "";
                        $remove_link = Router::url(array( "plugin" => false, "controller" => "stared_projects", "action" => "remove_reminder" ), true) . "/" . base64_encode($user) . "/" . $project_detail["Project"]["slug"];
                        $project_n = array(  );
                        $project_n["CronSendNotificationEmail"]["subject"] = Configure::read("CONFIG_SITE_TITLE") . " Reminder! " . $project_detail["Project"]["title"] . " project's update posted.";
                        $body = "Hello!<br />";
                        $body .= "An update has just been posted by " . $project_detail["User"]["name"] . ". Please click on the link right below to check out the details.<br />";
                        $body .= "<a href='" . Router::url(array( "plugin" => false, "controller" => "projects", "action" => "updates" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"] . "'>" . $project_detail["Project"]["title"] . "</a>";
                        $body .= "<br />You're receiving this email because you chose to be reminded about this project.";
                        $body .= "<br />If you wish, you can stop receiving such emails. To do this, just click here:  <a href='" . $remove_link . "'>Unsubscribe</a>";
                        $project_n["CronSendNotificationEmail"]["content"] = $body;
                        $project_n["CronSendNotificationEmail"]["to"] = $user;
                        $project_n["CronSendNotificationEmail"]["from"] = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                        $this->CronSendNotificationEmail->save($project_n);
                        $this->CronSendNotificationEmail->create();
                        if( $user_id != 0 ) 
                        {
                            $notification_array = array(  );
                            $notification_array["Notification"]["user_id"] = $user_id;
                            $notification_array["Notification"]["notification_type"] = "project_update_posted";
                            $notification_array["Notification"]["subject_id"] = $projects_updates["TempProjectNotification"]["project_id"];
                            $notification_array["Notification"]["is_read"] = 0;
                            $notification_array["Notification"]["subject_type"] = "project";
                            $this->Notification->save($notification_array);
                            $this->Notification->create();
                        }

                    }
                }

                $this->TempProjectNotification->deleteAll(array( "TempProjectNotification.id" => $projects_updates["TempProjectNotification"]["id"] ));
            }

            if( $projects_updates["TempProjectNotification"]["activity_type"] == "project_comment" ) 
            {
                $project_detail = $this->Project->find("first", array( "conditions" => array( "Project.id" => $projects_updates["TempProjectNotification"]["project_id"] ) ));
                $project_url = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"];
                if( $reminded_users ) 
                {
                    $this->loadModel("CronSendNotificationEmail");
                    if( !empty($projects_updates["TempProjectNotification"]["user_id"]) ) 
                    {
                        $user_detail = $this->User->find("first", array( "conditions" => array( "User.id" => $projects_updates["TempProjectNotification"]["user_id"] ) ));
                    }

                    foreach( $reminded_users as $user_id => $user ) 
                    {
                        $body = "";
                        $body = "Hello!,<br />";
                        $body .= "This is to let you know that a new comment has just been posted by " . $user_detail["User"]["name"] . ". Please click on the link right below to check out the details.<br />";
                        $body .= "<a href='" . Router::url(array( "plugin" => false, "controller" => "projects", "action" => "backer_comment" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"] . "'>" . $project_detail["Project"]["title"] . "</a>";
                        $body .= "<br />You're receiving this email because you chose  to be reminded about this project.";
                        $remove_link = Router::url(array( "plugin" => false, "controller" => "stared_projects", "action" => "remove_reminder" ), true) . "/" . base64_encode($user) . "/" . $project_detail["Project"]["slug"];
                        $body .= "<br />If you wish, you can stop receiving such emails. To do this, just click here:  <a href='" . $remove_link . "'>Unsubscribe</a>";
                        $project_n = array(  );
                        $project_n["CronSendNotificationEmail"]["subject"] = Configure::read("CONFIG_SITE_TITLE") . " Reminder! Comment posted on " . $project_detail["Project"]["title"] . ".";
                        $project_n["CronSendNotificationEmail"]["content"] = $body;
                        $project_n["CronSendNotificationEmail"]["to"] = $user;
                        $project_n["CronSendNotificationEmail"]["from"] = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                        $this->CronSendNotificationEmail->save($project_n);
                        $this->CronSendNotificationEmail->create();
                        if( $user_id != 0 ) 
                        {
                            $notification_array = array(  );
                            $notification_array["Notification"]["user_id"] = $user_id;
                            $notification_array["Notification"]["notification_type"] = "project_comment";
                            $notification_array["Notification"]["subject_id"] = $projects_updates["TempProjectNotification"]["project_id"];
                            $notification_array["Notification"]["is_read"] = 0;
                            $notification_array["Notification"]["subject_type"] = "project";
                            $this->Notification->save($notification_array);
                            $this->Notification->create();
                        }

                    }
                }

                $this->TempProjectNotification->deleteAll(array( "TempProjectNotification.id" => $projects_updates["TempProjectNotification"]["id"] ));
            }

            if( $projects_updates["TempProjectNotification"]["activity_type"] == "backed" ) 
            {
                $project_detail = $this->Project->find("first", array( "conditions" => array( "Project.id" => $projects_updates["TempProjectNotification"]["project_id"] ) ));
                $project_url = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"];
                if( $reminded_users ) 
                {
                    $this->loadModel("CronSendNotificationEmail");
                    if( !empty($projects_updates["TempProjectNotification"]["user_id"]) ) 
                    {
                        $user_detail = $this->User->find("first", array( "conditions" => array( "User.id" => $projects_updates["TempProjectNotification"]["user_id"] ) ));
                    }

                    foreach( $reminded_users as $user_id => $user ) 
                    {
                        $body = "";
                        $project_n = array(  );
                        $body = "Hello!,<br />";
                        $body .= $user_detail["User"]["name"] . " has just backed project " . $project_detail["Project"]["title"] . ". Please click on the link to the project right below to check the details.<br />";
                        $body .= "<a href='" . Router::url(array( "plugin" => false, "controller" => "projects", "action" => "backer_comment" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"] . "'>" . $project_detail["Project"]["title"] . "</a>";
                        $body .= "<br />You're receiving this email because you chose to be reminded about this project.";
                        $remove_link = Router::url(array( "plugin" => false, "controller" => "stared_projects", "action" => "remove_reminder" ), true) . "/" . base64_encode($user) . "/" . $project_detail["Project"]["slug"];
                        $body .= "<br /> If you would like to stop being updated on this project, click here: <a href='" . $remove_link . "'>Unsubscribe</a>";
                        $project_n["CronSendNotificationEmail"]["subject"] = Configure::read("CONFIG_SITE_TITLE") . " Reminder! " . $project_detail["Project"]["title"] . ".";
                        $project_n["CronSendNotificationEmail"]["content"] = $body;
                        $project_n["CronSendNotificationEmail"]["to"] = $user;
                        $project_n["CronSendNotificationEmail"]["from"] = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                        $this->CronSendNotificationEmail->save($project_n);
                        $this->CronSendNotificationEmail->create();
                    }
                }

                $this->TempProjectNotification->deleteAll(array( "TempProjectNotification.id" => $projects_updates["TempProjectNotification"]["id"] ));
            }

        }

    }

    public function send_project_ending_notification()
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $this->loadModel("CronSendNotificationEmail");
        $current_time = time();
        $ending_soon_projects_time = strtotime("+48 hours", $current_time);
        $ending_soon_projects = $this->Project->find("all", array( "conditions" => array( "Project.project_end_date" => $ending_soon_projects_time, "Project.ending_soon_notification" => 0, "Project.is_payment_processed" => 0, "Project.submitted_status" => 1, "Project.active" => 1, "Project.is_cancelled" => 0 ) ));
        $view = new View($this, false);
        foreach( $ending_soon_projects as $ending_soon_project ) 
        {
            $email_temp["project_link"] = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . "/" . $ending_soon_project["User"]["slug"] . "/" . $ending_soon_project["Project"]["slug"];
            $email_temp["user_link"] = Router::url(array( "plugin" => "users", "controller" => "users", "action" => "profile", "slug" => $ending_soon_project["User"]["slug"] ), true);
            $email_temp["category_link"] = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "category_projects", $ending_soon_project["Category"]["slug"] ), true);
            $view->set("ending_soon_project", $ending_soon_project);
            $view->set("email_temp", $email_temp);
            $starred_users = $this->StaredProject->find("list", array( "conditions" => array( "StaredProject.project_id" => $ending_soon_project["Project"]["id"] ), "fields" => array( "StaredProject.email" ) ));
            $view_output = $view->render("/elements/email/html/ending_soon_notification");
            foreach( $starred_users as $starred_user ) 
            {
                $cron_table_array = array(  );
                $cron_table_array["CronSendNotificationEmail"]["to"] = $starred_user;
                $cron_table_array["CronSendNotificationEmail"]["from"] = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                $cron_table_array["CronSendNotificationEmail"]["subject"] = Configure::read("CONFIG_SITE_TITLE") . " reminder!" . $ending_soon_project["Project"]["title"] . " by " . $ending_soon_project["User"]["name"] . " is ending soon.";
                $cron_table_array["CronSendNotificationEmail"]["content"] = $view_output;
                $this->CronSendNotificationEmail->save($cron_table_array);
                $this->CronSendNotificationEmail->create();
            }
            $this->Project->id = $ending_soon_project["Project"]["id"];
            $this->Project->saveField("ending_soon_notification", 1);
            $this->Project->create();
        }
    }

    public function send_cancellation_notification()
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $backers = $this->Backer->find("all", array( "conditions" => array( "Backer.is_cancelled" => 1, "Backer.cancellation_notification_sent" => 0 ), "limit" => "10" ));
        foreach( $backers as $backer ) 
        {
            $backerInfo["User"] = $backer["User"];
            if( $backer["Backer"]["payment_status"] == "reauthorize" || $backer["Backer"]["payment_status"] == "authorized" ) 
            {
                $paymentInfo["token"] = $backer["Backer"]["transaction_id"];
                $do_void_result = $this->Paypal->processPayment($paymentInfo, "DoVoid");
                $ack_do_void = strtoupper($do_void_result["ACK"]);
                if( $ack_do_void != "SUCCESS" ) 
                {
                    $this->Backer->id = $backer["Backer"]["id"];
                    $update_backer_payment_status = array(  );
                    $update_backer_payment_status["Backer"]["id"] = $backer["Backer"]["id"];
                    $update_backer_payment_status["Backer"]["payment_status"] = "void_failed";
                    $update_backer_payment_status["Backer"]["void_date"] = time();
                    $update_backer_payment_status["Backer"]["void_status"] = $do_void_result["L_LONGMESSAGE0"];
                    $update_backer_payment_status["Backer"]["cancellation_notification_sent"] = 1;
                    $this->Backer->save($update_backer_payment_status);
                    $this->Backer->create();
                    $paymentlog["PaymentLog"]["backer_id"] = $backer["Backer"]["id"];
                    $paymentlog["PaymentLog"]["user_id"] = $backer["Backer"]["user_id"];
                    $paymentlog["PaymentLog"]["project_id"] = $backer["Project"]["id"];
                    $paymentlog["PaymentLog"]["payment_log_message"] = "void_failed";
                    $this->PaymentLog->save($paymentlog);
                    $this->PaymentLog->create();
                }
                else
                {
                    $this->Backer->id = $backer["Backer"]["id"];
                    $update_backer_payment_status = array(  );
                    $update_backer_payment_status["Backer"]["id"] = $backer["Backer"]["id"];
                    $update_backer_payment_status["Backer"]["payment_status"] = "voided";
                    $update_backer_payment_status["Backer"]["void_date"] = time();
                    $update_backer_payment_status["Backer"]["void_status"] = "success";
                    $update_backer_payment_status["Backer"]["cancellation_notification_sent"] = 1;
                    $this->Backer->save($update_backer_payment_status);
                    $this->Backer->create();
                    $paymentlog["PaymentLog"]["backer_id"] = $backer["Backer"]["id"];
                    $paymentlog["PaymentLog"]["user_id"] = $backer["Backer"]["user_id"];
                    $paymentlog["PaymentLog"]["project_id"] = $backer["Project"]["id"];
                    $paymentlog["PaymentLog"]["payment_log_message"] = "voided";
                    $this->PaymentLog->save($paymentlog);
                    $this->PaymentLog->create();
                }

                $to = $backer["User"]["email"];
                $subject = "Cancellation notification for " . $backer["Project"]["title"];
                $this->set("backer", $backer);
                $element = "project_cancellation_to_backer";
                $replyTo = "";
                $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
            }

        }
    }

}

