<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Archive Component
 *
 * @package utils
 * @subpackage utils.controllers.components
 */

class ArchiveComponent extends Object
{
    protected $_parameters = array( "year", "month", "day" );
    public $controller = null;
    public $modelName = null;
    public $dateField = "created";

    public function startup($controller)
    {
        $this->controller =& $controller;
        if( empty($this->modelName) ) 
        {
            $this->modelName = $controller->modelClass;
        }

        $parsedParams = array(  );
        foreach( $this->_parameters as $param ) 
        {
            if( isset($controller->params[$param]) && is_numeric($controller->params[$param]) ) 
            {
                $parsedParams[$param] = $controller->params[$param];
            }

        }
        if( empty($parsedParams) ) 
        {
            return false;
        }

        if( method_exists($controller->{$this->modelName}, "buildArchiveConditions") ) 
        {
            $archiveConditions = $controller->{$this->modelName}->buildArchiveConditions($parsedParams);
        }
        else
        {
            $archiveConditions = $this->_buildArchiveConditions($parsedParams);
        }

        $paginate = array(  );
        if( !empty($controller->paginate[$this->modelName]) ) 
        {
            $paginate = $controller->paginate[$this->modelName];
        }

        if( isset($paginate["conditions"]) ) 
        {
            $paginate["conditions"] = array_merge($paginate["conditions"], $archiveConditions);
        }
        else
        {
            $paginate["conditions"] = $archiveConditions;
        }

        $controller->paginate[$this->modelName] = $paginate;
        return true;
    }

    public function archiveLinks($conditions = array(  ))
    {
        $modelName = $this->modelName;
        $defaults = array( "order" => array( "" . $modelName . "." . $this->dateField => "DESC" ), "fields" => array( "" . $modelName . "." . $this->dateField, "COUNT(*) AS month_count" ), "conditions" => array(  ), "group" => array( "" . "MONTH(" . $modelName . "." . $this->dateField . ")", "" . "YEAR(" . $modelName . "." . $this->dateField . ")" ), "limit" => 10 );
        $conditions = Set::merge($defaults, $conditions);
        $elements = $this->controller->$modelName->find("all", $conditions);
        $dates = array(  );
        foreach( $elements as $element ) 
        {
            $date = $element[$modelName][$this->dateField];
            $year = date("Y", strtotime($date));
            $month = date("m", strtotime($date));
            $count = $element[0]["month_count"];
            $dates[] = compact("year", "month", "count");
        }
        return $dates;
    }

    protected function _buildArchiveConditions($dateParams)
    {
        $duration = "1 month";
        extract($dateParams, EXTR_SKIP);
        if( !isset($year) ) 
        {
            $year = date("Y");
            $duration = "1 year";
        }

        if( !isset($month) || 12 < $month || $month < 1 ) 
        {
            $month = "01";
            $duration = "1 year";
        }

        if( !isset($day) || 31 < $day || $day < 1 ) 
        {
            $day = "01";
        }
        else
        {
            $duration = "2 days";
        }

        $startDate = sprintf("%s-%s-%s", $year, $month, $day);
        if( time() < strtotime($startDate) ) 
        {
            $this->cakeError("error", array( "name" => sprintf(__d("utils", "No %s found for that date range"), Inflector::humanize(Inflector::pluralize($this->modelName))), "message" => $this->controller->here, "code" => 404 ));
            $this->_stop();
        }

        $endDatetime = new DateTime($startDate);
        $endDatetime->modify($duration);
        $endDatetime->modify("-1 day");
        $endDate = $endDatetime->format("Y-m-d");
        $field = $this->modelName . "." . $this->dateField . " BETWEEN ? AND ?";
        return array( $field => array( $startDate, $endDate ) );
    }

}
