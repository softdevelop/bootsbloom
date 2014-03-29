<?php 
//
// This source code was recovered by Recover-PHP.com
//

$Routingprefixes = Configure::read("Routing.prefixes");
if( !empty($Routingprefixes) ) 
{
    foreach( $Routingprefixes as $Routingprefix ) 
    {
        Router::connect("/" . $Routingprefix . "/blogs/blog_fav_projects/remove/*", array( "plugin" => "blogs", "controller" => "blog_fav_projects", "action" => "remove", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blogs/blog_fav_projects/add/*", array( "plugin" => "blogs", "controller" => "blog_fav_projects", "action" => "add", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blogs/blog_fav_projects/*", array( "plugin" => "blogs", "controller" => "blog_fav_projects", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blogs/blog_dashboard", array( "plugin" => "blogs", "controller" => "blogs", "action" => "blog_dashboard", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blogs/operate/*", array( "plugin" => "blogs", "controller" => "blogs", "action" => "operate", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/add_blog/*", array( "plugin" => "blogs", "controller" => "blogs", "action" => "add_blog", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete_blog/*", array( "plugin" => "blogs", "controller" => "blogs", "action" => "delete_blog", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/edit_blog/*", array( "plugin" => "blogs", "controller" => "blogs", "action" => "edit_blog", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/change_blog_status/*", array( "plugin" => "blogs", "controller" => "blogs", "action" => "change_blog_status", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blog_categories/operate/*", array( "plugin" => "blogs", "controller" => "blog_categories", "action" => "operate", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete_blog_category/*", array( "plugin" => "blogs", "controller" => "blog_categories", "action" => "delete_blog_category", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/add_blog_category/*", array( "plugin" => "blogs", "controller" => "blog_categories", "action" => "add_blog_category", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/edit_blog_category/*", array( "plugin" => "blogs", "controller" => "blog_categories", "action" => "edit_blog_category", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/change_category_status/*", array( "plugin" => "blogs", "controller" => "blog_categories", "action" => "change_category_status", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blog_posts/operate/*", array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "operate", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/add_post/*", array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "add_post", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/delete_post/*", array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "delete_post", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/edit_post/*", array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "edit_post", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/change_post_status/*", array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "change_post_status", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blog_post_comments/view_comment/*", array( "plugin" => "blogs", "controller" => "blog_post_comments", "action" => "view_comment", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blog_post_comments/awaiting_comments/*", array( "plugin" => "blogs", "controller" => "blog_post_comments", "action" => "awaiting_comments", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blog_post_comments/operate/*", array( "plugin" => "blogs", "controller" => "blog_post_comments", "action" => "operate", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blog_post_comments/delete_comment/*", array( "plugin" => "blogs", "controller" => "blog_post_comments", "action" => "delete_comment", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/edit_comment/*", array( "plugin" => "blogs", "controller" => "blog_post_comments", "action" => "edit_comment", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/change_comment_status/*", array( "plugin" => "blogs", "controller" => "blog_post_comments", "action" => "change_comment_status", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blog_post_comments/*", array( "plugin" => "blogs", "controller" => "blog_post_comments", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blog_categories/*", array( "plugin" => "blogs", "controller" => "blog_categories", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blog_posts/*", array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "index", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blogs/get-blog-categories/*", array( "plugin" => "blogs", "controller" => "blogs", "action" => "get_blog_categories", $Routingprefix => true ));
        Router::connect("/" . $Routingprefix . "/blogs/*", array( "plugin" => "blogs", "controller" => "blogs", "action" => "index", $Routingprefix => true ));
    }
}

Router::connect("/blog/post-detail/*", array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "detail" ));
Router::connect("/blog/post-comment/*", array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "post_comment" ));
Router::connect("/blog/categories/*", array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "category_project" ));
Router::connect("/blog/get_blog_categories", array( "plugin" => "blogs", "controller" => "blogs", "action" => "get_blog_categories" ));
Router::connect("/blog/*", array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "blog" ));
Router::connect("/blogs/blog_fav_projects/*", array( "plugin" => "blogs", "controller" => "blog_fav_projects", "action" => "index" ));



?>