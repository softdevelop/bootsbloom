<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Tiny Sluggable Behavior
 *
 * @package utils
 * @subpackage utils.models.behaviors
 */

class TinySluggableBehavior extends ModelBehavior
{
    public $settings = array(  );
    protected $_defaults = array( "tinySlug" => "tiny_slug", "codeset" => "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", "orderField" => "created" );

    public function setup($Model, $settings = array(  ))
    {
        $this->settings[$Model->alias] = array_merge($this->_defaults, $settings);
        $Model->tinySlug = $this->settings[$Model->alias]["tinySlug"];
        $this->settings[$Model->alias]["base"] = strlen($this->settings[$Model->alias]["codeset"]);
    }

    public function beforeSave($Model)
    {
        if( empty($Model->data[$Model->alias]) ) 
        {
            return NULL;
        }

        if( empty($Model->data[$Model->alias][$Model->tinySlug]) ) 
        {
            $Model->data[$Model->alias][$Model->tinySlug] = $this->__getNextSlug($Model);
        }

        return true;
    }

    private function __getNextSlug($Model)
    {
        $new = "";
        $prev = $Model->find("first", array( "contain" => array(  ), "fields" => array( "" . $Model->alias . "." . $Model->tinySlug, "" . $Model->alias . ".created" ), "order" => "" . $Model->alias . "." . $this->settings[$Model->alias]["orderField"] . " DESC" ));
        if( empty($prev) ) 
        {
            $new = $this->settings[$Model->alias]["codeset"][0];
        }
        else
        {
            $new = $this->__toShort($Model, (bool) $this->__toDecimal($Model, $prev[$Model->alias][$Model->tinySlug]) + 1);
            $attempts = 0;
            $maxAttempts = 5;
            $new = $prev[$Model->alias][$Model->tinySlug];
            do
            {
                if( $attempts == 1 ) 
                {
                    $maxAttempts = $Model->find("count", array( "conditions" => array( $Model->alias . ".created" => $prev[$Model->alias]["created"] ) ));
                }

                $new = $this->__toShort($Model, $this->__toDecimal($Model, $new) + 1);
                $existing = $Model->find("count", array( "conditions" => array( $Model->alias . "." . $Model->tinySlug => $new ) ));
                $attempts++;
            }
            while( !(empty($existing) || $attempts >= $maxAttempts) );
        }

        return $new;
    }

    private function __toShort($Model, $decimal)
    {
        $codeSet = $this->settings[$Model->alias]["codeset"];
        $base = $this->settings[$Model->alias]["base"];
        $short = "";
        while( 0 < $decimal ) 
        {
            $short = substr($codeSet, $decimal % $base, 1) . $short;
            $decimal = floor($decimal / $base);
        }
        return $short;
    }

    private function __toDecimal($Model, $short)
    {
        $codeSet = $this->settings[$Model->alias]["codeset"];
        $base = $this->settings[$Model->alias]["base"];
        $decimal = 0;
        for( $i = strlen($short); $i; $i-- ) 
        {
            $decimal += strpos($codeSet, substr($short, 0 - 1 * ($i - strlen($short)), 1)) * pow($base, $i - 1);
        }
        return $decimal;
    }

}




?>