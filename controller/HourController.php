<?php
class HourController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );
	
    function index( $params ){
        $d = $this->data;
        $a_year_ago = date('Y-m-d', time() - ( 60 * 60 * 24 * 180 ));
        $default_query = array( 'hour_search' => array('start_date' => $a_year_ago), 
								'sort' => 'date DESC');
        $hour_query = array_merge($default_query, $this->search_params('hour_search'));

		$d->hours = getMany( 'Hour',$hour_query); 
		$d->new_hour = new Hour();
		$d->new_hour->set( array( 'staff_id'=>getUser(),
								  'date'=>date('Y-m-d')
								  ));
		$d->new_support_hour = new Hour();
        $d->new_support_hour->set( array( 
                                  'staff_id'=>getUser(),
								  'date'=>date('Y-m-d')
								  ));
    
    }

    function show( $params ){
		if ( !$params['id']) bail('Required $params["id"] not present.');

    	$d = $this->data;

        $d->hour = new Hour( $params['id']);
	    $d->estimate = new Estimate( $d->hour->get('estimate_id'));
        $d->project = new Project( $d->estimate->get('project_id'));

		$d->new_hour = new Hour();
		$d->new_hour->set( array( 'estimate_id'=>$params['id'],
								  'staff_id'=>getUser(),
								  'date'=>date('Y-m-d')
								  ));
		$d->projects = Project::getAll();								  
		$d->new_estimate = new Estimate();
		$d->new_estimate->set(array('project_id'=>$d->project->id));
    }
    function update( $params ){
    	$h = $this->updated_hours[0];
		$h->save();
		$project_id = $h->getProject()->id;
        $this->redirectTo(array('controller' => 'Project', 
        						'action' => 'show', 
        						'id' => $project_id 
        						));
    }
    function new_form( $params ){
		if(!$params['project_id']) bail('required parameter "project_id" is missing.');
	
		$project = new Project( $params['project_id'] );

		$this->options = array( 'project_id' => $project->id,
							   'title' => $project->getName()
							   );
		

		$this->data = new Hour();
		$this->data->set(array( 
								'staff_id'=>getUser(),
								'date'=>date('Y-m-d')
								));
		
    }
	function edit_form( $params ){
		if(!$params['project_id']) bail('required parameter "project_id" is missing.');
		if(!$params['hour_id']) bail('required parameter "id" is missing.');
	
		$this->data->project = new Project( $params['project_id'] );

		$this->options = array( 'project_id' => $this->data->project->id,
							   'title' => $this->data->project->getName()
							   );
		

		$this->data = new Hour( $params['hour_id']);
	}
    function create( $params){
		$h = $this->new_hours[0];
		$h->save();
        $this->redirectTo(array('controller' => 'Project', 
        						'action' => 'show', 
        						'id' => $h->getProject()->id
        						));
	}

	function search($params){
		$this->data = Hour::getMany(  $params);
		$this->options = $params;
	}

    function destroy($params){
		if(empty($params['id'])) bail('required param["id"] not set.');
		$hour = new Hour($params['id']);
		$project_id = $hour->getProject()->id;
		$hour->destroy();
		$this->redirectTo(array(
							'controller'=>'Project',
							'action'=>'show',
							'id'=>$project_id
							));
	}
}
