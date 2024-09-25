<?php

namespace App\Infra\Repositories;

use App\Domain\Repositories\IDataRepository;
use Illuminate\Database\Eloquent\Model;

    class DataRepository implements IDataRepository{
        protected $model;

        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function getAll(){
            return $this->model->all();
        }

        public function find(int $id){
            return $this->model->find($id);
        }
    
        public function create(array $data){
            return $this->model->create($data);
        }
    
        public function update(int $id, array $data){
            $record = $this->model->find($id);
            if ($record) {
                $record->update($data);
                return $record;
            }
            return null;
        }
    
        public function destroy(int $id){
            $record = $this->model->find($id);
            if ($record) {
                return $record->delete();
            }
            return false;
        }
    }
?>