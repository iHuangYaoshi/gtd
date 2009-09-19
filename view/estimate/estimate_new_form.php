<?php
function estimateNewForm( $e, $o = array()){
    $r =& getRenderer();
    $list_items = array(
		'Description' => $r->field( $e, 'description'),
		'Low Estimate' =>$r->field( $e, 'low_hours'),
		'High Estimate' => $r->field( $e, 'high_hours'),
		'Due Date' => $r->field( $e, 'due_date'),
		'Details' => $r->field( $e, 'notes'),
		'Project' => $r->field( $e, 'project_id')
	);	
    
    $form_contents = $r->view( 'basicList', 
    							$list_items, 
    							array( 'title'=>'Add Estimate', 'display'=>'inline')
    						  );
    						  
//	$form_contents .= $r->hidden('project_id',$e->get('project_id'));
		  
    $o['method'] = 'post';
    
    return $r->form( 'create', 'Estimate', $form_contents.$r->submit(), $o);
}
?>