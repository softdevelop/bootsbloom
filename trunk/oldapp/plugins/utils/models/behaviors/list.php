<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils List Behavior
 *
 * @package utils
 * @subpackage utils.models.behaviors
 */

class ListBehavior extends ModelBehavior
{
    public $settings = array(  );
    protected $_defaults = array( "positionColumn" => "position", "scope" => "", "validate" => false, "callbacks" => false );

    public function setup($model, $config = array(  ))
    {
        $settings = array_merge($this->_defaults, $config);
        $this->settings[$model->alias] = $settings;
    }

    public function beforeSave($model)
    {
        extract($this->settings[$model->alias]);
        if( empty($model->data[$model->alias][$model->primaryKey]) ) 
        {
            $this->__addToListBottom($model);
        }

        return true;
    }

    public function beforeDelete($model)
    {
        $dataStore = $model->data;
        $model->recursive = 0;
        $model->read(null, $model->id);
        extract($this->settings[$model->alias]);
        $result = $this->removeFromList($model);
        $model->data = $dataStore;
        return $result;
    }

    private function __setById($model, $id = null, $checkId = true)
    {
        if( !isset($id) ) 
        {
            if( $checkId ) 
            {
                return isset($model->data[$model->alias][$model->primaryKey]);
            }

            return isset($model->data[$model->alias]);
        }

        return $model->read(null, $id);
    }

    public function insertAt($model, $position = 1, $id = null)
    {
        if( !$this->__setById($model, $id, false) ) 
        {
            return false;
        }

        return $this->__insertAtPosition($model, $position);
    }

    public function moveLower($model, $id = null)
    {
        if( !$this->__setById($model, $id) ) 
        {
            return false;
        }

        $lowerItem = $this->lowerItem($model);
        if( $lowerItem == null ) 
        {
            return NULL;
        }

        $currData = $model->data;
        $model->set($lowerItem);
        $this->_decrementPosition($model);
        $model->set($currData);
        return $this->_incrementPosition($model);
    }

    public function moveDown($model, $id = null)
    {
        return $this->moveLower($model, $id);
    }

    public function moveHigher($model, $id = null)
    {
        if( !$this->__setById($model, $id) ) 
        {
            return false;
        }

        $higherItem = $this->higherItem($model);
        if( $higherItem == null ) 
        {
            return NULL;
        }

        $currData = $model->data;
        $model->set($higherItem);
        $this->_incrementPosition($model);
        $model->set($currData);
        return $this->_decrementPosition($model);
    }

    public function moveUp($model, $id = null)
    {
        return $this->moveHigher($model, $id);
    }

    public function moveToBottom($model, $id = null)
    {
        if( !$this->__setById($model, $id) ) 
        {
            return false;
        }

        if( !$this->isInList($model) ) 
        {
            return NULL;
        }

        $this->__decrementPositionsOnLowerItems($model);
        return $this->__assumeBottomPosition($model);
    }

    public function moveToTop($model, $id = null)
    {
        if( !$this->__setById($model, $id) ) 
        {
            return false;
        }

        if( !$this->isInList($model) ) 
        {
            return NULL;
        }

        $this->__incrementPositionsOnHigherItems($model);
        return $this->__assumeTopPosition($model);
    }

    public function removeFromList($model, $id = null)
    {
        if( !$this->__setById($model, $id) ) 
        {
            return false;
        }

        if( $this->isInList($model) ) 
        {
            return $this->__decrementPositionsOnLowerItems($model);
        }

    }

    protected function _incrementPosition($model)
    {
        if( !$this->isInList($model) ) 
        {
            return NULL;
        }

        extract($this->settings[$model->alias]);
        $model->data[$model->alias][$positionColumn]++;
        return $model->save(null, array( "validate" => $validate, "callbacks" => $callbacks ));
    }

    protected function _decrementPosition($model)
    {
        if( !$this->isInList($model) ) 
        {
            return NULL;
        }

        extract($this->settings[$model->alias]);
        $model->data[$model->alias][$positionColumn]--;
        return $model->save(null, array( "validate" => $validate, "callbacks" => $callbacks ));
    }

