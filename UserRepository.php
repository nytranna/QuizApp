<?php

require_once __DIR__.'/DatabaseModel.php';


class UserRepository extends DatabaseModel
{
    private $table = 'user';

    public function selectUser($email){
        return $this->query('SELECT * 
                                    FROM '.$this->table.' 
                                    WHERE email=? LIMIT 1', [$email]);
    }

    public function selectUserId($id){
        return $this->query('SELECT * 
                                    FROM '.$this->table.' 
                                    WHERE email=? LIMIT 1', [$id]);
    }

    public function selectAllUsers() {
        return $this->query('SELECT id, username 
                                    FROM '.$this->table);
    }



    public function insertUser($data){
        $this->insert($this->table, $data);
    }

    public function updateUser($data, $where){
        $this->update($this->table, $data, $where);
    }

    public function deleteUser($where){
        $this->delete($this->table, $where);
    }

    public function getUserRole($id){
        return $this->query('SELECT role FROM '.$this->table.' 
                                    WHERE id=? LIMIT 1', [$id]);
    }



}