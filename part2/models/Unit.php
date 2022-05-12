<?php
class Unit
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  // GET USER

  public function getAvailableUnits()
  {
    // Create query
    $query = 'SELECT * from Units;';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  public function getUnit($unitId)
  {
    // Create query
    $query = 'SELECT * from Units WHERE unit_id=? ;';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$unitId]);
    return $stmt;
  }

}