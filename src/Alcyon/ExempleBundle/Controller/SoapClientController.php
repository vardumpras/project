<?php

namespace Alcyon\ExempleBundle\Controller;

use Alcyon\CoreBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/soapclient")
 */
class SoapClientController extends Controller
{
    /**
      * @Route("/soapclient/{source}/{secret}/{codeclient}/{password}", name="soapclient",
      * requirements={"source" = "\w+", "secret" = "\w+", "codeclient" = "\w+"})
      * @Template
     */
    public function soapclientAction($source, $secret, $codeclient, $password)
    {
        $revCrypt = $this->get("alcyon_core.service.revCrypt");

    	$sig = $revCrypt->code(date('Ymd').'$'.$codeclient.$secret, '69test?');//$password);

	    $context = array('http' =>
	        array(
	            'header'  => 'Authorization: '.$source.' '.$codeclient.':'.$sig
	        )
	    );
 
        echo $source.' '.$codeclient.':'.$sig;
        
	    $soap_options = array(
	        'soap_version' => SOAP_1_2,
            'cache_wsdl' => 0,
	        'encoding' => 'UTF-8',
	        'exceptions' => FALSE,
	        'stream_context' => stream_context_create($context),
            'location' => 'http://developpement.alcyon.com/webservices'
	    );
        
	    try {
	        $soapClient = new \SoapClient("http://developpement.alcyon.com/webservices?wsdl", $soap_options);
            
            $object = new \stdClass();
            $object->codeclient = '107480';

            $message = $soapClient->getalladresse($object);

	    } catch (\SoapFault $fault) {
	        $message = "error";
	    }
        
        return array('message' =>  $message);
    }
}
