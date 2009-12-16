<?php

function paymentShow( $d ) {
	$r = getRenderer( );

    $title = $d->company->getName();

	$company_info = '	<div class="detail-list float-left"> 
	 						'.$r->view( 'companyInfo', $d->company).'
						</div>';

    $payment_edit_form = '	<div id="payment-edit-container">
    				   		'.$r->view( 
								  	'paymentEditForm', 
    				   			  	$d->payment, 
								  	array('class'=>'clear-left')
    				   			  	).'
    				   	</div>';

	$hidden_forms = $r->view('jsHideable',array(
						'New Payment'	=> $r->view(
												'paymentNewForm', 
												$d->new_payment, 
												array('company_id'=>$d->company->id)
											   ),
    				   	'Edit Payment' => $r->view( 
											  	'paymentEditForm', 
    				   						  	$d->payment
    				   			  			   )
					), 
					array( 'open_by_default' => array( 'Edit Payment' ) )
					);


    $payment_table = $r->view('paymentTable', $d->company->getPayments(), array('title'=>'payments for '.$d->company->getName()));


    return array(   'title' 	=> $title,
                    'body' 		=> 	$company_info
                    				.$hidden_forms
                    				.$payment_table
    								);

}