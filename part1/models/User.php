<?php
class User
{
  private $conn;

  public $id;
  public $category_id;
  public $category_name;
  public $title;
  public $body;
  public $author;
  public $created_at;


  public function __construct($db)
  {
    $this->conn = $db;
  }

  // GET USER

  public function read($username, $password)
  {
    // Create query
    $query = 'SELECT * from users where username=? AND password=?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$username, md5($password)]);
    return $stmt;
  }

  public function createAccount($username, $password)
  {
    $query = 'INSERT INTO users (username, `password`) VALUES (?,?);';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$username, md5($password)]);
    return $stmt;
  }

  public function updateUsername($new_username, $old_username)
  {
    $query = 'UPDATE users  SET username=? WHERE  username=?;';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$new_username, $old_username]);
    return $stmt;
  }
  public function updatePassword($username, $password)
  {
    $query = 'UPDATE users  SET password=? WHERE  username=?;';;
    $stmt = $this->conn->prepare($query);
    $stmt->execute([md5($password), $username]);
    return $stmt;
  }
}
