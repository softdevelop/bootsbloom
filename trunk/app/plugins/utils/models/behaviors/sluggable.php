<?php 
//
// This source code was recovered by Recover-PHP.com
//

uses("Multibyte", "I18n");

/**
 * Utils Plugin
 *
 * Utils Sluggable Behavior
 *
 * @package utils
 * @subpackage utils.models.behaviors
 */

class SluggableBehavior extends ModelBehavior
{
    public $settings = array(  );
    protected $_defaults = array( "label" => "title", "slug" => "slug", "scope" => array(  ), "separator" => "_", "length" => 255, "unique" => true, "update" => false, "trigger" => false );

    public function setup($Model, $settings = array(  ))
    {
        $this->settings[$Model->alias] = array_merge($this->_defaults, $settings);
    }

    public function beforeSave($Model)
    {
        $settings = $this->settings[$Model->alias];
        if( is_string($this->settings[$Model->alias]["trigger"]) && $Model->{$this->settings[$Model->alias]["trigger"]} != true ) 
        {
            return true;
        }

        if( empty($Model->data[$Model->alias]) ) 
        {
            return true;
        }

        if( empty($Model->data[$Model->alias][$this->settings[$Model->alias]["label"]]) ) 
        {
            return true;
        }

        if( !$this->settings[$Model->alias]["update"] && !empty($Model->id) && !is_string($this->settings[$Model->alias]["trigger"]) ) 
        {
            return true;
        }

        $slug = $Model->data[$Model->alias][$settings["label"]];
        if( method_exists($Model, "beforeSlugGeneration") ) 
        {
            $slug = $Model->beforeSlugGeneration($slug, $settings["separator"]);
        }

        $settings = $this->settings[$Model->alias];
        if( method_exists($Model, "multibyteSlug") ) 
        {
            $slug = $Model->multibyteSlug($slug, $settings["separator"]);
        }
        else
        {
            $slug = $this->multibyteSlug($Model, $slug);
        }

        if( $settings["unique"] === true || is_array($settings["unique"]) ) 
        {
            $slug = $this->makeUniqueSlug($Model, $slug);
        }

        if( !empty($Model->whitelist) && !in_array($settings["slug"], $Model->whitelist) ) 
        {
            $Model->whitelist[] = $settings["slug"];
        }

        $Model->data[$Model->alias][$settings["slug"]] = $slug;
        return true;
    }

    public function makeUniqueSlug($Model, $slug = "")
    {
        $settings = $this->settings[$Model->alias];
        $conditions = array(  );
        if( $settings["unique"] === true ) 
        {
            $conditions[$Model->alias . "." . $settings["slug"] . " LIKE"] = $slug . "%";
        }
        else
        {
            if( is_array($settings["unique"]) ) 
            {
                foreach( $settings["unique"] as $field ) 
                {
                    $conditions[$Model->alias . "." . $field] = $Model->data[$Model->alias][$field];
                }
                $conditions[$Model->alias . "." . $settings["slug"] . " LIKE"] = $slug . "%";
            }

        }

        if( !empty($Model->id) ) 
        {
            $conditions[$Model->alias . "." . $Model->primaryKey . " !="] = $Model->id;
        }

        $conditions = array_merge($conditions, $settings["scope"]);
        $duplicates = $Model->find("all", array( "recursive" => 0 - 1, "conditions" => $conditions, "fields" => array( $settings["slug"] ) ));
        if( !empty($duplicates) ) 
        {
            $duplicates = Set::extract($duplicates, "{n}." . $Model->alias . "." . $settings["slug"]);
            $startSlug = $slug;
            for( $index = 1; 0 < $index; $index++ ) 
            {
                if( !in_array($startSlug . $settings["separator"] . $index, $duplicates) ) 
                {
                    $slug = $startSlug . $settings["separator"] . $index;
                    $index = 0 - 1;
                }

            }
        }

        return $slug;
    }

    public function multibyteSlug($Model, $string = null)
    {
        $str = mb_strtolower($string);
        $str = preg_replace("/\\xE3\\x80\\x80/", " ", $str);
        $str = preg_replace("['s ]", "s ", $str);
        $str = str_replace($this->settings[$Model->alias]["separator"], " ", $str);
        $str = preg_replace("#[:\\#\\*\"()~\$^{}`@+=;,<>!&%\\.\\]\\/'\\\\|\\[]#", " ", $str);
        $str = str_replace("?", "", $str);
        $str = trim($str);
        $str = preg_replace("#\\x20+#", $this->settings[$Model->alias]["separator"], $str);
        return $str;
    }

}




?>