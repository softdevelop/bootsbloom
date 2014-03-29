<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import(array( "Security", "Validation" ));

/**
 * CakePHP Gravatar Helper
 *
 * A CakePHP View Helper for the display of Gravatar images (http://www.gravatar.com)
 *
 * @copyright Copyright 2009-2010, Graham Weldon (http://grahamweldon.com)
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package goodies
 * @subpackage goodies.views.helpers
 */

class GravatarHelper extends AppHelper
{
    private $__url = array( "http" => "http://www.gravatar.com/avatar/", "https" => "https://secure.gravatar.com/avatar/" );
    private $__hashType = "md5";
    private $__allowedRatings = array( "g", "pg", "r", "x" );
    private $__defaultIcons = array( "none", "identicon", "mm", "monsterid", "retro", "wavatar", "404" );
    private $__default = array( "default" => null, "size" => null, "rating" => null, "ext" => false );
    public $helpers = array( "Html" );

    public function __construct($settings = array(  ))
    {
        if( !is_array($settings) ) 
        {
            $settings = array(  );
        }

        $this->__default = array_merge($this->__default, array_intersect_key($settings, $this->__default));
        $this->__default["secure"] = env("HTTPS");
    }

    public function image($email, $options = array(  ))
    {
        $imageUrl = $this->url($email, $options);
        unset($options["default"]);
        unset($options["size"]);
        unset($options["rating"]);
        unset($options["ext"]);
        return $this->Html->image($imageUrl, $options);
    }

    public function url($email, $options = array(  ))
    {
        $options = $this->__cleanOptions(array_merge($this->__default, $options));
        $ext = $options["ext"];
        $secure = $options["secure"];
        unset($options["ext"]);
        unset($options["secure"]);
        $protocol = $secure === true ? "https" : "http";
        $imageUrl = $this->__url[$protocol] . $this->__emailHash($email, $this->__hashType);
        if( $ext === true ) 
        {
            $imageUrl .= ".jpg";
        }

        $imageUrl .= $this->__buildOptions($options);
        return $imageUrl;
    }

    private function __cleanOptions($options)
    {
        if( !isset($options["size"]) || empty($options["size"]) || !is_numeric($options["size"]) ) 
        {
            unset($options["size"]);
        }
        else
        {
            $options["size"] = min(max($options["size"], 1), 512);
        }

        if( !$options["rating"] || !in_array(mb_strtolower($options["rating"]), $this->__allowedRatings) ) 
        {
            unset($options["rating"]);
        }

        if( !$options["default"] ) 
        {
            unset($options["default"]);
        }
        else
        {
            if( !in_array($options["default"], $this->__defaultIcons) && !Validation::url($options["default"]) ) 
            {
                unset($options["default"]);
            }

        }

        return $options;
    }

    private function __emailHash($email, $type)
    {
        return Security::hash(mb_strtolower($email), $type);
    }

    private function __buildOptions($options = array(  ))
    {
        $gravatarOptions = array_intersect(array_keys($options), array_keys($this->__default));
        if( !empty($gravatarOptions) ) 
        {
            $optionArray = array(  );
            foreach( $gravatarOptions as $key ) 
            {
                $value = $options[$key];
                $optionArray[] = $key . "=" . mb_strtolower($value);
            }
            return "?" . implode("&amp;", $optionArray);
        }

        return "";
    }

}




?>