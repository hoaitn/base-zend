<?php
/**
 * mapController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class MapController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        // TODO Auto-generated mapController::indexAction() default action
        $where = array(
        	'city !=' => '' , 
        	'postCode !=' => '' , 
        	'lon !=' => '' , 
        	'lat !=' => '' , 
        	'phone !=' => ''
        );
		$postcodeList = Trainer::getAllPostcode();
		$trainer = array();
		for ($i = 0; $i < count($postcodeList); $i++) {		
    		$trainerList[$i] = Trainer::getGMapData($postcodeList[$i]);
    		if (is_array($trainerList[$i])) {
				$trainer = array_merge($trainerList[$i],$trainer);
    		}	
		}		
		
    	for ($j = 0; $j < count($trainer); $j ++)
    	{
    		$dataJson[$j]['name'] =  $trainer[$j]['city'];
    		$dataJson[$j]['postcode'] =  $trainer[$j]['postcode'];
    		$dataJson[$j]['total'] =  $trainer[$j]['total'];
    		$dataJson[$j]['lon'] =  $trainer[$j]['lon'];
    		$dataJson[$j]['lat'] =  $trainer[$j]['lat'];
//    		$dataJson[$i][$j]['city'] =  $trainerList[$j]['city'];
//    		$dataJson[$i][$j]['type'] =  $trainerList[$j]['type'];
//    		$dataJson[$i][$j]['phone'] =  $trainerList[$j]['phone'];
   			$dataCity = array('city' => $dataJson);
    	}
    	$dataCities = array('cities' => $dataCity);		
		$data = array('data' => $dataCities);
		$dataJson = json_encode($data);

        $this->view->data = $dataJson;
    }
}
