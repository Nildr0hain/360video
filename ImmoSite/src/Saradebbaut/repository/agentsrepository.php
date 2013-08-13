<?php

namespace Saradebbaut\Repository;

class agentsrepository extends \Knp\Repository {

	public function getTableName() {
		return 'agents';
	}
        public function getAgents() {
		return $this->db->fetchAll('SELECT email, password FROM agents');
	}         
        public function getAgentTrue($username) {
		return $this->db->fetchassoc('SELECT * FROM agents WHERE email = ?', array($username));
	}
        public function getAgentId($username) {
		return $this->db->fetchassoc('SELECT id FROM agents WHERE email = ?', array($username));
	}
        public function getId() {
		return $this->db->fetchassoc('SELECT id FROM agents ORDER BY id DESC');
	}
        public function insertAgent($id, $company, $name, $email, $password){
            // build query
            return $this->db->insert('agents', array('id' => $id, 'Company_name' => $company, 'Contact_name' => $name, 'Email' => $email ,'Password' => $password));
        }
        public function updateAgent($Company_name, $Contact_name, $Email, $Description, $Website, $Telephone, $Address_street, $Address_city, $idToChange){
            // build query
            return $this->db->update('agents', array('Company_name' => $Company_name,
                                                     'Contact_name' => $Contact_name,
                                                     'Email' => $Email,
                                                     'Description' => $Description,
                                                     'Website' => $Website,
                                                     'Telephone' => $Telephone,
                                                     'Address_street' => $Address_street,
                                                     'Address_city' => $Address_city)
                    , array('id' => $idToChange));
        }
        
        
        
        
        //******************************************************************//
       

	public function getAdmin($id) {
		return $this->db->fetchAll('SELECT email, password FROM companies WHERE id = ?', array($id));
        }
        public function getAdminData($id) {
		return $this->db->fetchAll('SELECT * FROM companies WHERE id = ?', array($id));
        }
        
	public function getAdmins() {
		return $this->db->fetchAll('SELECT email, password FROM companies');
	}        
        public function getAllAdmins() {
		return $this->db->fetchAll('SELECT * FROM companies');
	}
        public function getAdminId($username) {
		return $this->db->fetchassoc('SELECT id FROM companies WHERE email = ?', array($username));
	}
        public function insertData($id, $company, $username, $password){
            // build query
            return $this->db->insert('companies', array('id' => $id,'name' => $username, 'email' => $company ,'password' => $password));
        }
        public function updateData($company, $name, $email, $des, $website, $tele, $str, $city, $country, $idToChange){
            // build query
            //return($idToChange);
            return $this->db->update('companies', array('name' => $company,
                                                     'contact_name' => $name,
                                                     'email' => $email,
                                                     'description' => $des,
                                                     'website' => $website,
                                                     'telephone' => $tele,
                                                     'address_street' => $str,
                                                     'address_city' => $city,
                                                     'address_country' => $country)
                    , array('id' => $idToChange));
        }
        public function updateShortData($name, $des, $website, $tele, $str, $city, $country, $idToChange){
            // build query
            //return($idToChange);
            return $this->db->update('companies', array('contact_name' => $name,
                                                     'description' => $des,
                                                     'website' => $website,
                                                     'telephone' => $tele,
                                                     'address_street' => $str,
                                                     'address_city' => $city,
                                                     'address_country' => $country)
                    , array('id' => $idToChange));
        }
        //$app['admins']->updateShortData($data["contact_name"], $data["description"], $data["web"], $data["tel"], $data['address_street'],$data['address_city'],$data['address_country'], $userID["id"]);
                           
        
       
        public function getSelected($str, $limit, $min, $max) {                
                if($limit){
                    return $this->db->fetchAll('SELECT * FROM companies ' . $str . 'ORDER BY name ASC LIMIT ' . $min .",". $max);	
                }else{
                    return $this->db->fetchAll('SELECT count(*) as count FROM companies ' . $str . 'ORDER BY name ASC');
                }  
	}
        public function getNames() {
		return $this->db->fetchAll('SELECT name FROM companies order by name asc');
	}
        
        public function getInternships($id) {
		return $this->db->fetchAll('SELECT internships.id, internships.title FROM companies INNER JOIN internships on companies.id = internships.Companies_id where companies.id= ? order by internships.title asc', array($id));
	}
        
}