    public function isFirst($model, $id = null)
    {
        if( !$this->__setById($model, $id) ) 
        {
            return false;
        }

        extract($this->settings[$model->alias]);
        if( !$this->isInList($model) ) 
        {
            return false;
        }

        return $model->data[$model->alias][$positionColumn] == 1;
    }

    public function isLast($model, $id = null)
    {
        if( !$this->__setById($model, $id) ) 
        {
            return false;
        }

        extract($this->settings[$model->alias]);
        if( !$this->isInList($model) ) 
        {
            return false;
        }

        return $model->data[$model->alias][$positionColumn] == $this->__bottomPositionInList($model);
    }

    public function higherItem($model, $id = null)
    {
        if( !$this->__setById($model, $id) ) 
        {
            return false;
        }

        extract($this->settings[$model->alias]);
        if( !$this->isInList($model) ) 
        {
            return null;
        }

        $positionColumn = $this->settings[$model->alias]["positionColumn"];
        return $model->find("first", array( "conditions" => array( $this->__scopeCondition($model), $model->alias . "." . $positionColumn => $model->data[$model->alias][$positionColumn] - 1 ), "recursive" => 0 ));
    }

    public function lowerItem($model, $id = null)
    {
        if( !$this->__setById($model, $id) ) 
        {
            return false;
        }

        extract($this->settings[$model->alias]);
        if( !$this->isInList($model) ) 
        {
            return null;
        }

        $positionColumn = $this->settings[$model->alias]["positionColumn"];
        return $model->find("first", array( "conditions" => array( $this->__scopeCondition($model), $model->alias . "." . $positionColumn => $model->data[$model->alias][$positionColumn] + 1 ), "recursive" => 0 ));
    }

    public function isInList($model)
    {
        extract($this->settings[$model->alias]);
        $positionColumn = $this->settings[$model->alias]["positionColumn"];
        if( empty($model->data[$model->alias][$positionColumn]) ) 
        {
            return false;
        }

        return $model->data[$model->alias][$positionColumn] != null;
    }

    private function __scopeCondition($model)
    {
        extract($this->settings[$model->alias]);
        $scopes = array(  );
        if( is_string($scope) ) 
        {
            if( $scope == "" ) 
            {
                return $scopes;
            }

            $scopes[$model->alias . "." . $scope] = $model->data[$model->alias][$scope];
        }
        else
        {
            if( is_array($scope) ) 
            {
                foreach( $scope as $k => $v ) 
                {
                    if( is_numeric($k) ) 
                    {
                        $scopeEl = $v;
                        $v = $model->data[$model->alias][$scopeEl];
                    }
                    else
                    {
                        $scopeEl = $k;
                    }

                    $scopes[$model->alias . "." . $scopeEl] = $v;
                }
            }

        }

        return $scopes;
    }

    private function __addToListTop($model)
    {
        return $this->__incrementPositionsOnAllItems($model);
    }

    private function __addToListBottom($model)
    {
        extract($this->settings[$model->alias]);
        $positionColumn = $this->settings[$model->alias]["positionColumn"];
        $model->data[$model->alias][$positionColumn] = $this->__bottomPositionInList($model) + 1;
    }

    private function __bottomPositionInList($model, $except = null)
    {
        extract($this->settings[$model->alias]);
        $positionColumn = $this->settings[$model->alias]["positionColumn"];
        $item = $this->__bottomItem($model, $except);
        if( !empty($item) && isset($item[$model->alias][$positionColumn]) ) 
        {
            return $item[$model->alias][$positionColumn];
        }

        return 0;
    }

    private function __bottomItem($model, $except = null)
    {
        extract($this->settings[$model->alias]);
        $conditions = $this->__scopeCondition($model);
        if( is_string($conditions) ) 
        {
            $conditions = array( $conditions );
        }

        if( $except != null ) 
        {
            $conditions = array_merge($conditions, array( $model->alias . "." . $model->primaryKey . " != " => $except[$model->alias][$model->primaryKey] ));
        }

        $model->recursive = 0;
        $options = array( "conditions" => $conditions, "order" => array( $model->alias . "." . $positionColumn => "DESC" ) );
        return $model->find("first", $options);
    }

