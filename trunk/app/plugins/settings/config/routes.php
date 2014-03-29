<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/settings/get_cities/*", array( "plugin" => "settings", "controller" => "settings", "action" => "get_cities", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/settings/*", array( "plugin" => "settings", "controller" => "settings", "action" => "index", $Routingprefix => true ));
    }
}




?>