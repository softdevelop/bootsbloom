<?php 
//
// This source code was recovered by Recover-PHP.com
//

class Blog extends BlogsAppModel
{
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "name", "type" => "string" ) );
    public $name = "Blog";
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable", "Utils.Sluggable" => array(  ) );
    public $hasMany = array( "BlogPost" => array( "className" => "BlogPost", "foreignKey" => "blog_id", "order" => "BlogPost.created DESC" ) );
    public $validate = array(  );

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array( "name" => array( "required" => array( "rule" => array( "notEmpty" ), "required" => true, "allowEmpty" => false, "message" => __d("blogs", "Please enter blog title", true) ) ), "description" => array( "required" => array( "rule" => array( "notEmpty" ), "required" => true, "allowEmpty" => false, "message" => __d("blogs", "Please enter blog description", true) ) ), "blog_images" => array( "rule" => array( "extension", array( "gif", "jpeg", "png", "jpg" ) ), "message" => "Please upload image like gif,jpeg,png,jpg or do not leave blank " ) );
    }

}




?>