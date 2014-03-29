<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/categories/add_category/*", array( "plugin" => "categories", "controller" => "categories", "action" => "add_category", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/categories/edit/*", array( "plugin" => "categories", "controller" => "categories", "action" => "edit", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/categories/delete/*", array( "plugin" => "categories", "controller" => "categories", "action" => "delete", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/categories/archive", array( "plugin" => "categories", "controller" => "categories", "action" => "archive_categories", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/categories/status/*", array( "plugin" => "categories", "controller" => "categories", "action" => "status_update", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/categories/total_categories/*", array( "plugin" => "categories", "controller" => "categories", "action" => "total_categories", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/categories/operate/*", array( "plugin" => "categories", "controller" => "categories", "action" => "operate", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/categories/index/*", array( "plugin" => "categories", "controller" => "categories", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/categories/*", array( "plugin" => "categories", "controller" => "categories", "action" => "index", $Routingprefix => true ));
        Router::connect("/categories/get_main_categories", array( "plugin" => "categories", "controller" => "categories", "action" => "get_main_categories" ));
    }
}
