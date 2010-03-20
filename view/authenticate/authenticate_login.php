<?php
function authenticateLogin($d){
	$r = getRenderer();

	$form = new Form( array('controller'=>'Authenticate', 
							'action'=>'create_session',
							'id'=>'login-form'
							)
					);

	$form->content = $r->classSelect( 'Staff', array('name'=>'id'));

	$html = '
			<div id="login-container" class="detail-list">
				<h2>Choose your Character:</h2>
				'.$form->html.'
			</div>
			';

	return array(	'title'=>'Staff Login',
					'controls'=>'',
					'body'=>$html
				);
}
