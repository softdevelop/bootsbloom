<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Tree Behavior.
 *
 * Enables a model object to act as a node-based tree. Using Modified Preorder Tree Traversal
 *
 * @see http://en.wikipedia.org/wiki/Tree_traversal
 * @package          cake
 * @subpackage      cake.cake.libs.model.behaviors
 */

class BTreeBehavior extends ModelBehavior
{
    public $errors = array(  );
    public $_defaults = array( "parent" => "parent_id", "left" => "lft", "right" => "rght", "scope" => "1 = 1", "type" => "nested", "__parentChange" => false, "recursive" => -1 );

    public function setup($Model, $config = array(  ))
    {
        if( !is_array($config) ) 
        {
            $config = array( "type" => $config );
        }

        if( !array_key_exists("block_size", $config) ) 
        {
            $config["block_size"] = 32768;
        }

        $settings = array_merge($this->_defaults, $config);
        if( in_array($settings["scope"], $Model->getAssociated("belongsTo")) ) 
        {
            $data = $Model->getAssociated($settings["scope"]);
            $parent =& $Model->{$settings["scope"]};
            $settings["scope"] = $Model->alias . "." . $data["foreignKey"] . " = " . $parent->alias . "." . $parent->primaryKey;
            $settings["recursive"] = 0;
        }

        $this->settings[$Model->alias] = $settings;
    }

    public function afterSave($Model, $created)
    {
        extract($this->settings[$Model->alias]);
        if( $created ) 
        {
            if( isset($Model->data[$Model->alias][$parent]) && $Model->data[$Model->alias][$parent] ) 
            {
                return $this->_setParent($Model, $Model->data[$Model->alias][$parent], $created);
            }

        }
        else
        {
            if( $__parentChange ) 
            {
                $this->settings[$Model->alias]["__parentChange"] = false;
                return $this->_setParent($Model, $Model->data[$Model->alias][$parent]);
            }

        }

    }

    public function beforeDelete($Model)
    {
        extract($this->settings[$Model->alias]);
        list($name, $data) = array( $Model->alias, $Model->read() );
        $data = $data[$name];
        if( !$data[$right] || !$data[$left] ) 
        {
            return true;
        }

        $diff = $data[$right] - $data[$left] + 1;
        if( 2 < $diff ) 
        {
            if( is_string($scope) ) 
            {
                $scope = array( $scope );
            }

            $scope[]["" . $Model->alias . "." . $left . " BETWEEN ? AND ?"] = array( $data[$left] + 1, $data[$right] - 1 );
            $Model->deleteAll($scope);
        }

        $this->__sync($Model, $diff, "-", "> " . $data[$right]);
        return true;
    }

    public function beforeSave($Model)
    {
        extract($this->settings[$Model->alias]);
        if( isset($Model->data[$Model->alias][$Model->primaryKey]) ) 
        {
            if( $Model->data[$Model->alias][$Model->primaryKey] && !$Model->id ) 
            {
                $Model->id = $Model->data[$Model->alias][$Model->primaryKey];
            }

            unset($Model->data[$Model->alias][$Model->primaryKey]);
        }

        $this->_addToWhitelist($Model, array( $left, $right ));
        if( !$Model->id ) 
        {
            if( array_key_exists($parent, $Model->data[$Model->alias]) && $Model->data[$Model->alias][$parent] ) 
            {
                $parentNode = $Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $Model->data[$Model->alias][$parent] ), "fields" => array( $Model->primaryKey, $right ), "recursive" => $recursive ));
                if( !$parentNode ) 
                {
                    return false;
                }

