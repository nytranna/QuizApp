<?php

require_once __DIR__.'/DatabaseModel.php';


class QuizRepository extends DatabaseModel
{
    private $table = 'quiz';

    public function selectQuiz($id){
        return $this->query('SELECT *
                                    FROM '.$this->table.'
                                    WHERE id=? LIMIT 1', [$id]);
    }

    public function selectAllQuizzes(){
        return $this->query('SELECT * 
                                    FROM '.$this->table);
    }

    public function selectLastQuiz(){
        return $this->query('SELECT * 
                                    FROM '.$this->table.' 
                                    ORDER BY ID DESC LIMIT 1');
    }

    public function selectUsersQuizzes($id){
        return $this->query('SELECT DISTINCT q.*
                                    FROM '.$this->table.' q
                                    INNER JOIN quiz_question qq ON q.id = qq.quiz_id
                                    INNER JOIN user_question uq ON qq.id = uq.quiz_question_id
                                    WHERE uq.user_id = ?', [$id]);
    }

    public function insertQuiz($data){
        $this->insert($this->table, $data);
    }




}