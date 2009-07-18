<?php

function staffTable( $staffers, $o = array()){
    $r =& getRenderer();
    $out = array();
    $out['headers'] = array('Name','Team','Email');
    $out['rows'] =  array();
    foreach($staffers as $s){
      $out['rows'][] = array(	$r->link( 'StaffDetail', array('id'=>$s->id),$s->getName()),
      							$s->getData('team'),
      							'<a href="mailto:'.$s->getData('email').'">'.$s->getData('email').'</a>'
      							);
    }
    
    $html = $r->view( 'basicTable', $out, array('title'=>'Staff'), $o);
    return $html;
}
?>
