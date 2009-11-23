<?php
class EstimateController extends PageController {
 	protected $before_filters = array( 'get_posted_records' => array('create','update','destroy'));
 	
    function edit( $params){
   		if ( !$params['id']) bail('Required $params["id"] not present.');
		$d = $this->data;
		
		$d->estimate = new Estimate( $params['id']);
		$d->project = new Project( $d->estimate->get('project_id'));

		$d->new_hour = new Hour();
		$d->new_hour->set( array( 'estimate_id'=>$params['id'],
								  'staff_id'=>getUser(),
								  'date'=>date('Y-m-d')
								  ));
		$d->new_estimate = new Estimate();
		$d->new_estimate->set(array('project_id'=>$d->project->id));
		
		$d->estimates = $d->project->getEstimates();
		$d->hours = getMany('Hour', array('estimate_id'=>$params['id']));
    }
    function update( $params ){
    	foreach( $this->updated_estimates as $e) $e->save();
	    $this->redirectTo( array('action' => 'edit','id'=>$e->id));
    }
    function create( $params){
    	$e = $this->new_estimates[0];
    	$e->save();
    	$this->redirectTo( array('controller'=>'Project','action' => 'show','id'=>$e->get('project_id')));
    }
    function new_record(){
    }
    function destroy(){
    }
}
?>
