<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Users Plugin User Model
 *
 * @package users
 * @subpackage users.models
 */

class User extends UsersAppModel
{
    public $name = "User";
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $hasMany = array(  );
    public $belongsTo = array( "Group" );
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "name", "type" => "query", "method" => "search_name_email", "field" => "User.name" ) );
    public $validationSets = array( "admin_add_user" => array( "name" => array( "rule1" => array( "rule" => "/^[^%#\\/*@!&()-]+\$/", "message" => "Only letters and spaces please.", "required" => true ), "rule2" => array( "rule" => "notEmpty", "message" => "Please enter user name.", "required" => true ) ), "email" => array( "rule1" => array( "rule" => "email", "message" => "Please enter valid Email Address.", "required" => true ), "rule2" => array( "rule" => "isUnique", "message" => "This email has already been taken." ) ), "password" => array( "rule" => array( "minLength", 6 ), "message" => "Password must be at least 6 characters long." ), "con_password" => array( "rule" => array( "checkpassword" ), "message" => "Passwords do not match." ) ), "admin_edit_user" => array( "name" => array( "rule1" => array( "rule" => "/^[^%#\\/*@!&()-]+\$/", "message" => "Only letters and spaces please.", "required" => true ), "rule2" => array( "rule" => "notEmpty", "message" => "Please enter user name.", "required" => true ) ), "password" => array( "allowEmpty" => true, "rule" => array( "minLength", 6 ), "message" => "Password must be at least 6 characters long." ), "con_password" => array( "rule" => array( "checkpassword" ), "message" => "Passwords do not match." ), "email" => array( "rule1" => array( "rule" => "email", "message" => "Please enter valid Email Address.", "required" => true ), "rule2" => array( "rule" => "isUnique", "message" => "This email has already been taken." ) ) ), "admin_myaccount" => array( "name" => array( "rule1" => array( "rule" => "/^[^%#\\/*@!&()-]+\$/", "message" => "Only letters and spaces please.", "required" => true ), "rule2" => array( "rule" => "notEmpty", "message" => "Please enter user name.", "required" => true ) ), "password" => array( "allowEmpty" => true, "rule" => array( "minLength", 6 ), "message" => "Password must be at least 6 characters long." ), "con_password" => array( "rule" => array( "checkpassword" ), "message" => "Passwords do not match." ) ), "register" => array( "name" => array( "rule1" => array( "rule" => "/^[^%#\\/*@!&()-]+\$/", "message" => "letter_space_only", "required" => true ), "rule2" => array( "rule" => "notEmpty", "message" => "sign_up_please_enter_name", "required" => true ) ), "email" => array( "rule1" => array( "rule" => "email", "message" => "valid_email", "required" => true ), "rule2" => array( "rule" => array( "isUnique", true, "email" ), "message" => "email_alrady_save" ) ), "re_email" => array( "rule1" => array( "rule" => array( "identicalFieldValues", "email" ), "message" => "email_confirm_email_not_match" ) ), "password" => array( "rule" => array( "minLength", 6 ), "message" => "at_least_6_character" ), "re_password" => array( "rule" => array( "identicalFieldValues", "password" ), "message" => "password_not_match" ) ), "forgot_password" => array( "email" => array( "rule" => "email", "message" => "valid_email" ) ), "reset_password" => array( "password" => array( "rule" => array( "minLength", 6 ), "message" => "at_least_6_character" ), "con_password" => array( "rule" => array( "checkpassword" ), "message" => "password_not_match" ) ), "edit_profile" => array( "name" => array( "rule" => "notEmpty", "message" => "space_letter", "required" => true ) ), "account_setting" => array( "email" => array( "rule1" => array( "rule" => "email", "message" => "valid_email", "required" => true ), "rule2" => array( "rule" => array( "isUnique", true, "email" ), "message" => "email_alrady_save" ) ), "password" => array( "rule" => array( "minLength", 6 ), "message" => "at_least_6_character", "required" => true ), "con_password" => array( "rule" => array( "checkpassword" ), "message" => "password_not_match", "required" => true ) ), "account" => array( "paypal_email" => array( "rule1" => array( "rule" => "email", "message" => "valid_email", "required" => true ) ) ) );

    public function checkpassword($fields)
    {
        if( !empty($this->data[$this->alias]["password"]) ) 
        {
            if( $this->data[$this->alias]["password"] != $this->data[$this->alias]["con_password"] ) 
            {
                return false;
            }

            return true;
        }

        return true;
    }

    public function identicalFieldValues($field = array(  ), $compare_field = null)
    {
        foreach( $field as $key => $value ) 
        {
            $v1 = $value;
            $v2 = $this->data[$this->name][$compare_field];
            if( $v1 !== $v2 ) 
            {
                return FALSE;
            }

            continue;
        }
        return TRUE;
    }

}




?>