<?php

App::import('Lib', 'Facebook.FB');

class UsersController extends UsersAppController {

    var $name = 'Users';
    var $uses = array('users.User', 'groups.Group', 'Project', 'Backer', 'StaredProject', 'Country', 'UserFollow', 'BlockedUser', 'Notification', 'UserActivity', 'ProjectComment');
    public $components = array('Auth', 'Email', 'Session', 'RequestHandler', 'Search.Prg', 'Users.LogUtil', 'Cookie');
    var $helpers = array('Html', 'Form', 'Paginator', 'FlashChart');
    var $sessiondata = 'Auth.UserData';
    var $paginate;
    public $presetVars = array(
        array('field' => 'name', 'type' => 'value')
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('model', $this->modelClass);
        if (!Configure::read('App.defaultEmail')) {
            Configure::write('App.defaultEmail', Configure::read('noreply_email.email'));
        }
        if (!isset($this->params['prefix'])) {
            $this->Auth->allow('signup', 'login', 'forgot_password', 'profile', 'reset_password', 'verify_email', 'reset_email', 'update_profile_image', 'starred_projects', 'backed_projects', 'load_more_project_content', 'find_friends', 'user_comments', 'activity', 'created_projects', 'fblogin');
        } else {
            $this->Auth->allow('admin_recover_password', 'admin_reset_password');
        }
    }

    function admin_users_dashboard() {
        
    }

    function admin_index() {
        $conditions = array();
        $conditions['User.is_admin'] = 0;
        if (!empty($this->data) && isset($this->data['recordsPerPage'])) {
            $limitValue = $limit = $this->data['recordsPerPage'];
            $this->Session->write($this->name . '.' . $this->action . '.recordsPerPage', $limit);
        } else {
            $this->Prg->commonProcess();
        }
        $limitValue = $limit = ($this->Session->read($this->name . '.' . $this->action . '.recordsPerPage')) ? $this->Session->read($this->name . '.' . $this->action . '.recordsPerPage') : Configure::read('defaultPaginationLimit');
        $this->set('limitValue', $limitValue);
        $this->set('limit', $limit);
        $this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
        $parsedConditions = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
        $this->paginate[$this->modelClass]['limit'] = $limit;
        $this->paginate[$this->modelClass]['conditions'] = $parsedConditions + $conditions;
        $this->paginate[$this->modelClass]['order'] = array($this->modelClass . '.created' => 'desc');
        $this->set('result', $this->paginate());
        $users = $this->paginate();
        $this->set("users", $users);
    }

    function admin_a_users() {
        $conditions['User.is_admin'] = 1;
        if (!empty($this->data) && isset($this->data['recordsPerPage'])) {
            $limitValue = $limit = $this->data['recordsPerPage'];
            $this->Session->write($this->name . '.' . $this->action . '.recordsPerPage', $limit);
        } else {
            $this->Prg->commonProcess();
        }
        $limitValue = $limit = ($this->Session->read($this->name . '.' . $this->action . '.recordsPerPage')) ? $this->Session->read($this->name . '.' . $this->action . '.recordsPerPage') : Configure::read('defaultPaginationLimit');
        $this->set('limitValue', $limitValue);
        $this->set('limit', $limit);
        $this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
        $parsedConditions = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
        $this->paginate[$this->modelClass]['limit'] = $limit;
        $this->paginate[$this->modelClass]['conditions'] = $parsedConditions + $conditions;
        $this->paginate[$this->modelClass]['order'] = array($this->modelClass . '.created' => 'desc');
        $this->set('result', $this->paginate());
        $users = $this->paginate();
        $this->set("users", $users);
    }

