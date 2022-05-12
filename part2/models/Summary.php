<?php
class Summary
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  // GET USER

  public function getSummary($unit_id)
  {
    // Create query
    $query = 'SELECT * from Summaries WHERE unit_id=?;';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$unit_id]);
    return $stmt;
  }


}