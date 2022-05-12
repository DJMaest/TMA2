<?php
class Enrollment
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET USER

    public function isEnrolled($username, $unit_id)
    {
        // Create query
        $query = 'SELECT * FROM Enrollments WHERE username=? AND unit_id=?';
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $unit_id]);
        return $stmt->rowCount() > 0;
    }

    public function addEnrollment($username, $unit_id)
    {
        $query = 'INSERT INTO Enrollments (username, unit_id ) VALUES (?,?)';
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $unit_id]);
        return $stmt;
    }
}