    function admin_login() {
        $this->layout = "admin_login";
        if (empty($this->data)) {
            if (($this->Session->read("Auth.admin.id"))) {
                $this->redirect(array("plugin" => "users", "controller" => "users", "action" => "dashboard"));
            }
            $cookie = $this->Cookie->read('Auth.admin');

            if (!is_null($cookie)) {
                $this->data['User'] = $cookie;
            }
        } else {
            if ($this->Auth->user()) {
                $password = $this->data['User']['passwd'];
                if (!empty($this->data['User']['remember_me'])) {
                    $cookie = array();
                    $cookie['email'] = $this->data['User']['email'];
                    $cookie['passwd'] = $password;
                    $this->Cookie->write('Auth.admin', $cookie, true, '+2 weeks');
                    unset($this->data['User']['remember_me']);
                }
                $this->User->id = $this->Session->read('Auth.admin.id');
                $this->User->saveField("is_login", 1);
                $option = array('description' => 'Session opened for user ' . $this->Session->read('Auth.admin.name'));
                $this->LogUtil->log($option);
                $this->loadModel("group_privileges.GroupPrivilege");
                $group_id = $this->Session->read("Auth.admin.group_id");
                $modulePermissions = $this->GroupPrivilege->find("all", array("conditions" => "GroupPrivilege.group_id=" . $group_id));
                $permissions_array = array();
                foreach ($modulePermissions as $modulePermission) {
                    $permissions_array[] = $modulePermission['Module']['controller'] . "/" . $modulePermission['Module']['action'];
                }
                $this->Session->write('Auth.admin.permissions', $permissions_array);
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__d('users', 'Please enter valid Email and Password.', true), 'admin/error');
            }
        }
    }

    function admin_recover_account($user_id) {
        $this->User->id = $user_id;
        $this->User->saveField('is_deleted', 0);
        $this->User->saveField('is_opt_out', 0);
        $this->Session->setFlash(__d('users', 'Account recovered successfully.', true), "admin/success");
        $this->redirect(array("plugin" => "users", "controller" => "users", "action" => "index"));
    }

    function admin_dashboard() {
        
    }

    function admin_logout() {
        $this->User->id = $this->Session->read('Auth.admin.id');
        $this->User->saveField("is_login", 0);
        $message = sprintf(__d('users', 'You have successfully logged out.', true));
        $this->Session->setFlash($message, 'admin/success');
        $this->redirect($this->Auth->logout());
    }

    function admin_add_user() {
        $conditions = array();
        if ($this->Session->read('Auth.admin.group_id') != 1) {
            $conditions = array('Group.id <>' => 1, 'Group.active' => 1);
        } else {
            $conditions = array('Group.active' => 1);
        }
        $groups = $this->Group->find("list", array("conditions" => $conditions));
        $this->set("groups", $groups);
        if ($this->data) {
            $this->User->setValidation('admin_add_user');
            $this->User->set($this->data);
            if ($this->User->validates()) {
                unset($this->data['User']['con_password']);
                $this->data['User']['slug'] = $this->User->createSlug($this->data['User']['name']); // generate slug
                $this->data['User']['password_token'] = $this->data['User']['password'];
                $this->data['User']['passwd'] = Security::hash($this->data['User']['password'], null, true);
                $this->data['User']['active'] = '1';
                if ($this->data['User']['group_id'] == 1 || $this->data['User']['group_id'] == 2) {
                    $this->data['User']['is_admin'] = 1;
                } else {
                    $this->data['User']['is_admin'] = 0;
                }
                $this->User->save($this->data);
                $message = sprintf(__d('users', 'User added successfully.', true));
                $this->Session->setFlash($message, 'admin/success');
                $this->redirect(array("plugin" => "users", "controller" => "users", "action" => "index"));
            } else {
                unset($this->data['User']['password']);
                unset($this->data['User']['con_password']);
            }
        }
    }

    function admin_edit($id) {
        $conditions = array();
        if ($this->Session->read('Auth.admin.group_id') != 1) {
            $conditions = array("Group.id <> 1");
        }
        $groups = $this->Group->find("list", array("conditions" => $conditions));
        $this->set("groups", $groups);
        if (empty($this->data)) {
            if ($id == 1) {
                if ($this->Session->read('Auth.admin.id') != 1) {
                    $this->Session->setFlash("You are no autherized to access this page.", 'admin/error');
                    $this->redirect(array("plugin" => "users", "controller" => "users", "action" => "dashboard"));
                }
            }
            $this->User->id = $id;
            $this->data = $this->User->read();
        } else {
            if (isset($this->data)) {
                $this->User->setValidation('admin_edit_user');
                $this->User->set($this->data);
                if ($this->User->validates()) {
                    unset($this->data['User']['con_password']);
                    if (!empty($this->data['User']['password'])) {
                        $this->data['User']['password_token'] = $this->data['User']['password'];
                        $this->data['User']['passwd'] = Security::hash($this->data['User']['password'], null, true);
                    }
                    if ($this->data['User']['group_id'] == 1 || $this->data['User']['group_id'] == 2) {
                        $this->data['User']['is_admin'] = 1;
                    } else {
                        $this->data['User']['is_admin'] = 0;
                    }
                    $this->User->save($this->data);
                    $message = sprintf(__d('users', 'User updated successfully.', true));
                    $this->Session->setFlash($message, 'admin/success');
                    $this->redirect(array("plugin" => "users", "controller" => "users", "action" => "index"));
                }
            }
        }
    }

    function admin_status_update($id = null, $status = 0) {
        if ($id == null) {
            $this->Session->setFlash("You are using wrong url.", "admin/error");
        } else {
            $this->User->id = $id;
            $this->User->saveField("active", $status);
            $this->Session->setFlash("User status updated successfully.", "admin/success");
        }
        $this->redirect(array("plugin" => "users", "controller" => "users", "action" => "index"));
    }

    function admin_delete($id) {
        if ($id == null) {
            $this->Session->setFlash("You are using wrong url.", "admin/error");
        } else {
            /* $this->loadModel('Backer');
              $this->loadModel('ProjectAskedQuestion');
              $this->loadModel('ProjectComment');
              $this->loadModel('ProjectReport');
              $this->loadModel('ProjectTransaction');
              $this->loadModel('ProjectUpdate');
              $this->loadModel('ProjectUpdateComment');
              $this->loadModel('Reward');
              $this->loadModel('StaredProject');
              $this->loadModel('UserFollow');
              $this->loadModel('UserActivity');
              $this->loadModel('messages.Message');
              $this->loadModel('blogs.BlogPost');
              $this->loadModel('blogs.BlogPostComment');

              $this->User->id = $id;
              $this->Project->recursive = '-1';
              $user_created_projects = $this->Project->find('list', array('conditions' => array('Project.user_id' => $id), 'fields' => array('Project.id')));
              $project_backing_delete = $this->Backer->deleteAll(array('Backer.project_id' => $user_created_projects));
              $project_asked_question_delete = $this->ProjectAskedQuestion->deleteAll(array('ProjectAskedQuestion.project_id' => $user_created_projects));
              $project_comment_delete = $this->ProjectComment->deleteAll(array('ProjectComment.project_id' => $user_created_projects));
              $project_report_delete = $this->ProjectReport->deleteAll(array('ProjectReport.project_id' => $user_created_projects));
              $project_transaction_delete = $this->ProjectTransaction->deleteAll(array('ProjectTransaction.project_id' => $user_created_projects));
              $project_update_delete = $this->ProjectUpdate->deleteAll(array('ProjectUpdate.project_id' => $user_created_projects));
              $project_reward_delete = $this->Reward->deleteAll(array('Reward.project_id' => $user_created_projects));
              $project_update_comment_delete = $this->ProjectUpdateComment->deleteAll(array('ProjectUpdateComment.project_id' => $user_created_projects));
              $project_stared_project_delete = $this->StaredProject->deleteAll(array('StaredProject.user_id' => $id));
              $user_follow_delete = $this->UserFollow->deleteAll(array('UserFollow.user_id' => $id));
              $user_activity_delete = $this->UserActivity->deleteAll(array('UserActivity.user_id' => $id));
              $user_message_from = $this->Message->deleteAll(array('Message.from_user_id' => $id));
              $user_message_to = $this->Message->deleteAll(array('Message.to_user_id' => $id));
              $user_message_project = $this->Message->deleteAll(array('Message.project_id' => $user_created_projects));
              $block_user_delete = $this->BlockedUser->deleteAll(array('BlockedUser.user_id' => $id));
              $blogpost_delete = $this->BlogPost->deleteAll(array('BlogPost.user_id' => $id));
              $blogpost_comment = $this->BlogPostComment->deleteAll(array('BlogPostComment.user_id' => $id));
              $delete_project = $this->Project->deleteAll(array('Project.id' => $user_created_projects));
              $this->User->delete(); */
            $this->Session->setFlash("User removed successfully.", "admin/success");
        }
        $this->redirect(array("plugin" => "users", "controller" => "users", "action" => "index"));
    }

    function admin_settings() {
        
    }

    function admin_myaccount() {
        $login_id = $this->Auth->user("id");
        $this->User->id = $login_id;
        if (empty($this->data)) {
            $this->data = $this->User->read();
        } else {
            if (isset($this->data)) {
                $this->User->setValidation('admin_myaccount');
                $this->User->set($this->data);
                if ($this->User->validates()) {
                    unset($this->data['User']['con_password']);
                    if (!empty($this->data['User']['password'])) {
                        $this->data['User']['password_token'] = $this->data['User']['password'];
                        $this->data['User']['passwd'] = Security::hash($this->data['User']['password'], null, true);
                    }
                    $this->User->save($this->data);
                    $message = sprintf(__d('users', 'Admin updated successfully.', true));
                    $this->Session->setFlash($message, 'admin/success');
                    $this->redirect(array("plugin" => "users", "controller" => "users", "action" => "myaccount"));
                }
            }
        }
    }

    function admin_operate() {
        if (!empty($this->data[$this->modelClass]['operation'])) {

            if ($this->data[$this->modelClass]['operation'] == "active") {
                $ids = implode(",", $this->data['usersChk']);
                $this->{$this->modelClass}->updateAll(array("active" => 1), array($this->modelClass . ".id IN (" . $ids . ")"));
                $message = sprintf(__d('users', 'Users activated successfully.', true));
            }
            if ($this->data[$this->modelClass]['operation'] == "inactive") {
                $ids = implode(",", $this->data['usersChk']);
                $this->{$this->modelClass}->updateAll(array("active" => 0), array($this->modelClass . ".id IN (" . $ids . ")"));
                $message = sprintf(__d('users', 'Users inactivated successfully.', true));
            }
            $this->Session->setFlash($message, 'admin/success');
            $this->redirect(array("plugin" => "users", "controller" => "users", "action" => "index"));
        }
    }

    function admin_user_backed_project($user_id = null) {
        $conditions = array();
        if (!empty($this->data) && isset($this->data['recordsPerPage'])) {
            $limitValue = $limit = $this->data['recordsPerPage'];
            $this->Session->write($this->name . '.' . $this->action . '.recordsPerPage', $limit);
        } else {
            $this->Prg->commonProcess();
        }
        $limitValue = $limit = ($this->Session->read($this->name . '.' . $this->action . '.recordsPerPage')) ? $this->Session->read($this->name . '.' . $this->action . '.recordsPerPage') : Configure::read('defaultPaginationLimit');
        $this->set('limitValue', $limitValue);
        $this->set('limit', $limit);
        $this->{'Backer'}->data['Backer'] = $this->passedArgs;
        $parsedConditions = $this->{'Project'}->parseCriteria($this->passedArgs);
        $this->paginate['Backer']['limit'] = $limit;
        $conditions['Backer.user_id'] = $user_id;
        $this->paginate['Backer']['conditions'] = $parsedConditions + $conditions;
        $this->paginate['Backer']['order'] = array('Backer.created' => 'desc');
        $this->set('results', $this->paginate('Backer'));
        $user_name = $this->User->find('first', array('conditions' => array('User.id' => $user_id)));
        $this->set('user_name', $user_name);
        $this->set('user_id', $user_id);
    }

    function admin_recover_password() {
        $this->layout = "admin_login";
        if (!empty($this->data)) {
            $this->User->set($this->data);
            $this->User->setValidation('forgot_password');
            if ($this->User->validates()) {
                $admin_email = $this->User->find('first', array('conditions' => array('User.email' => $this->data['User']['email'])));
                if (isset($admin_email) && ($admin_email != '')) {

                    $this->data['User']['forgot_password_token'] = $this->User->RandomPasswordGenerator();
                    $this->data['User']['id'] = $admin_email['User']['id'];
                    $this->data['User']['forgot_password_token_expire'] = time() + (3600 * 24);

                    if ($this->User->save($this->data, false)) {
                        $url = Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'reset_password'), true) . '/' . $this->data['User']['forgot_password_token'];
                        $ms = $url;
                        $this->set('ms', $ms);
                        $this->data['User']['name'] = $admin_email['User']['name'];
                        $subject = 'Password Reset';
                        $to = $admin_email['User']['email'];
                        $from = Configure::read('CONFIG_FROMNAME') . "<" . Configure::read('CONFIG_FROMEMAIL') . ">";
                        $body = 'Reset your password here';
                        $d['Emaillog']['email_to'] = $to;
                        $d['Emaillog']['email_from'] = $from;
                        $d['Emaillog']['email_type'] = 'C';
                        $d['Emaillog']['subject'] = $subject;
                        $d['Emaillog']['message'] = $body;
                        $d['Emaillog']['active'] = '1';
                        $d['Emaillog']['deleted'] = '0';
                        $this->Email->from = $from;
                        $this->Email->to = $to;
                        $this->Email->subject = $subject;
                        $element = 'forgot_password';
                        $replyTo = Configure::read('CONFIG_FROMEMAIL');
                        if ($this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(), $attachments = "", $sendAs = 'html', $bcc = array())) {
                            $this->Emaillog->create();
                            $this->Emaillog->set($d);
                            $this->Emaillog->save();
                        }
                        $this->Session->setFlash(__d('users', 'TO reset password check your email address.', true), 'admin/success');
                        $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'recover_password'));
                    }
                } else {
                    $this->Session->setFlash(__d('users', 'This email address does not exist.', true), 'admin/error');
                }
            } else {

                $this->Session->setFlash(__d('users', 'Please enter valid Email .', true), 'admin/error');
            }
        }
    }

    function admin_reset_password($token = null) {
        $this->layout = "admin_login";
        if (!empty($token) && $token != null) {
            $this->User->recursive = -1;
            $user = $this->User->find('first', array('conditions' => array('User.forgot_password_token' => $token)));
            if ($user['User']['forgot_password_token_expire'] != '' && $user['User']['forgot_password_token_expire'] > time()) {
                if (!empty($user)) {
                    if (!empty($this->data)) {
                        $this->User->setValidation('reset_password');
                        $this->User->set($this->data);
                        if ($this->User->validates()) {
                            $this->data['User']['passwd'] = Security::hash($this->data['User']['password'], null, true);
                            $this->data['User']['id'] = $user['User']['id'];
                            $this->data['User']['password_token'] = $this->data['User']['password'];
                            $this->data['User']['forgot_password_token'] = '';
                            $this->data['User']['forgot_password_token_expire'] = '';
                            if ($this->User->save($this->data, false)) {
                                $this->Session->setFlash(__d('users', 'Congratulation!, password reset successfily .', true), 'admin/success');
                                $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));
                            }
                        }
                    }
                    $this->set('token', $token);
                } else {
                    $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'reset_password'));
                }
            } else {
                $this->Session->setFlash(__d('users', 'Sorry, that password reset link has expired or has already been used.', true), 'admin/error');
                $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));
            }
        } else {
            $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));
        }
    }

    function fblogin() {

        try {
            Configure::load('facebook');

            $facebook = new Facebook(array(
                'appId' => Configure::read('Facebook.appId'),
                'secret' => Configure::read('Facebook.secret')
            ));

            $user = $facebook->getUser();
            if (!$user)
                throw new Exception();

            $user_profile = $facebook->api('/me');
            if (!isset($user_profile['id']))
                throw new Exception();

            if ($this->Auth->user()) {
                if ($this->User->field('facebook_id') && $this->User->field('facebook_id') != $user_profile['id'])
                    throw new Exception();

                $this->User->saveField('facebook_id', $user_profile['id']);
                $this->redirect(array('plugin' => false, 'controller' => 'home', 'action' => 'index'));
            }
            else {
                $existingUser = $this->User->findByEmail($user_profile['email']);

                if ($existingUser) {
                    if ($existingUser['User']['facebook_id'] && $existingUser['User']['facebook_id'] != $user_profile['id'])
                        throw new Exception();

                    $existingUser['User']['facebook_id'] = $user_profile['id'];
                    $this->User->save($existingUser);

                    $this->data = array(
                        'User' => array(
                            'login_email' => $user_profile['email'],
                            'login_password' => $existingUser['User']['password_token']
                        )
                    );

                    $this->login();
                }
                else {
                    $randomUserPass = substr(md5($user_profile['id'] . date()), 0, 8);

                    $this->data = array(
                        'User' => array(
                            'facebook_id' => $user_profile['id'],
                            'name' => $user_profile['name'],
                            'email' => $user_profile['email'],
                            're_email' => $user_profile['email'],
                            'password' => $randomUserPass,
                            're_password' => $randomUserPass,
                            'fb_image_url' => "https://graph.facebook.com/" . $fb_user_info['id'] . "/picture?type=large"
                        )
                    );

                    $this->Session->write('fb_logged_in_cus', 1);
                    $this->signup(1);
                }
            }
        } catch (Exception $e) {
            $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));
        }
    }

    function login() {
        $this->autoRender = false;
        if ($this->referer() == "/home/start") {
            $this->Session->write('redirect_to', $this->referer());
            $this->Session->write('login_redirect', 1);
        } else { // condition for blog
            $reffer_url = $this->referer();
            $explode_reffer_url = explode('/', $reffer_url);
            if ($explode_reffer_url['1'] == 'blog' && $explode_reffer_url['2'] == 'post-detail') {
                $this->Session->write('redirect_to', $this->referer());
                $this->Session->write('login_redirect', 1);
            }
        }

        if ($this->Session->read('Auth.User.id')) {
            $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $this->Session->read('Auth.User.slug')));
        }
        if (empty($this->data)) {
            $cookie = $this->Cookie->read('Auth.User');
            if (!is_null($cookie)) {
                $this->data['User'] = $cookie;
                $this->data['User']['remember_me'] = 1;
            }
            echo $this->render('signup');
            exit;
        } else {
            $data = array('email' => $this->data['User']['login_email'], 'passwd' => $this->Auth->password($this->data['User']['login_password']));
            $loginAction = array('plugin' => 'users', 'controller' => 'users', 'action' => 'login');
            $this->Auth->login($data);

            if ($this->Auth->user()) {
                $this->User->id = $this->Session->read('Auth.User.id');
                $this->User->saveField("is_login", 1);
                $this->User->saveField("last_login", time());
                $option = array('description' => 'Session opened for user ' . $this->Session->read('Auth.User.name'),
                );
                if (!empty($this->data['User']['remember_me']) && $this->data['User']['remember_me'] == 1) {
                    $cookie = array();
                    $cookie['login_email'] = $this->data['User']['login_email'];
                    $cookie['login_password'] = $this->data['User']['login_password'];
                    $this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
                    unset($this->data['User']['remember_me']);
                }
                $this->LogUtil->log($option);
                if ($this->Session->check('login_redirect') && $this->Session->read('redirect_to')) {
                    $redirect_to = $this->Session->read('redirect_to');
                    $this->Session->delete('redirect_to');
                    $this->redirect($redirect_to);
                } else {
                    if ($this->Auth->redirect() == "/users/ideallogin") {
                        $this->redirect(array('plugin' => false, 'controller' => 'home', 'action' => 'index'));
                        exit;
                    }
                    $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $this->Session->read('Auth.User.slug')));
                }
            } else {
                $user = $this->User->find('first', array('conditions' => array('User.email' => $this->data['User']['login_email']), 'fields' => array('User.is_facebook_user', 'User.is_deleted')));
                if ($user['User']['is_facebook_user']) {
                    $this->Session->setFlash(__('login_wit_facebook', true));
                } else if ($user['User']['is_deleted']) {
                    $this->Session->setFlash(vsprintf(__('account_deleted_contact_site_admin', true), array(Configure::read('CONFIG_SITE_TITLE'), Configure::read('CONFIG_SITE_TITLE'))));
                } else {
                    $this->Session->setFlash(__('invalid_user_pass', true));
                }
            }
            $this->render('signup');
        }
    }

    function ideallogin() {
        $this->layout = false;
        $this->render('ideallogin');
    }

    function logout() {
        $this->User->id = $this->Session->read('Auth.User.id');
        $this->User->saveField("is_login", 0);
        $option = array('description' => 'Session opened for user ' . $this->Session->read('Auth.User.name'),
        );
        $this->Session->delete('fb_logged_in_cus');
        $this->Session->delete('login_redirect');
        $this->Session->delete('redirect_to');
        $this->LogUtil->log($option);
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect($this->Auth->logout());
        } else {
            echo $this->Auth->logout();
        }
        exit;
    }

    function idealogout() {
        $this->autoRender = false;
        $this->User->id = $this->Session->read('Auth.User.id');
        $this->User->saveField("is_login", 0);
        $option = array('description' => 'Session opened for user ' . $this->Session->read('Auth.User.name'),
        );
        $this->Session->delete('fb_logged_in_cus');
        $this->Session->delete('login_redirect');
        $this->Session->delete('redirect_to');
        $this->LogUtil->log($option);
        echo $this->Auth->logout();
        exit;
    }

    function signup($is_facebook_user = 0) {

        if ($this->Session->read('Auth.User.id')) {
            $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $this->Session->read('Auth.User.slug')));
        }

        if ($this->data) {
            $this->User->setValidation('register');
            $this->User->set($this->data);
            if ($this->User->validates()) {
                $this->data['User']['slug'] = $this->User->createSlug($this->data['User']['name']); // generate slug
                $this->data['User']['password_token'] = $this->data['User']['password'];
                $this->data['User']['passwd'] = Security::hash($this->data['User']['password'], null, true);
                $this->data['User']['group_id'] = 3;
                $this->data['User']['active'] = 1;
                $this->data['User']['receive_weekly_newsletter'] = 1;
                $this->data['User']['notify_created_project_pledges'] = 1;
                $this->data['User']['notify_created_project_comment'] = 1;
                $this->data['User']['notify_backing_project_update'] = 1;
                $this->User->save($this->data);

                $to = $this->data['User']['email'];
                $from = Configure::read('CONFIG_FROMNAME') . "<" . Configure::read('CONFIG_FROMEMAIL') . ">";
                $subject = 'Thanks for joining ' . Configure::read('CONFIG_SITE_TITLE');
                $replyTo = Configure::read('CONFIG_FROMEMAIL');
                $element = 'registration_successfully';
                $body = 'You have Registred Successfully';
                $d['Emaillog']['email_to'] = $to;
                $d['Emaillog']['email_from'] = $from;
                $d['Emaillog']['email_type'] = 'A';
                $d['Emaillog']['subject'] = $subject;
                $d['Emaillog']['message'] = $body;
                $d['Emaillog']['active'] = '1';
                $d['Emaillog']['deleted'] = '0';
                $user_name = $this->data['User']['name'];
                $user_email = $this->data['User']['email'];
                $start_project = Router::url(array('plugin' => false, 'controller' => 'home', 'action' => 'start'), true);
                $what_is_boostbloom = Router::url(array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display'), true) . '/what-is-boostbloom';
                $password = $this->data['User']['password'];
                $this->set(compact('user_name', 'start_project', 'what_is_boostbloom', 'user_email', 'password'));
                if ($this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(), $attachments = "", $sendAs = 'html', $bcc = array())) {
                    $this->Emaillog->create();
                    $this->Emaillog->set($d);
                    $this->Emaillog->save();
                }
                $user_id = $this->User->id;
                if ($this->data['User']['receive_weekly_newsletter']) {
                    $this->loadModel('Newsletter.Subscriber');
                    $subscribe = array();
                    $subscribe['Subscriber']['user_id'] = $user_id;
                    $subscribe['Subscriber']['email'] = $this->data['User']['email'];
                    $subscribe['Subscriber']['active'] = 1;
                    $this->Subscriber->save($subscribe);
                    $this->Subscriber->create();
                }

                /** Login After Registration * */
                $data = array('email' => $this->data['User']['email'], 'passwd' => $this->Auth->password($this->data['User']['password']));
                $this->Auth->login($data);

                if ($this->Auth->user()) {
                    $this->User->id = $this->Session->read('Auth.User.id');
                    $this->User->saveField("is_login", 1);
                    $option = array('description' => 'Session opened for user ' . $this->Session->read('Auth.User.name'));
                    $this->LogUtil->log($option);
                    $this->redirect('/home/index');
                }
            }
        } else {
            $cookie = $this->Cookie->read('Auth.User');
            if (!is_null($cookie)) {
                $this->data['User'] = $cookie;
                $this->data['User']['remember_me'] = 1;
            }
        }
        $password_session = $this->Session->read('reset_pass_session');
        $password_msg = $this->Session->read('pass_msg');
        if (isset($password_session)) {
            $this->set('msg_text', $password_msg);
            $this->set('password_session', $password_session);
            $this->Session->delete('pass_msg');
            $this->Session->delete('reset_pass_session');
        }
    }

    function forgot_password() {

        if (($this->Session->read('Auth.User.id'))) {
            $this->data['User']['email'] = $this->Session->read('Auth.User.email');
        }
        $this->loadModel('Emaillog');
        $this->layout = false;
        $this->User->recursive = -1;
        if ($this->data) {
            $this->User->setValidation('forgot_password');
            $this->User->set($this->data);
            if ($this->User->validates()) {
                $user = $this->User->findByEmail($this->data['User']['email']);
                if (!empty($user)) {
                    $this->data['User']['forgot_password_token'] = $this->User->RandomPasswordGenerator();
                    $this->data['User']['id'] = $user['User']['id'];
                    $this->data['User']['forgot_password_token_expire'] = time() + (3600 * 24);
                    if ($this->User->save($this->data, false)) {
                        $url = Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'reset_password'), true) . '/' . $this->data['User']['forgot_password_token'];
                        $ms = $url;
                        $this->set('ms', $ms);
                        /*                         * ***********save to email log start************** */
                        $this->data['User']['name'] = $user['User']['name'];
                        $subject = 'Passsword reset';
                        $from = Configure::read('CONFIG_FROMNAME') . "<" . Configure::read('CONFIG_FROMEMAIL') . ">";
                        $to = $this->data['User']['email'];
                        $body = 'Reset your password here';
                        $d['Emaillog']['email_to'] = $to;
                        $d['Emaillog']['email_from'] = $from;
                        $d['Emaillog']['email_type'] = 'B';
                        $d['Emaillog']['subject'] = $subject;
                        $d['Emaillog']['message'] = $body;
                        $d['Emaillog']['active'] = '1';
                        $d['Emaillog']['deleted'] = '0';
                        $replyTo = Configure::read('CONFIG_FROMEMAIL');
                        $element = 'forgot_password';
                        if ($this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(), $attachments = "", $sendAs = 'html', $bcc = array())) {
                            $this->Emaillog->create();
                            $this->Emaillog->set($d);
                            $this->Emaillog->save();
                        }
                        /*                         * ***********save to email log end************** */
                        echo "success";
                        exit;
                    }
                } else {
                    $this->User->validationErrors['email'] = __('valid_email', true);
                }
            }
        }
    }

    function reset_password($token = null) {
        if (!empty($token) && $token != null) {
            $this->User->recursive = -1;
            $user = $this->User->find('first', array('conditions' => array('forgot_password_token' => $token)));

            if ($user['User']['forgot_password_token_expire'] != '' && $user['User']['forgot_password_token_expire'] > time()) {
                if (!empty($user)) {
                    if (!empty($this->data)) {
                        $this->User->setValidation('reset_password');
                        $this->User->set($this->data);
                        if ($this->User->validates()) {
                            $this->data['User']['passwd'] = Security::hash($this->data['User']['password'], null, true);
                            $this->data['User']['id'] = $user['User']['id'];
                            $this->data['User']['password_token'] = $this->data['User']['password'];
                            $this->data['User']['forgot_password_token'] = '';
                            $this->data['User']['forgot_password_token_expire'] = '';
                            if ($this->User->save($this->data, false)) {
                                $this->Session->write('reset_pass_session', 'success');
                                $this->Session->write('pass_msg', __('reset_password_congratulation_password_successfuly', true));
                                $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'signup'));
                            }
                        }
                    }
                    $this->set('token', $token);
                } else {
                    $this->redirect(array('plugin' => false, 'controller' => 'home', 'action' => 'index'));
                }
            } else {
                $this->Session->write('reset_pass_session', 'error');
                $this->Session->write('pass_msg', __('reset_password_link_expire_or_used_once', true));
                $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'signup'));
            }
        } else {
            $this->redirect(array('plugin' => false, 'controller' => 'home', 'action' => 'index'));
        }
    }

    function edit_profile() {

        $this->set('title_for_layout', __('edit_profile', true) . '&mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        if ($this->data) {

            $this->User->setValidation('edit_profile');
            $this->User->set($this->data);
            if ($this->User->validates()) {

                /*                 * ********save country by json************ */
                if (!empty($this->data['User']['city'])) {
                    $city_data = $this->data['User']['city'];
                    $city_vals = explode('##', $city_data);

                    $this->data['User']['city'] = $city_vals[0];
                    $this->data['User']['city_json'] = '{"id":"' . $city_data . '","name":"' . $city_vals[1] . ', ' . $city_vals[2] . '"}';
                    $this->data['User']['country'] = $city_vals[2];
                    $this->data['User']['country_json'] = '';
                } else {
                    $this->data['User']['city'] = '';
                    $this->data['User']['city'] = '';
                    $this->data['User']['country'] = '';
                    $this->data['User']['country_json'] = '';
                }
                $this->data['User']['id'] = $this->Session->read('Auth.User.id');
                if (!empty($this->data['User']['website'])) {

                    $this->data['User']['website'] = implode(',', $this->data['User']['website']);
                } else {
                    $this->data['User']['website'] = "";
                }
                $this->Session->write('Auth.User.name', $this->data['User']['name']);
                $this->Session->write('Auth.User.biography', $this->data['User']['biography']);
                $this->Session->write('Auth.User.country', $this->data['User']['country']);
                $this->Session->write('Auth.User.country_json', $this->data['User']['country_json']);
                $this->Session->write('Auth.User.city', $this->data['User']['city']);
                $this->Session->write('Auth.User.city_json', $this->data['User']['city_json']);
                $this->Session->write('Auth.User.timezone', $this->data['User']['timezone']);
                $this->Session->write('Auth.User.website', $this->data['User']['website']);
                if ($this->User->save($this->data, false)) {
                    if (!empty($this->data['User']['website'])) {
                        $this->data['User']['website'] = explode(',', $this->data['User']['website']);
                    } else {
                        $this->data['User']['website'] = array();
                    }
                    $this->set('success', 1);
                }
            }
        }
        $user = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('Auth.User.id'))));
        $this->data = $user;
        unset($this->data['User']['id']);
        if (!empty($this->data['User']['website'])) {
            $this->data['User']['website'] = explode(',', $this->data['User']['website']);
        } else {
            $this->data['User']['website'] = array();
        }
    }

    function add_image() {
        $this->layout = false;
        if ($_FILES['User']['tmp_name'] != '') {
            /*             * ****Check Allowed Extension****** */
            $allowed_extension = Configure::read('allowed_image_files');
            $fileExtension = $this->get_file_extension($_FILES['User']['name']);
            if (!in_array($fileExtension, $allowed_extension)) {
                echo 'error';
                exit;
            }
            /*             * ****Check Size Restriction***** */
            $size = $_FILES['User']['size'];
            if ($size > (1024 * 1024 * 10)) {
                echo 'errorsize';
                exit;
            }
            $tmpPath = $_FILES['User']['tmp_name'];
            $imgName = $_FILES['User']['name'];
            $imgName = str_replace(' ', '_', $imgName);
            $image_name = "profile_" . time() . $imgName;
            $userData['User']['profile_image'] = $image_name;
            $userData['User']['id'] = $this->Session->read('Auth.User.id');
            if (move_uploaded_file($tmpPath, UPLOAD_DIR . $image_name)) {
                //Remove Old Image
                $this->data = $this->User->findById($this->Session->read('Auth.User.id'));
                @unlink(UPLOAD_DIR . $this->data['User']['profile_image']);
                //Remove Old Image
                $this->Session->write('Auth.User.profile_image', $userData['User']['profile_image']);
                if ($this->User->save($userData, false)) {
                    App::import('Helper', 'Html');
                    $html = new HtmlHelper();
                    echo $html->image(WEBSITE_IMG_URL . "image.php?image=" . $image_name . '&height=125px&width=125px', array('alt' => '', 'class' => 'pr20'));
                    echo '<br>';
                    echo $html->link('Remove', 'javascript:void(0);', array('onclick' => 'remove_image()', 'class' => 'pl3 blue14'));
                    echo '<div id="image_display" class="width125">' . $imgName . '</div>';
                }
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
        exit;
    }

    function update_profile_image($user_id = null) {

        $this->layout = 'project';
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $allowed_extension = Configure::read('allowed_image_files');
            $fileExtension = $this->get_file_extension($_FILES['Filedata']['name']);
            if (!in_array($fileExtension, $allowed_extension)) {
                echo 'error';
                exit;
            }
            $targetPath = UPLOAD_DIR;
            $filename = 'profile_' . $user_id . "_" . time() . $_FILES['Filedata']['name'];
            $targetFile = $targetPath . $filename;
            move_uploaded_file($tempFile, $targetFile);
            $this->User->id = $user_id;
            $user = $this->User->findById($user_id);
            @unlink(UPLOAD_DIR . $user['User']['profile_image']);
            $this->User->saveField('profile_image', $filename);
            $this->User->saveField('fb_image_url', '');
            echo $filename;
            exit;
        }
    }

    function remove_image() {
        $this->layout = false;
        $this->autoRender = false;
        $this->data = $this->User->findById($this->Session->read('Auth.User.id'));
        if (!empty($this->data)) {
            $userData['User']['profile_image'] = '';
            $userData['User']['fb_image_url'] = '';
            $userData['User']['id'] = $this->Session->read('Auth.User.id');
            $this->Session->write('Auth.User.profile_image', $userData['User']['profile_image']);
            if ($this->User->save($userData, false)) {
                @unlink(UPLOAD_DIR . $this->data['User']['profile_image']);
            }
        }
    }

    function account_setting() {
        $this->set('title_for_layout', __('edit_user_edit_account', true) . '&mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        if ($this->data) {
            $this->loadModel('Emaillog');
            $this->data['User']['id'] = $this->Session->read('Auth.User.id');
            $this->User->setValidation('account_setting');
            if ($this->data['User']['password'] == "") {
                unset($this->User->validate['password']);
                unset($this->User->validate['con_password']);
            }
            $this->User->set($this->data);
            if ($this->User->validates()) {
                /**                 * *******check for email update************ */
                $user_info = $this->User->findById($this->Session->read('Auth.User.id'));
                if ($user_info['User']['email'] == $this->data['User']['email']) {
                    $userData['User']['email'] = $this->data['User']['email'];
                } else {
                    $userData['User']['email'] = $this->data['User']['email'];
                    $userData['User']['tmp_email'] = $user_info['User']['email'];
                    $userData['User']['email_reset'] = $this->User->RandomPasswordGenerator();
                    $userData['User']['email_token'] = $this->User->RandomPasswordGenerator();
                    $userData['User']['email_authenticated'] = '0';
                    $userData['User']['email_token_expires'] = time() + (3600 * 24);
                    /*                     * ********email user for email change************ */
                    $from = Configure::read('CONFIG_FROMNAME') . "<" . Configure::read('CONFIG_FROMEMAIL') . ">";
                    $subject = 'Action Needed.Please verify your email address for boostbloom.';
                    $to = $this->data['User']['email'];
                    $body = 'Email address change notification';
                    $d['Emaillog']['email_to'] = $to;
                    $d['Emaillog']['email_from'] = $from;
                    $d['Emaillog']['email_type'] = 'V';
                    $d['Emaillog']['subject'] = $subject;
                    $d['Emaillog']['message'] = $body;
                    $d['Emaillog']['active'] = '1';
                    $d['Emaillog']['deleted'] = '0';
                    $this->Session->write('Auth.User.email', $userData['User']['email']);
                    $email_verify = Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'verify_email'), true) . '/' . $userData['User']['email_token'];
                    $this->set('email_verify', $email_verify);
                    /*                     * **********email to new email id********************** */
                    $replyTo = Configure::read('CONFIG_FROMEMAIL');
                    $element = 'email_notofication_to_new_email';
                    if ($this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(), $attachments = "", $sendAs = 'html', $bcc = array())) {
                        $this->Emaillog->create();
                        $this->Emaillog->set($d);
                        $this->Emaillog->save();
                    }
                    /*                     * **********email to new email id end********************** */
                    /*                     * **********email to old email id********************** */
                    $from = Configure::read('CONFIG_FROMNAME') . "<" . Configure::read('CONFIG_FROMEMAIL') . ">";
                    $subject = 'Your email has been changed.';
                    $body = 'Email address change notification.';
                    $to = $user_info['User']['email'];
                    $dl['Emaillog']['subject'] = $subject;
                    $dl['Emaillog']['email_type'] = 'H';
                    $dl['Emaillog']['message'] = $body;
                    $dl['Emaillog']['email_to'] = $to;
                    $dl['Emaillog']['email_from'] = $from;
                    $dl['Emaillog']['active'] = '1';
                    $dl['Emaillog']['deleted'] = '0';
                    $this->data['User']['email_token'] = $userData['User']['email_token'];
                    $this->set('tmp_email', $user_info['User']['email']);
                    $reset_email = Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'reset_email'), true) . '/' . $userData['User']['email_reset'];
                    $this->set('restore_email', $reset_email);
                    $replyTo = Configure::read('CONFIG_FROMEMAIL');
                    $element = 'email_notofication_to_old_email';
                    if ($this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(), $attachments = "", $sendAs = 'html', $bcc = array())) {
                        $this->Emaillog->create();
                        $this->Emaillog->set($dl);
                        $this->Emaillog->save();
                    }
                    /*                     * **********email to old emai id end********************** */
                }
                if ($this->data['User']['password'] != "") {
                    /*                     * ********************check for same passsword again*********************** */
                    $userData['User']['passwd'] = Security::hash($this->data['User']['password'], null, true);
                    if ($user_info['User']['passwd'] == $userData['User']['passwd']) {
                        echo "new_password";
                        exit;
                        /**                         * *******************check for same passsword again end*********************** */
                    } else {
                        $userData['User']['password_token'] = $this->data['User']['password'];
                        $userData['User']['passwd'] = Security::hash($this->data['User']['password'], null, true);
                        $userData['User']['is_facebook_user'] = 0;
                        /**                         * *******email user for password change************ */
                        $subject = 'Password Change';
                        $from = Configure::read('CONFIG_FROMNAME') . "<" . Configure::read('CONFIG_FROMEMAIL') . ">";
                        $to = $user_info['User']['email'];
                        $body = 'Password Change notification';
                        $d['Emaillog']['email_to'] = $to;
                        $d['Emaillog']['email_from'] = $from;
                        $d['Emaillog']['email_type'] = 'H';
                        $d['Emaillog']['subject'] = $subject;
                        $d['Emaillog']['message'] = $body;
                        $d['Emaillog']['active'] = '1';
                        $d['Emaillog']['deleted'] = '0';
                        $replyTo = Configure::read('CONFIG_FROMEMAIL');
                        $element = 'password_change_notification';
                        if ($this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(), $attachments = "", $sendAs = 'html', $bcc = array())) {
                            $this->Emaillog->create();
                            $this->Emaillog->set($d);
                            $this->Emaillog->save();
                        }
                        $this->Session->write('Auth.User.password_token', $userData['User']['password_token']);
                    }
                }
                $userData['User']['id'] = $this->Session->read('Auth.User.id');
                $this->User->save($userData, false);
                {
                    echo 'success';
                    exit;
                }
            } else {
                echo "un success";
                exit;
            }
        }
        $user = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('Auth.User.id'))));
        $this->data = $user;
        unset($this->data['User']['id']);
    }

    function profile_notification() {
        $this->set('title_for_layout', __('edit_user_edit_notification', true) . ' &mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        if ($this->data) {
            $this->data['User']['id'] = $this->Session->read('Auth.User.id');
            $this->Session->write('Auth.User.receive_weekly_newsletter', $this->data['User']['receive_weekly_newsletter']);
            $this->User->save($this->data, false); {
                $this->set('success', 1);
            }
        }
        $user = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('Auth.User.id'))));
        $this->data = $user;
        unset($this->data['User']['id']);
    }

    function check_password() {
        $this->layout = false;
        if ($this->data) {
            $user = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('Auth.User.id'))));
            if ($user != '') {
                if ($user['User']['is_facebook_user']) {  // by me for facebook users
                    echo "success";
                    exit;
                }
                if ($user['User']['passwd'] == Security::hash($this->data['User']['password'], null, true)) {
                    echo "success";
                    exit;
                } else {
                    $this->set('error', __('check_password_enter_right_password', true));
                }
            } else {
                $this->set('error', __('check_password_enter_right_password', true));
            }
        }
    }

    function email_verification() {
        $this->loadModel('Emaillog');
        $this->layout = false;
        $user = $this->User->findById($this->Session->read('Auth.User.id'));
        if (!empty($user)) {
            $this->data['User']['email_token'] = $this->User->RandomPasswordGenerator();
            $this->data['User']['id'] = $this->Session->read('Auth.User.id');
            $this->data['User']['email_token_expire'] = time() + (3600 * 168);
            if ($this->User->save($this->data, false)) {
                /*                 * **********save to email log start************** */
                $from = Configure::read('CONFIG_FROMNAME') . "<" . Configure::read('CONFIG_FROMEMAIL') . ">";
                $this->data['User']['name'] = $user['User']['name'];
                $subject = 'Email Verification';
                $to = $user['User']['email'];
                $body = 'Please verification your email by clicking on given link';
                $d['Emaillog']['email_to'] = $to;
                $d['Emaillog']['email_from'] = $from;
                $d['Emaillog']['email_type'] = 'I';
                $d['Emaillog']['subject'] = $subject;
                $d['Emaillog']['message'] = $body;
                $d['Emaillog']['active'] = '1';
                $d['Emaillog']['deleted'] = '0';
                $verify_email = Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'verify_email'), true) . '/' . $this->data['User']['email_token'];
                $this->set('verify_email', $verify_email);
                $replyTo = Configure::read('CONFIG_FROMEMAIL');
                $element = 'email_verification';
                if ($this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(), $attachments = "", $sendAs = 'html', $bcc = array())) {
                    $this->Emaillog->create();
                    $this->Emaillog->set($d);
                    $this->Emaillog->save();
                }
                /**                 * **********save to email log end************** */
                echo 'success';
                exit;
            }
        }
    }

    function verify_email($token = null) {
        $this->layout = false;
        if (!empty($token) && $token != null) {
            $this->User->recursive = -1;
            $user_info = $this->User->find('first', array('conditions' => array('User.email_token' => $token)));
            if (!empty($user_info) && $user_info['User']['email_token'] != '' && $user_info['User']['email_token_expire'] > time()) {
                $this->data['User']['email_authenticated'] = '1';
                $this->data['User']['id'] = $user_info['User']['id'];
                $this->data['User']['email_token'] = '';
                $this->data['User']['email_reset'] = '';
                if ($this->User->save($this->data, false)) {
                    $this->Session->write('email_session', 'success');
                    $this->Session->write('email_msg', __('edit_user_tnks_ur_email_address_verified', true));
                    $this->redirect(array('plugin' => false, 'controller' => 'home', 'action' => 'index'));
                }
            } else {
                $this->Session->write('email_session', 'error');
                $this->Session->write('email_msg', __('edit_user_sorry_email_cout_not_verified', true));
                $this->redirect(array('plugin' => false, 'controller' => 'home', 'action' => 'index'));
            }
        } else {
            $this->redirect(array('plugin' => false, 'controller' => 'home', 'action' => 'index'));
        }
    }

    function reset_email($token = null) {
        if (!empty($token) && $token != null) {
            $this->User->recursive = -1;
            $user_info = $this->User->find('first', array('conditions' => array('email_reset' => $token)));
            if ((!empty($user_info)) && $user_info['User']['email_reset'] != '' && ( time() < $user_info['User']['email_token_expire'])) {
                $this->data['User']['email_authenticated'] = '1';
                $this->data['User']['id'] = $user_info['User']['id'];
                $this->data['User']['email_token'] = '';
                $this->data['User']['email_reset'] = '';
                $this->data['User']['tmp_email'] = '';
                $this->data['User']['email'] = $user_info['User']['tmp_email'];
                if ($this->User->save($this->data, false)) {
                    $this->Session->write('email_session', 'success');
                    $this->Session->write('email_msg', __('edit_user_email_restore_successfully', true));
                    $this->redirect(array('plugin' => false, 'controller' => 'home', 'action' => 'index'));
                }
            } else {
                $this->Session->write('email_session', 'error');
                $this->Session->write('email_msg', __('edit_user_email_not_restore_successfully', true));
                $this->redirect(array('plugin' => false, 'controller' => 'home', 'action' => 'index'));
            }
        } else {
            $this->redirect(array('plugin' => false, 'controller' => 'home', 'action' => 'index'));
        }
    }

    function profile() {
        $userInfo = $this->User->findBySlug($this->params['slug']);
        if ($this->params['slug'] != $this->Session->read('Auth.User.slug')) {
            $this->set('title_for_layout', $userInfo['User']['name'] . sprintf(__('user_profile', true), "'s") . ' &mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        } else {
            $this->set('title_for_layout', __('my_profile', true) . ' &mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        }
        $this->load_more_project_content('backed', $this->params['slug']);
        if ($this->Session->check('project_success')) {
            $project_success = $this->Session->read('project_success');
            $project_success_msg = $this->Session->read('project_success_msg');
            $this->Session->delete('project_success');
            $this->Session->delete('project_success_msg');
            $this->set('project_success', $project_success);
            $this->set('project_success_msg', $project_success_msg);
        }
        /*         * Get Projects for each category created by user* */
        $this->Project->virtualFields = array('project_count' => 'COUNT(`Project`.`id`)');
        $this->Project->unbindModel(array('hasMany' => array('Backer', 'Reward', 'ProjectAskedQuestion')));
        $userCategoryProjetsCount = $this->Project->find('all', array('fields' => array('Project.id', 'Project.project_count', 'Category.category_name'), 'conditions' => array('Project.user_id' => $userInfo['User']['id'], 'Project.active' => '1'), 'group' => 'Project.category_id'));
        /*         * ***Data to be passed in the Pie chart**** */
        $chartData = array();
        if (count($userCategoryProjetsCount) > 0) {
            foreach ($userCategoryProjetsCount as $categoryData) {
                if ($categoryData['Project']['project_count'] > 0 && $categoryData['Category']['category_name'] != '') {
                    $chartData[$categoryData['Category']['category_name']] = array('value' => (int) $categoryData['Project']['project_count'], 'label' => $categoryData['Category']['category_name'], 'colour' => '#' . strtoupper(dechex(rand(0, 10000000))));
                }
            }
        }
        $this->set('chartData', $chartData);
        $total_backed_project = $this->Backer->find('count', array('conditions' => array('Backer.user_id' => $this->data['User']['id'])));
        $this->set('total_backed_project', $total_backed_project);
    }

    function created_projects() {
        
        $userInfo = $this->User->findBySlug($this->params['slug']);


        if ($this->params['slug'] != $this->Session->read('Auth.User.slug')) {
            $this->set('title_for_layout', $userInfo['User']['name'] . sprintf(__('profile_user_created_project', true), "'s") . ' &mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        } else {
            $this->set('title_for_layout', __('my_created_project', true) . ' &mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        }


        $this->load_more_project_content('created', $this->params['slug']);
        /*         * Get Projects for each category created by user* */
        $this->Project->virtualFields = array('project_count' => 'COUNT(`Project`.`id`)');
        $this->Project->unbindModel(array('hasMany' => array('Backer', 'Reward', 'ProjectAskedQuestion')));
        $userCategoryProjetsCount = $this->Project->find('all', array('fields' => array('Project.id', 'Project.project_count', 'Category.category_name'), 'conditions' => array('Project.user_id' => $userInfo['User']['id'], 'Project.active' => '1'), 'group' => 'Project.category_id'));
        /*         * ***Data to be passed in the Pie chart**** */
        $chartData = array();
        if (count($userCategoryProjetsCount) > 0) {
            foreach ($userCategoryProjetsCount as $categoryData) {
                if ($categoryData['Project']['project_count'] > 0 && $categoryData['Category']['category_name'] != '') {
                    $chartData[$categoryData['Category']['category_name']] = array('value' => (int) $categoryData['Project']['project_count'], 'label' => $categoryData['Category']['category_name'], 'colour' => '#' . strtoupper(dechex(rand(0, 10000000))));
                }
            }
        }
        $this->set('chartData', $chartData);
    }

    function load_more_project_content($type = 'created', $slug = null) {

        if (isset($this->params['named']['page'])) {
            $current_page = $this->params['named']['page'];
        } else {
            $current_page = 1;
        }
        $limit = Configure::read('CONFIG_PAGE_LIMIT');
        // $limit = 1;
        $page = $current_page;
        $page = $page - 1;
        $lt = $page * $limit;
        if ($type == 'created') {
            $this->data = $this->User->findBySlug($slug);
            $userloginId = $this->data['User']['id'];
            $conditions = array();
            $conditions[] = array('Project.user_id' => $userloginId);
            $login_user_slug = $this->Session->read('Auth.User.slug');
            if (($login_user_slug != $slug) || empty($login_user_slug)) {
                $conditions[] = array('Project.active' => 1);
                $conditions[] = array('Project.submitted_status' => 1);
                //  $conditions[]=array('Project.is_cancelled' => 0);
            }

            if ($this->data == '') {
                $this->_404error();
            }
            /*             * ***find country****** */

            //$userloginId = $this->Session->read('Auth.User.id');

            $total_records = $this->Project->find('count', array('conditions' => $conditions));
            $lastpage = ceil($total_records / $limit);
            $offset = '';
            if ($lt > 0) {
                $offset = $lt . ' , ';
            }
            $offset .= $limit;
            //$conditions = array('Project.user_id' => $userloginId);
            $data = $this->Project->find('all', array('limit' => $offset, 'conditions' => $conditions, 'order' => array('Project.created DESC')));
        }
        if ($type == 'backed') {
            $this->data = $this->User->findBySlug($slug);
            if ($this->data == '') {
                $this->_404error();
            }
            /*             * ***find country****** */
            /*  $country = $this->Country->find('first', array('conditions' => array('Country.iso3166_1' => $this->data['User']['country']), 'fields' => array('Country.name')));
              $this->data['User']['country'] = $country['Country']['name']; */

            $userloginId = $this->data['User']['id'];
            $total_records = $this->Backer->find('count', array('conditions' => array('Backer.user_id' => $userloginId)));
            $lastpage = ceil($total_records / $limit);
            $offset = '';
            if ($lt > 0) {
                $offset = $lt . ' , ';
            }
            $offset .= $limit;
            $conditions = array('Backer.user_id' => $userloginId);
            $this->Backer->recursive = 2;
            $backed_project = $this->Backer->find('list', array('fields' => array('project_id'), 'conditions' => array('Backer.user_id' => $userloginId), 'limit' => $offset));
            $project_cond = array('Project.id' => $backed_project);
            $data = $this->Project->find('all', array('conditions' => $project_cond, 'order' => array('Project.created DESC')));
        }
        if ($type == 'stared') {
            $this->loadModel('StaredProject');
            $this->data = $this->User->findBySlug($slug);
            if ($this->data == '') {
                $this->_404error();
            }
            $userloginId = $this->data['User']['id'];
            $conditions = array('StaredProject.user_id' => $userloginId);
            $total_records = $this->StaredProject->find('count', array('conditions' => $conditions));

            $lastpage = ceil($total_records / $limit);

            $offset = '';
            if ($lt > 0) {
                $offset = $lt . ' , ';
            }
            $offset .= $limit;

            /* $this->StaredProject->recursive = 2;

              $stared_project = $this->StaredProject->find('list', array('fields' => array('project_id'), 'conditions' =>$conditions, 'limit' => $offset)); */
            $this->StaredProject->recursive = 2;

            // $stared_project = $this->StaredProject->find('all', array('fields' => array('project_id'), 'conditions' =>$conditions, 'limit' => $offset));

            $data = $this->StaredProject->find('all', array(
                'limit' => $offset,
                'order' => 'StaredProject.id DESC',
                'conditions' => $conditions,
                'contain' => array(
                    'Project' => array(
                        'User' => array(
                            'fields' => array('id', 'name', 'slug')
                        ),
                        'Backer' => array(
                            'fields' => array('id', 'amount', 'user_id')
                        ),
                        'Reward' => array(
                            'fields' => array('id', 'pledge_amount')
                        ),
                        'Category' => array(
                            'fields' => array('id', 'category_name', 'slug')
                        ),
                        'fields' => array('Project.*')
                    ),
                ),
                    // 'fields'=>array('StaredProject.id')
            ));
            $this->set('slug', $slug);
        }

        /*         * ***condition for all the comments on all the projects realted to the profile user*** */

        if ($type == 'user_comments') {

            $this->loadModel('ProjectComment');
            $this->data = $this->User->findBySlug($slug);
            if ($this->data == '') {
                $this->_404error();
            }

            $this->data['User'] = $this->Session->read('Auth.User');
            $userloginId = $this->Session->read('Auth.User.id');
            //$user_project			=	$this->Project->find('all',array('fields'=>'Project.id,Project.title','conditions' => array('Project.user_id' => $userloginId)));
            //$user_comment_array	=	array();
            //pr($user_project);die;
            /* $project_id_array	=	array();
              for($i=0;$i<count($user_project);$i++)
              {
              $project_id_array[]	=	$user_project[$i]['Project']['id'];
              }

              $project_id_str		=	'0';
              if(is_array($project_id_array) && count($project_id_array)>0){
              sort($project_id_array);
              $project_id_str		=	implode(",",$project_id_array);
              }
             */

            $data = $this->ProjectComment->find('all', array('conditions' => array('ProjectComment.user_id' => $userloginId), 'order' => array('ProjectComment.created' => 'DESC')));


            //pr($data);

            /*
              $j=0;
              for($i=0;$i<count($user_project);$i++)
              {
              $comment	=	$this->ProjectComment->find('all',array('conditions' => array('ProjectComment.project_id' => $user_project[$i]['Project']['id']),'order'=>array('ProjectComment.created'=> 'ASC')));

              if(count($comment)>0)
              {
              for($ij=0;$ij<count($comment);$ij++)
              {
              $data[$j]	=	$comment[$ij]['ProjectComment'];
              $data[$j]['Project_Title']	=	$user_project[$i]['Project']['title'];
              $data[$j]['user_name']	=	$comment[$ij]['User']['name'];
              $data[$j]['user_slug']	=	$comment[$ij]['User']['slug'];
              $j++;
              }
              }
              }
             */
            $lastpage = count($data);
        }
        /*         * ***condition for all the comments on all the projects realted to the profile user*** */



        $this->set('projects', $data);
        $this->set('slug', $slug);
        $this->set('page', $current_page + 1);
        $this->set('last_page', $lastpage);
        $this->set('current_page', $current_page);
        $this->set('type', $type);
        if ($this->params['isAjax']) {
            echo $this->render('/elements/front/load_more_project_content');
            exit;
        }
    }

    function backed_projects() {
        $userInfo = $this->User->findBySlug($this->params['slug']);
        if ($this->params['slug'] != $this->Session->read('Auth.User.slug')) {
            $this->set('title_for_layout', sprintf(__('user_backer_history', true), $userInfo['User']['name'] . "'s") . '&mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        } else {
            $this->set('title_for_layout', __('my_backer_history', true) . '&mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        }

        $this->load_more_project_content('backed', $this->params['slug']);
        if ($this->Session->check('project_success')) {
            $project_success = $this->Session->read('project_success');
            $project_success_msg = $this->Session->read('project_success_msg');
            $this->Session->delete('project_success');
            $this->Session->delete('project_success_msg');
            $this->set('project_success', $project_success);
            $this->set('project_success_msg', $project_success_msg);
        }
        /** Get Projects for each category created by user **/
        $this->Project->virtualFields = array('project_count' => 'COUNT(`Project`.`id`)');
        $this->Project->unbindModel(array('hasMany' => array('Backer', 'Reward', 'ProjectAskedQuestion')));
        $userCategoryProjetsCount = $this->Project->find('all', array('fields' => array('Project.id', 'Project.project_count', 'Category.category_name'), 'conditions' => array('Project.user_id' => $userInfo['User']['id'], 'Project.active' => '1'), 'group' => 'Project.category_id'));
        /*         * ***Data to be passed in the Pie chart**** */
        $chartData = array();
        if (count($userCategoryProjetsCount) > 0) {
            foreach ($userCategoryProjetsCount as $categoryData) {
                if ($categoryData['Project']['project_count'] > 0 && $categoryData['Category']['category_name'] != '') {
                    $chartData[$categoryData['Category']['category_name']] = array('value' => (int) $categoryData['Project']['project_count'], 'label' => $categoryData['Category']['category_name'], 'colour' => '#' . strtoupper(dechex(rand(0, 10000000))));
                }
            }
        }
        $this->set('chartData', $chartData);
    }

    function user_comments() {
        $userInfo = $this->User->findBySlug($this->params['slug']);
        $this->data = $userInfo;

        $result = $this->load_user_comments($this->params['slug']);
        $this->set('user_comments', $result['result']);

        $this->set('page', $result['page']);
        $this->set('slug', $this->params['slug']);
        $this->set('last_page', $result['last_page']);
        $this->set('current_page', $result['current_page']);
        if ($this->params['isAjax']) {
            echo $this->render('/elements/front/load_more_user_comment');
            exit;
        }
        /*         * Get Projects for each category created by user* */

        $this->Project->virtualFields = array('project_count' => 'COUNT(`Project`.`id`)');
        $this->Project->unbindModel(array('hasMany' => array('Backer', 'Reward', 'ProjectAskedQuestion')));
        $userCategoryProjetsCount = $this->Project->find('all', array('fields' => array('Project.id', 'Project.project_count', 'Category.category_name'), 'conditions' => array('Project.user_id' => $userInfo['User']['id'], 'Project.active' => '1'), 'group' => 'Project.category_id'));
        /*         * ***Data to be passed in the Pie chart**** */
        $chartData = array();
        if (count($userCategoryProjetsCount) > 0) {
            foreach ($userCategoryProjetsCount as $categoryData) {
                if ($categoryData['Project']['project_count'] > 0 && $categoryData['Category']['category_name'] != '') {
                    $chartData[$categoryData['Category']['category_name']] = array('value' => (int) $categoryData['Project']['project_count'], 'label' => $categoryData['Category']['category_name'], 'colour' => '#' . strtoupper(dechex(rand(0, 10000000))));
                }
            }
        }
        $this->set('chartData', $chartData);

        //	pr($comment_list); exit;
        $this->set('title_for_layout', __('Comments', true) . '&mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        $total_backed_project = $this->Backer->find('count', array('conditions' => array('Backer.user_id' => $this->data['User']['id'])));
        $this->set('total_backed_project', $total_backed_project);
    }

    function load_user_comments($slug) {
        $this->loadModel('ProjectComment');
        if (isset($this->params['named']['page'])) {
            $current_page = $this->params['named']['page'];
        } else {
            $current_page = 1;
        }
        $limit = Configure::read('CONFIG_PROJECT_LISTING');
        $page = $current_page;
        $page = $page - 1;
        $lt = $page * $limit;
        $this->data = $this->User->findBySlug($slug);
        if ($this->data == '') {
            $this->_404error();
        }
        $userloginId = $this->data['User']['id'];
        $conditions = array('ProjectComment.user_id' => $userloginId);
        $total_records = $this->ProjectComment->find('count', array('conditions' => $conditions));
        $lastpage = ceil($total_records / $limit);
        $offset = '';
        if ($lt > 0) {
            $offset = $lt . ' , ';
        }
        $offset .= $limit;
        $data = $this->ProjectComment->find('all', array('limit' => $offset, 'conditions' => $conditions, 'order' => array('ProjectComment.created DESC')));

        $return_array['result'] = $data;
        $return_array['page'] = $current_page + 1;
        $return_array['last_page'] = $lastpage;
        $return_array['current_page'] = $current_page;
        $return_array['current_page'] = $current_page;
        $return_array['total_result'] = $total_records;
        return $return_array;
        exit;
    }

    function backed_history() {
        
        $this->data['User'] = $this->Session->read('Auth.User');
        $this->params['slug'] = $this->data['User']['slug'];

        $country = $this->Country->find('first', array('conditions' => array('Country.iso3166_1' => $this->data['User']['country']), 'fields' => array('Country.name')));
        $this->data['User']['country'] = $country['Country']['name'];
        $result = $this->load_backed_history();
        
        // to show notification
        if ($this->Session->check('project_success')) {
            $project_success = $this->Session->read('project_success');
            $project_success_msg = $this->Session->read('project_success_msg');
            $this->Session->delete('project_success');
            $this->Session->delete('project_success_msg');
            $this->set('project_success', $project_success);
            $this->set('project_success_msg', $project_success_msg);
        }

        // $this->set('title_for_layout', __('my_backer_history', true));
        $this->set('title_for_layout', __('manage_your_pledge', true));
        $this->set('project_backers', $result['result']);
        $this->set('page', $result['page']);
        $this->set('last_page', $result['last_page']);
        $this->set('current_page', $result['current_page']);
        if ($this->params['isAjax']) {
            echo $this->render('/elements/front/backer_history');
            exit;
        }
    }

    function load_backed_history() {
        if (isset($this->params['named']['page'])) {
            $current_page = $this->params['named']['page'];
        } else {
            $current_page = 1;
        }
        $limit = Configure::read('CONFIG_PROJECT_LISTING');
        $page = $current_page;
        $page = $page - 1;
        $lt = $page * $limit;
        $userloginId = $this->data['User']['id'];
        $total_records = $this->Backer->find('count', array('conditions' => array('Backer.user_id' => $userloginId)));
        $lastpage = ceil($total_records / $limit);
        $offset = '';
        if ($lt > 0) {
            $offset = $lt . ' , ';
        }
        $offset .= $limit;
        $conditions = array('Backer.user_id' => $userloginId);
        $this->Backer->recursive = 2;
        $backed_project = $this->Backer->find('list', array('fields' => array('project_id'), 'conditions' => array('Backer.user_id' => $userloginId), 'limit' => $offset));
        $data = $this->Backer->find('all', array(
            'conditions' => array('Backer.user_id' => $userloginId),
            'contain' => array(
                'Project' => array(
                    'User' => array(
                        'fields' => array('id', 'name', 'slug')
                    ),
                    'Backer' => array(
                        'fields' => array('id', 'amount')
                    ),
                    'Category' => array(
                        'fields' => array('id', 'category_name', 'slug')
                    ),
                    'fields' => array('Project.id', 'Project.title', 'Project.slug', 'Project.image', 'Project.project_country', 'Project.project_end_date', 'Project.project_country_json', 'Project.funding_goal', 'Project.short_description', 'Project.is_funded', 'Project.is_successful', 'Project.is_cancelled'),
                ),
                'Reward' => array(
                    'fields' => array('Reward.pledge_amount')
                )
            ),
            'order' => 'Backer.created DESC',
            'limit' => $offset,
        ));

        $return_array['result'] = $data;
        $return_array['page'] = $current_page + 1;
        $return_array['last_page'] = $lastpage;
        $return_array['current_page'] = $current_page;
        $return_array['current_page'] = $current_page;
        $return_array['total_result'] = $total_records;
        return $return_array;
    }

    function starred_projects() {
        $userInfo = $this->User->findBySlug($this->params['slug']);
        if ($this->params['slug'] != $this->Session->read('Auth.User.slug')) {
            $this->set('title_for_layout', sprintf(__('profile_stared_user_stared_project', true), $userInfo['User']['name'] . "'s") . '&mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        } else {
            $this->set('title_for_layout', __('profile_stared_my_stared_project', true) . ' &mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        }
        if ($this->Session->check('project_success')) {
            $project_success = $this->Session->read('project_success');
            $project_success_msg = $this->Session->read('project_success_msg');
            $this->Session->delete('project_success');
            $this->Session->delete('project_success_msg');
            $this->set('project_success', $project_success);
            $this->set('project_success_msg', $project_success_msg);
        }

        $this->load_more_project_content('stared', $this->params['slug']);
        /*         * Get Projects for each category created by user* */
        $this->Project->virtualFields = array('project_count' => 'COUNT(`Project`.`id`)');
        $this->Project->unbindModel(array('hasMany' => array('Backer', 'Reward', 'ProjectAskedQuestion')));
        $userCategoryProjetsCount = $this->Project->find('all', array('fields' => array('Project.id', 'Project.project_count', 'Category.category_name'), 'conditions' => array('Project.user_id' => $userInfo['User']['id'], 'Project.active' => '1'), 'group' => 'Project.category_id'));
        /*         * ***Data to be passed in the Pie chart**** */
        $chartData = array();
        if (count($userCategoryProjetsCount) > 0) {
            foreach ($userCategoryProjetsCount as $categoryData) {
                if ($categoryData['Project']['project_count'] > 0 && $categoryData['Category']['category_name'] != '') {
                    $chartData[$categoryData['Category']['category_name']] = array('value' => (int) $categoryData['Project']['project_count'], 'label' => $categoryData['Category']['category_name'], 'colour' => '#' . strtoupper(dechex(rand(0, 10000000))));
                }
            }
        }
        $this->set('chartData', $chartData);
    }

    function facebook_disconnect() {

        $this->layout = false;

        $this->autoRender = false;
        $this->loadModel('Emaillog');
        $this->User->id = $this->Session->read('Auth.User.id');
        $this->User->saveField('facebook_id', '');
        $this->Session->write('Auth.User.facebook_id', '');
        $this->Session->delete('fb_logged_in_cus');
        $this->FB = new FB();
        $this->FB->api('/me/permissions', 'DELETE');

        $from = Configure::read('CONFIG_FROMNAME') . "<" . Configure::read('CONFIG_FROMEMAIL') . ">";
        $to = $this->Session->read('Auth.User.email');
        $user_id = $this->Session->read('Auth.User.id');
        $subject = 'Your Facebook account has been disconnected.';
        $this->Email->to = $to;
        $this->UserFollow->deleteAll(array('UserFollow.user_id' => $user_id));
        $this->UserFollow->deleteAll(array('UserFollow.follow_user_id' => $user_id));
        $from = Configure::read('CONFIG_FROMNAME') . "<" . Configure::read('CONFIG_FROMEMAIL') . ">";
        $this->Email->template = "facebook_disconnect";
        $this->Email->sendAs = 'html';
        $this->Email->subject = $subject;
        $this->Email->from = $from;

        $body = 'Facebook account disconnected.';
        $d['Emaillog']['email_to'] = $to;
        $d['Emaillog']['email_from'] = $from;
        $d['Emaillog']['email_type'] = 'I';
        $d['Emaillog']['subject'] = $subject;
        $d['Emaillog']['message'] = $body;
        $d['Emaillog']['active'] = '1';
        $d['Emaillog']['deleted'] = '0';
        if ($this->Email->send()) {
            $this->Emaillog->create();
            $this->Emaillog->set($d);
            $this->Emaillog->save();
            $this->Email->reset();
        }
        echo $this->referer();
        exit;
    }

    function blocked() {
        $user = $this->Session->read('Auth.User');
        if (empty($user['facebook_id'])) {
            echo $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'find_friends'));
            exit;
        }
        if (($user['is_opt_out'])) {
            echo $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'find_friends'));
            exit;
        }
        $contain_fields = array('UserFollow.follow_user_id', 'UserFollow.follow_user_id');
        $following_friends = $this->CommonFunction->get_user_followings($user['id'], 'list', $contain_fields); // get list of user which I follow
        $blocked_user_contain_fields = array('BlockedUser.blocked_user_id', 'BlockedUser.blocked_user_id');
        $blocked_users_list = $this->CommonFunction->get_user_blocked_users_list($user['id'], 'list', $blocked_user_contain_fields);
        $conditions = array('BlockedUser.user_id' => $user['id']);
        $this->get_loading('BlockedUser', $conditions, 'BlockedUser.id DESC', 'following_users', 1);
        $this->set('following_friends', $following_friends);
        $this->set('title_for_layout', __('find_friend_get_social', true) . ' &raquo; ' . __('get_social_right_pannel_blocked', true) . ' &mdash;' . ' ' . Configure::read('CONFIG_SITE_TTILE'));
        $this->set('blocked_users_list', $blocked_users_list);
        if ($this->params['isAjax']) {
            echo $this->render('/elements/front/load_following_friends');
            exit;
        }
    }

    function block($user_slug = null) {
        $this->layout = 'ajax';
        $this->autoRender = false;
        if ($user_slug == '' || empty($user_slug) || is_null($user_slug)) {
            $this->_404error();
        }
        $user = $this->Session->read('Auth.User');
        $get_user_info = $this->User->find('first', array('conditions' => array('User.slug' => $user_slug), 'fields' => array('User.id')));
        if (empty($get_user_info)) {
            $this->_404error();
        }
        if (!empty($get_user_info)) {
            $check_is_already_blocked = $this->BlockedUser->find('all', array('conditions' => array('BlockedUser.blocked_user_id' => $get_user_info['User']['id'], 'BlockedUser.user_id' => $user['id']), 'fields' => array('BlockedUser.id')));
            if (empty($check_is_already_blocked)) {
                $user_block['BlockedUser']['user_id'] = $user['id'];
                $user_block['BlockedUser']['blocked_user_id'] = $get_user_info['User']['id'];
                $this->BlockedUser->save($user_block);
                $this->BlockedUser->create();
                // delete user from my followings
                $get_user_following = $this->UserFollow->find('first', array('conditions' => array('UserFollow.user_id' => $user['id'], 'UserFollow.follow_user_id' => $get_user_info['User']['id'])));
                if (!empty($get_user_following['UserFollow']['id'])) {
                    $this->UserFollow->id = $get_user_following['UserFollow']['id'];
                    $this->UserFollow->delete();
                }
                // delete me from user followers list
                $get_user_follower = $this->UserFollow->find('first', array('conditions' => array('UserFollow.user_id' => $get_user_info['User']['id'], 'UserFollow.follow_user_id' => $user['id'])));
                if (!empty($get_user_follower['UserFollow']['id'])) {
                    $this->UserFollow->id = $get_user_follower['UserFollow']['id'];
                    $this->UserFollow->delete();
                }
            }
        }
        if ($this->RequestHandler->isAjax()) {
            echo Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'unblock', $user_slug));
            exit;
        } else {

            $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'blocked'));
        }
    }

    function unblock($user_slug = null) {
        $this->layout = 'ajax';
        $this->autoRender = false;
        if ($user_slug == '' || empty($user_slug) || is_null($user_slug)) {
            $this->_404error();
        }
        $user = $this->Session->read('Auth.User');
        $get_user_info = $this->User->find('first', array('conditions' => array('User.slug' => $user_slug), 'fields' => array('User.id')));
        if (empty($get_user_info)) {
            $this->_404error();
        }
        if (!empty($get_user_info)) {
            $check_is_already_blocked = $this->BlockedUser->find('first', array('conditions' => array('BlockedUser.blocked_user_id' => $get_user_info['User']['id'], 'BlockedUser.user_id' => $user['id']), 'fields' => array('BlockedUser.id')));
            if (!empty($check_is_already_blocked)) {
                $this->BlockedUser->id = $check_is_already_blocked['BlockedUser']['id'];
                $this->BlockedUser->delete();
            }
        }
        if ($this->RequestHandler->isAjax()) {
            echo Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'follow', $user_slug));
            exit;
        } else {
            $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'blocked'));
        }
    }

    function opt_in() {
        $user = $this->Session->read('Auth.User');
        $this->User->id = $user['id'];
        $this->User->saveField('is_opt_out', 0);
        $this->Session->write('Auth.User.is_opt_out', 0);
        $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'find_friends'));
    }

    function set_opt_out() {
        $this->autoRender = false;
        $this->layout = false;
        $user = $this->Session->read('Auth.User');
        $this->User->id = $user['id'];
        $this->User->saveField('is_opt_out', 1);
        $this->Session->write('Auth.User.is_opt_out', 1);
        /* IF set opt out then delete all followings and followers* */
        $this->UserFollow->deleteAll(array('UserFollow.user_id' => $user['id']));
        $this->UserFollow->deleteAll(array('UserFollow.follow_user_id' => $user['id']));
        /* Delete entries from notification for my followings and if some one followed me */
        $this->Notification->deleteAll(array('Notification.user_id' => $user['id'], 'Notification.notification_type' => 'follow', 'Notification.subject_type' => 'user'));
        $this->Notification->deleteAll(array('Notification.notification_type' => 'follow', 'Notification.subject_type' => 'user', 'Notification.subject_id' => $user['id']));
        echo Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'find_friends'), true);
    }

    function activity() {

        $this->loadModel('Country');
        $this->data = $this->User->findBySlug($this->params['slug']);
        if ($this->data == '') {
            $this->_404error();
        }
        /*         * ***find country****** */
        $country = $this->Country->find('first', array('conditions' => array('Country.iso3166_1' => $this->data['User']['country']), 'fields' => array('Country.name')));
        $this->data['User']['country'] = $country['Country']['name'];
        /*         * ***find country end****** */
        /*         * * Set Success Message */
        if ($this->Session->check('project_success')) {
            $project_success = $this->Session->read('project_success');
            $project_success_msg = $this->Session->read('project_success_msg');
            $this->Session->delete('project_success');
            $this->Session->delete('project_success_msg');
            $this->set('project_success', $project_success);
            $this->set('project_success_msg', $project_success_msg);
        }


        //$this->set('title_for_layout', $this->data['User']['name'] . ' &raquo; ' . sprintf(__('my_profile', true), "'s") . ' &mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        if ($this->params['slug'] != $this->Session->read('Auth.User.slug')) {
            $this->set('title_for_layout', $this->data['User']['name'] . sprintf(__('user_profile', true), "'s") . ' &mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        } else {
            $this->set('title_for_layout', __('recent_activity', true) . ' &mdash; ' . Configure::read('CONFIG_SITE_TITLE'));
        }
        $conditions = array('UserActivity.user_id' => $this->data['User']['id']);
        $this->get_loading('UserActivity', $conditions, 'UserActivity.id DESC', 'user_activities');

        /*         * Get Projects for each category created by user* */
        $this->Project->virtualFields = array('project_count' => 'COUNT(`Project`.`id`)');
        $this->Project->unbindModel(array('hasMany' => array('Backer', 'Reward', 'ProjectAskedQuestion')));
        $userCategoryProjetsCount = $this->Project->find('all', array('fields' => array('Project.id', 'Project.project_count', 'Category.category_name'), 'conditions' => array('Project.user_id' => $this->data['User']['id'], 'Project.active' => '1'), 'group' => 'Project.category_id'));
        /*         * ***Data to be passed in the Pie chart**** */
        $chartData = array();
        if (count($userCategoryProjetsCount) > 0) {
            foreach ($userCategoryProjetsCount as $categoryData) {
                if ($categoryData['Project']['project_count'] > 0 && $categoryData['Category']['category_name'] != '') {
                    $chartData[$categoryData['Category']['category_name']] = array('value' => (int) $categoryData['Project']['project_count'], 'label' => $categoryData['Category']['category_name'], 'colour' => '#' . strtoupper(dechex(rand(0, 10000000))));
                }
            }
        }
        $this->set('chartData', $chartData);
    }

    function delete_user_account() 
    {
        
        $this->layout = 'project';
        $this->set('title_for_layout', __('delete_account', true));
        if ($this->data) 
        {
            if ($this->data['User']['password'] != $this->Session->read('Auth.User.password_token')) 
            {
                $this->set('invalid_password', '1');
            } 
            else 
            {
                $this->User->id = $this->Session->read('Auth.User.id');
                $user_id = $this->Session->read('Auth.User.id');
                $user_info = $this->Session->read('Auth.User');
                $user_projects = $this->Project->find('all', array('conditions' => array('Project.user_id' => $user_id, 'Project.active' => 1, 'Project.is_successful' => 0)));
                
                // HOANGADD 04072014
                // retrieves all projects of current user
                $projects_current_user = $this->Project->find('all', array('conditions' => array('Project.user_id' => $user_id, 'Project.active' => 1, 'Project.is_successful' => 0), 'fields' => array('Project.project_end_date', 'Project.user_id', 'Project.id', 'Project.funding_goal', 'Project.is_cancelled')));
                
                foreach ($projects_current_user as $project_current_user)
                {                    
                    if($project_current_user['Project']['project_end_date'] > time() && $project_current_user['Project']['is_cancelled'] == 0)
                    {
                        $this->Project->updateAll(array("is_cancelled" => 1), array( 'Project.id' => $project_current_user['Project']['id'], 'Project.user_id' => $project_current_user['Project']['user_id'], 'Project.active' => 1, 'Project.is_successful' => 0));
                    }   
                    
                    if($project_current_user['Project']['funding_goal'] > $this->Project->get_total_pledge_amount($project_current_user['Backer']) && $project_current_user['Project']['project_end_date'] < time() ||  $project_current_user['Project']['project_end_date'] > time())
                    {
                        $this->Backer->updateAll(array("is_cancelled" => 1), array('Backer.project_id' => $project_current_user['Project']['id']));
                    }
                }
                
               
                
                
                // list all backers
                $backers = $this->Backer->find('all', array('conditions' => array('Backer.project_id' => $user_projects)));
                
                foreach ($backers as $backer) 
                {
                    $this->Notification->create_noti($backer['User']['id'], 'project_cancelled', $backer['Project']['id']);
                    $backer = $this->User->findById($backer['user_id']);
                    $to = $backer["User"]["email"];
                    $this->set("backer", $backer);
                    $this->set("project", $backer['Project']);
                    $element = "project_cancellation_to_backer_1";
                    $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(), $attachments = "", $sendAs = "html", $bcc = array());
                }
                $user_update_array = array();
                $user_update_array['User']['id'] = $user_id;
                $user_update_array['User']['is_opt_out'] = 1;
                $user_update_array['User']['is_deleted'] = 1;
                $user_update_array['User']['is_login'] = 0;
                $this->User->save($user_update_array, false);
                $this->set('user_info', $user_info);
                $to = $user_info['email'];
                $subject = Configure::read("CONFIG_SITE_TITLE") . ' Account Deactivated';
                $element = 'user_account_deleted';
                $replyTo = '';
                $from = Configure::read('CONFIG_FROMNAME') . "<" . Configure::read('CONFIG_FROMEMAIL') . ">";
                $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(), $attachments = "", $sendAs = 'html', $bcc = array());

                $this->Session->delete('fb_logged_in_cus');
                $this->Session->delete('login_redirect');
                $this->Session->delete('redirect_to');
                $this->Auth->logout();
                $this->Session->write('email_session', 'success');
                $this->Session->write('email_msg', __('account_delete_message', true));
                $this->redirect(array('plugin' => false, 'controller' => 'home', 'action' => 'index'));
            }
        }
    }

}
