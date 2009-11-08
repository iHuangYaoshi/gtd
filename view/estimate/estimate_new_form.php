<?php
function estimateNewForm( $e, $o = array()){
    $r =& getRenderer();

    $form = new Form( array( 'controller'=>'Estimate', 'action'=>'create'));
    $fs = $form->getFieldSetFor($e);

    $list_items = array(
		'Description' => 	$fs->description,
		'Low Estimate' =>	$fs->low_hours,
		'High Estimate' => 	$fs->high_hours,
		'Due Date' => 		$fs->due_date,
		'Details' => 		$fs->notes,
		'Project' => 		$fs->project_id
	);	
    
    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'Add Estimate', 'display'=>'inline')
    						  );
    						  
//	$form_contents .= $r->hidden('project_id',$e->get('project_id'));
		  
    
    return $form->html;
}
?>