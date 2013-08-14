<?php

namespace Saradebbaut\Repository;

class realestatesrepository extends \Knp\Repository {

	public function getTableName() {
		return 'properties';
	}
        public function getProperties($id) {
		return $this->db->fetchAll('SELECT * FROM properties WHERE Agents_id = ? ORDER BY date_posted', array($id));
	}
        public function getCountProperties($id) {
		return $this->db->fetchAll('SELECT count(*) as count FROM properties WHERE Agents_id = ? ORDER BY date_posted', array($id));
	}
        public function getProperty($id) {
		return $this->db->fetchAll('SELECT properties.*, agents.Company_name, agents.Contact_name, agents.Email FROM properties INNER JOIN agents on properties.Agents_id = agents.id WHERE properties.id = ?', array($id) );
	}
        public function getEnum($field) {
                $table = "properties";
                
                $enumArr = $this->db->fetchAll('SHOW columns FROM properties LIKE "'. $field. '"');
                //var_dump($enumArr);
                $type = $enumArr[0]['Type'];
                //var_dump($type);
                $regex = "/'(.*?)'/";
                preg_match_all($regex, $type, $matches);
                //$vals = explode(",", $matches[1]);
                //var_dump($matches[1]);
                return $matches[1];
	}
        public function getPropertiesPage($id, $min, $max) {
		return $this->db->fetchAll('SELECT * FROM properties WHERE Agents_id = ? ORDER BY date_posted ASC LIMIT ' . $min .",". $max, array($id));
	}
        public function getPropertiesFilter($min, $max, $avail, $state, $items, $id) {   
            //var_dump($max);  
            if ($items != null) {                       
                $str = '';        
                foreach ($items as $key => $value) {
                    if ($value != '' || $value != null) {
                        //var_dump($value);
                        $str .= ' AND ( Name LIKE \'%'.$value.'%\' OR Type LIKE \'%'.$value.'%\' OR Province LIKE \'%'.$value.'%\' OR Location_street LIKE \'%'.$value.'%\' OR Location_City LIKE \'%'.$value.'%\' OR Size LIKE \'%'.$value.'%\' OR Bedrooms LIKE \'%'.$value.'%\' OR Buildyear LIKE \'%'.$value.'%\' OR Price LIKE \'%'.$value.'%\' )';      
                        //var_dump($str);
                    }                   
                }
                $result = $this->db->fetchAll('SELECT * FROM properties WHERE Agents_id = ? AND Available = ? AND State = ? '. $str .' ORDER BY date_posted ASC LIMIT ' . $min . ',' .$max , array($id, $avail, $state));
            }  else {                
		$result =  $this->db->fetchAll('SELECT * FROM properties WHERE  Agents_id = ? AND  Available = ? AND State = ? ORDER BY date_posted ASC LIMIT  ' . $min .",". $max, array($id, $avail, $state));
            }            
            //var_dump($result);
            return  $result;
	}        
        public function getPropertiesFilterCount($avail, $state, $items) {  
            if ($items != null) {                       
                $str = '';                      
                foreach ($items as $key => $value) {
                    if ($value != '' || $value != null) {
                        //var_dump($value);
                        $str .= ' AND ( Name LIKE \'%'.$value.'%\' OR Type LIKE \'%'.$value.'%\' OR Province LIKE \'%'.$value.'%\' OR Location_street LIKE \'%'.$value.'%\' OR Location_City LIKE \'%'.$value.'%\' OR Size LIKE \'%'.$value.'%\' OR Bedrooms LIKE \'%'.$value.'%\' OR Buildyear LIKE \'%'.$value.'%\' OR Price LIKE \'%'.$value.'%\' )';      
                        //var_dump($str);
                    }                   
                }
                $result = $this->db->fetchAll('SELECT count(*) as Count FROM properties WHERE Available = ? AND State = ? '. $str .' ORDER BY date_posted ASC ' , array($avail, $state));       
            }  else {                
		$result =  $this->db->fetchAll('SELECT count(*) as Count  FROM properties WHERE Available = ? AND State = ? ORDER BY date_posted ASC', array($avail, $state));
            }            
            //var_dump($result);
            return  $result;
	}
         public function deleteData($id){
            // build query
            return $this->db->delete('properties',array('id' => $id));
        }
        public function getId() {
		return $this->db->fetchassoc('SELECT id FROM properties ORDER BY id DESC');
	}
        
