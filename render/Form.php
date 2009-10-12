<?php
class Form extends PHP5_Accessor{

	public $content;
	public $controller;
	public $action;
	public $method;

	private $new_object_counters = array();
	private $does_submit_button_exist = false;
	
	function __construct( $o = array()){
		$this->controller = $o['controller'];
		$this->action = $o['action'];
		isset($o['method'])	? $this->method = $o['method']
							: $this->method = 'post';
	}
	function getSubmitBtn(){
		$this->does_submit_button_exist = true;
		$r = getRenderer();
		return  $r->submit();
	}
	function getHtml(){
		$r = getRenderer();
		
		if (!$this->does_submit_button_exist) $this->content .= $r->submit();
		
		$html = $r->form( $this->action, 
						  $this->controller, 
						  $this->content, 
						  array('method'=>$this->method)
						 );
		return $html;
	}
	function getFieldsFor( $obj){
		if( !is_a( $obj, 'ActiveRecord')) bail('Cannot get fields for non-ActiveRecord objects');

		$obj->id	? $fields = new FieldCollection( $obj)
					: $fields = new FieldCollection( $obj, $this->incrementNewObjectCounterFor( $obj));

		return $fields;
	}
	private function incrementNewObjectCounterFor( $obj){
		$class = get_class( $obj);

		isset($this->new_object_counters[$class])	? $this->new_object_counters[$class]++
													: $this->new_object_counters[$class] = 0;

		return $this->new_object_counters[$class];
	}
}
?>