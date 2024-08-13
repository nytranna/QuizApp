<?php

require_once __DIR__.'/DatabaseModel.php';


class QuestionRepository extends DatabaseModel
{
    private $table = 'question';

    public function selectQuestion($question_id){
        return $this->query('SELECT q.* 
                                    FROM '.$this->table.' q
                                    JOIN quiz_question qq ON q.id = qq.question_id
                                    WHERE qq.quiz_id=?', [$question_id]);
    }

    public function selectRandomQuestions($category_id){
        return $this->query('SELECT * 
                                    FROM '.$this->table.' 
                                    WHERE category_id = ?
                                    ORDER BY RAND() LIMIT 5', [$category_id]);
    }


    public function selectAllQuestions(){
        return $this->query('SELECT * FROM '.$this->table);
    }

    public function selectQuestionId($id){
        return $this->query('SELECT * 
                                    FROM '.$this->table.' 
                                    WHERE id = ? LIMIT 1', [$id]);
    }



    public function insertQuestion($data){
        $this->insert($this->table, $data);


    }

    public function updateQuestion($data, $id){
        $this->update($this->table, $data, $id);
    }

    public function deleteQuestion($id){
        $this->delete($this->table, ['id' => $id]);
    }



}