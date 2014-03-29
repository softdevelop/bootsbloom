<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/emaillogs", array( "plugin" => "emaillogs", "controller" => "emaillogs", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete_email/*", array( "plugin" => "emaillogs", "controller" => "emaillogs", "action" => "delete_email", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/view_email/*", array( "plugin" => "emaillogs", "controller" => "emaillogs", "action" => "view_email", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/utilities_dashboard/*", array( "plugin" => "emaillogs", "controller" => "emaillogs", "action" => "utilities_dashboard", $Routingprefix => true ));
    }
}
