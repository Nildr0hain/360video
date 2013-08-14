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

use Acme\TaskBundle\Form\DataTransformer\IssueToNumberTransformer;
/**
 * TO DO HERE: 
 *  
 *  OVERZICHT
 *   +    sorten op datum
 * 
 *  EDIT
 *    +   ZORG DAT DROPDOWNS INGEVULD ZIJN
 * 
 */
        

class RealEstateController implements ControllerProviderInterface {

	function __construct() {
	}

	public function connect(Application $app) {
            
		//@note $app['controllers_factory'] is a factory that returns a new instance of ControllerCollection when used.
		//@see http://silex.sensiolabs.org/doc/organizing_controllers.html
		$controllers = $app['controllers_factory'];

		// Bind sub-routes
                $controllers
                        ->match('/', array($this, 'main'))
			->before(array($this, 'checkLogin'))
			->bind('realestate');  
		$controllers
                        ->match('/browse', array($this, 'main'))
			->before(array($this, 'checkLogin'))
			->bind('browse'); 
                $controllers
                        ->match('/details', array($this, 'details'))
			->before(array($this, 'checkRightId'))
			->before(array($this, 'checkLogin'))  
			->bind('details');             
                $controllers
                        ->match('/edit', array($this, 'edit'))
			->before(array($this, 'checkRightId'))
			->before(array($this, 'checkLogin'));
                $controllers
                        ->match('/delete', array($this, 'delete'))
			->before(array($this, 'checkRightId'))
			->before(array($this, 'checkLogin'))
			->bind('delete');
                
		$controllers
                        ->match('/add', array($this, 'add'))
			->before(array($this, 'checkLogin'))
			->bind('add');

		return $controllers;

	}
        
