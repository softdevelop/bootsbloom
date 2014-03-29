<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Soft Delete Behavior
 *
 * @package utils
 * @subpackage utils.models.behaviors
 */

class SoftDeleteBehavior extends ModelBehavior
{
    public $default = array( "deleted" => "deleted_date" );
    public $runtime = array(  );

    public function setup($model, $settings = array(  ))
    {
        if( empty($settings) ) 
        {
            $settings = $this->default;
        }
        else
        {
            if( !is_array($settings) ) 
            {
                $settings = array( $settings );
            }

        }

        $error = "SoftDeleteBehavior::setup(): model " . $model->alias . " has no field ";
        $fields = $this->_normalizeFields($model, $settings);
        foreach( $fields as $flag => $date ) 
        {
            if( $model->hasField($flag) ) 
            {
                if( $date && !$model->hasField($date) ) 
                {
                    trigger_error($error . $date, E_USER_NOTICE);
                    return NULL;
                }

                continue;
            }

            trigger_error($error . $flag, E_USER_NOTICE);
            return NULL;
        }
        $this->settings[$model->alias] = $fields;
        $this->softDelete($model, true);
    }

    public function beforeFind($model, $query)
    {
        $runtime = $this->runtime[$model->alias];
        if( $runtime ) 
        {
            $query["conditions"] = is_array($query["conditions"]) ? $query["conditions"] : array(  );
            $conditions = array_filter(array_keys($query["conditions"]));
            $fields = $this->_normalizeFields($model);
            foreach( $fields as $flag => $date ) 
            {
                if( true === $runtime || $flag === $runtime ) 
                {
                    if( !in_array($flag, $conditions) && !in_array($model->name . "." . $flag, $conditions) ) 
                    {
                        $query["conditions"][$model->alias . "." . $flag] = false;
                    }

                    if( $flag === $runtime ) 
                    {
                        break;
                    }

                }

            }
            return $query;
        }

    }

    public function beforeDelete($model)
    {
        $runtime = $this->runtime[$model->alias];
        if( $runtime ) 
        {
            $res = $this->delete($model, $model->id);
            return false;
        }

        return true;
    }

    public function delete($model, $id)
    {
        $runtime = $this->runtime[$model->alias];
        $data = array(  );
        $fields = $this->_normalizeFields($model);
        foreach( $fields as $flag => $date ) 
        {
            if( true === $runtime || $flag === $runtime ) 
            {
                $data[$flag] = true;
                if( $date ) 
                {
                    $data[$date] = date("Y-m-d H:i:s");
                }

                if( $flag === $runtime ) 
                {
                    break;
                }

            }

        }
        $model->create();
        $model->set($model->primaryKey, $id);
        return $model->save(array( $model->alias => $data ), false, array_keys($data));
    }

    public function undelete($model, $id)
    {
        $runtime = $this->runtime[$model->alias];
        $this->softDelete($model, false);
        $data = array(  );
        $fields = $this->_normalizeFields($model);
        foreach( $fields as $flag => $date ) 
        {
            if( true === $runtime || $flag === $runtime ) 
            {
                $data[$flag] = false;
                if( $date ) 
                {
                    $data[$date] = null;
                }

                if( $flag === $runtime ) 
                {
                    break;
                }

            }

        }
        $model->create();
        $model->set($model->primaryKey, $id);
        $result = $model->save(array( $model->alias => $data ), false, array_keys($data));
        $this->softDelete($model, $runtime);
        return $result;
    }

    public function softDelete($model, $active)
    {
        if( is_null($active) ) 
        {
            return isset($this->runtime[$model->alias]) ? $this->runtime[$model->alias] : null;
        }

        $result = !isset($this->runtime[$model->alias]) || $this->runtime[$model->alias] !== $active;
        $this->runtime[$model->alias] = $active;
        $this->_softDeleteAssociations($model, $active);
        return $result;
    }

    public function purgeDeletedCount($model, $expiration = "-90 days")
    {
        $this->softDelete($model, false);
        return $model->find("count", array( "conditions" => $this->_purgeDeletedConditions($model, $expiration), "recursive" => 0 - 1 ));
    }

    public function purgeDeleted($model, $expiration = "-90 days")
    {
        $this->softDelete($model, false);
        $records = $model->find("all", array( "conditions" => $this->_purgeDeletedConditions($model, $expiration), "fields" => array( $model->primaryKey ), "recursive" => 0 - 1 ));
        if( $records ) 
        {
            foreach( $records as $record ) 
            {
                $model->delete($record[$model->alias][$model->primaryKey]);
            }
            return true;
        }

        return false;
    }

    protected function _purgeDeletedConditions($model, $expiration = "-90 days")
    {
        $purgeDate = date("Y-m-d H:i:s", strtotime($expiration));
        $conditions = array(  );
        foreach( $this->settings[$model->alias] as $flag => $date ) 
        {
            $conditions[$model->alias . "." . $flag] = true;
            if( $date ) 
            {
                $conditions[$model->alias . "." . $date . " <"] = $purgeDate;
            }

        }
        return $conditions;
    }

    protected function _normalizeFields($model, $settings = array(  ))
    {
        $settings = empty($settings) ? $this->settings[$model->alias] : $settings;
        $result = array(  );
        foreach( $settings as $flag => $date ) 
        {
            if( is_numeric($flag) ) 
            {
                $flag = $date;
                $date = false;
            }

            $result[$flag] = $date;
        }
        return $result;
    }

    protected function _softDeleteAssociations($model, $active)
    {
        if( empty($model->belongsTo) ) 
        {
            return NULL;
        }

        $fields = array_keys($this->_normalizeFields($model));
        $parentModels = array_keys($model->belongsTo);
        foreach( $parentModels as $parentModel ) 
        {
            foreach( array( "hasOne", "hasMany" ) as $assocType ) 
            {
                if( empty($model->$parentModel->$assocType) ) 
                {
                    continue;
                }

                foreach( $model->$parentModel->$assocType as $assoc => $assocConfig ) 
                {
                    $modelName = empty($assocConfig["className"]) ? $assoc : $assocConfig["className"];
                    if( $model->alias != $modelName ) 
                    {
                        continue;
                    }

                    $conditions =& $model->$parentModel->$assocType[$assoc]["conditions"];
                    if( !is_array($conditions) ) 
                    {
                        $model->$parentModel->$assocType[$assoc]["conditions"] = array(  );
                    }

                    $multiFields = 1 < count($fields);
                    foreach( $fields as $field ) 
                    {
                        if( $active ) 
                        {
                            if( !isset($conditions[$field]) && !isset($conditions[$assoc . "." . $field]) ) 
                            {
                                if( is_string($active) ) 
                                {
                                    if( $field == $active ) 
                                    {
                                        $conditions[$assoc . "." . $field] = false;
                                    }
                                    else
                                    {
                                        if( isset($conditions[$assoc . "." . $field]) ) 
                                        {
                                            unset($conditions[$assoc . "." . $field]);
                                        }

                                    }

                                }
                                else
                                {
                                    if( !$multiFields ) 
                                    {
                                        $conditions[$assoc . "." . $field] = false;
                                    }

                                }

                            }

                        }
                        else
                        {
                            if( isset($conditions[$assoc . "." . $field]) ) 
                            {
                                unset($conditions[$assoc . "." . $field]);
                            }

                        }

                    }
                }
            }
        }
    }

}




?>