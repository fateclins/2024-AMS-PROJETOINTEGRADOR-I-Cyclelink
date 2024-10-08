<?php
    namespace App\Domain\Repositories;
    
    interface IDataRepository{
        public function getAll();

        public function find(int $id);
    
        public function create(array $data);
    
        public function update(int $id, array $data);
    
        public function destroy(int $id);
    }
?>