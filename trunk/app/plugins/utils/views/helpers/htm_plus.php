<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Useful extensions to the Html Helper
 *
 * @package utils
 * @subpackage utils.views.helpers
 */

class HtmlPlusHelper extends AppHelper
{
    public function metaForLayout($scripts = null)
    {
        return $this->_getScriptType($scripts, "meta");
    }

    public function scriptsForLayout($scripts)
    {
        return $this->_getScriptType($scripts, "script");
    }

    protected function _getScriptType($scripts = null, $type)
    {
        $scripts = explode("\n\t", $scripts);
        $result = array(  );
        foreach( $scripts as $s ) 
        {
            if( strpos($s, "<" . $type) === 0 ) 
            {
                $result[] = $s;
            }

        }
        return implode("\n\t", $result);
    }

}
