<?php

require_once __DIR__.'/DatabaseModel.php';

class QuizQuestionRepository extends DatabaseModel{
    private $table = 'quiz_question';

    public function insertQuizQuestion($data){
        $this->insert($this->table, $data);
    }

    public function selectAllQuizQuestion(){
        return $this->query('SELECT * FROM '.$this->table);
    }


    public function selectIdQQ($quiz_id, $question_id){
        return $this->query('SELECT id 
                                    FROM '.$this->table.
                                    ' WHERE quiz_id = ? 
                                        AND question_id = ?', [$quiz_id, $question_id]);
    }

    public function selectQQIds($quiz_id){
        return $this->query('SELECT id 
                                    FROM '.$this->table.
            '                        WHERE quiz_id = ?  ', [$quiz_id]);
    }


    public function selectAnswers($user_id){
        return $this->query('SELECT qq.*
                                    FROM '.$this->table.' qq
                                    JOIN question q ON qq.question_id = q.id
                                    JOIN user_question uq ON qq.id = uq.quiz_question_id
                                    WHERE q.right_answer = uq.answer
                                    AND uq.user_id = ?', [$user_id]);
    }



}
