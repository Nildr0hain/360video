<?php

namespace Saradebbaut\Provider\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Silex\Provider\FormServiceProvider;

class HomeController implements ControllerProviderInterface {

	function __construct() {
	}

	public function connect(Application $app) {           
		//@note $app['controllers_factory'] is a factory that returns a new instance of ControllerCollection when used.
		//@see http://silex.sensiolabs.org/doc/organizing_controllers.html
		$controllers = $app['controllers_factory'];

		// Bind sub-routes
		$controllers
                        ->match('/', array($this, 'main'))
			->bind('home.view'); 
		return $controllers;

	}
        
        public function main(Application $app) {  
                             
                
		return $app['twig']->render('static/home.twig', array(
                    
                ));
	}
        

}