<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/reset-password/*", array( "plugin" => "users", "controller" => "users", "action" => "reset_password", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/recover-password", array( "plugin" => "users", "controller" => "users", "action" => "recover_password", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/user-backed-project/*", array( "plugin" => "users", "controller" => "users", "action" => "user_backed_project", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/fblogin", array( "plugin" => "users", "controller" => "users", "action" => "fblogin", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/login", array( "plugin" => "users", "controller" => "users", "action" => "login", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/operate/*", array( "plugin" => "users", "controller" => "users", "action" => "operate", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/dashboard", array( "plugin" => "users", "controller" => "users", "action" => "dashboard", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/edit/*", array( "plugin" => "users", "controller" => "users", "action" => "edit", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/delete/*", array( "plugin" => "users", "controller" => "users", "action" => "delete", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/add/*", array( "plugin" => "users", "controller" => "users", "action" => "add_user", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/status/*", array( "plugin" => "users", "controller" => "users", "action" => "status_update", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/total_users/*", array( "plugin" => "users", "controller" => "users", "action" => "total_users", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/logout/*", array( "plugin" => "users", "controller" => "users", "action" => "logout", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/idealogout/*", array( "plugin" => "users", "controller" => "users", "action" => "idealogout", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/status_update/*", array( "plugin" => "users", "controller" => "users", "action" => "status_update", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/myaccount/*", array( "plugin" => "users", "controller" => "users", "action" => "myaccount", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/users_dashboard/*", array( "plugin" => "users", "controller" => "users", "action" => "users_dashboard", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/a_users", array( "plugin" => "users", "controller" => "users", "action" => "a_users", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/recover_account/*", array( "plugin" => "users", "controller" => "users", "action" => "recover_account", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix, array( "plugin" => "users", "controller" => "users", "action" => "login", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/users/*", array( "plugin" => "users", "controller" => "users", "action" => "index", $Routingprefix => true ));
        Router::connect("/users/signup", array( "plugin" => "users", "controller" => "users", "action" => "signup" ));
        Router::connect("/users/fblogin", array( "plugin" => "users", "controller" => "users", "action" => "fblogin" ));
        Router::connect("/users/forgot-password", array( "plugin" => "users", "controller" => "users", "action" => "forgot_password" ));
        Router::connect("/users/reset-password/*", array( "plugin" => "users", "controller" => "users", "action" => "reset_password" ));
        Router::connect("/users/verify-email/*", array( "plugin" => "users", "controller" => "users", "action" => "verify_email" ));
        Router::connect("/users/reset-email/*", array( "plugin" => "users", "controller" => "users", "action" => "reset_email" ));
        Router::connect("/users/verify-email/*", array( "plugin" => "users", "controller" => "users", "action" => "verify_email" ));
        Router::connect("/users/login", array( "plugin" => "users", "controller" => "users", "action" => "login" ));
        Router::connect("/users/logout", array( "plugin" => "users", "controller" => "users", "action" => "logout" ));
        Router::connect("/users/idealogout", array( "plugin" => "users", "controller" => "users", "action" => "idealogout" ));
        Router::connect("/users/ideallogin", array( "plugin" => "users", "controller" => "users", "action" => "ideallogin" ));
        Router::connect("/users/profile/:slug", array( "plugin" => "users", "controller" => "users", "action" => "profile" ));
        Router::connect("/users/activity/:slug", array( "plugin" => "users", "controller" => "users", "action" => "activity" ));
        Router::connect("/users/edit-profile", array( "plugin" => "users", "controller" => "users", "action" => "edit_profile" ));
        Router::connect("/users/add-image", array( "plugin" => "users", "controller" => "users", "action" => "add_image" ));
        Router::connect("/users/remove-image", array( "plugin" => "users", "controller" => "users", "action" => "remove_image" ));
        Router::connect("/users/save-profile", array( "plugin" => "users", "controller" => "users", "action" => "save_profile" ));
        Router::connect("/users/account-setting/*", array( "plugin" => "users", "controller" => "users", "action" => "account_setting" ));
        Router::connect("/users/profile-notification/*", array( "plugin" => "users", "controller" => "users", "action" => "profile_notification" ));
        Router::connect("/users/check-password", array( "plugin" => "users", "controller" => "users", "action" => "check_password" ));
        Router::connect("/users/update_profile_image/*", array( "plugin" => "users", "controller" => "users", "action" => "update_profile_image" ));
        Router::connect("/users/facebook_disconnect", array( "plugin" => "users", "controller" => "users", "action" => "facebook_disconnect" ));
        Router::connect("/users/created-projects/:slug/*", array( "plugin" => "users", "controller" => "users", "action" => "created_projects" ));
        Router::connect("/users/backed-projects/:slug/*", array( "plugin" => "users", "controller" => "users", "action" => "backed_projects" ));
        Router::connect("/users/user-comments/:slug/*", array( "plugin" => "users", "controller" => "users", "action" => "user_comments" ));
        Router::connect("/users/starred-projects/:slug/*", array( "plugin" => "users", "controller" => "users", "action" => "starred_projects" ));
        Router::connect("/users/transaction/*", array( "plugin" => "users", "controller" => "users", "action" => "backed_history" ));
        Router::connect("/friends/blocked/*", array( "plugin" => "users", "controller" => "users", "action" => "blocked" ));
        Router::connect("/delete-account/*", array( "plugin" => "users", "controller" => "users", "action" => "delete_user_account" ));
    }
}
