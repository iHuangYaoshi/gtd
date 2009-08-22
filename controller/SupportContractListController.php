<?php
class SupportContractListController extends PageController {
    var $_class_name = 'SupportContractList';

    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r =& getRenderer();
        $finder = new SupportContract();
        $companies = $finder->find(array("sort"=>"custom8,Company") ); #status, company_id

        $html = $r->view('supportContractTable', $companies, array('id'=>'support_contract'));
 
        return $r->template('template/standard_inside.html',
                            array(
                            'title'=>'Listing All Support Contracts',
                            'controls'=>'',
                            'body'=>$html
                            ));   
	}
}
?>