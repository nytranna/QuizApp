<?php


require_once __DIR__ . '/DatabaseModel.php';


class UserQuestionRepository extends DatabaseModel
{
    private $table = 'user_question';


    public function insertUQ($data){
        $this->insertUpdate($this->table, $data);
    }

    public function deleteUQ($data){
        $this->delete($this->table, $data);
    }

    public function selectUserAnswers($userId, $quizId){
        return $this->query('SELECT uq.answer, qq.id AS quiz_question_id, qu.*
                                    FROM '.$this->table.' uq
                                    INNER JOIN quiz_question qq ON uq.quiz_question_id = qq.id
                                    INNER JOIN question qu ON qq.question_id = qu.id
                                    WHERE uq.user_id = ? AND qq.quiz_id = ?', [$userId, $quizId]);
    }




}