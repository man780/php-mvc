<?php

namespace application\core;

use application\lib\Db;

abstract class Model {

	public $db;
	
	protected $data = [];

	public function __construct() {
		$this->db = new Db;
	}

	/**
     * Create: Inserts a new record into the database, returning the unique
     * record ID if successful, otherwise returns false.
     * @access protected
     * @param string $table
     * @param array $fields
     * @return string|boolean
     * @since 1.0.3
     * @throws Exception
     */
    protected function create($table, array $fields) {
        return($this->Db->insert($table, $fields));
    }

	/**
     * Data: Returns the record data from the database.
     * @access public
     * @return array
     * @since 1.0.3
     */
    public function data() {
        return($this->data);
    }

    /**
     * Exists: Returns true if the record data has been pulled from the database
     * and stored in a class property, or false if not.
     * @access public
     * @return boolean
     * @since 1.0.3
     */
    public function exists() {
        return(!empty($this->data));
    }
    
    /**
     * Find: Retrieves and stores a specified record from the database into a 
     * class property. Returns true if the record was found, or false if not.
     * @access protected
     * @param string $table
     * @param array $where
     * @return \App\Core\Model
     * @since 1.0.3
     */
    protected function find($table, array $where = []) {
        $data = $this->Db->select($table, $where);
        if ($data->count()) {
            $this->data = $data->first();
        }
        return $this;
    }

    /**
     * Update: Updates a specified record in the database.
     * @access protected
     * @param string $table
     * @param array $fields
     * @param integer $recordID [optional]
     * @return void
     * @since 1.0.3
     * @throws Exception
     */
    protected function update($table, array $fields, $recordID = null) {
        if (!$recordID and $this->exists()) {
            $recordID = $this->data()->id;
        }
        return(!$this->Db->update($table, $recordID, $fields));
    }
}