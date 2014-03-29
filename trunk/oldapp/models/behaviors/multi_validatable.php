<?php 
//
// This source code was recovered by Recover-PHP.com
//


class MultiValidatableBehavior extends ModelBehavior
{
    public $__oldRules = array(  );
    public $__defaultRules = array(  );

    public function setUp($model, $config = array(  ))
    {
        $this->__defaultRules[$model->name] = $model->validate;
    }

    public function setValidation($model, $rules = array(  ))
    {
        if( is_array($rules) ) 
        {
            $this->_setValidation($model, $rules);
        }
        else
        {
            if( isset($model->validationSets[$rules]) ) 
            {
                $this->setValidation($model, $model->validationSets[$rules]);
            }

        }

    }

    public function restoreValidation($model)
    {
        $model->validate = $this->__oldRules[$model->name];
    }

    public function restoreDefaultValidation($model)
    {
        $model->validate = $this->__defaultRules[$model->name];
    }

    public function _setValidation($model, $rules)
    {
        $this->__oldRules[$model->name] = $model->validate;
        $model->validate = $rules;
    }

}
