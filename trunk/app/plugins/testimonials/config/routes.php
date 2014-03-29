<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/testimonials", array( "plugin" => "testimonials", "controller" => "testimonials", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/add_testimonial/*", array( "plugin" => "testimonials", "controller" => "testimonials", "action" => "add_testimonial", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/edit_testimonial/*", array( "plugin" => "testimonials", "controller" => "testimonials", "action" => "edit_testimonial", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete_testimonial/*", array( "plugin" => "testimonials", "controller" => "testimonials", "action" => "delete_testimonial", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/change_testimonial_status/*", array( "plugin" => "testimonials", "controller" => "testimonials", "action" => "change_testimonial_status", $Routingprefix => true ));
    }
}




?>