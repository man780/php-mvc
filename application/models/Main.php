<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

	public function getTasks() {
		$result = $this->db->row('SELECT `fio`, `email` ,`text` FROM tasks');
		return $result;
	}

}