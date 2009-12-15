<?php
function supporthourTable( $hours, $o = array()){
    $r =& getRenderer();
    if( !$hours ) return false;
    $table = array();
    $table['headers'] = array(	'ID',
    							'Description',
                                'Date Completed',
    							'Staff',
    							'Hours',
    							'Discount',
    							'Billable Hours'
    							);
    $table['rows'] =  array();
    foreach($hours as $h){
      $table['rows'][] = array(	$h->id,
      							$r->link( 'SupportHour', array('action'=>'show','id'=>$h->id),$h->getName()),
      							$h->getData('date'),
      							$h->getStaffName(),
      							$h->getHours(),
      							$h->getDiscount(),
      							$h->getBillableHours()
      							);
    }
    if ( !isset($o['title'])) $o['title'] = 'Hours';
    $html = $r->view( 'basicTable', $table, $o);
    return $html;
}