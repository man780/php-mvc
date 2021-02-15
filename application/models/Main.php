<?php

namespace application\models;

use application\core\Model;

class Main extends Model {
	public function getTasks() {
		$result = $this->db->select("tasks");
		return $result->results();
	}
}