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
  use Symfony\Component\Form\AbstractType;

    
class ProfileController implements ControllerProviderInterface {

	function __construct() {
	}

	public function connect(Application $app) {

            
		//@note $app['controllers_factory'] is a factory that returns a new instance of ControllerCollection when used.
		//@see http://silex.sensiolabs.org/doc/organizing_controllers.html
		$controllers = $app['controllers_factory'];

		// Bind sub-routes
		$controllers
                        ->match('/', array($this, 'main'))
			->bind('profile')
			->before(array($this, 'checkLogin'));   
                $controllers
                        ->match('/edit', array($this, 'edit'))
			->bind('profileEdit')
			->before(array($this, 'checkLogin'));   
		return $controllers;

	}
        
        
        public function main(Application $app) {       
                $username = $app['session']->get('username');                
                $user = $app['agents']->getAgentTrue($username);
                                
                $edited  = isset($app['session']->get('profile')[0])?$app['session']->get('profile'):null;
                $app['session']->remove('profile'); 
                                
                if ($handle = opendir($app['admin.base_path'])) {
                  //  echo "Directory handle: $handle\n";
                  //  echo "Entries:\n";
                   $exit = false;
                    /* This is the correct way to loop over the directory. */
                    while (false !== ($entry = readdir($handle)) && !$exit) {
                        if($entry == ($user['id'] + ".jpg")){                            
                            $logoName = $user['id'];
                            $exit = true;
                        }
                        else{                            
                            $logoName = "default";
                        }
                    }
                    closedir($handle);
                }
                
                return $app['twig']->render('admin/profile/home.twig', array(
                   "user"   => $app['session']->get('username'),
                   "profile"   => $user,
                   "edited"  => $edited,
                   "url"   => $logoName                     
                ));
        }
        
        
        
        public function edit(Application $app) {                 
                $username = $app['session']->get('username');                
                $user = $app['agents']->getAgentTrue($username);
                //var_dump($username);                
                if ($handle = opendir($app['admin.base_path'])) {
                  //  echo "Directory handle: $handle\n";
                  //  echo "Entries:\n";
                   $exit = false;
                    /* This is the correct way to loop over the directory. */
                    while (false !== ($entry = readdir($handle)) && !$exit) {
                        if($entry == ($user['id'] + ".jpg")){                            
                            $logoName = $user['id'];
                            $exit = true;
                        }
                        else{                            
                            $logoName = "default";
                        }
                    }
                    closedir($handle);
                }
                $agentID = $app['agents']->getAgentId($username);                 
                //var_dump($userID["id"]);
                
                $profileform = $app['form.factory']->createNamed('profileform')
                        ->add('Company_name', 'text', array(
                                'data' => $user['Company_name'],
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3)))
                        ))
			->add('Contact_name', 'text', array(
                                'data' => $user['Contact_name'],
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3)))
                        ))
                        ->add('Email', 'text', array(
                                'data' => $user['Email'],
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3)), new Assert\Email())
                        ))
                        ->add('Description', 'textarea', array(
                                "attr" => array("class" => "tinymce" ),
                                'data' => $user['Description'],
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
                        ))					
                        ->add('Website', 'text', array(
                                'data' => $user['Website'],
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
                        ))
                        ->add('Telephone', 'text', array(
                                'data' => $user['Telephone'],
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
                        ))
                         ->add('Address_street', 'text', array(
                                'data' => $user['Address_street'],
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
                        ))
                        ->add('Address_city', 'text', array(
                                'data' => $user['Address_city'],
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
                        ))
                        ->add('Fileupload', 'file', array(
                                'label' => 'Upload a jpg with your logo'
                        )); 
                
                $username = $app['session']->get('username');
                $userId = $app['agents']->getAgentId($username);
                // Form was submitted: process it
		if ('POST' == $app['request']->getMethod()) {
                        $profileform->bind($app['request']);
			if ($profileform->isValid()) {        
                            
				$data = $profileform->getData();
				$files = $app['request']->files->get($profileform->getName());
                                // Uploaded file must be `.jpg`!                 
                                var_dump($files);
				if (isset($files['Fileupload']) && ('.jpg' == substr($files['Fileupload']->getClientOriginalName(), -4))) {
                                        // Define the new name (files are named sequentially)                      
                                        $logoName = ((string)$userId['id'] + ".jpg");
                                        var_dump($logoName);
                                        
					$di = new \DirectoryIterator($app['admin.base_path']);
					// Move it to its new location
					$files['Fileupload']->move($app['admin.base_path']. DIRECTORY_SEPARATOR . "logos", $userId['id'] . '.jpg');
                                        var_dump($app['admin.base_path'], $userId['id'] . '.jpg');
                                        
                                }                 
                                //var_dump($userId);
                                //$id = $stageId;

                                //$title, $sector, $location, $datePosted, $dateExpires, $description, $qual, $diploma, $year, $company
                                //$name, $website, $tele, $logo, $id

                                $app['session']->set('profile', $username);  
                                $app['agents']->updateAgent($data["Company_name"], $data["Contact_name"], $data["Email"], $data["Description"], $data["Website"], $data["Telephone"], $data['Address_street'],$data['Address_city'], $userId['id']);
                                return $app->redirect($app['url_generator']->generate('profile'));  
                                exit(0);
                        }
		}              
                
		return $app['twig']->render('admin/profile/edit.twig', array(
                   'profileform' => $profileform->createView(), 
                   "user"   => $app['session']->get('username'),
                   "profile"   => $user,
                   "url"   => $logoName                     
                ));
	}
        
      
        
        public function checkLogin(Request $request, Application $app) {
		if (!$app['session']->get('username')) {
			return $app->redirect($app['url_generator']->generate('board'));    
		}
	}

}