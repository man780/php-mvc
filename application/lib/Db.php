<?php

namespace application\lib;

use PDO;

class Db {

	protected $db;

	/** @var PDOStatement */
    private $_query = null;

    /** @var boolean */
    private $_error = false;

    /** @var array */
    private $_results = [];

    /** @var integer */
    private $_count = 0;
	
	public function __construct() {
		$this->db = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');
	}

	/**
     * Action:
     * @access public
     * @param string $action
     * @param string $table
     * @param array $where [optional]
     * @return Database|boolean
     * @since 1.0.1
     */
    public function action($action, $table, array $where = []) {
        if (count($where) === 3) {
            $operator = $where[1];
            $operators = ["=", ">", "<", ">=", "<="];
            if (in_array($operator, $operators)) {
                $field = $where[0];
                $value = $where[2];
                $params = [":value" => $value];
                if (!$this->query("{$action} FROM `{$table}` WHERE `{$field}` {$operator} :value", $params)->error()) {
                    return $this;
                }
            }
        } else {
            if (!$this->query("{$action} FROM `{$table}`")->error()) {
                return $this;
            }
        }
        return false;
    }

	/**
     * Count:
     * @access public
     * @return integer
     * @since 1.0.1
     */
    public function count() {
        return($this->_count);
    }

    /**
     * Delete:
     * @access public
     * @param string $table
     * @param array $where [optional]
     * @return Database|boolean
     * @since 1.0.1
     */
    public function delete($table, array $where = []) {
        return($this->action('DELETE', $table, $where));
    }

    /**
     * Error:
     * @access public
     * @return boolean
     * @since 1.0.1
     */
    public function error() {
        return($this->_error);
    }

    /**
     * First:
     * @access public
     * @return array
     * @since 1.0.1
     */
    public function first() {
        return($this->results(0));
    }

    /**
     * Insert:
     * @access public
     * @param string $table
     * @param array $fields
     * @return string|boolean
     * @since 1.0.1
     */
    public function insert($table, array $fields) {
        if (count($fields)) {
            $params = [];
            foreach ($fields as $key => $value) {
                $params[":{$key}"] = $value;
            }
            $columns = implode("`, `", array_keys($fields));
            $values = implode(", ", array_keys($params));
            if (!$this->query("INSERT INTO `{$table}` (`{$columns}`) VALUES({$values})", $params)->error()) {
                return($this->db->lastInsertId());
            }
        }
        return false;
    }

    /**
     * Query:
     * @access public
     * @param string $sql
     * @param array $params [optional]
     * @return Database
     * @since 1.0.1
     */
    public function query($sql, array $params = []) {
        $this->_count = 0;
        $this->_error = false;
        $this->_results = [];
        if (($this->_query = $this->db->prepare($sql))) {
            foreach ($params as $key => $value) {
                $this->_query->bindValue($key, $value);
            }
            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_ASSOC);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    /**
     * Results:
     * @access public
     * @param integer $key [optional]
     * @return array
     * @since 1.0.1
     */
    public function results($key = null) {
        return(isset($key) ? $this->_results[$key] : $this->_results);
    }

    /**
     * Select:
     * @access public
     * @param string $table
     * @param array $where [optional]
     * @return Database|boolean
     * @since 1.0.1
     */
    public function select($table, array $where = []) {
        return($this->action('SELECT *', $table, $where));
    }

    /**
     * Update:
     * @access public
     * @param string $table
     * @param string $id
     * @param array $fields
     * @return boolean
     * @since 1.0.1
     */
    public function update($table, $id, array $fields) {
        if (count($fields)) {
            $x = 1;
            $set = "";
            $params = [];
            foreach ($fields as $key => $value) {
                $params[":{$key}"] = $value;
                $set .= "`{$key}` = :$key";
                if ($x < count($fields)) {
                    $set .= ", ";
                }
                $x ++;
            }
            if (!$this->query("UPDATE `{$table}` SET {$set} WHERE `id` = {$id}", $params)->error()) {
                return true;
            }
        }
        return false;
    }



}