<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/pages/*", array( "plugin" => "pages", "controller" => "pages", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/add_page/*", array( "plugin" => "pages", "controller" => "pages", "action" => "add_page", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/edit_page/*", array( "plugin" => "pages", "controller" => "pages", "action" => "edit_page", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete-page/*", array( "plugin" => "pages", "controller" => "pages", "action" => "delete_page", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/change_status/*", array( "plugin" => "pages", "controller" => "pages", "action" => "change_status", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/add_page_fr/*", array( "plugin" => "pages", "controller" => "pages", "action" => "add_page_fr", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/edit_page_fr/*", array( "plugin" => "pages", "controller" => "pages", "action" => "edit_page_fr", $Routingprefix => true ));
        Router::connect("/display/*", array( "plugin" => "pages", "controller" => "pages", "action" => "display" ));
        Router::connect("/contact_us/*", array( "plugin" => "pages", "controller" => "pages", "action" => "contact_us" ));
    }
}
