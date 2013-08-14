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
            //var_dump($items[0]);  
            if ($items[0] != null || $items[0]!= "") {
                $search = "%" . $items[0] . "%";
                $result = $this->db->fetchAll(
                        'SELECT * FROM properties WHERE Agents_id = ? AND Available = ? AND State = ? 
                         AND ( Name LIKE ? OR Name LIKE ? OR Type LIKE ? OR Province LIKE ? OR Location_street LIKE ? OR Location_City LIKE ? OR Size LIKE ?  OR Bedrooms LIKE ?  OR Buildyear LIKE ?  OR Price LIKE ?  )
                         ORDER BY date_posted ASC LIMIT ' . $min . ',' .$max , array($id, $avail, $state, $search, $search, $search, $search, $search, $search, $search, $search, $search, $search ));
            }  else {                
		$result =  $this->db->fetchAll('SELECT * FROM properties WHERE  Agents_id = ? AND  Available = ? AND State = ? ORDER BY date_posted ASC LIMIT  ' . $min .",". $max, array($id, $avail, $state));
            }            
            //var_dump($result);
            return  $result;
	}     
        
        /* public function getPropertiesFilter($min, $max, $avail, $state, $items, $id) {   
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
                
                $str = $this->db->prepare($str);
            
                
                $result = $this->db->fetchAll('SELECT * FROM properties WHERE Agents_id = ? AND Available = ? AND State = ? '. $str .' ORDER BY date_posted ASC LIMIT ' . $min . ',' .$max , array($id, $avail, $state));
            }  else {                
		$result =  $this->db->fetchAll('SELECT * FROM properties WHERE  Agents_id = ? AND  Available = ? AND State = ? ORDER BY date_posted ASC LIMIT  ' . $min .",". $max, array($id, $avail, $state));
            }            
            //var_dump($result);
            return  $result;
	}     */
       
        public function getPropertiesFilterCount($avail, $state, $items, $id) {  
            //var_dump($items[0]);  
            if ($items[0] != null || $items[0]!= "") {
                $search = "%" . $items[0] . "%";
                $result = $this->db->fetchAll(
                        'SELECT count(*) as Count FROM  properties WHERE Agents_id = ? AND Available = ? AND State = ? 
                         AND ( Name LIKE ? OR Name LIKE ? OR Type LIKE ? OR Province LIKE ? OR Location_street LIKE ? OR Location_City LIKE ? OR Size LIKE ?  OR Bedrooms LIKE ?  OR Buildyear LIKE ?  OR Price LIKE ?  )
                         ORDER BY date_posted ASC ' , array($id, $avail, $state, $search, $search, $search, $search, $search, $search, $search, $search, $search, $search ));
            }  else {                
		$result =  $this->db->fetchAll('SELECT count(*) as Count  FROM properties WHERE  Agents_id = ? AND  Available = ? AND State = ? ORDER BY date_posted ASC ', array($id, $avail, $state));
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
}
