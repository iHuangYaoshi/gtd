<?php

class Staff extends ActiveRecord {

	var $datatable = "userdata";
	var $name_field = "First_Name";
	var $_class_name = "Staff";
	var $_search_criteria_global = array( "modin = 65");
	var $projects;
    protected static $schema_json = "{	
			'fields'   : {	
							'first_name'  :  'text',
							'last_name'  :  'text',
							'email'  :  'text',
							'basecamp_id'  :  'int',
							'team'  :  'text',
						},
			'required' : {
							
						}
			}";
    function __construct( $id = null){
        parent::__construct( $id);
        $this->mergeData(array("modin"=>"65"));
    }
	function getName(){
		$name = $this->getData('first_name');
		if( $this->getData('last_name')) $name .= ' '.$this->getData('last_name');
		return $name;
	}
	function getProjects(){
		if(!$this->projects){
			$this->projects = getMany( 'Project', array("staff_id"=>$this->id));
		}

		return $this->projects;
	}
	function _adjustSetData($data) {
		$this->legacyFieldName($data,'First_Name', "first_name" );
		$this->legacyFieldName($data,'Last_Name', "last_name" );
		$this->legacyFieldName($data,'Email', "email" );
		$this->legacyFieldName($data,'custom1', "basecamp_id" );
		$this->legacyFieldName($data,'custom2', "team" );
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaFirstName( $value ) {
		return $this->_makeCriteriaEquals( 'First_Name', $value );
	}
	function makeCriteriaLastName( $value ) {
		return $this->_makeCriteriaEquals( 'Last_Name', $value );
	}
	function makeCriteriaEmail( $value ) {
		return $this->_makeCriteriaEquals( 'Email', $value );
	}
	function makeCriteriaBasecampId( $value ) {
		return $this->_makeCriteriaEquals( 'custom1', $value );
	}
	function makeCriteriaTeam( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
}

?>
