<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/systemdocs/*", array( "plugin" => "systemdocs", "controller" => "systemdocs", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/add_doc/*", array( "plugin" => "systemdocs", "controller" => "systemdocs", "action" => "add_doc", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete_doc/*", array( "plugin" => "systemdocs", "controller" => "systemdocs", "action" => "delete_doc", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/download_doc/*", array( "plugin" => "systemdocs", "controller" => "systemdocs", "action" => "download_doc", $Routingprefix => true ));
    }
}




?>