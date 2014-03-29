<?php 
//
// This source code was recovered by Recover-PHP.com
//

Router::connect("/report_spam/*", array( "plugin" => "messages", "controller" => "messages", "action" => "report_spam" ));
Router::connect("/set_as_spam/*", array( "plugin" => "messages", "controller" => "messages", "action" => "reportspam" ));
Router::connect("/latestmessages", array( "plugin" => "messages", "controller" => "messages", "action" => "getrecent" ));
Router::connect("/sendmessage/*", array( "plugin" => "messages", "controller" => "messages", "action" => "send_message" ));
Router::connect("/messages/*", array( "plugin" => "messages", "controller" => "messages", "action" => "index" ));
$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
    }
}




?>