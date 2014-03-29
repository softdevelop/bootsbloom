<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 */

class Subscriber extends AppModel
{
    public $name = "Subscriber";
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable", "Utils.Sluggable" => array( "label" => "fname", "method" => "multibyteSlug" ) );
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "email", "type" => "query", "method" => "search_by_email" ) );
    public $validate = array(  );
    public $validationSets = array( "add_new" => array( "email" => array( "valid" => array( "rule" => "email", "required" => true, "allowEmpty" => false, "message" => "email_not_right" ), "duplicate" => array( "rule" => "isUnique", "on" => "create", "message" => "email_alrady_subscribed" ) ) ), "emaillogo" => array( "template" => array( "rule" => "notEmpty", "required" => true, "allowEmpty" => false, "message" => "Template field cannot be left blank.", "last" => true ), "SelectedMail" => array( "rule" => "checkTags", "message" => "Please select at least one receiver." ) ) );

    public function checkTags()
    {
        if( !empty($this->data["Subscriber"]["SelectedMail"]) ) 
        {
            return true;
        }

        return false;
    }

    public function afterSave($created)
    {
        if( $created && !empty($this->data[$this->alias]["slug"]) && $this->hasField("url") ) 
        {
            $this->saveField("url", "/newsletter/" . $this->data[$this->alias]["slug"], false);
        }

    }

}




?>