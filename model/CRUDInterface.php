<?php
    abstract class CRUDInterface 
    {
        abstract public function find($id);
        abstract public function findAll();
        abstract public function save(array $data);
        abstract public function update($id, array $data);
        abstract public function delete($id);
    }
?>