        //$app['realestates']->insertRealestate($newId, $currentAgentId['id'], $data['Name'], $data['Available'],  $data['State']+1,  $data['Type']+1,  $data['Province']+1,  $data['Location_street'],  $data['Location_City'], date('Y-m-d') , $data['Date_available'], $data['Description'], $data['Price'], $data['Size'], $data['Bedrooms'], $data['Buildyear']); 
         public function insertRealestate($id, $agentId, $name, $ava, $state,  $type, $Province, $street, $city, $datePosted, $dateAva, $description, $price, $size, $bedrooms, $buildyear){
            // build query
            return $this->db->insert('properties', array(
                                                     'id' => $id,
                                                     'Agents_id' => $agentId,
                                                     'Name' => $name,
                                                     'Available' => $ava,
                                                     'State' => $state,
                                                     'Type' => $type,
                                                     'Province' => $Province,
                                                     'Location_street' => $street,
                                                     'Location_City' => $city,
                                                     'Date_posted' => $datePosted,
                                                     'Date_available' => $dateAva, 
                                                     'Description' => $description,
                                                     'Price' => $price, 
                                                     'Size' => $size,
                                                     'Bedrooms' => $bedrooms,
                                                     'Buildyear' => $buildyear));
        }
        public function updateRealestate($id, $agentId, $name, $ava, $state,  $type, $Province, $street, $city, $datePosted, $dateAva, $description, $price, $size, $bedrooms, $buildyear){
            // build query
            return $this->db->update('properties', array(
                                                     'id' => $id,
                                                     'Agents_id' => $agentId,
                                                     'Name' => $name,
                                                     'Available' => $ava,
                                                     'State' => $state,
                                                     'Type' => $type,
                                                     'Province' => $Province,
                                                     'Location_street' => $street,
                                                     'Location_City' => $city,
                                                     'Date_posted' => $datePosted,
                                                     'Date_available' => $dateAva, 
                                                     'Description' => $description,
                                                     'Price' => $price, 
                                                     'Size' => $size,
                                                     'Bedrooms' => $bedrooms,
                                                     'Buildyear' => $buildyear)
                    , array('id' => $id));
        }
        public function checkId($currentAgent, $propertyId) {
            //var_dump($currentAgent);
            //var_dump($propertyId);
		return $this->db->fetchassoc('SELECT * FROM properties WHERE id=? AND Agents_id=?' , array($propertyId, $currentAgent));
	}
        
        
        
        //******************************************************************//
        
        
        
	public function getNumStages($id) {
		return $this->db->fetchColumn('SELECT COUNT(*) FROM internships WHERE Company_id = ?', array($id));
	}
        public function getEndDates() {
		return $this->db->fetchAll('SELECT * FROM internships INNER JOIN companies ON internships.Companies_id = companies.id ORDER BY internships.Date_Expires ASC limit 0, 4');
	}
        public function getNewest() {
		return $this->db->fetchAll('SELECT * FROM internships INNER JOIN companies ON internships.Companies_id = companies.id ORDER BY internships.Date_posted ASC limit 0, 4');
	}
        

	public function getStages($id) {
		return $this->db->fetchAll('SELECT * FROM internships WHERE Companies_id = ? ORDER BY date_posted, date_expires', array($id));
	}
        
        public function getAllStages() {
		return $this->db->fetchAll('SELECT internships.*, companies.name as compName FROM internships INNER JOIN companies ON internships.Companies_id = companies.id ORDER BY internships.date_posted ASC');
	}
        
	public function getStage($id) {
		return $this->db->fetchAll('SELECT internships.*, companies.name, companies.email FROM internships INNER JOIN companies on internships.Companies_id = companies.id WHERE internships.id = ?', array($id) );
	}
        
        public function getStagesWithUser($username) {
		return $this->db->fetchAll('SELECT internships.*, companies.name, companies.logo FROM internships INNER JOIN companies ON companies.name = ?', array($username));
	}
        public function getEnums($field) {
                $table = "Stages";
		//return $this->db->fetchAll('SELECT ? FROM stages', array($colomname));
                
                $enumArr = $this->db->fetchAll('SHOW columns FROM internships LIKE "'. $field. '"');
                //var_dump($enumArr);
                $type = $enumArr[0]['Type'];
                //var_dump($type);
                $regex = "/'(.*?)'/";
                preg_match_all($regex, $type, $matches);
                //$vals = explode(",", $matches[1]);
                //var_dump($matches[1]);
                return $matches[1];
	}
        
