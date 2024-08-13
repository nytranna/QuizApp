<?php

require_once __DIR__.'/DatabaseModel.php';


class CategoryRepository extends DatabaseModel
{

    private $table = 'category';

    public function selectCategory(){
        return $this->query('SELECT * FROM '.$this->table);
    }

    public function insertCategory($data){
        $this->insert($this->table, $data);
    }

}