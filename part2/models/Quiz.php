<?php
class Quiz
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET USER
    public function getQuiz($unit_id)
    {
        $query = 'SELECT * FROM Quizzes WHERE unit_id=?';
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$unit_id]);
        return $stmt;
    }

    public function getQuestions($quiz_id)
    {
        $query = 'SELECT * FROM Questions WHERE quiz_id=?';
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$quiz_id]);
        return $stmt;
    }

    public function getAnswers($question_id)
    {
        $query = 'SELECT * FROM Answers WHERE question_id=?';
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$question_id]);
        return $stmt;
    }

    public function getQuizCorrectAnswers($quiz_id)
    {
        $query = 'SELECT a.answer_id, a.content, q.question_id, q.quiz_id FROM Answers a LEFT JOIN Questions q ON a.question_id = q.question_id WHERE iscorrect = 1 AND quiz_id = ?;';
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$quiz_id]);
        return $stmt;
    }
}
