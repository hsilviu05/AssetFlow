<?php
    interface CRUDInterface 
    {
        public function find($id);
        public function findAll();
        public function save(array $data);
        public function update($id, array $data);
        public function delete($id);
    }
?>