         public function insertData($id, $company, $title, $sector, $ava,  $str, $city, $country, $datePosted, $dateExpires, $description, $qual, $diploma, $year){
            // build query
            return $this->db->insert('internships', array(
                                                     'id' => $id,
                                                     'Companies_id' => $company,
                                                     'Title' => $title,
                                                     'available' => $ava,
                                                     'Sector' => $sector,
                                                     'location_street' => $str,
                                                     'location_city' => $city,
                                                     'location_country' => $country,
                                                     'Date_posted' => $datePosted,
                                                     'Date_expires' => $dateExpires, 
                                                     'Description' => $description,
                                                     'Qualifications' => $qual, 
                                                     'Diploma' => $diploma,
                                                     'Year' => $year,
                                                     'Companies_id' => $company));
        }
        //$app['internships']->insertData($currentCompanyId['id'], $data['Title'], $data['available'],  $data['Sector']+1,  $data['Location_street'],  $data['Location_city'],  $data['Location_country'],  $data['Location'], date('Y-m-d') , $data['Date_expires'], $data['Description'], $data['Qualifications'], $data['Diploma']+1, $data['Year']+1); 
                            
        
        
        public function updateData($title,  $ava, $sector, $str, $city, $country,  $datePosted, $dateExpires, $description, $qual, $diploma, $year, $id){
            // build query
            return $this->db->update('internships', array(
                                                     'Title' => $title,
                                                     'available' => $ava,
                                                     'Sector' => $sector,
                                                     'location_street' => $str,
                                                     'location_city' => $city,
                                                     'location_country' => $country,
                                                     'Date_posted' => $datePosted,
                                                     'Date_expires' => $dateExpires,
                                                     'Description' => $description,
                                                     'Qualifications' => $qual,
                                                     'Diploma' => $diploma,
                                                     'Year' => $year)
                    , array('id' => $id));
        }
        // $app['internships']->updateData($data['Title'], $data['avalible'], $data['Sector']+1, $data['Location_street'],$data['Location_city'],$data['Location_county'], date('Y-m-d') , $data['Date_expires'], $data['Description'], $data['Qualifications'], $data['Diploma']+1, $data['Year']+1, $id); 
                           
        
        
        public function deleteDatat($id){
            // build query
            return $this->db->delete('internships',array('id' => $id));
        }
        
         public function getIdst() {
		return $this->db->fetchassoc('SELECT id FROM internships ORDER BY id DESC');
	}
        
        public function getCount() {
		return $this->db->fetchAll('SELECT count(*) as count FROM internships');
	}
        
        public function getSelected($serialized, $order, $limit, $min, $max) {
           
                //var_dump($serialized);
               
                //var_dump('SELECT internships.*, companies.name as compName FROM internships INNER JOIN companies ON internships.Companies_id = companies.id' . $str);
                $str = " ";
                if($serialized != null) {
                    $str = " where ";
                    $first = true;
                    foreach ($serialized as $key => $value) { 
                        if(isset($serialized[$key])){
                             if($key != 'pages'){    
                                if($key != 'order'){                                  
                                    if($key == 'company'){
                                        $str .= " and companies.name" . " = '" . $value . "' ";  
                                        $first = false;                          
                                    }else{
                                        if($first){
                                            if($value){
                                                $str .= $key . " = " . 1 . " ";  
                                            }else{
                                                $str .= $key . " = " . 0 . " ";  
                                            }
                                            //var_dump($str);
                                            $first = false;                          
                                        }else{
                                            $str .= " and ". $key . "='" . $value . "' ";                            
                                        }
                                    }
                                }
                             }
                        }
                    }                    
                }                
                //var_dump($str);
                //echo ('SELECT internships.*, companies.name as compName FROM internships INNER JOIN companies ON internships.Companies_id = companies.id ' . $str . 'ORDER BY internships.date_posted ASC LIMIT ' . $min .",". $max);ORDER BY internships.Date_posted ASC limit 0, 4');

                if($limit){
                   //echo('SELECT internships.*, companies.name as compName FROM internships INNER JOIN companies ON internships.Companies_id = companies.id ' . $str . ' ORDER BY internships.'.$order.' ASC LIMIT ' . $min .",". $max);	
                    return $this->db->fetchAll('SELECT internships.*, companies.name as compName FROM internships INNER JOIN companies ON internships.Companies_id = companies.id ' . $str . ' ORDER BY internships.'.$order.' ASC LIMIT ' . $min .",". $max);	
                }else{
                    return $this->db->fetchAll('SELECT count(*) as count FROM internships INNER JOIN companies ON internships.Companies_id = companies.id ' . $str . ' ORDER BY internships.'.$order.' ASC');	
                }               
        }

        public function getCountry() {
		return $this->db->fetchAll('SELECT location_country FROM internships order by location_country asc');
	}
        public function getRelatedSector($id, $sector) {
		return $this->db->fetchAll('SELECT id, title FROM internships where id <> ? and sector=? order by Title asc limit 0, 5', array($id, $sector));
	}
        public function getRelatedDiploma($id,  $diploma,$year) {
		return $this->db->fetchAll('SELECT id, title FROM internships  where id <> ? and  diploma=? and year=? order by Title asc limit 0, 5', array($id, $diploma, $year));
	}
}
