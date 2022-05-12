<?php
class BookMark
{
  private $conn;


  public function __construct($db)
  {
    $this->conn = $db;
  }

  // GET USER

  public function getPopular()
  {
    // Create query
    $query = 'SELECT * FROM `bookmarks` ORDER BY used_count DESC LIMIT 10;';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  public function getUserBookMarks($username)
  {
    $query = 'SELECT * FROM `user_bookmarks` WHERE username=?;';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$username]);
    return $stmt;
  }

  public function postUserBookMark($url, $username, $title)
  {

    $stmt = $this->insertBookMark($url);


    $query2 = 'INSERT INTO `user_bookmarks` (username, bookmark_url, title) VALUES (?,?,?);';
    $stmt = $this->conn->prepare($query2);
    $stmt->execute([$username, $url, $title]);

    $stmt = $this->updateBookMarkCount($url);
    return $stmt;
  }


  public function deleteUserBookMark($username, $url)
  {
    $query = 'DELETE FROM user_bookmarks WHERE username=? AND bookmark_url=?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$username, $url]);

    $stmt = $this->updateBookMarkCount($url);
    $stmt = $this->purgeDBFromUnusedURL();
    return $stmt;
  }

  public function editUserBookMark($title, $new_title, $url, $new_url, $username)
  {

    $query = 'UPDATE `user_bookmarks` SET title=?, bookmark_url=? WHERE bookmark_url = ? AND title=? AND username=?;';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$new_title, $new_url, $url, $title, $username]);
    $stmt = $this->insertBookMark($new_url);

    $stmt = $this->updateBookMarkCount($url);
    $stmt = $this->updateBookMarkCount($new_url);
    $stmt = $this->purgeDBFromUnusedURL();
    return $stmt;
  }

  private function insertBookMark($url)
  {
    $query = 'INSERT IGNORE INTO `bookmarks` (used_count, url) VALUES (0, ?);';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$url]);
    return $stmt;
  }

  private function updateBookMarkCount($url)
  {
    $query = 'UPDATE `bookmarks` SET used_count = (SELECT COUNT(*) FROM `user_bookmarks` WHERE bookmark_url = ?) WHERE url = ?;';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$url, $url]);
    return $stmt;
  }


  private function purgeDBFromUnusedURL()
  {
    $query = 'DELETE FROM bookmarks WHERE used_count=0';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }
}
