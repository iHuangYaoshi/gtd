<?php
/**
    Main Utilities
    
    Helper functions used throughout the system.
    
    @package utility
*/
function bail( $msg){
	$html = '';
	if (class_exists('Router')){
		$router = Router::singleton();
		$html .= '
				<h1 style="margin-bottom:0;">'.$router->controller.'</h1>
				<h3 style="margin:4px 0;">Action: '.$router->action.'</h3>
				<h3 style="margin:4px 0;">Method: '.$router->method.'</h3>
				<h3 style="margin:6px 0 2px 0;"><u>Params</u></h3></dt> 
				'.$router->params_to_str().'
				';
	}
	$html .= '<h2 style="margin-bottom:2px;">ERRORS</h2>'.$msg.'<br>';
	$trace = debug_backtrace();
	$html .= '<h2 style="margin-bottom:6px;">BACKTRACE</h2>';
	foreach( $trace as $t){
		$html .= '
					FILE: '.$t['file'].'<br>
					LINE: '.$t['line'].'<br>
				 ';

		isset($t['class'])	?  $function = $t['class'].'->'.$t['function']
							:  $function = $t['function'];
		$html .= 'FUNCTION: '. $function .'<br><br>';
	}
	echo $html;
	trigger_error( strip_tags($msg));
	exit();
}
function &getRenderer(){
	static $render = null;
	if( $render === null) $render = new Render();
	return $render;
}
function getDbcon(){
	return AMP_Registry::getDbcon();
}
function getOne( $class, $search_criteria = array()){
	$finder = new $class();
	$objects = $finder->find( $search_criteria);
	return array_shift($objects);
}
function getMany( $class, $search_criteria = array()){
	$finder = new $class();
	$objects = $finder->find( $search_criteria);
	return $objects;
}
function getAll( $class){
	$finder = new $class;
	$objects = $finder->find( array());
	return $objects;
}
?>
