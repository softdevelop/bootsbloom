<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/backups/*", array( "plugin" => "backups", "controller" => "backups", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/backup/*", array( "plugin" => "backups", "controller" => "backups", "action" => "backup", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete_backup/*", array( "plugin" => "backups", "controller" => "backups", "action" => "delete_backup", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/download_backup/*", array( "plugin" => "backups", "controller" => "backups", "action" => "download_backup", $Routingprefix => true ));
    }
}
