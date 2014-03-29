<?php
/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 *
 */
class Page extends PagesAppModel {

    /**
     * Behaviors
     *
     * @var array
     */
    public $actsAs = array('Containable', 'MultiValidatable', 'Search.Searchable');
    /**
     * Additional Find methods
     *
     * @var array
     */
    public $_findMethods = array('search' => true);
    /**
     * @todo comment me
     *
     * @var array
     */
    public $filterArgs = array(
        array('name' => 'title', 'type' => 'string'),
    );
    /**
     * Name
     *
     * @var string
     */
    public $name = 'Page';
    /**
     * Validation parameters
     *
     * @var array
     */
    public $validate = array();

    /**
     * Constructor
     *
     * @param string $id ID
     * @param string $table Table
     * @param string $ds Datasource
     */
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validationSets = array(
            'add_page' => array(
                'title' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'Please enter title', true))
                    ),
                'description' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'Please enter description', true))),
                'metadescription' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'Please enter meta description', true))),
                'metakeyword' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'Please enter meta keyword', true))),
            ),
            'contact_us' => array(
                'question' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'plz_enter_question', true))),
                'details' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'plz_enter_details', true))),
                'name' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'plz_enter_name', true))),
                'email' => array(
                    'required' => array(
                        'rule' => array('email', true),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'plz_enter_email', true))),
                'question_about' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'plz_select_question_abt', true)))
            ),
	    'add_page_hy' => array(
                'title_hy' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'Please enter title', true))),
                'description_hy' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'Please enter description', true))),
                'metadescription_hy' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'Please enter meta description', true))),
                'metakeyword_hy' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'Please enter meta keyword', true))),
                'position' => array(
                    'required' => array(
                        'rule' => array('notEmpty'),
                        'required' => true, 'allowEmpty' => false,
                        'message' => __d('pages', 'Please enter position of page', true))),
            ),
        );
    }
    /**
     * After save callback
     *
     * @param boolean $created
     * @return void
     */
    public function afterSave($created) {
        if ($created) {
            if (!empty($this->data[$this->alias]['slug'])) {
                if ($this->hasField('url')) {
                    $this->saveField('url', '/pages/' . $this->data[$this->alias]['slug'], false);
                }
            }
        }
    }

    function title($data) {
        return "Select title from pages WHERE value LIKE '%" . $data['title'] . "%'  AND field = 'Page.title'";
    }
	
	
	
}
