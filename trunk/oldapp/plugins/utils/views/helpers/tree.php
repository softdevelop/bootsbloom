<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Tree helper
 *
 * Helper to generate tree representations of MPTT or recursively nested data
 */

class TreeHelper extends AppHelper
{
    public $name = "Tree";
    private $__settings = array(  );
    private $__typeAttributes = array(  );
    private $__typeAttributesNext = array(  );
    private $__itemAttributes = array(  );
    public $helpers = array( "Html" );

    public function generate($data, $settings = array(  ))
    {
        $this->__settings = array_merge(array( "model" => null, "alias" => "name", "type" => "ul", "itemType" => "li", "id" => false, "class" => false, "element" => false, "callback" => false, "autoPath" => false, "left" => "lft", "right" => "rght", "depth" => 0, "firstChild" => true, "indent" => null, "splitDepth" => false, "splitCount" => 3 ), (array) $settings);
        if( $this->__settings["autoPath"] && !isset($this->__settings["autoPath"][2]) ) 
        {
            $this->__settings["autoPath"][2] = "active";
        }

        extract($this->__settings);
        if( $indent === null && Configure::read("debug") ) 
        {
            $indent = true;
        }

        $view = $this->_View;
        if( $model === null ) 
        {
            $model = Inflector::classify($view->params["models"][0]);
        }

        if( !$model ) 
        {
            $model = "_NULL_";
        }

        $stack = array(  );
        if( $depth == 0 ) 
        {
            if( $class ) 
            {
                $this->addTypeAttribute("class", $class, null, "previous");
            }

            if( $id ) 
            {
                $this->addTypeAttribute("id", $id, null, "previous");
            }

        }

        $return = "";
        if( $indent ) 
        {
            $return = "\r\n";
        }

        $__addType = true;
        foreach( $data as $i => $result ) 
        {
            if( $model == "_NULL_" ) 
            {
                $_result = $result;
                $result[$model] = $_result;
            }

            if( !isset($result[$model][$left]) && !isset($result["children"]) ) 
            {
                $result["children"] = array(  );
            }

            while( $stack && $stack[count($stack) - 1] < $result[$model][$right] ) 
            {
                array_pop($stack);
                if( $indent ) 
                {
                    $whiteSpace = str_repeat("\t", count($stack));
                    $return .= "\r\n" . $whiteSpace . "\t";
                }

                if( $type ) 
                {
                    $return .= "</" . $type . ">";
                }

                if( $itemType ) 
                {
                    $return .= "</" . $itemType . ">";
                }

            }
            $hasChildren = $firstChild = $lastChild = $hasVisibleChildren = false;
            $numberOfDirectChildren = $numberOfTotalChildren = null;
            if( isset($result["children"]) ) 
            {
                if( $result["children"] ) 
                {
                    $hasChildren = $hasVisibleChildren = true;
                    $numberOfDirectChildren = count($result["children"]);
                }

                $prevRow = prev($data);
                if( !$prevRow ) 
                {
                    $firstChild = true;
                }

                next($data);
                $nextRow = next($data);
                if( !$nextRow ) 
                {
                    $lastChild = true;
                }

                prev($data);
            }
            else
            {
                if( isset($result[$model][$left]) ) 
                {
                    if( $result[$model][$left] != $result[$model][$right] - 1 ) 
                    {
                        $hasChildren = true;
                        $numberOfTotalChildren = ($result[$model][$right] - $result[$model][$left] - 1) / 2;
                        if( isset($data[$i + 1]) && $data[$i + 1][$model][$right] < $result[$model][$right] ) 
                        {
                            $hasVisibleChildren = true;
                        }

                    }

                    if( !isset($data[$i - 1]) || $data[$i - 1][$model][$left] == $result[$model][$left] - 1 ) 
                    {
                        $firstChild = true;
                    }

                    if( !isset($data[$i + 1]) || $stack && $stack[count($stack) - 1] == $result[$model][$right] + 1 ) 
                    {
                        $lastChild = true;
                    }

                }

            }

            $elementData = array( "data" => $result, "depth" => $depth ? $depth : count($stack), "hasChildren" => $hasChildren, "numberOfDirectChildren" => $numberOfDirectChildren, "numberOfTotalChildren" => $numberOfTotalChildren, "firstChild" => $firstChild, "lastChild" => $lastChild, "hasVisibleChildren" => $hasVisibleChildren );
            $this->__settings = array_merge($this->__settings, $elementData);
            if( $element ) 
            {
                $content = $view->element($element, $elementData);
            }
            else
            {
                if( $callback ) 
                {
                    list($content) = array_map($callback, array( $elementData ));
                }
                else
                {
                    $content = $result[$model][$alias];
                }

            }

            if( !$content ) 
            {
                continue;
            }

            $whiteSpace = str_repeat("\t", $depth);
            if( $indent && strpos($content, "\r\n", 1) ) 
            {
                $content = str_replace("\r\n", "\n" . $whiteSpace . "\t", $content);
            }

            if( $__addType ) 
            {
                if( $indent ) 
                {
                    $return .= "\r\n" . $whiteSpace;
                }

                if( $type ) 
                {
                    $typeAttributes = $this->__attributes($type, array( "data" => $elementData ));
                    $return .= "<" . $type . $typeAttributes . ">";
                }

            }

            if( $indent ) 
            {
                $return .= "\r\n" . $whiteSpace . "\t";
            }

            if( $itemType ) 
            {
                $itemAttributes = $this->__attributes($itemType, $elementData);
                $return .= "<" . $itemType . $itemAttributes . ">";
            }

            $return .= $content;
            $__addType = false;
            if( $hasVisibleChildren ) 
            {
                if( $numberOfDirectChildren ) 
                {
                    $settings["depth"] = $depth + 1;
                    $return .= $this->__suffix();
                    $return .= $this->generate($result["children"], $settings);
                    if( $itemType ) 
                    {
                        $return .= "</" . $itemType . ">";
                    }

                }
                else
                {
                    if( $numberOfTotalChildren ) 
                    {
                        $__addType = true;
                        $stack[] = $result[$model][$right];
                    }

                }

            }
            else
            {
                if( $itemType ) 
                {
                    $return .= "</" . $itemType . ">";
                }

                $return .= $this->__suffix();
            }

        }
        while( $stack ) 
        {
            array_pop($stack);
            if( $indent ) 
            {
                $whiteSpace = str_repeat("\t", count($stack));
                $return .= "\r\n" . $whiteSpace . "\t";
            }

            if( $type ) 
            {
                $return .= "</" . $type . ">";
            }

            if( $itemType ) 
            {
                $return .= "</" . $itemType . ">";
            }

        }
        if( $indent ) 
        {
            $return .= "\r\n";
        }

        if( $type ) 
        {
            $return .= "</" . $type . ">";
            if( $indent ) 
            {
                $return .= "\r\n";
            }

        }

        return $return;
    }