        public function main(Application $app) {  
                //var_dump($app['session']->get('deleted')[0]);
                $deleted  = isset($app['session']->get('deleted')[0])?$app['session']->get('deleted'):null;
                $app['session']->remove('deleted'); 
                $added  = isset($app['session']->get('added')[0])?$app['session']->get('added'):null;
                $app['session']->remove('added'); 
                $edited  = isset($app['session']->get('edited')[0])?$app['session']->get('edited'):null;
                $app['session']->remove('edited'); 
                $wrong  = isset($app['session']->get('Wrong')[0])?$app['session']->get('Wrong'):null;
                $app['session']->remove('Wrong'); 
               
               // -------------------------------- Get base data --------------------------------------------- //     
                $username = $app['session']->get('username');
                $userId = $app['agents']->getAgentId($username);
                $userId = $userId['id'];
                //var_dump($userId);                
                
                
                // number of items on page 
                $pageItems = 7;
                //Current page
                $page = $app['request']->get('page');
                if ($page == 0 || $page < 0)  { 
                    $page = 1; 
                }  
                
               // -------------------------------- Filtering --------------------------------------------- //     
                $searchform = $app['form.factory']->createNamed('searchform')
			->add('searchItem', 'text', array(
                                'label' => "Fill in any keyword",
                                'attr' => array("autocomplete"=>"off"),
                                'attr' => array("class"=>"input-block-level search-query"),
                                'attr' => array("placeholder"=>"Name; type; price; size ..."),
                                'data' => isset($app['session']->get('filterItems')[0])? implode("; ", $app['session']->get('filterItems')): "")
			)
                        ->add('available', 'choice', array(
                                'choices' => array('1' => 'Available', '0' => 'Not available'),
                                'data' => isset($app['session']->get('serialize')["available"])? array_search($app['session']->get('serialize')["available"], array('0', '1')) : array_search('Available', array('1' => 'Available', '0' => 'Not available'))
                        ))
                        ->add('offer', 'choice', array(
                                'choices' => array('Rent' => 'Rent', 'Buy' => 'Buy'),
                                'data' => isset($app['session']->get('serialize')["offer"])? array_search($app['session']->get('serialize')["offer"], array('Rent', 'Buy')) : array_search('Rent', array('Rent' => 'Rent', 'Buy' => 'Buy'))
                        )); 
                // Form was submitted: process it
		// Form was submitted: process it
		if ('POST' == $app['request']->getMethod()) {
			$searchform->bind($app['request']);
			if ($searchform->isValid()) {                                        
                                $page = 1;     
				$data = $searchform->getData();
                                //var_dump($data);
                                //$data['available'] $data['searchItem'] 
                                $data['searchItem'] = str_replace('\'', '', $data['searchItem']);
                                $data['searchItem'] = str_replace('-', '', $data['searchItem']);
                                if ( $data['searchItem'] != null) {
                                    $filterItems = explode('; ', $data['searchItem']); 
                                    foreach ($filterItems as $key => $value) {                                     
                                        $filterItems[$key] = $app->escape($value);
                                    }
                                }else{
                                    $filterItems = null;
                                }
                                
                                //var_dump($filterItems);
                                //var_dump($app['session']->get('filterItems'));
                                                     
                                if(isset($data['available']) && $data['available'] == 1){
                                    $serialize["available"] = 1;
                                }else{
                                    $serialize["available"] = 0;
                                }    
                                if(isset($data['offer']) && $data['offer'] == "Rent"){
                                    $serialize["offer"]= "Rent";
                                }else{
                                    $serialize["offer"]= "Buy";
                                }  
                                
                                if(isset($_POST["reset"])){
                                    echo "Reset den boel";
                                    $serialize = [
                                                     "available"  => 1,
                                                     "offer" => "Rent"
                                                  ];
                                    $app['session']->set('serialize', $serialize);
                                    $app['session']->set('filterItems', null);
                                     return $app->redirect($app['url_generator']->generate('browse')."?page=1");      
                                 }                    
                        }                      
		}      
                //var_dump(isset($filterItems)?$filterItems:null);    
                $app['session']->set('filterItems', isset($filterItems)?$filterItems:null);      
                $app['session']->set('serialize', isset($serialize)?$serialize:array(
                                                                                        "available" => 1,
                                                                                        "offer" => "Rent",
                                                                                    ));
                
                //var_dump($app['session']->get('filterItems'));
                $showOnScreen = $app['realestates']->getPropertiesFilter(($page-1) * $pageItems, ($page*$pageItems), $app['session']->get('serialize')["available"],$app['session']->get('serialize')["offer"], isset($app['session']->get('filterItems')[0])?$app['session']->get('filterItems'):null , $userId); 
                $count = $app['realestates']->getPropertiesFilterCount($app['session']->get('serialize')["available"],$app['session']->get('serialize')["offer"], isset($app['session']->get('filterItems')[0])?$app['session']->get('filterItems'):null , $userId); 
                //var_dump($showOnScreen);        
                                
               // -------------------------------- PAGINATION: funtional --------------------------------------------- //     
                                
                // items count
               // $count = $app['realestates']->getPropertiesFilterCount($userId['id']);
              
                //var_dump($count[0]["Count"]);
                $pageCount = ceil(((int)$count[0]["Count"])/$pageItems);     
                     
                //var_dump($pageCount);
                if ($pageCount < 1)  { 
                    $pageCount = 1; 
                } 
                //Make sure then cant fiddle with it
                if ($page < 1)  { 
                    $page = 1; 
                } 
                if ($page > $pageCount)  { 
                    $page = $pageCount; 
                } 
                $previous = $page-1;
                $next = $page+1;
            
               // -------------------------------- Render --------------------------------------------- //     
		return $app['twig']->render('admin/realestate/home.twig', array(
                   "user"   => $app['session']->get('username'),
                   "deleted"  => $deleted,
                   "added"  => $added,
                   "edited"  => $edited,
                   "wrong"  => $wrong,
                   "pageCount"  => $pageCount,
                   "previous"  => $previous,
                   "next"  => $next,
                   "page"  => $page,  
                   'searchform' => $searchform->createView(),
                   "realestates"  => $showOnScreen
                ));
	}
        
        public function details(Application $app) {
                $edited  = isset($app['session']->get('edited')[0])?$app['session']->get('edited'):null;
                $app['session']->remove('edited'); 
                
                
                $propertyId = $app['request']->get('id');
		$property = $app['realestates']->getProperty($propertyId);
                $property = $property[0];
		if (!$property) {
			$app->abort(404, 'Stage $$propertyId does not exist');
		}
                
                //var_dump($app['admin.base_path'] . "\\" . $propertyId );
                if ($handle = opendir($app['admin.base_path'] . "\\immo\\" . $propertyId )) {
                  //  echo "Directory handle: $handle\n";
                  //  echo "Entries:\n";
                   $i = 0;
                   $exit = false;
                    /* This is the correct way to loop over the directory. */
                    while (false !== ($entry = readdir($handle)) && !$exit) {
                        while (false !== ($entry = readdir($handle))) {
                            if ($entry != "." && $entry != "..") {                         
                                $imgAr[$i] = $entry;
                                $i++;
                            }
                        }
                    }
                    closedir($handle);
                }
                
                
                
		return $app['twig']->render('admin/realestate/detail.twig', array(  
                    "user"   => $app['session']->get('username'),
                    "imgAr"   => $imgAr,    
                    'edited' => $edited,       
                    'property' => $property
                 ));
	}
        
