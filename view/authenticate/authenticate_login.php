<?php
function authenticateLogin($d){
	$r = getRenderer();

	$form = new Form( array('controller'=>'Authenticate', 
							'action'=>'create_session',
							'id'=>'login-form'
							)
					);

	$form->content = '
			<div id="login-container" class="detail-list">
				<h2>Email</h2>
				<input type="text" name="email" value="'.$d->email.'" />
				<h2>Password</h2>
				<input type="password" name="password" />
				<p>'.$form->submitBtn.'</p>
			</div>
			';
	
	return array(	'title'=>'Staff Login',
					'controls'=>'',
					'body'=>$form->html
				);
}
