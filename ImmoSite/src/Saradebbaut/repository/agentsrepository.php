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
}