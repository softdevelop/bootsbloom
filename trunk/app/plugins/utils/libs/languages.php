<?php 
//
// This source code was recovered by Recover-PHP.com
//

uses("L10n", "I18n");

/**
 * Utils Plugin
 *
 * Utils Languages Library
 *
 * @package utils
 * @subpackage utils.libs
 */

class Languages extends L10n
{
    public function __construct()
    {
    }

    public function lists($order = "language")
    {
        static $lists = array(  );
        if( empty($lists) ) 
        {
            $catalogs = $this->catalog();
            $match = null;
            foreach( $catalogs as $catalog ) 
            {
                if( $match != $catalog["localeFallback"] ) 
                {
                    $lists[$catalog["language"]] = $catalog["localeFallback"];
                }

                $match = $catalog["localeFallback"];
            }
        }

        ksort($lists);
        if( $order === "locale" ) 
        {
            return array_flip($lists);
        }

        return $lists;
    }

}




?>