    public function addItemAttribute($id = "", $key = "", $value = null)
    {
        if( !is_null($value) ) 
        {
            $this->__itemAttributes[$id][$key] = $value;
        }
        else
        {
            if( !(isset($this->__itemAttributes[$id]) && in_array($key, $this->__itemAttributes[$id])) ) 
            {
                $this->__itemAttributes[$id][] = $key;
            }

        }

    }

    public function addTypeAttribute($id = "", $key = "", $value = null, $previousOrNext = "next")
    {
        $var = "__typeAttributes";
        $firstChild = isset($this->__settings["firstChild"]) ? $this->__settings["firstChild"] : true;
        if( $previousOrNext == "next" && $firstChild ) 
        {
            $var = "__typeAttributesNext";
        }

        if( !is_null($value) ) 
        {
            $this->{$var}[$id][$key] = $value;
        }
        else
        {
            if( !(isset($this->$var[$id]) && in_array($key, $this->$var[$id])) ) 
            {
                $this->{$var}[$id][] = $key;
            }

        }

    }

    public function supressChildren()
    {
    }

    private function __suffix()
    {
        static $__splitCount = 0;
        static $__splitCounter = 0;
        extract($this->__settings);
        if( $splitDepth ) 
        {
            if( $depth == $splitDepth - 1 ) 
            {
                $total = $numberOfDirectChildren ? $numberOfDirectChildren : $numberOfTotalChildren;
                if( $total ) 
                {
                    $__splitCounter = 0;
                    $__splitCount = $total / $splitCount;
                    $rounded = (int) $__splitCount;
                    if( $rounded < $__splitCount ) 
                    {
                        $__splitCount = $rounded + 1;
                    }

                }

            }

            if( $depth == $splitDepth ) 
            {
                $__splitCounter++;
                if( $type && $__splitCounter % $__splitCount == 0 ) 
                {
                    return "</" . $type . "><" . $type . ">";
                }

            }

        }

    }

    private function __attributes($rType, $elementData = array(  ), $clear = true)
    {
        extract($this->__settings);
        if( $rType == $type ) 
        {
            $attributes = $this->__typeAttributes;
            if( $clear ) 
            {
                $this->__typeAttributes = $this->__typeAttributesNext;
                $this->__typeAttributesNext = array(  );
            }

        }
        else
        {
            $attributes = $this->__itemAttributes;
            $this->__itemAttributes = array(  );
            if( $clear ) 
            {
                $this->__itemAttributes = array(  );
            }

        }

        if( $autoPath && $depth ) 
        {
            if( $this->__settings["data"][$model][$left] < $autoPath[0] && $autoPath[1] < $this->__settings["data"][$model][$right] ) 
            {
                $attributes["class"][] = $autoPath[2];
            }
            else
            {
                if( isset($autoPath[3]) && $this->__settings["data"][$model][$left] == $autoPath[0] ) 
                {
                    $attributes["class"][] = $autoPath[3];
                }

            }

        }

        if( $attributes ) 
        {
            foreach( $attributes as $type => $values ) 
            {
                foreach( $values as $key => $val ) 
                {
                    if( is_array($val) ) 
                    {
                        $attributes[$type][$key] = "";
                        foreach( $val as $vKey => $v ) 
                        {
                            $attributes[$type][$key][$vKey] .= $vKey . ":" . $v;
                        }
                        $attributes[$type][$key] = implode(";", $attributes[$type][$key]);
                    }

                    if( is_string($key) ) 
                    {
                        $attributes[$type][$key] = $key . ":" . $val . ";";
                    }

                }
                $attributes[$type] = $type . "=\"" . implode(" ", $attributes[$type]) . "\"";
            }
            return " " . implode(" ", $attributes);
        }

        return "";
    }

}




?>