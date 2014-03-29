<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/curatedpages", array( "plugin" => "partners", "controller" => "partners", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/add_curatedpages/*", array( "plugin" => "partners", "controller" => "partners", "action" => "add_partner", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/edit_curatedpages/*", array( "plugin" => "partners", "controller" => "partners", "action" => "edit_partner", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/change_curatedpage_status/*", array( "plugin" => "partners", "controller" => "partners", "action" => "change_partner_status", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete_curatedpage/*", array( "plugin" => "partners", "controller" => "partners", "action" => "delete_partner", $Routingprefix => true ));
    }
}




?>