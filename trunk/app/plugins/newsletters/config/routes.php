<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/newsletters", array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/add_newsletter/*", array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "add_newsletter", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/edit_newsletter/*", array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "edit_newsletter", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete_newsletter/*", array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "delete_newsletter", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/change_newsletter_status/*", array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "change_newsletter_status", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/send_mail/*", array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "send_mail", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/newsletters_dashboard/*", array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "newsletters_dashboard", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/newsletters/operate/*", array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "operate", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/subscribers", array( "plugin" => "newsletters", "controller" => "subscribers", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/add_subscriber/*", array( "plugin" => "newsletters", "controller" => "subscribers", "action" => "add_subscriber", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/edit_subscriber/*", array( "plugin" => "newsletters", "controller" => "subscribers", "action" => "edit_subscriber", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete_subscriber/*", array( "plugin" => "newsletters", "controller" => "subscribers", "action" => "delete_subscriber", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/change_subscriber_status/*", array( "plugin" => "newsletters", "controller" => "subscribers", "action" => "change_subscriber_status", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/subscriber_send_mail/*", array( "plugin" => "newsletters", "controller" => "subscribers", "action" => "subscriber_send_mail", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/subscribers/operate/*", array( "plugin" => "newsletters", "controller" => "subscribers", "action" => "operate", $Routingprefix => true ));
    }
}

Router::connect("/newsletters/subscribe_newsletter", array( "plugin" => "newsletters", "controller" => "subscribers", "action" => "subscribe_newsletter" ));
Router::connect("/newsletters/get_latest_newsletter", array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "get_latest_newsletter" ));
Router::connect("/newsletters/newsletter_detail/*", array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "newsletter_detail" ));
Router::connect("/newsletters/*", array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "newsletters" ));



?>