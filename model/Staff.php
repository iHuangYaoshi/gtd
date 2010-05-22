<?php
class Staff extends ActiveRecord {

	var $datatable = "staff";
	var $name_field = "first_name";
        
    protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
							'first_name'	:  'text',
							'last_name'  	:  'text',
							'email'  		:  'text',
							'team'  		:  'text',
						},
			'required' : {
							
						},
			'values'{
					'team' : {'production':'Production','development':'Development','administration':'Administration'}
					}
			}";

    function __construct( $id = null){
        parent::__construct( $id);
    }
	function getName(){
		$name = $this->getData('first_name');
		if( $this->getData('last_name')) $name .= ' '.$this->getData('last_name');
		return $name;
	}
	function getProjects(){
		if(empty($this->projects)){
			$this->projects = getMany( 'Project', array("staff_id"=>$this->id));
		}
		return $this->projects;
	}
	function getHours(){
		if(empty($this->hours)){
			$this->hours = getMany( 'Hour', array("staff_id"=>$this->id));
		}
		return $this->hours;
	}
}
