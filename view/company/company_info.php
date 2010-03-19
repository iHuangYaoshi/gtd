<?php
function companyInfo( $c, $o){
	$r = getRenderer();

	$address = $c->get('street').'<br>';
	if ($c->get('street_2')) $address.= $c->get('street2').'<br>';
	if ($c->get('city')) 	 $address.= $c->get('city').',';
	$address.= $c->get('state').'<br>';
	$address.= $c->get('zip');

	$c->get('notes') ? $notes = ' 
								<div class="notes-box">
									<div class="notes-content">	
										'.nl2br($c->get('notes')).'
									</div>
								</div>'
					 : $notes = '';

	$contacts = '';
	if($primary = $c->getPrimaryContact()) $contacts.= $r->view('contactDetail',$primary);
	if($billing = $c->getBillingContact()) $contacts.= $r->view('contactDetail',$billing);
	if($technical = $c->getTechnicalContact()) $contacts.= $r->view('contactDetail',$technical);

	return '
			<div class="company-info-header">
				<div class="status">
					'.$c->get('status').'
				</div>
				<h2>
					'.$c->get('name').'
				</h2>
			</div>
			<div class="clear-both"></div>
			<div class="company-contacts">
				'.$contacts.'
			</div>
			<div class="address">
				<h4>
					Address
				</h4>
				'.$address.'<br>
				'.$c->get('phone').'
			</div>
			'.$notes.'	
			<div class="clear-both"></div>
		';
}