    private function __assumeBottomPosition($model)
    {
        extract($this->settings[$model->alias]);
        $positionColumn = $this->settings[$model->alias]["positionColumn"];
        $model->data[$model->alias][$positionColumn] = $this->__bottomPositionInList($model, $model->data) + 1;
        return $model->save(null, array( "validate" => $validate, "callbacks" => $callbacks ));
    }

    private function __assumeTopPosition($model)
    {
        extract($this->settings[$model->alias]);
        $positionColumn = $this->settings[$model->alias]["positionColumn"];
        $model->data[$model->alias][$positionColumn] = 1;
        return $model->save(null, array( "validate" => $validate, "callbacks" => $callbacks ));
    }

    private function __decrementPositionsOnHigherItems($model, $position)
    {
        extract($this->settings[$model->alias]);
        return $model->updateAll(array( $model->alias . "." . $positionColumn => $model->alias . "." . $positionColumn . "-1" ), array( $this->__scopeCondition($model), $model->alias . "." . $positionColumn . " <= " => $position ));
    }

    private function __decrementPositionsOnLowerItems($model)
    {
        if( !$this->isInList($model) ) 
        {
            return NULL;
        }

        extract($this->settings[$model->alias]);
        $positionColumn = $this->settings[$model->alias]["positionColumn"];
        return $model->updateAll(array( $model->alias . "." . $positionColumn => $model->alias . "." . $positionColumn . " - 1" ), array( $this->__scopeCondition($model), $model->alias . "." . $positionColumn . " > " => $model->data[$model->alias][$positionColumn] ));
    }

    private function __incrementPositionsOnHigherItems($model)
    {
        if( !$this->isInList($model) ) 
        {
            return NULL;
        }

        extract($this->settings[$model->alias]);
        $positionColumn = $this->settings[$model->alias]["positionColumn"];
        return $model->updateAll(array( $model->alias . "." . $positionColumn => $model->alias . "." . $positionColumn . "+1" ), array( $this->__scopeCondition($model), $model->alias . "." . $positionColumn . " < " => $model->data[$model->alias][$positionColumn] ));
    }

    private function __incrementPositionsOnLowerItems($model, $position)
    {
        extract($this->settings[$model->alias]);
        $positionColumn = $this->settings[$model->alias]["positionColumn"];
        return $model->updateAll(array( $model->alias . "." . $positionColumn => $model->alias . "." . $positionColumn . "+1" ), array( $this->__scopeCondition($model), $model->alias . "." . $positionColumn . " >= " => $position ));
    }

    private function __incrementPositionsOnAllItems($model)
    {
        extract($this->settings[$model->alias]);
        return $model->updateAll(array( $model->alias . "." . $positionColumn => $model->data[$model->alias][$positionColumn] + 1 ), array( $this->__scopeCondition($model) ));
    }

    private function __insertAtPosition($model, $position)
    {
        extract($this->settings[$model->alias]);
        $data = $model->data;
        $model->data[$model->alias][$positionColumn] = 0;
        $model->save(null, array( "validate" => $validate, "callbacks" => $callbacks ));
        $model->create($data);
        $model->recursive = 0;
        $model->findById($model->id);
        $this->removeFromList($model);
        $result = $this->__incrementPositionsOnLowerItems($model, $position);
        if( $position <= $this->__bottomPositionInList($model) + 1 ) 
        {
            $model->data[$model->alias][$positionColumn] = $position;
            $result = $model->save(null, array( "validate" => $validate, "callbacks" => $callbacks ));
        }

        return $result;
    }

    public function fixListOrder($model)
    {
        extract($this->settings[$model->alias]);
        $data = $model->find("all", array( "conditions" => $this->__scopeCondition($model), "order" => array( $model->alias . "." . $positionColumn => "asc" ), "recursive" => 0 - 1 ));
        $position = 1;
        foreach( $data as $row ) 
        {
            $model->id = $row[$model->alias][$model->primaryKey];
            $model->saveField($positionColumn, $position, array( "validate" => $validate, "callbacks" => $callbacks ));
            $position += 1;
        }
    }

}




?>