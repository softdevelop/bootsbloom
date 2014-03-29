<?php 
//
// This source code was recovered by Recover-PHP.com
//


class StaredProject extends AppModel
{
    public $name = "StaredProject";
    public $belongsTo = array( "Project" );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );

}
