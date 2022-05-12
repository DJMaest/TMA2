<?php
class Topic
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  // GET USER

  public function getUnitTopics($unit_id)
  {
    // Create query
    $query = 'SELECT * from Topics WHERE unit_id=?;';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$unit_id]);
    return $stmt;
  }


}