<?php

namespace Saradebbaut\Provider\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Locale\Locale;
use Silex\Provider\FormServiceProvider;

/**
 * TO DO HERE: 
 *  
 * @login
 *      zorg dat data gecontroleerd word          
 *    +      * Zorg dat je checkt of het een email  is
 *          * PW moet lang genoeg zijn + cijfers
 *    +      * login var = use when cookie with name made
 * 
 * @register 
 *          * check of er cijfers en hoofdletters in het passwoord zitten
 *          * zet email in LOWERCASE
 *  
 * 
 */
        

class AdminController implements ControllerProviderInterface {

	function __construct() {            
	}

	public function connect(Application $app) {                 
		//@note $app['controllers_factory'] is a factory that returns a new instance of ControllerCollection when used.
		//@see http://silex.sensiolabs.org/doc/organizing_controllers.html
		$controllers = $app['controllers_factory'];

		// Bind sub-routes
		$controllers
                        ->match('/', array($this, 'login'))
                        ->bind('admin')
			->before(array($this, 'checkLogin'));
		$controllers
                        ->match('/logout', array($this, 'logout'))
                        ->bind('logout');
                $controllers
			->match('/register', array($this, 'register'))
			->method('GET|POST')
                        ->bind('register')
			->before(array($this, 'checkLogin'));
                
		return $controllers;
	}
               
        
        public function logout(Application $app) {
                $app['session']->remove('loggedIn'); 
                $app['session']->remove('username'); 
                
		return $app->redirect($app['url_generator']->generate('admin'));   
	}        
       
        public function login(Application $app) {		
		// Create Form
                $name = "";
                if(isset($_COOKIE["username"])){
                    $name = $_COOKIE["username"];                   
                };
                //echo $_COOKIE["username"];
		$loginform = $app['form.factory']->createNamed('loginform')
			->add('username', 'text', array(
                                'data' => $name,
                                'label' => "Username :",
                                'attr' => array("autocomplete"=>"off"),
                                'attr' => array("class"=>"input-block-level"),
                                'attr' => array("placeholder"=>"Username"),
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)), new Assert\Email())
			))
			->add('password', 'password', array(   
                                'label' => "Password :",                         
                                'attr' => array("autocomplete"=>"off"),
                                'attr' => array("class"=>"input-block-level"),
                                'attr' => array("placeholder"=>"Password"),
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
			));            
            
                // Form was submitted: process it
		// Form was submitted: process it
		if ('POST' == $app['request']->getMethod()) {
			$loginform->bind($app['request']);

			if ($loginform->isValid()) {
				$data = $loginform->getData();
                                $agents = $app['agents']->getAgents();
                                $password = $data['password'];
                                $username = $data['username'];
                                $password = sha1($password . PASSWORD_SALT);
                                $agent = $app['agents']->getAgentTrue($username);  
                                // Valid login
                                if ($agent != 0) {
                                        // store name in a cookie which expires in a week from now
                                        setcookie('username', $username, time() + 60*60*24*7);
                                        $app['session']->set('loggedIn', true);
                                        $app['session']->set('username', $username);
                                        return $app->redirect($app['url_generator']->generate('browse')."?page=1");                              			
                                        exit(0);
                                }else{
                                        $loginform->get('password')->addError(new \Symfony\Component\Form\FormError('Invalid password'));
                                }
			}
		}
		return $app['twig']->render('admin/home.twig', array('loginform' => $loginform->createView()));
	}
        
        
        public function register(Application $app) {

		$registerform = $app['form.factory']->createNamed('registerform')
			
                        ->add('company', 'text', array(
                                'label' => "The companies name",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
			))
                        ->add('name', 'text', array(
                                'label' => "Your name",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
			))
                        ->add('email', 'text', array(
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)), new Assert\Email())
			))
			->add('password', 'password', array(
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
		));         
            
                // Form was submitted: process it
		if ('POST' == $app['request']->getMethod()) {
			$registerform->bind($app['request']);
                        
                        $ids = $app['agents']->getId(); 
                        $ids = (int)$ids['id'] + 1;
                        //var_dump($ids);

			if ($registerform->isValid()) {
				$data = $registerform->getData();				
                                
                                $username = $data['email'];
                                $agentExists = $app['agents']->getAgentTrue($username); 

                                $password = $data['password'];
                                $password = sha1($password . PASSWORD_SALT);
                                // Valid register
                                if ($agentExists ==  false) {
                                        // store name in a cookie which expires in a week from now
                                        $agentExists = $app['agents']->insertAgent($ids, $data['company'], $data['name'],  $username ,$password); 
                                        
                                        if ($agentExists ==  true) {
                                            setcookie('username', $username, time() + 60*60*24*7);
                                            $app['session']->set('loggedIn', true);
                                            $app['session']->set('username', $username);
                                        }
                                        
                                            
                                        return $app->redirect($app['url_generator']->generate('browse')."?page=1");  
                                        var_dump($agentExists);
                                        exit(0);
                                }else{
                                        $registerform->get('password')->addError(new \Symfony\Component\Form\FormError('User allready exists'));
                                }   
                        }
		}
		return $app['twig']->render('admin/register.twig', array('registerform' => $registerform->createView()));
	}
        
        public function checkLogin(Request $request, Application $app) {
		if ($app['session']->get('username')) {
			return $app->redirect($app['url_generator']->generate('browse')."?page=1");    
		}
	}
}