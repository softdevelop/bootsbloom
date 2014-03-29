<?php 
//
// This source code was recovered by Recover-PHP.com
//


class AssetFixture extends CakeTestFixture
{
    public $name = "Asset";
    public $fields = array( "id" => array( "type" => "integer", "key" => "primary" ), "title" => array( "type" => "string", "null" => false ), "description" => array( "type" => "text" ), "created" => "datetime", "updated" => "datetime" );
    public $records = array( array( "id" => 1, "title" => "soccuer image", "description" => "amazing shot..." ), array( "id" => 2, "title" => "animal image", "description" => "very disturbing" ), array( "id" => 11, "title" => "home page link", "description" => "link back to home page" ), array( "id" => 12, "title" => "google", "description" => "Google is the search engine" ) );

}




?>