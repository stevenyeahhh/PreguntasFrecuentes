<?php

class Database extends PDO {

    private $totalRows;
    private $columns;

    function __construct() {
        try {
            parent::__construct(DB_ROUTE, DB_USER, DB_PASSWORD, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        } catch (PDOException $e) {
        }
    }
    function selectQuery($table, $columns, $where) {
        $where = trim($where) == "" ? "" : " WHERE $where";        
        return parent::query("SELECT $columns FROM $table $where");
    }

    function insertQuery($table, $columns, $values) {
        $query = parent::query("INSERT INTO $table ($columns) VALUES ($values)");
        return $query;
    }

    function updateQuery($table, $columnValues, $where) {
        return parent::query("UPDATE $table SET $columnValues WHERE $where");
    }

    function query($query) {
        return parent::query($query);
    }

}
