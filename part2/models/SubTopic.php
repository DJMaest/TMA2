<?php
class SubTopic
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  // GET USER

  public function getSubTopics($topic_id)
  {
    // Create query
    $query = 'SELECT * from SubTopics WHERE topic_id=?;';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$topic_id]);
    return $stmt;
  }


}