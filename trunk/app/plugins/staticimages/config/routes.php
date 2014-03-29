<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/staticimages/*", array( "plugin" => "staticimages", "controller" => "staticimages", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/add_image/*", array( "plugin" => "staticimages", "controller" => "staticimages", "action" => "add_image", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete_image/*", array( "plugin" => "staticimages", "controller" => "staticimages", "action" => "delete_image", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/download_image/*", array( "plugin" => "staticimages", "controller" => "staticimages", "action" => "download_image", $Routingprefix => true ));
    }
}




?>