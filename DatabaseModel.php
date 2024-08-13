<?php

class DatabaseModel
{
    private $db;

    public function __construct(){
        $this->connect();
    }

    public function connect(){
        $this->db = new PDO('mysql:host=127.0.0.1;dbname=quizapp;charset=utf8', 'root', 'mysql');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//        $this->db = new PDO('mysql:host=127.0.0.1;dbname=nyta00;charset=utf8', 'nyta00', 'ae3Aib4poeM9hei7ca');
//        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        //ae3Aib4poeM9hei7ca
    }

//    public function disconnect(){
//        $this->db = null;
//    }

    public function query($sql, array $data=[]){

        //$this->connect();

        try{
            $query = $this->db->prepare($sql);
            $query->execute(array_values($data));

//            var_dump($sql);
//            echo '<br>';
//            var_dump($query);exit;
//            echo '<br>';

            $result = $query->fetchAll(PDO::FETCH_ASSOC);
//            $result = $query->fetchPairs(PDO::FETCH_ASSOC);

//            var_dump($result);exit;
        } catch (PDOException $e){
            echo 'Connection failed: '.$e->getMessage();

            $result = false;
        }

        //$this->disconnect();

        return $result;

    }

    public function insert($table, array $data){
        $sql = "INSERT INTO ".$table." (".implode(',', array_keys($data)).") VALUES (". implode(',', array_fill(0, count($data), '?')) .")";

        $this->query($sql, $data);
    }


    private function updatePart($data){
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = ?";
        }
        $set = implode(', ', $set);

        return $set;

    }

    public function insertUpdate($table, array $data){
        $sql = "INSERT INTO ".$table." (".implode(',', array_keys($data)).") VALUES (". implode(',', array_fill(0, count($data), '?')) .") ON DUPLICATE KEY UPDATE ".$this->updatePart($data);


        $data = array_merge(array_values($data), array_values($data));

        $this->query($sql, $data);

    }




    public function update($table, array $data, $where){

        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = ?";
        }
        $set = implode(', ', $set);

        $conditions = [];
        $params = array_values($data);
        foreach ($where as $key => $value) {
            $conditions[] = "$key = ?";
            $params[] = $value;
        }
        $conditions = implode(' AND ', $conditions);

        $sql = "UPDATE $table SET $set WHERE $conditions";

        $data = array_merge($data, $where);

        $this->query($sql, $data);
    }

    public function delete($table, $where){

        $conditions = [];
        $params = [];
        foreach ($where as $key => $value) {
            $conditions[] = "$key = ?";
            $params[] = $value;
        }
        $conditions = implode(' AND ', $conditions);

        $sql = "DELETE FROM $table WHERE $conditions";


        $this->query($sql, $params);
    }

}