                list($parentNode) = array_values($parentNode);
                $Model->data[$Model->alias][$left] = 0;
                $Model->data[$Model->alias][$right] = 0;
            }
            else
            {
                $edge = $this->__getPartition($Model, $scope, $recursive);
                $Model->data[$Model->alias][$left] = $edge + 1;
                $Model->data[$Model->alias][$right] = $edge + 2;
            }

        }
        else
        {
            if( array_key_exists($parent, $Model->data[$Model->alias]) ) 
            {
                if( $Model->data[$Model->alias][$parent] != $Model->field($parent) ) 
                {
                    $this->settings[$Model->alias]["__parentChange"] = true;
                }

                if( !$Model->data[$Model->alias][$parent] ) 
                {
                    $Model->data[$Model->alias][$parent] = null;
                    $this->_addToWhitelist($Model, $parent);
                }
                else
                {
                    list($node) = array_values($Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $Model->id ), "fields" => array( $Model->primaryKey, $parent, $left, $right ), "recursive" => $recursive )));
                    $parentNode = $Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $Model->data[$Model->alias][$parent] ), "fields" => array( $Model->primaryKey, $left, $right ), "recursive" => $recursive ));
                    if( !$parentNode ) 
                    {
                        return false;
                    }

                    list($parentNode) = array_values($parentNode);
                    if( $node[$left] < $parentNode[$left] && $parentNode[$right] < $node[$right] ) 
                    {
                        return false;
                    }

                    if( $node[$Model->primaryKey] == $parentNode[$Model->primaryKey] ) 
                    {
                        return false;
                    }

                }

            }

        }

        return true;
    }

    public function childCount($Model, $id = null, $direct = false)
    {
        if( is_array($id) ) 
        {
            extract(array_merge(array( "id" => null ), $id));
        }

        if( $id === null && $Model->id ) 
        {
            $id = $Model->id;
        }
        else
        {
            if( !$id ) 
            {
                $id = null;
            }

        }

        extract($this->settings[$Model->alias]);
        if( $direct ) 
        {
            return $Model->find("count", array( "conditions" => array( $scope, $Model->escapeField($parent) => $id ) ));
        }

        if( $id === null ) 
        {
            return $Model->find("count", array( "conditions" => $scope ));
        }

        if( isset($Model->data[$Model->alias][$left]) && isset($Model->data[$Model->alias][$right]) ) 
        {
            $data = $Model->data[$Model->alias];
        }
        else
        {
            $data = $Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $id ), "recursive" => $recursive ));
            if( !$data ) 
            {
                return 0;
            }

            $data = $data[$Model->alias];
        }

        return ($data[$right] - $data[$left] - 1) / 2;
    }

    public function children($Model, $id = null, $direct = false, $fields = null, $order = null, $limit = null, $page = 1, $recursive = null)
    {
        if( is_array($id) ) 
        {
            extract(array_merge(array( "id" => null ), $id));
        }

        $overrideRecursive = $recursive;
        if( $id === null && $Model->id ) 
        {
            $id = $Model->id;
        }
        else
        {
            if( !$id ) 
            {
                $id = null;
            }

        }

        $name = $Model->alias;
        extract($this->settings[$Model->alias]);
        if( !is_null($overrideRecursive) ) 
        {
            $recursive = $overrideRecursive;
        }

        if( !$order ) 
        {
            $order = $Model->alias . "." . $left . " asc";
        }

        if( $direct ) 
        {
            $conditions = array( $scope, $Model->escapeField($parent) => $id );
            return $Model->find("all", compact("conditions", "fields", "order", "limit", "page", "recursive"));
        }

        if( !$id ) 
        {
            $conditions = $scope;
        }
        else
        {
            $result = array_values($Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $id ), "fields" => array( $left, $right ), "recursive" => $recursive )));
            if( empty($result) || !isset($result[0]) ) 
            {
                return array(  );
            }

            $conditions = array( $scope, $Model->escapeField($right) . " <" => $result[0][$right], $Model->escapeField($left) . " >" => $result[0][$left] );
        }

        return $Model->find("all", compact("conditions", "fields", "order", "limit", "page", "recursive"));
    }

    public function generateTreeList($Model, $conditions = null, $keyPath = null, $valuePath = null, $spacer = "_", $recursive = null)
    {
        $overrideRecursive = $recursive;
        extract($this->settings[$Model->alias]);
        if( !is_null($overrideRecursive) ) 
        {
            $recursive = $overrideRecursive;
        }

        if( $keyPath == null && $valuePath == null && $Model->hasField($Model->displayField) ) 
        {
            $fields = array( $Model->primaryKey, $Model->displayField, $left, $right );
        }
        else
        {
            $fields = null;
        }

        if( $keyPath == null ) 
        {
            $keyPath = "{n}." . $Model->alias . "." . $Model->primaryKey;
        }

        if( $valuePath == null ) 
        {
            $valuePath = array( "{0}{1}", "{n}.tree_prefix", "{n}." . $Model->alias . "." . $Model->displayField );
        }
        else
        {
            if( is_string($valuePath) ) 
            {
                $valuePath = array( "{0}{1}", "{n}.tree_prefix", $valuePath );
            }
            else
            {
                $valuePath[0] = "{" . count($valuePath) - 1 . "}" . $valuePath[0];
                $valuePath[] = "{n}.tree_prefix";
            }

        }

        $order = $Model->alias . "." . $left . " asc";
        $results = $Model->find("all", compact("conditions", "fields", "order", "recursive"));
        $stack = array(  );
        foreach( $results as $i => $result ) 
        {
            while( $stack && $stack[count($stack) - 1] < $result[$Model->alias][$right] ) 
            {
                array_pop($stack);
            }
            $results[$i]["tree_prefix"] = str_repeat($spacer, count($stack));
            $stack[] = $result[$Model->alias][$right];
        }
        if( empty($results) ) 
        {
            return array(  );
        }

        return Set::combine($results, $keyPath, $valuePath);
    }

    public function getParentNode($Model, $id = null, $fields = null, $recursive = null)
    {
        if( is_array($id) ) 
        {
            extract(array_merge(array( "id" => null ), $id));
        }

        $overrideRecursive = $recursive;
        if( empty($id) ) 
        {
            $id = $Model->id;
        }

        extract($this->settings[$Model->alias]);
        if( !is_null($overrideRecursive) ) 
        {
            $recursive = $overrideRecursive;
        }

        $parentId = $Model->read($parent, $id);
        if( $parentId ) 
        {
            $parentId = $parentId[$Model->alias][$parent];
            $parent = $Model->find("first", array( "conditions" => array( $Model->escapeField() => $parentId ), "fields" => $fields, "recursive" => $recursive ));
            return $parent;
        }

        return false;
    }

    public function getPath($Model, $id = null, $fields = null, $recursive = null)
    {
        $cachequeries = $Model->cacheQueries;
        $Model->cacheQueries = false;
        if( is_array($id) ) 
        {
            extract(array_merge(array( "id" => null ), $id));
        }

        $overrideRecursive = $recursive;
        if( empty($id) ) 
        {
            $id = $Model->id;
        }

        extract($this->settings[$Model->alias]);
        if( !is_null($overrideRecursive) ) 
        {
            $recursive = $overrideRecursive;
        }

        $result = $Model->find("first", array( "conditions" => array( $Model->escapeField() => $id ), "fields" => am($fields, array( $left, $right, $parent, $Model->primaryKey )), "recursive" => $recursive ));
        if( $result ) 
        {
            if( $result[$Model->alias][$left] == 0 && $result[$Model->alias][$right] == 0 ) 
            {
                return array( $result );
            }

            $result = array_values($result);
            $item = $result[0];
            $results = array(  );
            if( $item[$left] < $item[$right] ) 
            {
                $results = $Model->find("all", array( "conditions" => array( $scope, $Model->escapeField($left) . " <=" => $item[$left], $Model->escapeField($right) . " >=" => $item[$right] ), "fields" => am($fields, $left, $right, $Model->primaryKey, $parent), "order" => array( $Model->escapeField($left) => "asc" ), "recursive" => $recursive ));
                $i = 0;
                if( $i < count($results) ) 
                {
                    for( $j = $i + 1; $j < count($results); $j++ ) 
                    {
                        if( $results[$i][$Model->alias][$Model->primaryKey] == $results[$j][$Model->alias][$parent] ) 
                        {
                            break;
                        }

                    }
                    $results = array(  );
                    break;
                }

            }

            $orig_id = $Model->id;
            if( empty($results) ) 
            {
                array_unshift($results, array( $Model->alias => $item ));
                $cur_id = $item[$Model->primaryKey];
                while( $pNode = $this->getParentNode($Model, $cur_id, am($fields, $left, $right, $parent, $Model->primaryKey), $recursive) ) 
                {
                    array_unshift($results, $pNode);
                    if( $pNode[$Model->alias][$parent] == null ) 
                    {
                        break;
                    }

                    $cur_id = $pNode[$Model->alias][$Model->primaryKey];
                }
            }

            $Model->id = $orig_id;
            $Model->cacheQueries = $cachequeries;
            return $results;
        }

        return null;
    }

    public function moveDown($Model, $id = null, $number = 1)
    {
        if( is_array($id) ) 
        {
            extract(array_merge(array( "id" => null ), $id));
        }

        if( !$number ) 
        {
            return false;
        }

        if( empty($id) ) 
        {
            $id = $Model->id;
        }

        extract($this->settings[$Model->alias]);
        list($node) = array_values($Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $id ), "fields" => array( $Model->primaryKey, $left, $right, $parent ), "recursive" => $recursive )));
        if( $node[$parent] ) 
        {
            list($parentNode) = array_values($Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $node[$parent] ), "fields" => array( $Model->primaryKey, $left, $right ), "recursive" => $recursive )));
            if( $node[$right] + 1 == $parentNode[$right] ) 
            {
                return false;
            }

        }

        $nextNode = $Model->find("first", array( "conditions" => array( $scope, $Model->escapeField($left) => $node[$right] + 1 ), "fields" => array( $Model->primaryKey, $left, $right ), "recursive" => $recursive ));
        if( $nextNode ) 
        {
            list($nextNode) = array_values($nextNode);
            $edge = $this->__getMax($Model, $scope, $right, $recursive);
            $this->__sync($Model, $edge - $node[$left] + 1, "+", "BETWEEN " . $node[$left] . " AND " . $node[$right]);
            $this->__sync($Model, $nextNode[$left] - $node[$left], "-", "BETWEEN " . $nextNode[$left] . " AND " . $nextNode[$right]);
            $this->__sync($Model, $edge - $node[$left] - $nextNode[$right] - $nextNode[$left], "-", "> " . $edge);
            if( is_int($number) ) 
            {
                $number--;
            }

            if( $number ) 
            {
                $this->moveDown($Model, $id, $number);
            }

            return true;
        }

        return false;
    }

    public function moveUp($Model, $id = null, $number = 1)
    {
        if( is_array($id) ) 
        {
            extract(array_merge(array( "id" => null ), $id));
        }

        if( !$number ) 
        {
            return false;
        }

        if( empty($id) ) 
        {
            $id = $Model->id;
        }

        extract($this->settings[$Model->alias]);
        list($node) = array_values($Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $id ), "fields" => array( $Model->primaryKey, $left, $right, $parent ), "recursive" => $recursive )));
        if( $node[$parent] ) 
        {
            list($parentNode) = array_values($Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $node[$parent] ), "fields" => array( $Model->primaryKey, $left, $right ), "recursive" => $recursive )));
            if( $node[$left] - 1 == $parentNode[$left] ) 
            {
                return false;
            }

        }

        $previousNode = $Model->find("first", array( "conditions" => array( $scope, $Model->escapeField($right) => $node[$left] - 1 ), "fields" => array( $Model->primaryKey, $left, $right ), "recursive" => $recursive ));
        if( $previousNode ) 
        {
            list($previousNode) = array_values($previousNode);
            $edge = $this->__getMax($Model, $scope, $right, $recursive);
            $this->__sync($Model, $edge - $previousNode[$left] + 1, "+", "BETWEEN " . $previousNode[$left] . " AND " . $previousNode[$right]);
            $this->__sync($Model, $node[$left] - $previousNode[$left], "-", "BETWEEN " . $node[$left] . " AND " . $node[$right]);
            $this->__sync($Model, $edge - $previousNode[$left] - $node[$right] - $node[$left], "-", "> " . $edge);
            if( is_int($number) ) 
            {
                $number--;
            }

            if( $number ) 
            {
                $this->moveUp($Model, $id, $number);
            }

            return true;
        }

        return false;
    }

    public function recover($Model, $mode = "parent", $missingParentAction = null)
    {
        $cachequeries = $Model->cacheQueries;
        $Model->cacheQueries = false;
        if( is_array($mode) ) 
        {
            extract(array_merge(array( "mode" => "parent" ), $mode));
        }

        extract($this->settings[$Model->alias]);
        $Model->recursive = $recursive;
        if( $mode == "parent" ) 
        {
            $Model->bindModel(array( "belongsTo" => array( "VerifyParent" => array( "className" => $Model->alias, "foreignKey" => $parent, "fields" => array( $Model->primaryKey, $left, $right, $parent ) ) ) ));
            $missingParents = $Model->find("list", array( "recursive" => 0, "conditions" => array( $scope, array( "NOT" => array( $Model->escapeField($parent) => null ), $Model->VerifyParent->escapeField() => null ) ) ));
            $Model->unbindModel(array( "belongsTo" => array( "VerifyParent" ) ));
            if( $missingParents ) 
            {
                if( $missingParentAction == "return" ) 
                {
                    foreach( $missingParents as $id => $display ) 
                    {
                        $this->errors[] = "cannot find the parent for " . $Model->alias . " with id " . $id . "(" . $display . ")";
                    }
                    return false;
                }

                if( $missingParentAction == "delete" ) 
                {
                    $Model->deleteAll(array( $Model->primaryKey => array_flip($missingParents) ));
                }
                else
                {
                    $Model->updateAll(array( $parent => $missingParentAction ), array( $Model->escapeField($Model->primaryKey) => array_flip($missingParents) ));
                }

            }

            $count = 1;
            $Model->find("all", array( "conditions" => $scope, "fields" => array( $Model->primaryKey, $parent ), "order" => $left ));
            foreach( $Model->find("all", array( "conditions" => $scope, "fields" => array( $Model->primaryKey, $parent ), "order" => $left )) as $array ) 
            {
                $Model->id = $array[$Model->alias][$Model->primaryKey];
                if( $array[$Model->alias][$parent] == null ) 
                {
                    $lft = $this->__getPartition($Model, $scope, $recursive);
                    $rght = $lft + 1;
                }
                else
                {
                    $lft = $count++;
                    $rght = $count++;
                }

                $Model->save(array( $left => $lft, $right => $rght ), array( "callbacks" => false ));
            }
            $nodePage = 0;
            $count = 0;
            while( $nodes = $Model->find("all", array( "conditions" => am($scope, array( "NOT" => array( $parent => NULL ) )), "fields" => array( $Model->primaryKey, $parent ), "limit" => 1024, "page" => $nodePage++, "order" => $Model->primaryKey, "recursive" => 0 )) ) 
            {
                foreach( $nodes as $node ) 
                {
                    $Model->create();
                    $Model->id = $node[$Model->alias][$Model->primaryKey];
                    $this->_setParent($Model, $node[$Model->alias][$parent]);
                }
            }
        }
        else
        {
            $db =& ConnectionManager::getdatasource($Model->useDbConfig);
            $Model->find("all", array( "conditions" => $scope, "fields" => array( $Model->primaryKey, $parent ), "order" => $left ));
            foreach( $Model->find("all", array( "conditions" => $scope, "fields" => array( $Model->primaryKey, $parent ), "order" => $left )) as $array ) 
            {
                $path = $this->getPath($Model, $array[$Model->alias][$Model->primaryKey]);
                if( $path == null || count($path) < 2 ) 
                {
                    $parentId = null;
                }
                else
                {
                    $parentId = $path[count($path) - 2][$Model->alias][$Model->primaryKey];
                }

                $Model->updateAll(array( $parent => $db->value($parentId, $parent) ), array( $Model->escapeField() => $array[$Model->alias][$Model->primaryKey] ));
            }
        }

        $Model->cacheQueries = $cachequeries;
        return true;
    }

    public function reorder($Model, $options = array(  ))
    {
        $options = array_merge(array( "id" => null, "field" => $Model->displayField, "order" => "ASC", "verify" => true ), $options);
        extract($options);
        if( $verify && !$this->verify($Model) ) 
        {
            return false;
        }

        $verify = false;
        extract($this->settings[$Model->alias]);
        $fields = array( $Model->primaryKey, $field, $left, $right );
        $sort = $field . " " . $order;
        $nodes = $this->children($Model, $id, true, $fields, $sort, null, null, $recursive);
        if( $nodes ) 
        {
            foreach( $nodes as $node ) 
            {
                $id = $node[$Model->alias][$Model->primaryKey];
                $this->moveDown($Model, $id, true);
                if( $node[$Model->alias][$left] != $node[$Model->alias][$right] - 1 ) 
                {
                    $this->reorder($Model, compact("id", "field", "order", "verify"));
                }

            }
        }

        return true;
    }

    public function removeFromTree($Model, $id = null, $delete = false)
    {
        if( is_array($id) ) 
        {
            extract(array_merge(array( "id" => null ), $id));
        }

        extract($this->settings[$Model->alias]);
        list($node) = array_values($Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $id ), "fields" => array( $Model->primaryKey, $left, $right, $parent ), "recursive" => $recursive )));
        if( $node[$right] == $node[$left] + 1 ) 
        {
            if( $delete ) 
            {
                return $Model->delete($id);
            }

            $Model->id = $id;
            return $Model->saveField($parent, null);
        }

        if( $node[$parent] ) 
        {
            list($parentNode) = array_values($Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $node[$parent] ), "fields" => array( $Model->primaryKey, $left, $right ), "recursive" => $recursive )));
        }
        else
        {
            $parentNode[$right] = $node[$right] + 1;
        }

        $db =& ConnectionManager::getdatasource($Model->useDbConfig);
        $Model->updateAll(array( $parent => $db->value($node[$parent], $parent) ), array( $parent => $node[$Model->primaryKey] ));
        $Model->id = $id;
        $this->__sync($Model, 1, "-", "BETWEEN " . $node[$left] + 1 . " AND " . $node[$right] - 1);
        $this->__sync($Model, 2, "-", "> " . $node[$right]);
        if( $delete ) 
        {
            $sub_tree = $Model->find("list", array( "conditions" => array( $left . " >= " . $node[$left], $right . " <= " . $node[$right] ), "fields" => array( "id", "parent_id" ) ));
            foreach( $sub_tree as $sChild => $sParent ) 
            {
                $Model->del($sChild);
            }
            return true;
        }

        $edge = $this->__getPartition($Model, $scope, $recursive);
        if( $node[$right] == $edge ) 
        {
            $edge = $edge - 2;
        }

        $Model->id = $id;
        return $Model->save(array( $left => $edge, $right => $edge + 1, $parent => null ), array( "callbacks" => false ));
    }

    public function verify($Model)
    {
        extract($this->settings[$Model->alias]);
        $cachequeries = $Model->cacheQueries;
        $Model->cacheQueries = false;
        if( !$Model->find("count", array( "conditions" => $scope )) ) 
        {
            return true;
        }

        $errors = array(  );
        $errors = am($errors, $this->__verifyContinuity($Model));
        $errors = am($errors, $this->__verifySanity($Model));
        $errors = am($errors, $this->__verifyRelations($Model));
        $Model->cacheQueries = $cachequeries;
        if( $errors ) 
        {
            return $errors;
        }

        return true;
    }

    public function __verifyRelations($Model)
    {
        extract($this->settings[$Model->alias]);
        $errors = array(  );
        $Model->bindModel(array( "belongsTo" => array( "VerifyParent" => array( "className" => $Model->alias, "foreignKey" => $parent, "fields" => array( $Model->primaryKey, $left, $right, $parent ) ) ) ));
        $nodePage = 0;
        $nodes = $Model->find("all", array( "conditions" => am($scope), "fields" => array( $Model->primaryKey, $left, $right, $parent, "VerifyParent." . $Model->primaryKey, "VerifyParent." . $left, "VerifyParent." . $right ), "limit" => 1024, "page" => $nodePage++, "order" => $Model->escapeField($Model->primaryKey), "recursive" => 1 ));
        while( $nodes ) 
        {
            foreach( $nodes as $instance ) 
            {
                if( is_null($instance[$Model->alias][$left]) || is_null($instance[$Model->alias][$right]) ) 
                {
                    $errors[] = array( "node", $instance[$Model->alias][$Model->primaryKey], "has invalid left or right values" );
                }
                else
                {
                    if( $instance[$Model->alias][$left] == $instance[$Model->alias][$right] ) 
                    {
                        $errors[] = array( "node", $instance[$Model->alias][$Model->primaryKey], "left and right values identical" );
                    }
                    else
                    {
                        if( $instance[$Model->alias][$parent] ) 
                        {
                            if( !$instance["VerifyParent"][$Model->primaryKey] ) 
                            {
                                $errors[] = array( "node", $instance[$Model->alias][$Model->primaryKey], "The parent node " . $instance[$Model->alias][$parent] . " doesn't exist" );
                            }
                            else
                            {
                                if( $instance[$Model->alias][$left] < $instance["VerifyParent"][$left] ) 
                                {
                                    $errors[] = array( "node", $instance[$Model->alias][$Model->primaryKey], "left less than parent (node " . $instance["VerifyParent"][$Model->primaryKey] . ")." );
                                }
                                else
                                {
                                    if( $instance["VerifyParent"][$right] < $instance[$Model->alias][$right] ) 
                                    {
                                        $errors[] = array( "node", $instance[$Model->alias][$Model->primaryKey], "right greater than parent (node " . $instance["VerifyParent"][$Model->primaryKey] . ")." );
                                    }

                                }

                            }

                        }
                        else
                        {
                            if( $Model->find("count", array( "conditions" => array( $scope, $Model->escapeField($left) . " <" => $instance[$Model->alias][$left], $Model->escapeField($right) . " >" => $instance[$Model->alias][$right] ), "recursive" => 0 )) ) 
                            {
                                $errors[] = array( "node", $instance[$Model->alias][$Model->primaryKey], "The parent field is blank, but has a parent" );
                            }

                        }

                    }

                }

            }
            $Model->bindModel(array( "belongsTo" => array( "VerifyParent" => array( "className" => $Model->alias, "foreignKey" => $parent, "fields" => array( $Model->primaryKey, $left, $right, $parent ) ) ) ));
            $nodes = $Model->find("all", array( "conditions" => am($scope), "fields" => array( $Model->primaryKey, $left, $right, $parent, "VerifyParent." . $Model->primaryKey, "VerifyParent." . $left, "VerifyParent." . $right ), "limit" => 1024, "page" => $nodePage++, "order" => $Model->escapeField($Model->primaryKey), "recursive" => 1 ));
        }
        return $errors;
    }

    public function __verifySanity($Model)
    {
        extract($this->settings[$Model->alias]);
        $errors = array(  );
        $node = $Model->find("first", array( "conditions" => array( $scope, $Model->escapeField($right) . "< " . $Model->escapeField($left) ), "recursive" => 0 ));
        if( $node ) 
        {
            $errors[] = array( "node", $node[$Model->alias][$Model->primaryKey], "left greater than right." );
        }

        return $errors;
    }

    public function __verifyContinuity($Model)
    {
        extract($this->settings[$Model->alias]);
        $errors = array(  );
        $nodes = $this->children($Model, null, true, array( $left, $right ));
        foreach( $nodes as $node ) 
        {
            $min = $node[$Model->alias][$left];
            $max = $node[$Model->alias][$right];
            for( $i = $min; $i <= $max; $i++ ) 
            {
                $count = $Model->find("count", array( "conditions" => array( $scope, "OR" => array( $Model->escapeField($left) => $i, $Model->escapeField($right) => $i ) ) ));
                if( $count != 1 ) 
                {
                    if( $count == 0 ) 
                    {
                        $errors[] = array( "index", $i, "missing" );
                    }
                    else
                    {
                        $errors[] = array( "index", $i, "duplicate" );
                    }

                }

            }
        }
        return $errors;
    }

    public function _setParent($Model, $parentId = null, $created = false)
    {
        extract($this->settings[$Model->alias]);
        $cachequeries = $Model->cacheQueries;
        $Model->cacheQueries = false;
        list($node) = array_values($Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $Model->id ), "fields" => array( $Model->primaryKey, $parent, $left, $right ), "recursive" => $recursive )));
        if( empty($parentId) ) 
        {
            $edge = $this->__getMax($Model, $scope, $right, $recursive, $created);
            $this->__sync($Model, $edge - $node[$left] + 1, "+", "BETWEEN " . $node[$left] . " AND " . $node[$right], $created);
            $this->__sync($Model, $node[$right] - $node[$left] + 1, "-", "> " . $node[$left], $created);
        }
        else
        {
            $parentNode = array_values($Model->find("first", array( "conditions" => array( $scope, $Model->escapeField() => $parentId ), "fields" => array( $Model->primaryKey, $left, $right ), "recursive" => $recursive )));
            if( empty($parentNode) || empty($parentNode[0]) ) 
            {
                return false;
            }

            $parentNode = $parentNode[0];
            $edge = $this->__getMax($Model, "" . $Model->alias . "." . $left . " <= " . $parentNode[$left], $right, $recursive, $created);
            if( $Model->id == $parentId ) 
            {
                return false;
            }

            if( $node[$left] < $parentNode[$left] && $parentNode[$right] < $node[$right] ) 
            {
                return false;
            }

            if( empty($node[$left]) && empty($node[$right]) ) 
            {
                $result = $Model->save(array( $left => $parentNode[$right], $right => $parentNode[$right] + 1, $parent => $parentId ), array( "validate" => false, "callbacks" => false ));
                $this->__sync($Model, 2, "+", ">= " . $parentNode[$right], $created);
                $Model->data = $result;
            }
            else
            {
                $diff = $node[$right] - $node[$left];
                $this->__sync($Model, $diff + 1, "+", ">= " . $parentNode[$right], $created);
                $this->__sync($Model, $parentNode[$right] - $node[$left], "+", "BETWEEN " . $node[$left] . " AND " . $node[$right], $created);
                $nodeTreeMax = $this->__getMax($Model, "" . $Model->alias . "." . $left . " <= " . $node[$left], $right, $recursive, $created);
                $this->__sync($Model, $diff + 1, "-", "BETWEEN " . $node[$right] . " AND " . $nodeTreeMax, $created);
            }

        }

        $Model->cacheQueries = $cachequeries;
        return true;
    }

    public function __getPartition($Model, $scope, $recursive = -1, $created = false)
    {
        extract($this->settings[$Model->alias]);
        $db =& ConnectionManager::getdatasource($Model->useDbConfig);
        if( $created ) 
        {
            if( is_string($scope) ) 
            {
                $scope .= "" . " AND " . $Model->alias . "." . $Model->primaryKey . " <> ";
                $scope .= $db->value($Model->id, $Model->getColumnType($Model->primaryKey));
            }
            else
            {
                $scope["NOT"][$Model->alias . "." . $Model->primaryKey] = $Model->id;
            }

        }

        list($count) = array_values(current($Model->find("first", array( "conditions" => "1=1", "fields" => "count(" . $Model->alias . "." . $Model->primaryKey . ")" ))));
        $part_lft = $block_size * 2;
        while( $part_lft < $count * 2 ) 
        {
            $part_lft = $part_lft + $block_size * 2;
        }
        $edge_pairs = $Model->find("list", array( "conditions" => array( $scope, "parent_id" => null ), "fields" => array( $left, $right ), "order" => "lft ASC", "recursive" => $recursive ));
        reset($edge_pairs);
        while( list($lft, $rght) = each($edge_pairs) ) 
        {
            if( !$lft || $lft < $part_lft ) 
            {
                continue;
            }

            if( $block_size < $lft - $part_lft ) 
            {
                break;
            }

            $part_lft += $block_size * 2;
        }
        return $part_lft;
    }

    public function __getMax($Model, $scope, $right, $recursive = -1, $created = false)
    {
        $db =& ConnectionManager::getdatasource($Model->useDbConfig);
        if( $created ) 
        {
            if( is_string($scope) ) 
            {
                $scope .= "" . " AND " . $Model->alias . "." . $Model->primaryKey . " <> ";
                $scope .= $db->value($Model->id, $Model->getColumnType($Model->primaryKey));
            }
            else
            {
                $scope["NOT"][$Model->alias . "." . $Model->primaryKey] = $Model->id;
            }

        }

        $edge = $Model->find("first", array( "conditions" => $scope, "fields" => $right, "order" => array( $right . " DESC" ), "recursive" => $recursive ));
        if( !empty($edge) ) 
        {
            list($edge) = array_values($edge);
        }

        return empty($edge[$right]) ? 0 : $edge[$right];
    }

    public function __getMin($Model, $scope, $left, $recursive = -1)
    {
        $db =& ConnectionManager::getdatasource($Model->useDbConfig);
        list($edge) = array_values($Model->find("first", array( "conditions" => $scope, "fields" => $db->calculate($Model, "min", array( $left )), "recursive" => $recursive )));
        return empty($edge[$left]) ? 0 : $edge[$left];
    }

    public function __sync($Model, $shift, $dir = "+", $conditions = array(  ), $created = false, $field = "both")
    {
        $ModelRecursive = $Model->recursive;
        $cachequeries = $Model->cacheQueries;
        extract($this->settings[$Model->alias]);
        $Model->recursive = $recursive;
        $Model->cacheQueries = false;
        if( $field == "both" ) 
        {
            $this->__sync($Model, $shift, $dir, $conditions, $created, $left);
            $field = $right;
        }

        if( is_string($conditions) ) 
        {
            $conditions = array( "" . $Model->alias . "." . $field . " " . $conditions );
        }

        if( $scope != "1 = 1" && $scope !== true && $scope ) 
        {
            $conditions[] = $scope;
        }

        $path = $this->getPath($Model, $Model->id);
        $max = $min = 0;
        if( $path ) 
        {
            if( count($path) == 1 ) 
            {
                if( $path[0][$Model->alias][$left] != 0 || $path[0][$Model->alias][$right] != 0 ) 
                {
                    $conditions[] = array( $Model->primaryKey => $Model->id );
                }
                else
                {
                    $min = $path[0][$Model->alias][$left];
                    $max = $path[0][$Model->alias][$right];
                }

            }
            else
            {
                $min = $this->__getMax($Model, $scope, $right, $recursive);
                foreach( $path as $node ) 
                {
                    if( $node[$Model->alias][$left] < $min ) 
                    {
                        $min = $node[$Model->alias][$left];
                    }

                    if( $max < $node[$Model->alias][$right] ) 
                    {
                        $max = $node[$Model->alias][$right];
                    }

                }
            }

        }

        $conditions[] = $Model->escapeField($left) . " >= " . $min;
        $conditions[] = $Model->escapeField($right) . " <= " . $max;
        if( $created ) 
        {
            $conditions["NOT"][$Model->alias . "." . $Model->primaryKey] = $Model->id;
        }

        $Model->updateAll(array( $Model->alias . "." . $field => $Model->escapeField($field) . " " . $dir . " " . $shift ), $conditions);
        $Model->recursive = $ModelRecursive;
        $Model->cacheQueries = $cachequeries;
    }

}




?>