         public function delete(Application $app) {
                $propertyId = $app['request']->get('id');
		$property = $app['realestates']->getProperty($propertyId);
		if (!$property) {
			$app->abort(404, 'Stage $property does not exist');
		}                
                       
                /*return $app['twig']->render('admin/realestate/delete.twig', array( 
                    "user"   => $app['session']->get('username'),
                    'property' => $property[0]
                 ));*/
                //var_dump($property[0]['Name']);
                $app['session']->set('deleted', $property[0]['Name']);  
                //var_dump($app['session']->get('deleted'));  
                $app['realestates']->deleteData($propertyId); 
                return $app->redirect($app['url_generator']->generate('browse')."?page=1");  
                exit(0); 
	}
        
        public function add(Application $app) {       
            
                //fetch enums
		$state = $app['realestates']->getEnum("State");
		$type = $app['realestates']->getEnum("Type");
		$province = $app['realestates']->getEnum("Province");
                                
                $addform = $app['form.factory']->createNamed('addform')
			->add('Name', 'text', array(
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
			))
                        ->add('Price', 'text', array(
                                'label' => "Price in €",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2)))
			))
                        ->add('Size', 'text', array(
                                'label' => "Size in m²",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2)))
			))
                        ->add('Bedrooms', 'text', array(
                                'label' => "Number of bedrooms",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 1)))
			))
                        ->add('Buildyear', 'text', array(
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 4)))
			))
                        ->add('Available', 'checkbox', array(
                                "attr" => array("class" => "available" )
                        )) 			
			->add('Location_street', 'text', array(
                                'label' => "Street + housenumber ",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3)))
			)) 
                        ->add('Location_City', 'text', array(
                                'label' => "Zip code + city ",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3)))
			))                        
                        ->add('Description', 'textarea', array(
                                "attr" => array("class" => "tinymce mce-custom" ),
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
			))                        
                        ->add('State', 'choice', array(
                                'choices' => $state,
				'constraints' => array(new Assert\NotBlank())
                        ))
                        ->add('Date_available', 'text', array(
                                'label' => "Date available (yyyy-mm-dd)",
				'constraints' => array(new Assert\NotBlank(), new Assert\Date())
                        ))
			->add('Type', 'choice', array(
                                'choices' => $type,
				'constraints' => array(new Assert\NotBlank())
                        )) 
			->add('Province', 'choice', array(
                                'choices' => $province,
				'constraints' => array(new Assert\NotBlank())
                        ))
                        ->add('files', 'file', array(
                                'label' => "Choose 1 - 5 pictures",
                                "attr" => array(
                                                "multiple" => "multiple",
                                                "name" => "files[]",
                                                ),
				'constraints' => array(new Assert\NotBlank())
                        ));
            
                // Form was submitted: process it
		if ('POST' == $app['request']->getMethod()) {
                        $addform->bind($app['request']);
                       // var_dump($addform);
                       if ($addform->isValid()) {
                            $data = $addform->getData();                            
                            //var_dump($data['Date_expires']);                            

                            $user = $app['session']->get('username');
                            $currentAgentId = $app['agents']->getAgentId($user);
                            //var_dump($currentAgentId['id']);
                            //echo  $data['Title'].  $data['Sector']. $data['Location']. date('Y-m-d') . $data['Date_expires']. $data['Description']. $data['Qualifications']. $data['Diploma']. $data['Year']. $currentCompanyId['id'];
                            //$title, $sector, $location, $datePosted, $dateExpires, $description, $qual, $diploma, $year, $company
                            
                            //$newDate = date("d-m-Y", strtotime($data['Date_available']));
                            $newDate = $data['Date_available'];
                            $newId = $app['realestates']->getId();
                            $newId = $newId['id'] +1;
                            if ($data['Available']) {
                                $ava = 1;
                            }  else {
                                $ava = 0;
                            }
                            $app['realestates']->insertRealestate($newId, $currentAgentId['id'], $data['Name'], $ava,  $data['State']+1,  $data['Type']+1,  $data['Province']+1,  $data['Location_street'],  $data['Location_City'], date('Y-m-d') , $newDate, $data['Description'], $data['Price'], $data['Size'], $data['Bedrooms'], $data['Buildyear']); 
                            
                            
                            $files = $app['request']->files->get($addform->getName());                            
                            foreach ($files['files'] as $key => $file) {
                                //var_dump($file);
                                if ('.jpg' == substr($file->getClientOriginalName(), -4)) {                                    
                                   if (!file_exists($app['admin.base_path']."/immo/".$newId)) {
                                       mkdir($app['admin.base_path']."/immo/".$newId, 0, true);
                                    }                                               
                                    // Move it to its new location
                                    $file->move($app['admin.base_path']."/immo/".$newId, $file->getClientOriginalName());
                                    //var_dump($app['admin.base_path']."/immo/".$newId);
                                }     
                            }
                             
                            // zet is valid uit kommentaar
                            // zwier files[] in data in uw twig - autocomplete dit dat
                            
                            $app['session']->set('added', $data['Name']);  
                            return $app->redirect($app['url_generator']->generate('browse')."?page=1");  
                            exit(0);
                        }
                }
                       
		return $app['twig']->render('admin/realestate/add.twig', array(
                    'addform' => $addform->createView(), 
                    "user"   => $app['session']->get('username')));        
        }
        
        
        
        public function edit(Application $app) {   
                
                $propertyId = $app['request']->get('id');
		$property = $app['realestates']->getProperty($propertyId);
		if (!$property) {
			$app->abort(404, 'Stage $propertyId does not exist');
		}
                //var_dump($property);
                //fetch enums
		$state = $app['realestates']->getEnum("State");
		$type = $app['realestates']->getEnum("Type");
		$province = $app['realestates']->getEnum("Province");
                                
                if ($handle = opendir($app['admin.base_path'] . "\\immo\\" . $propertyId )) {
                  //  echo "Directory handle: $handle\n";
                  //  echo "Entries:\n";
                   $i = 0;
                   $exit = false;
                    /* This is the correct way to loop over the directory. */
                    while (false !== ($entry = readdir($handle)) && !$exit) {
                        while (false !== ($entry = readdir($handle))) {
                            if ($entry != "." && $entry != "..") {                         
                                $imgAr[$i] = $entry;
                                $i++;
                            }
                        }
                    }
                    closedir($handle);
                }
                
                
                $bool = false;
                if($property[0]['Available']){
                    $bool = true;
                }
                
                $editform = $app['form.factory']->createNamed('editform')
                        ->add('Name', 'text', array(
                                'data' => $property[0]['Name'],
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
			))
                        ->add('Price', 'text', array(
                                'data' => $property[0]['Price'],
                                'label' => "Price in €",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2)))
			))
                        ->add('Size', 'text', array(
                                'data' => $property[0]['Size'],
                                'label' => "Size in m²",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2)))
			))
                        ->add('Bedrooms', 'text', array(
                                'data' => $property[0]['Bedrooms'],
                                'label' => "Number of bedrooms",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 1)))
			))
                        ->add('Buildyear', 'text', array(
                                'data' => $property[0]['Buildyear'],
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 4)))
			))
                        ->add('Available', 'checkbox', array(
                                'data' => $bool,                                
                                "attr" => array("class" => "available" )
                        )) 			
			->add('Location_street', 'text', array(
                                'data' => $property[0]['Location_street'],
                                'label' => "Street + housenumber ",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3)))
			)) 
                        ->add('Location_City', 'text', array(
                                'data' => $property[0]['Location_City'],
                                'label' => "Zip code + city ",
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3)))
			))                        
                        ->add('Description', 'textarea', array(
                                'data' => $property[0]['Description'],
                                "attr" => array("class" => "tinymce mce-custom" ),
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
			))                        
                        ->add('State', 'choice', array(
                                'data' => array_search($property[0]['State'], $state),
                                'choices' => $state,
				'constraints' => array(new Assert\NotBlank())
                        ))
                        ->add('Date_available', 'text', array(
                                'data' => $property[0]['Date_available'],
                                'label' => "Date available (yyyy-mm-dd)",
				'constraints' => array(new Assert\NotBlank(), new Assert\Date())
                        ))
			->add('Type', 'choice', array(
                                'data' => array_search($property[0]['Type'], $type),
                                'choices' => $type,
				'constraints' => array(new Assert\NotBlank())
                        )) 
			->add('Province', 'choice', array(
                                'data' => array_search($property[0]['Province'], $province),
                                'choices' => $province,
				'constraints' => array(new Assert\NotBlank())
                        ))
                        ->add('Delete', 'choice', array(
                                'label' => "Select the ones you would like to delete ",
                                "attr" => array("data-link" => $propertyId ),
                                'choices' => $imgAr,
                                'expanded' => true,
                                'multiple' => true
                        )) 
                        ->add('files', 'file', array(
                                'label' => "Choose new pictures",
                                "attr" => array(
                                                "multiple" => "multiple",
                                                "name" => "files[]",
                                                )
                        ));
                        
            
                // Form was submitted: process it
		if ('POST' == $app['request']->getMethod()) {
                        $editform->bind($app['request']);   
                       // var_dump($addform);
                        if ($editform->isValid()) {
                            $data = $editform->getData();  
                           
                            //var_dump($data['Diploma']);                            

                            $user = $app['session']->get('username');
                            $currentAgentId = $app['agents']->getAgentId($user);
                            //var_dump($currentCompanyId['id']);
                            $id = $propertyId;
                            $newDate = $data['Date_available'];
                            if ($data['Available']) {
                                $ava = 1;
                            }  else {
                                $ava = 0;
                            }
                            //$app['realestate']->updateData($data['Title'], $data['available'], $data['Sector']+1, $data['Location_street'],$data['Location_city'],$data['Location_country'], date('Y-m-d') , $data['Date_expires'], $data['Description'], $data['Qualifications'], $data['Diploma']+1, $data['Year']+1, $id); 
                            $app['realestates']->updateRealestate($id, $currentAgentId['id'], $data['Name'], $ava,  $data['State']+1,  $data['Type']+1,  $data['Province']+1,  $data['Location_street'],  $data['Location_City'], date('Y-m-d') , $newDate, $data['Description'], $data['Price'], $data['Size'], $data['Bedrooms'], $data['Buildyear']); 
                                
                            $files = $app['request']->files->get($editform->getName());        
                            var_dump($files['files']);
                            if ($files['files'][0] != null) {
                                 foreach ($files['files'] as $key => $file) {
                                    //var_dump($file);
                                    if ('.jpg' == substr($file->getClientOriginalName(), -4)) {                                    
                                       if (!file_exists($app['admin.base_path']."/immo/".$id)) {
                                           mkdir($app['admin.base_path']."/immo/".$id, 0, true);
                                        }                                               
                                        // Move it to its new location
                                        $file->move($app['admin.base_path']."/immo/".$id, $file->getClientOriginalName());
                                        //var_dump($app['admin.base_path']."/immo/".$newId);
                                    }     
                                }
                            }
                            
                            //var_dump($data);
                            if (isset($data['Delete'][0]) || $data['Delete'] != null) {
                                // ge krijgt den id van den img in den array terug da ge moet verwijdern
                                foreach ($data['Delete'] as $item) {              
                                    $temp = $imgAr[$item];
                                 //   var_dump($temp);
                                    unlink($app['admin.base_path']."immo".DIRECTORY_SEPARATOR. $id .DIRECTORY_SEPARATOR.$temp); //delete it
                                //    var_dump($app['admin.base_path']."immo".DIRECTORY_SEPARATOR.$temp);
                                }
                                
                            }
                           
                            
                            // set update & doorverwijslink terug uit kommentaar
                            
                            $app['session']->set('edited', $data['Name']);  
                            return $app->redirect($app['url_generator']->generate('details')."?id=" . $id);  
                            
                        }
                }
                
                $link = $app['admin.base_path']."immo/".$propertyId."/";
		return $app['twig']->render('admin/realestate/edit.twig', array(
                    'property' => $property[0],                    
                    'imgAr' => $imgAr,           
                    'link' => $link, 
                    'editform' => $editform->createView(), 
                    "user"   => $app['session']->get('username')));        
        }
        
        public function checkLogin(Request $request, Application $app) {
		if (!$app['session']->get('username')) {
			return $app->redirect($app['url_generator']->generate('admin'));    
		}
	}
        
        public function checkRightId(Request $request, Application $app) {
                $currentAgent = $app['session']->get('username');
                $currentAgentId = $app['agents']->getAgentId($currentAgent);
                                
                $propertyId = $app['request']->get('id');
                $temp = $app['realestates']->checkId($currentAgentId['id'], $propertyId);
                                                  
		if (!$temp) {
                        $app['session']->set('Wrong', 'Don\'t you fiddle with my shizzle');
			return $app->redirect($app['url_generator']->generate('realestate')."?page=1");
		}
	}

}