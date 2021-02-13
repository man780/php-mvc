<?php

namespace application\models;

use application\core\Model;

class Account extends Model {
	public function getUsers() {
		$result = $this->db->row('SELECT `login` FROM users');
		return $result;
	}

    public function addUser() {
		$result = $this->db->row('SELECT `login` FROM users');
		return $result;
	}
}
